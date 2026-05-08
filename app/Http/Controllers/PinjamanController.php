<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Anggota;
use App\Models\JadwalAngsuran;
use App\Models\New\Jurnal;
use App\Models\New\Transaksi;
use App\Models\Pencairan;
use App\Models\Persetujuan;
use App\Models\Pinjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PinjamanController extends Controller
{
    public function simulasi()
    {
        return view('transaksi.pinjaman.theme2.simulasi');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pinjaman = Pinjaman::with('anggota', 'pencairan', 'persetujuan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transaksi.pinjaman.theme2.index', compact('pinjaman'));
    }

    public function menuPersetujuan()
    {
        $pinjaman = Pinjaman::with('anggota', 'pencairan', 'persetujuan')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transaksi.pinjaman.theme2.menuPersetujuan', compact('pinjaman'));
    }

    public function menuPencairan()
    {
        $pinjaman = Pinjaman::with('anggota', 'pencairan', 'persetujuan')
            ->where('status', 'disetujui')
            ->whereDoesntHave('pencairan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transaksi.pinjaman.theme2.menuPencairan', compact('pinjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggota = Anggota::all();

        return view('transaksi.pinjaman.theme2.create', compact('anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_anggota' => 'required|exists:anggota,id',
            'jumlah' => 'required|numeric|min:1000',
            'bunga' => 'required|numeric|min:0',
            'suku_bunga_tahunan' => 'nullable|numeric|min:0', // baru, boleh null
            'tenor' => 'required|integer|min:1',
            'jenis_angsuran' => 'required|in:harian,mingguan,bulanan,jatuh_tempo',
            'besaran_jasa' => 'required|in:flat,anuitas,persen',
        ]);

        $kodePinjaman = Pinjaman::generateKodePinjaman();

        $pinjaman = Pinjaman::create([
            'id_anggota' => $validated['id_anggota'],
            'kode_pinjaman' => $kodePinjaman,
            'jumlah_pinjaman' => $validated['jumlah'],
            'bunga_persen' => $validated['bunga'],
            'suku_bunga_tahunan' => $validated['suku_bunga_tahunan'] ?? null, // simpan jika ada
            'tenor' => $validated['tenor'],
            'jenis_angsuran' => $validated['jenis_angsuran'],
            'besaran_jasa' => $validated['besaran_jasa'],
            'status' => 'pending', // default status
            'tanggal_pengajuan' => now(),
        ]);

        return redirect()
            ->route('transaksi.pinjaman.index')
            ->with('success', 'Pinjaman berhasil diajukan dengan kode '.$kodePinjaman);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kodePinjaman)
    {
        $pinjaman = Pinjaman::with('anggota', 'persetujuan', 'pencairan', 'jadwalAngsuran')
            ->where('kode_pinjaman', $kodePinjaman)
            ->firstOrFail();

        return view('transaksi.pinjaman.theme2.show', compact('pinjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function persetujuan(string $kodePinjaman)
    {
        $pinjaman = Pinjaman::with('anggota')->where('kode_pinjaman', $kodePinjaman)->firstOrFail();

        return view('transaksi.pinjaman.theme2.edit', compact('pinjaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function storePersetujuan(Request $request, string $kodePinjaman)
    {
        $pinjaman = Pinjaman::where('kode_pinjaman', $kodePinjaman)->firstOrFail();

        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string|max:1000',
        ]);

        Persetujuan::create([
            'id_pinjaman' => $pinjaman->id,
            'id_user' => Auth::id(),
            'tanggal_persetujuan' => now(),
            'status' => $validated['status'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        $pinjaman->update([
            'status' => $validated['status'],
        ]);

        $message = $validated['status'] === 'disetujui'
            ? 'Pinjaman telah disetujui. Lanjutkan ke proses pencairan.'
            : 'Pinjaman telah ditolak.';

        return redirect()->route('transaksi.pinjaman.index')
            ->with('success', $message);
    }

    public function pencairan(string $kodePinjaman)
    {
        $p = Pinjaman::with('anggota')->where('kode_pinjaman', $kodePinjaman)->firstOrFail();
        if (Persetujuan::where('id_pinjaman', $p->id)->where('status', 'disetujui')->exists()) {
            $pinjaman = Pinjaman::with('anggota')->where('kode_pinjaman', $kodePinjaman)->firstOrFail();

            return view('transaksi.pinjaman.theme2.pencairan', compact('pinjaman'));
        } else {
            return redirect()->route('transaksi.pinjaman.index')
                ->with('error', 'Pinjaman belum disetujui, tidak dapat melakukan pencairan.');
        }
    }

    // Simpan pencairan dan generate jadwal angsuran
    // public function storePencairan(Request $request, $kodePinjaman)
    // {
    //     $pinjaman = Pinjaman::where('kode_pinjaman', $kodePinjaman)->firstOrFail();

    //     $validated = $request->validate([
    //         'tanggal_pencairan' => 'required|date',
    //         'jumlah_cair' => 'required|numeric|min:1|max:'.$pinjaman->jumlah_pinjaman,
    //         'metode' => 'required|in:transfer,tunai',
    //     ]);

    //     DB::transaction(function () use ($pinjaman, $validated) {
    //         // Simpan pencairan
    //         $pencairan = Pencairan::create([
    //             'id_pinjaman' => $pinjaman->id,
    //             'tanggal_pencairan' => $validated['tanggal_pencairan'],
    //             'jumlah_cair' => $validated['jumlah_cair'],
    //             'metode' => $validated['metode'],
    //         ]);

    //         // Generate jadwal angsuran
    //         $jumlah = $pinjaman->jumlah_pinjaman;
    //         $bunga = $pinjaman->bunga_persen;
    //         $tenor = $pinjaman->tenor;
    //         $jenis = $pinjaman->jenis_angsuran;

    //         $totalBunga = $jumlah * ($bunga / 100);
    //         $pokokPerAngsuran = $jenis === 'jatuh_tempo' ? $jumlah : $jumlah / $tenor;
    //         $bungaPerAngsuran = $jenis === 'jatuh_tempo' ? $totalBunga : $totalBunga / $tenor;

    //         $tanggalAwal = \Carbon\Carbon::parse($validated['tanggal_pencairan']);

    //         for ($i = 1; $i <= $tenor; $i++) {
    //             $jatuhTempo = $tanggalAwal->copy();

    //             if ($jenis === 'harian') {
    //                 $jatuhTempo->addDays($i);
    //             } elseif ($jenis === 'mingguan') {
    //                 $jatuhTempo->addWeeks($i);
    //             } elseif ($jenis === 'bulanan') {
    //                 $jatuhTempo->addMonths($i);
    //             } elseif ($jenis === 'jatuh_tempo') {
    //                 $jatuhTempo->addMonths($tenor);
    //                 $i = $tenor; // sekali saja
    //             }

    //             JadwalAngsuran::create([
    //                 'id_pinjaman' => $pinjaman->id,
    //                 'angsuran_ke' => $i,
    //                 'tanggal_jatuh_tempo' => $jatuhTempo->format('Y-m-d'),
    //                 'jumlah_pokok' => $pokokPerAngsuran,
    //                 'jumlah_bunga' => $bungaPerAngsuran,
    //                 'jumlah_total' => $pokokPerAngsuran + $bungaPerAngsuran,
    //                 'status' => 'belum',
    //             ]);

    //             if ($jenis === 'jatuh_tempo') {
    //                 break;
    //             }
    //         }
    //     });

    //     return redirect()->route('transaksi.pinjaman.index')->with('success', 'Pencairan berhasil dan jadwal angsuran dibuat.');
    // }
    public function storePencairan(Request $request, $kodePinjaman)
    {
        $pinjaman = Pinjaman::where('kode_pinjaman', $kodePinjaman)->firstOrFail();

        $validated = $request->validate([
            'tanggal_pencairan' => 'required|date',
            'jumlah_cair' => 'required|numeric|min:1|max:'.$pinjaman->jumlah_pinjaman,
            'metode' => 'required|in:transfer,tunai',
        ]);

        DB::transaction(function () use ($pinjaman, $validated) {
            // Simpan data pencairan
            $pencairan = Pencairan::create([
                'id_pinjaman' => $pinjaman->id,
                'tanggal_pencairan' => $validated['tanggal_pencairan'],
                'jumlah_cair' => $validated['jumlah_cair'],
                'metode' => $validated['metode'],
            ]);

            // Ambil akun-akun yang dibutuhkan
            $akunPiutang = Account::where('nama_account', 'like', '%Piutang Simpan Pinjam (Piutang Uang)%')->first();
            $akunKas = Account::where('nama_account', 'like', '%Kas Simpan Pinjam%')->first();
            $akunPartisipasiJasa = Account::where('nama_account', 'like', '%Partisipasi Jasa Pinjaman Uang%')->first();

            if (! $akunPartisipasiJasa) {
                throw new \Exception("Akun 'Partisipasi Jasa Pinjaman Uang' tidak ditemukan.");
            }

            if (! $akunPiutang || ! $akunKas) {
                throw new \Exception("Akun 'Piutang Simpan Pinjam (Piutang Uang)' atau 'Kas Simpan Pinjam' tidak ditemukan.");
            }

            // Proses jadwal angsuran
            $jumlah = $pinjaman->jumlah_pinjaman;
            $tenor = $pinjaman->tenor;
            $bungaTahunan = $pinjaman->suku_bunga_tahunan ?? ($pinjaman->bunga_persen ?? 0);
            $jenis = $pinjaman->jenis_angsuran;
            $besaran = strtolower($pinjaman->besaran_jasa);

            $bungaBulanan = $bungaTahunan / 12 / 100;
            $totalBunga = 0;
            if ($besaran === 'flat') {
                $totalBunga = $jumlah * $bungaBulanan * $tenor;
            } elseif ($besaran === 'anuitas') {
                $angsuran = $jumlah * $bungaBulanan / (1 - pow(1 + $bungaBulanan, -$tenor));
                for ($i = 0, $sisa = $jumlah; $i < $tenor; $i++) {
                    $bunga = $sisa * $bungaBulanan;
                    $pokok = $angsuran - $bunga;
                    $sisa -= $pokok;
                    $totalBunga += $bunga;
                }
            } elseif ($besaran === 'menurun' || $besaran === 'persen') {
                for ($i = 0, $sisa = $jumlah; $i < $tenor; $i++) {
                    $bunga = $sisa * $bungaBulanan;
                    $sisa -= ($jumlah / $tenor);
                    $totalBunga += $bunga;
                }
            } elseif ($jenis === 'jatuh_tempo') {
                $totalBunga = $jumlah * $bungaBulanan * $tenor;
            }
            $sisaPokok = $jumlah;
            $tanggalAwal = Carbon::parse($validated['tanggal_pencairan']);

            // Buat transaksi
            $transaksi = Transaksi::create([
                'id_anggota' => $pinjaman->id_anggota,  // HARUS DIISI
                'id_user' => auth()->user()->id,
                'tanggal' => $validated['tanggal_pencairan'],
                'keterangan' => 'Pencairan pinjaman: '.$pinjaman->kode_pinjaman,
                'ref' => null, // optional jika ada
            ]);

            // Buat jurnal: DEBIT Piutang, KREDIT Kas
            Jurnal::create([
                'id_transaksi' => $transaksi->id,
                'id_account' => $akunPiutang->id,
                'jumlah' => $validated['jumlah_cair'] + $totalBunga,
                'tipe' => 'debit',
            ]);

            Jurnal::create([
                'id_transaksi' => $transaksi->id,
                'id_account' => $akunKas->id,
                'jumlah' => $validated['jumlah_cair'],
                'tipe' => 'kredit',
            ]);

            // DEBIT akun Partisipasi Jasa (Pendapatan Bunga), KREDIT akun Piutang (beban ditagih ke peminjam)
            Jurnal::create([
                'id_transaksi' => $transaksi->id,
                'id_account' => $akunPartisipasiJasa->id,
                'jumlah' => round($totalBunga),
                'tipe' => 'kredit',
            ]);
            // Jurnal::create([
            //     'id_transaksi' => $transaksi->id,
            //     'id_account' => $akunPartisipasiJasa->id,
            //     'jumlah' => round($totalBunga),
            //     'tipe' => 'debit',
            // ]);

            // Jurnal::create([
            //     'id_transaksi' => $transaksi->id,
            //     'id_account' => $akunPiutang->id,
            //     'jumlah' => round($totalBunga),
            //     'tipe' => 'kredit',
            // ]);

            for ($i = 1; $i <= $tenor; $i++) {
                $jatuhTempo = $tanggalAwal->copy();

                if ($jenis === 'harian') {
                    $jatuhTempo->addDays($i);
                } elseif ($jenis === 'mingguan') {
                    $jatuhTempo->addWeeks($i);
                } elseif ($jenis === 'bulanan') {
                    $jatuhTempo->addMonths($i);
                } elseif ($jenis === 'jatuh_tempo') {
                    $jatuhTempo->addMonths($tenor);
                    $i = $tenor;
                }

                $pokok = $jumlah / $tenor;
                $bunga = 0;
                $total = 0;

                if ($besaran === 'flat') {
                    $bunga = $jumlah * $bungaBulanan;
                    $total = $pokok + $bunga;
                } elseif ($besaran === 'anuitas') {
                    $angsuran = $jumlah * $bungaBulanan / (1 - pow(1 + $bungaBulanan, -$tenor));
                    $bunga = $sisaPokok * $bungaBulanan;
                    $pokok = $angsuran - $bunga;
                    $total = $angsuran;
                } elseif ($besaran === 'menurun' || $besaran === 'persen') {
                    $bunga = $sisaPokok * $bungaBulanan;
                    $total = $pokok + $bunga;
                }

                if ($jenis === 'jatuh_tempo') {
                    $pokok = $jumlah;
                    $bunga = $jumlah * $bungaBulanan * $tenor;
                    $total = $pokok + $bunga;
                }

                JadwalAngsuran::create([
                    'id_pinjaman' => $pinjaman->id,
                    'angsuran_ke' => $i,
                    'kode_angsuran' => $pinjaman->kode_pinjaman.sprintf('%03d', $i),
                    'tanggal_jatuh_tempo' => $jatuhTempo->format('Y-m-d'),
                    'jumlah_pokok' => round($pokok),
                    'jumlah_bunga' => round($bunga),
                    'jumlah_total' => round($total),
                    'status' => 'belum',
                ]);

                $sisaPokok -= $pokok;

                if ($jenis === 'jatuh_tempo') {
                    break;
                }
            }
        });

        return redirect()->route('transaksi.pinjaman.index')->with('success', 'Pencairan berhasil dan jadwal angsuran dibuat.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function pengecekanPinjaman()
    {
        $anggota = Anggota::all();

        return view('transaksi.pinjaman.theme2.pengecekan', compact('anggota'));
    }

    public function getDataPinjaman(Request $request)
    {
        $pinjaman = Pinjaman::with(['anggota', 'persetujuan', 'pencairan', 'jadwalAngsuran'])
            ->where('id_anggota', $request->id_anggota)
            ->latest()
            ->first();

        if (! $pinjaman) {
            return response()->json(['error' => 'Data pinjaman tidak ditemukan'], 404);
        }

        $response = [
            'nik' => $pinjaman->anggota->nomor_anggota ?? '-',
            'pengajuan' => $pinjaman->jumlah_pinjaman,
            'besaran_jasa' => $pinjaman->besaran_jasa,
            'biaya_pinjaman' => $pinjaman->biaya_admin,
            'status' => ucfirst($pinjaman->status),
            'nomor_akad' => $pinjaman->kode_pinjaman ?? '',
            'tanggal_akad' => \Carbon\Carbon::parse($pinjaman->tanggal_pengajuan)->translatedFormat('d F Y'),
        ];

        if ($pinjaman->status === 'disetujui') {
            // Kirim jadwal angsuran dari DB
            $response['jadwal_angsuran'] = $pinjaman->jadwalAngsuran->map(function ($item) {
                return [
                    'angsuran_ke' => $item->angsuran_ke,
                    'tanggal' => \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y'),
                    'jumlah_pokok' => $item->jumlah_pokok,
                    'jumlah_bunga' => $item->jumlah_bunga,
                    'jumlah_total' => $item->jumlah_total,
                    'status' => $item->status,
                ];
            });
        } elseif ($pinjaman->status === 'ditolak') {
            // Kirim data yang diperlukan untuk perhitungan manual di frontend
            $response['manual_calc'] = [
                'jumlah' => $pinjaman->jumlah_pinjaman,
                'bunga' => $pinjaman->bunga_persen,
                'tenor' => $pinjaman->tenor,
                'jenis' => $pinjaman->jenis_angsuran, // <-- perbaikan
                'besaran' => $pinjaman->besaran_jasa, // <-- perbaikan
            ];
        }

        return response()->json($response);
    }
}
