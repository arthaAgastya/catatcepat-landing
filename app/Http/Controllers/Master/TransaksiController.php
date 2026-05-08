<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Anggota;
use App\Models\JadwalAngsuran;
use App\Models\New\DetailTransaksi;
use App\Models\New\Jurnal;
use App\Models\New\Transaksi;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi = Transaksi::with(['anggota', 'user', 'jurnal.account'])->latest()->get();

        return view('transaksi.transaksi.theme2.index', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggota = Anggota::orderBy('nama')->get();
        $akun = Account::orderBy('no_account')->get();

        return view('transaksi.transaksi.theme2.create', compact('anggota', 'akun'));
    }

    public function createNonBarang()
    {
        $anggota = Anggota::orderBy('nama')->get();
        $akun = Account::orderBy('no_account')->get();

        return view('transaksi.transaksi.theme2.createNonBarang', compact('anggota', 'akun'));
    }

    public function storeNonBarang(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'id_account.*' => 'required|exists:account,id',
            'tipe_account.*' => 'required|in:debit,kredit',
            'nominal.*' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi.',
            'tanggal_transaksi.date' => 'Format tanggal transaksi tidak valid.',

            'id_account.*.required' => 'Akun transaksi wajib dipilih.',
            'id_account.*.exists' => 'Akun transaksi tidak ditemukan di database.',

            'tipe_account.*.required' => 'Tipe akun wajib diisi.',
            'tipe_account.*.in' => 'Tipe akun harus berupa debit atau kredit.',

            'nominal.*.required' => 'Nominal akun wajib diisi.',
            'nominal.*.string' => 'Nominal akun harus berupa teks.',

            'lampiran.file' => 'Bukti lampiran harus berupa file.',
            'lampiran.mimes' => 'Bukti lampiran harus berupa file JPG, JPEG, PNG, atau PDF.',
            'lampiran.max' => 'Ukuran file lampiran maksimal 2MB.',
        ]);

        // Server-side validation: sum of debits must exactly match sum of kredits, and at least 1 debit and 1 kredit
        $sumDebit = 0;
        $sumKredit = 0;
        $debitCount = 0;
        $kreditCount = 0;
        foreach ($request->tipe_account as $index => $tipe) {
            $cleanNominal = preg_replace('/[^\d]/', '', $request->nominal[$index]);
            $nominalValue = (int) $cleanNominal;
            if ($tipe === 'debit') {
                $sumDebit += $nominalValue;
                $debitCount++;
            } elseif ($tipe === 'kredit') {
                $sumKredit += $nominalValue;
                $kreditCount++;
            }
        }
        if ($debitCount < 1) {
            return back()->withErrors(['tipe_account' => 'Minimal harus ada 1 akun debit.'])->withInput();
        }
        if ($kreditCount < 1) {
            return back()->withErrors(['tipe_account' => 'Minimal harus ada 1 akun kredit.'])->withInput();
        }
        if ($sumDebit !== $sumKredit) {
            return back()->withErrors(['nominal' => 'Total nominal debit harus sama dengan total nominal kredit.'])->withInput();
        }

        DB::beginTransaction();

        try {
            // 1. Simpan Transaksi
            $transaksi = Transaksi::create([
                'id_user' => auth()->user()->id,
                'tanggal' => $request->tanggal_transaksi,
                'keterangan' => $request->deskripsi ?? 'Transaksi non barang tanpa deskripsi',
                'ref' => Str::uuid(),
            ]);

            // 2. Simpan Jurnal (Akun Debet & Kredit)
            $akun = $request->id_account;
            $tipe = $request->tipe_account;
            $nominal = $request->nominal;

            for ($j = 0; $j < count($akun); $j++) {
                $cleanNominal = preg_replace('/[^\d]/', '', $nominal[$j]);
                Jurnal::create([
                    'id_transaksi' => $transaksi->id,
                    'id_account' => $akun[$j],
                    'tipe' => $tipe[$j],
                    'jumlah' => (int) $cleanNominal,
                ]);
            }

            // 3. Upload lampiran jika ada
            if ($request->hasFile('lampiran')) {
                $file = $request->file('lampiran');
                $filename = 'lampiran_'.uniqid().'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/lampiran', $filename, 'public'); // Simpan di: storage/app/public/uploads/lampiran

                // Simpan relasi file polymorphic ke Transaksi
                $transaksi->files()->create([
                    'name' => $filename,
                    'path' => $path,
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'description' => 'Lampiran transaksi #'.$transaksi->id,
                    'type' => $this->getFileCategory($file->getClientMimeType()),
                ]);
            }

            DB::commit();

            return redirect()->route('transaksi.transaksi-lain.index')->with('success', 'Transaksi non barang berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage())->withInput();
        }
    }

    private function getFileCategory($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'application/pdf') || str_starts_with($mimeType, 'application/msword')) {
            return 'document';
        } else {
            return 'other';
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'id_account.*' => 'required|exists:account,id',
            'tipe_account.*' => 'required|in:debit,kredit',
            'nominal.*' => 'required|string',
            'items.*' => 'required|string',
            'qty.*' => 'required|numeric|min:0',
            'price.*' => 'required|string',
            'nota' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'tanggal_transaksi.required' => 'Tanggal transaksi wajib diisi.',
            'tanggal_transaksi.date' => 'Format tanggal transaksi tidak valid.',

            'id_account.*.required' => 'Akun transaksi wajib dipilih.',
            'id_account.*.exists' => 'Akun transaksi tidak ditemukan di database.',

            'tipe_account.*.required' => 'Tipe akun wajib diisi.',
            'tipe_account.*.in' => 'Tipe akun harus berupa debit atau kredit.',

            'nominal.*.required' => 'Nominal akun wajib diisi.',
            'nominal.*.string' => 'Nominal akun harus berupa teks.',

            'items.*.required' => 'Nama item/barang wajib diisi.',
            'items.*.string' => 'Nama item harus berupa teks.',

            'qty.*.required' => 'Kuantitas item wajib diisi.',
            'qty.*.numeric' => 'Kuantitas harus berupa angka.',
            'qty.*.min' => 'Kuantitas tidak boleh negatif.',

            'price.*.required' => 'Harga item wajib diisi.',
            'price.*.string' => 'Harga item harus berupa teks.',

            'nota.file' => 'Bukti nota harus berupa file.',
            'nota.mimes' => 'Bukti nota harus berupa file JPG, JPEG, PNG, atau PDF.',
            'nota.max' => 'Ukuran file nota maksimal 2MB.',
        ]);

        // Server-side validation: sum of debits and kredits must exactly match total harga, and at least 1 debit and 1 kredit
        $totalHarga = $this->hitungTotalTransaksi($request);
        $sumDebit = 0;
        $sumKredit = 0;
        $debitCount = 0;
        $kreditCount = 0;
        foreach ($request->tipe_account as $index => $tipe) {
            $cleanNominal = preg_replace('/[^\d]/', '', $request->nominal[$index]);
            $nominalValue = (int) $cleanNominal;
            if ($tipe === 'debit') {
                $sumDebit += $nominalValue;
                $debitCount++;
            } elseif ($tipe === 'kredit') {
                $sumKredit += $nominalValue;
                $kreditCount++;
            }
        }
        if ($debitCount < 1) {
            return back()->withErrors(['tipe_account' => 'Minimal harus ada 1 akun debit.'])->withInput();
        }
        if ($kreditCount < 1) {
            return back()->withErrors(['tipe_account' => 'Minimal harus ada 1 akun kredit.'])->withInput();
        }
        if ($sumDebit != $totalHarga) {
            return back()->withErrors(['nominal' => 'Total nominal debit harus sama dengan total harga.'])->withInput();
        }
        if ($sumKredit != $totalHarga) {
            return back()->withErrors(['nominal' => 'Total nominal kredit harus sama dengan total harga.'])->withInput();
        }

        DB::beginTransaction();

        try {
            // 1. Simpan Transaksi
            $transaksi = Transaksi::create([
                'id_user' => auth()->user()->id,
                'tanggal' => $request->tanggal_transaksi,
                'keterangan' => $request->deskripsi ?? 'Transaksi tanpa deskripsi',
                'ref' => Str::uuid(),
            ]);

            // 2. Simpan Detail Transaksi
            $items = $request->items;
            $qty = $request->qty;
            $price = $request->price;

            for ($i = 0; $i < count($items); $i++) {
                $cleanPrice = preg_replace('/[^\d]/', '', $price[$i]);
                $jumlah = (float) $qty[$i];
                $harga = (int) $cleanPrice;

                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'total_harga' => $jumlah * $harga,
                    'keterangan' => $items[$i],
                ]);
            }

            // 3. Simpan Jurnal (Akun Debet & Kredit)
            $akun = $request->id_account;
            $tipe = $request->tipe_account;
            $nominal = $request->nominal;

            for ($j = 0; $j < count($akun); $j++) {
                $cleanNominal = preg_replace('/[^\d]/', '', $nominal[$j]);
                Jurnal::create([
                    'id_transaksi' => $transaksi->id,
                    'id_account' => $akun[$j],
                    'tipe' => $tipe[$j],
                    'jumlah' => (int) $cleanNominal,
                ]);
            }

            // 4. Upload nota/invoice jika ada
            if ($request->hasFile('nota')) {
                $file = $request->file('nota');
                $filename = 'nota_'.uniqid().'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/nota', $filename, 'public'); // Simpan di: storage/app/public/uploads/nota

                // Simpan relasi file polymorphic ke Transaksi
                $transaksi->files()->create([
                    'name' => $filename,
                    'path' => $path,
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'description' => 'Nota transaksi #'.$transaksi->id,
                    'type' => 'document', // atau 'pdf', 'image', sesuai kebutuhan
                ]);
            }

            DB::commit();

            return redirect()->route('transaksi.transaksi-lain.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage())->withInput();
        }
    }

    private function hitungTotalTransaksi(Request $request)
    {
        $total = 0;
        $qty = $request->qty;
        $price = $request->price;

        for ($i = 0; $i < count($qty); $i++) {
            $jumlah = (float) $qty[$i];
            $harga = (int) preg_replace('/[^\d]/', '', $price[$i]);
            $total += $jumlah * $harga;
        }

        $diskon = (int) preg_replace('/[^\d]/', '', $request->diskon ?? 0);
        $tax = (int) preg_replace('/[^\d]/', '', $request->tax ?? 0);

        return max(($total - $diskon + $tax), 0);
    }

    public function angsuran(Request $request)
    {
        $anggotas = Anggota::all();
        $pinjaman = null;

        if ($request->has('param')) {
            try {
                $idAnggota = Crypt::decrypt($request->param);

                $pinjaman = Pinjaman::with('jadwalAngsuran', 'anggota')
                    ->where('id_anggota', $idAnggota)
                    ->latest()
                    ->first();
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return back()->with('error', 'Data tidak valid atau telah rusak.');
            }
        }

        // dd($pinjaman);

        return view('transaksi.transaksi.theme2.angsuran', compact('anggotas', 'pinjaman'));
    }

    public function bayarAngsuran(Request $request, $kode)
    {
        $jadwal = JadwalAngsuran::where('kode_angsuran', $kode)->first();

        if (! $jadwal) {
            return back()->with('error', 'Jadwal angsuran tidak ditemukan.');
        }

        if ($jadwal->status === 'sudah' || $jadwal->status === 'lunas') {
            return back()->with('warning', 'Angsuran ini sudah dibayar.');
        }

        $today = \Carbon\Carbon::today();
        $jatuhTempo = \Carbon\Carbon::parse($jadwal->tanggal_jatuh_tempo);
        $batasBayar = $jatuhTempo->copy()->subDays(20);

        // if ($today->lessThan($batasBayar)) {
        //     return back()->with('warning', 'Pembayaran hanya dapat dilakukan maksimal 20 hari sebelum jatuh tempo.');
        // }

        DB::beginTransaction();

        try {
            $pinjaman = $jadwal->pinjaman;

            // Buat transaksi
            $transaksi = Transaksi::create([
                'id_anggota' => $pinjaman->id_anggota,
                'id_user' => auth()->user()->id,
                'tanggal' => $today,
                'keterangan' => 'Pembayaran angsuran ke-'.$jadwal->angsuran_ke.' untuk kode '.$kode,
                'ref' => null,
            ]);

            $pembayaran = $jadwal->pembayaran()->create([
                'tanggal_bayar' => $today,
                'jumlah_bayar' => $jadwal->jumlah_total,
                'denda' => 0,
                'status' => 'lunas',
            ]);

            // Detail transaksi
            // DetailTransaksi::create([
            //     'id_transaksi' => $transaksi->id,
            //     'jumlah' => 1,
            //     'harga' => $jadwal->jumlah_total,
            //     'total_harga' => $jadwal->jumlah_total,
            //     'keterangan' => 'Pembayaran angsuran ke-'.$jadwal->angsuran_ke,
            // ]);

            // Ambil akun-akun
            $akunKas = Account::where('nama_account', 'like', '%Kas Simpan Pinjam%')->first();
            $akunPiutang = Account::where('nama_account', 'like', '%Piutang Simpan Pinjam (Piutang Uang)%')->first();

            if (! $akunKas || ! $akunPiutang) {
                throw new \Exception('Akun Kas atau Piutang Simpan Pinjam tidak ditemukan.');
            }

            // Jurnal: DEBIT Kas, KREDIT Piutang
            Jurnal::create([
                'id_transaksi' => $transaksi->id,
                'id_account' => $akunKas->id,
                'jumlah' => $jadwal->jumlah_total,
                'tipe' => 'debit',
            ]);

            Jurnal::create([
                'id_transaksi' => $transaksi->id,
                'id_account' => $akunPiutang->id,
                'jumlah' => $jadwal->jumlah_total,
                'tipe' => 'kredit',
            ]);

            // Update jadwal angsuran
            $jadwal->status = 'lunas';
            $jadwal->tanggal_pembayaran = $today;
            $jadwal->save();

            DB::commit();

            return back()->with('success', 'Angsuran ke-'.$jadwal->angsuran_ke.' berhasil dibayar.');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }
}
