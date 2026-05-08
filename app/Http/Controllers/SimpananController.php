<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Anggota;
use App\Models\New\Jurnal;
use App\Models\New\Transaksi;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Kata kunci nama akun simpanan yang dianggap setor/tarik
        $keywords_simpanan = [
            'Simpanan Pokok',
            'Simpanan Wajib',
            'Simpanan Sukarela',
        ];

        // Cari akun simpanan berdasarkan nama_account LIKE keyword
        $akun_simpanan = Account::where(function ($query) use ($keywords_simpanan) {
            foreach ($keywords_simpanan as $keyword) {
                $query->orWhere('nama_account', 'like', "%$keyword%");
            }
        })->pluck('id')->toArray();

        $jurnals = Jurnal::with(['transaksi.anggota', 'account'])
            ->join('transaksi', 'jurnal.id_transaksi', '=', 'transaksi.id')
            ->join('account', 'jurnal.id_account', '=', 'account.id')
            ->select('jurnal.*', 'transaksi.id_anggota', 'account.nama_account', 'transaksi.tanggal', 'transaksi.keterangan')
            ->whereIn('jurnal.id_account', $akun_simpanan)
            ->get();

        $total_setor = 0;
        $total_tarik = 0;
        $per_jenis = [];
        $transaksi_ids = [];

        foreach ($jurnals as $jurnal) {
            $idAccount = $jurnal->id_account;
            $tipe = strtolower($jurnal->tipe); // debit atau kredit
            $jumlah = $jurnal->jumlah;
            $idAnggota = $jurnal->id_anggota;
            $namaAccount = strtolower($jurnal->nama_account ?? '');

            // Tentukan jenis simpanan dari nama account (misal simpanan pokok, wajib, dll)
            // Kita cocokkan dengan keywords agar konsisten
            $jenisKey = null;
            foreach ($keywords_simpanan as $keyword) {
                if (str_contains(strtolower($namaAccount), strtolower($keyword))) {
                    $jenisKey = str_replace(' ', '_', strtolower($keyword));
                    break;
                }
            }
            if (! $jenisKey) {
                // Lewati jika jenis tidak dikenali
                continue;
            }

            // Inisialisasi jika belum ada
            if (! isset($per_jenis[$jenisKey])) {
                $per_jenis[$jenisKey] = [
                    'nama_account' => ucwords(str_replace('_', ' ', $jenisKey)),
                    'total_setor' => 0,
                    'total_tarik' => 0,
                    'jumlah_transaksi_setor' => 0,
                    'jumlah_transaksi_tarik' => 0,
                ];
            }

            if ($tipe == 'kredit') {
                // Kredit di akun simpanan = setoran
                $per_jenis[$jenisKey]['total_setor'] += $jumlah;
                $total_setor += $jumlah;
                $transaksi_ids[$idAnggota][$jenisKey]['setor'][$jurnal->id_transaksi] = true;
            } elseif ($tipe == 'debit') {
                // Debit di akun simpanan = penarikan
                $per_jenis[$jenisKey]['total_tarik'] += $jumlah;
                $total_tarik += $jumlah;
                $transaksi_ids[$idAnggota][$jenisKey]['tarik'][$jurnal->id_transaksi] = true;
            }
        }

        // Hitung jumlah transaksi unik per jenis per anggota (setor & tarik)
        foreach ($transaksi_ids as $anggotaTransaksis) {
            foreach ($anggotaTransaksis as $jenisKey => $tipeTransaksis) {
                $per_jenis[$jenisKey]['jumlah_transaksi_setor'] += isset($tipeTransaksis['setor']) ? count($tipeTransaksis['setor']) : 0;
                $per_jenis[$jenisKey]['jumlah_transaksi_tarik'] += isset($tipeTransaksis['tarik']) ? count($tipeTransaksis['tarik']) : 0;
            }
        }

        $jumlah_anggota = count($transaksi_ids);

        // Ambil transaksi terakhir 20 terbaru yang berkaitan dengan akun simpanan
        $last_transaksi = Transaksi::with(['anggota', 'jurnal.account'])
            ->whereHas('jurnal', function ($q) use ($akun_simpanan) {
                $q->whereIn('id_account', $akun_simpanan);
            })
            ->orderBy('tanggal', 'desc')
            ->limit(20)
            ->get();

        $statistik = [
            'total_setor' => $total_setor,
            'total_tarik' => $total_tarik,
            'jumlah_transaksi' => $jurnals->groupBy('id_transaksi')->count(),
            'jumlah_anggota' => $jumlah_anggota,
            'per_jenis_simpanan' => collect($per_jenis),
        ];

        return view('transaksi.simpanan.theme2.index', [
            'simpanan' => $last_transaksi,
            'statistik' => $statistik,
            'akun_simpanan' => $akun_simpanan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $keywords = ['Simpanan Pokok', 'Simpanan Wajib', 'Simpanan Sukarela'];

        $account = Account::where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('nama_account', 'like', '%'.$keyword.'%');
            }
        })->get();

        $anggota = Anggota::all();

        return view('transaksi.simpanan.theme2.create', compact('account', 'anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'id_anggota' => 'required|exists:anggota,id',
    //         'id_account' => [
    //             'required',
    //             'exists:account,id',
    //             function ($attribute, $value, $fail) {
    //                 // Pastikan hanya akun dengan nama mengandung salah satu keyword
    //                 $keywords = ['Simpanan Pokok', 'Simpanan Wajib', 'Simpanan Sukarela'];
    //                 $account = Account::find($value);

    //                 if ($account && ! collect($keywords)->contains(function ($keyword) use ($account) {
    //                     return stripos($account->nama_account, $keyword) !== false;
    //                 })) {
    //                     $fail('Akun simpanan yang dipilih tidak valid.');
    //                 }
    //             },
    //         ],
    //         'tanggal' => 'required|date',
    //         'keterangan' => 'nullable|string|max:255',
    //         'jumlah' => 'required|numeric|min:1000',
    //         'bukti_transaksi' => 'nullable|image|max:2048',
    //     ]);

    //     DB::transaction(function () use ($request) {
    //         // Upload bukti jika ada
    //         $buktiPath = null;
    //         if ($request->hasFile('bukti_transaksi')) {
    //             $buktiPath = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
    //         }

    //         // Buat transaksi
    //         $transaksi = Transaksi::create([
    //             'id_anggota' => $request->id_anggota,
    //             'tanggal' => $request->tanggal,
    //             'keterangan' => $request->keterangan ?? 'Setoran Simpanan Anggota',
    //             'ref' => $request->nomor_bukti ?? 'TRX-'.now()->format('YmdHis'),
    //             // 'bukti' => $buktiPath, // jika kolom ini ada di tabel transaksi
    //         ]);

    //         // Akun kas (default debit)
    //         $akunKas = Account::where('no_account', '1011')->firstOrFail(); // Kas Simpan Pinjam

    //         // DEBIT Kas
    //         Jurnal::create([
    //             'id_transaksi' => $transaksi->id,
    //             'id_account' => $akunKas->id,
    //             'tipe' => 'debit',
    //             'jumlah' => $request->jumlah,
    //         ]);

    //         // KREDIT ke akun simpanan (Pokok/Wajib/Sukarela)
    //         Jurnal::create([
    //             'id_transaksi' => $transaksi->id,
    //             'id_account' => $request->id_account,
    //             'tipe' => 'kredit',
    //             'jumlah' => $request->jumlah,
    //         ]);
    //     });

    //     return redirect()->route('transaksi.simpanan.index')->with('success', 'Simpanan anggota berhasil disimpan.');
    // }
    public function store(Request $request)
    {
        $request->merge([
            'jumlah_pokok' => ($request->jumlah_pokok == 0 || $request->jumlah_pokok == '0') ? null : $request->jumlah_pokok,
            'jumlah_wajib' => ($request->jumlah_wajib == 0 || $request->jumlah_wajib == '0') ? null : $request->jumlah_wajib,
            'jumlah_sukarela' => ($request->jumlah_sukarela == 0 || $request->jumlah_sukarela == '0') ? null : $request->jumlah_sukarela,
        ]);

        $validated = $request->validate([
            'id_anggota' => 'required|exists:anggota,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',

            // MINIMAL SALAH SATU DIISI
            'jumlah_pokok' => 'required_without_all:jumlah_wajib,jumlah_sukarela|numeric|min:0',
            'jumlah_wajib' => 'required_without_all:jumlah_pokok,jumlah_sukarela|numeric|min:0',
            'jumlah_sukarela' => 'required_without_all:jumlah_pokok,jumlah_wajib|numeric|min:0',

            'bukti_transaksi' => 'nullable|image|max:2048',

        ], [

            'id_anggota.required' => 'Nama anggota harus dipilih.',
            'id_anggota.exists' => 'Anggota tidak ditemukan dalam database.',

            'tanggal.required' => 'Tanggal transaksi harus diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',

            'keterangan.string' => 'Keterangan harus berupa teks.',
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',

            // Pesan jika tidak ada satu pun yang diisi
            'jumlah_pokok.required_without_all' => 'Minimal salah satu simpanan harus diisi (Pokok/Wajib/Sukarela).',
            'jumlah_pokok.numeric' => 'Jumlah Simpanan Pokok harus berupa angka.',
            'jumlah_pokok.min' => 'Jumlah Simpanan Pokok minimal Rp0.',

            'jumlah_wajib.required_without_all' => 'Minimal salah satu simpanan harus diisi (Pokok/Wajib/Sukarela).',
            'jumlah_wajib.numeric' => 'Jumlah Simpanan Wajib harus berupa angka.',
            'jumlah_wajib.min' => 'Jumlah Simpanan Wajib minimal Rp0.',

            'jumlah_sukarela.required_without_all' => 'Minimal salah satu simpanan harus diisi (Pokok/Wajib/Sukarela).',
            'jumlah_sukarela.numeric' => 'Jumlah Simpanan Sukarela harus berupa angka.',
            'jumlah_sukarela.min' => 'Jumlah Simpanan Sukarela minimal Rp0.',

            'bukti_transaksi.image' => 'Bukti transaksi harus berupa file gambar.',
            'bukti_transaksi.max' => 'Ukuran file bukti transaksi maksimal 2 MB.',
        ]);

        // Validasi minimal satu jenis simpanan harus diisi
        if (
            empty($request->jumlah_pokok) &&
            empty($request->jumlah_wajib) &&
            empty($request->jumlah_sukarela)
        ) {
            return back()->withErrors(['jumlah_wajib' => 'Minimal satu jenis simpanan harus diisi.'])->withInput();
        }

        DB::transaction(function () use ($request) {
            // Upload bukti transaksi jika ada
            $buktiPath = null;
            if ($request->hasFile('bukti_transaksi')) {
                $buktiPath = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
            }

            // Buat transaksi baru
            $transaksi = \App\Models\New\Transaksi::create([
                'id_anggota' => $request->id_anggota,
                'id_user' => auth()->id(),
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan ?? 'Setoran Simpanan Anggota',
                'ref' => $request->nomor_bukti ?? 'TRX-'.now()->format('YmdHis'),
            ]);

            // Akun kas simpan pinjam (contoh no_account = 1011)
            $akunKas = \App\Models\Account::where('no_account', '1011')->firstOrFail();

            $totalSimpanan = 0;

            $mapSimpanan = [
                'jumlah_pokok' => 'Simpanan Pokok',
                'jumlah_wajib' => 'Simpanan Wajib',
                'jumlah_sukarela' => 'Simpanan Sukarela',
            ];

            foreach ($mapSimpanan as $field => $namaAccountKeyword) {
                $jumlah = (int) $request->input($field);

                if ($jumlah > 0) {
                    $account = \App\Models\Account::where('nama_account', 'LIKE', "%$namaAccountKeyword%")->first();

                    if (! $account) {
                        throw new \Exception("Akun dengan nama mengandung '$namaAccountKeyword' tidak ditemukan.");
                    }

                    // Buat jurnal kredit untuk simpanan
                    \App\Models\New\Jurnal::create([
                        'id_transaksi' => $transaksi->id,
                        'id_account' => $account->id,
                        'tipe' => 'kredit',
                        'jumlah' => $jumlah,
                        'keterangan' => "Setoran $namaAccountKeyword",
                    ]);

                    $totalSimpanan += $jumlah;
                }
            }

            // Buat jurnal debit untuk kas
            \App\Models\New\Jurnal::create([
                'id_transaksi' => $transaksi->id,
                'id_account' => $akunKas->id,
                'tipe' => 'debit',
                'jumlah' => $totalSimpanan,
                'keterangan' => 'Setoran Simpanan Kas',
            ]);

            // $simpanan = Simpanan::create([
            //     'id_anggota' => $request->id_anggota,
            //     'id_user' => Auth::user()->id,
            //     'id_transaksi' => $transaksi->id,
            //     'tanggal' => $request->tanggal,
            //     'jumlah_pokok' => $request->jumlah_pokok ?? 0,
            //     'jumlah_wajib' => $request->jumlah_wajib ?? 0,
            //     'jumlah_sukarela' => $request->jumlah_sukarela ?? 0,
            //     'keterangan' => $request->keterangan ?? 'Setoran Simpanan Anggota',
            // ]);
        });

        return redirect()->route('transaksi.simpanan.index')->with('success', 'Simpanan anggota berhasil disimpan.');
    }

    public function tarikForm()
    {
        $keywords = ['Simpanan Pokok', 'Simpanan Sukarela'];

        $account = Account::where(function ($query) use ($keywords) {
            foreach ($keywords as $keyword) {
                $query->orWhere('nama_account', 'like', '%'.$keyword.'%');
            }
        })->get();

        $anggota = Anggota::all();

        return view('transaksi.simpanan.theme2.pull', compact('account', 'anggota'));
    }

    public function getSaldoAnggota(Request $request)
    {
        $anggotaId = $request->anggota_id;

        // Ambil semua jurnal yg berhubungan dengan transaksi anggota ini dan akun simpanan
        $jurnals = Jurnal::query()
            ->whereHas('transaksi', function ($q) use ($anggotaId) {
                $q->where('id_anggota', $anggotaId);
            })
            ->with('account')
            ->get();

        // Inisialisasi saldo utk tiap jenis
        $saldo = [
            'pokok' => 0,
            'wajib' => 0,
            'sukarela' => 0,
        ];

        foreach ($jurnals as $j) {
            $nama = strtolower($j->account->nama_account);

            // Tentukan jenis berdasarkan nama akun
            $jenis = null;
            if (str_contains($nama, 'pokok')) {
                $jenis = 'pokok';
            } elseif (str_contains($nama, 'wajib')) {
                $jenis = 'wajib';
            } elseif (str_contains($nama, 'sukarela')) {
                $jenis = 'sukarela';
            } else {
                continue;
            }

            // Jika akun jenis simpanan, hitung saldo berdasarkan normal akun
            if ($j->account->saldo_normal === 'debit') {
                // saldo normal debit: debit meningkatkan, kredit mengurangi
                if ($j->tipe === 'debit') {
                    $saldo[$jenis] += $j->jumlah;
                } else { // kredit
                    $saldo[$jenis] -= $j->jumlah;
                }
            } else {
                // saldo normal kredit: kredit meningkatkan, debit mengurangi
                if ($j->tipe === 'kredit') {
                    $saldo[$jenis] += $j->jumlah;
                } else {
                    $saldo[$jenis] -= $j->jumlah;
                }
            }
        }

        return response()->json([
            'simpanan_pokok' => max($saldo['pokok'], 0),
            'simpanan_wajib' => max($saldo['wajib'], 0),
            'simpanan_sukarela' => max($saldo['sukarela'], 0),
        ]);
    }

    public function tarikStore(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'account_id' => 'required|exists:account,id',
            'jumlah' => 'required|numeric|min:1',
            'nomor_bukti' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'bukti_transaksi' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Handle upload bukti
            $buktiPath = null;
            if ($request->hasFile('bukti_transaksi')) {
                $buktiPath = $request->file('bukti_transaksi')->store('bukti-transaksi', 'public');
            }

            $keterangan = substr($request->keterangan ?: 'Penarikan simpanan anggota', 0, 255);

            // Simpan ke tabel transaksi
            $transaksi = Transaksi::create([
                'id_anggota' => $request->anggota_id,
                'id_user' => auth()->id(),
                'nomor_bukti' => $request->nomor_bukti,
                'tanggal' => $request->tanggal,
                'jenis' => 'penarikan_simpanan',
                'keterangan' => $keterangan,
                'bukti_transaksi' => $buktiPath,
                'jumlah' => $request->jumlah,
            ]);

            // Dapatkan akun simpanan dan akun kas
            $akunSimpanan = Account::findOrFail($request->account_id);
            $akunKas = Account::where('nama_account', 'like', '%kas simpan pinjam%')->first();

            if (! $akunKas) {
                throw new \Exception('Akun Kas tidak ditemukan.');
            }

            // Jurnal: KREDIT ke akun Kas (kas keluar), DEBIT ke akun Simpanan (kurangi simpanan)
            Jurnal::create([
                'id_transaksi' => $transaksi->id,
                'id_account' => $akunKas->id,
                'tipe' => 'kredit',
                'jumlah' => $request->jumlah,
                'keterangan' => 'Penarikan Simpanan - '.$akunSimpanan->nama_account,
            ]);

            Jurnal::create([
                'id_transaksi' => $transaksi->id,
                'id_account' => $akunSimpanan->id,
                'tipe' => 'debit',
                'jumlah' => $request->jumlah,
                'keterangan' => 'Penarikan Simpanan - '.$akunSimpanan->nama_account,
            ]);

            DB::commit();

            return redirect()->route('transaksi.simpanan.index')
                ->with('success', 'Penarikan simpanan berhasil disimpan.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Gagal menyimpan transaksi: '.$e->getMessage()])
                ->withInput();
        }
    }

    // public function getSaldoAnggota(Request $request)
    // {
    //     $anggotaId = $request->anggota_id;

    //     $saldoPerAnggota = Simpanan::select('id_anggota')
    //         ->selectRaw('
    //             -- Simpanan Pokok
    //             SUM(CASE WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN jumlah ELSE 0 END) AS total_setor_pokok,
    //             SUM(CASE WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN jumlah ELSE 0 END) AS total_tarik_pokok,
    //             SUM(CASE
    //                 WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN jumlah
    //                 WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN -jumlah
    //                 ELSE 0
    //             END) AS saldo_pokok,

    //             -- Simpanan Wajib
    //             SUM(CASE WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN jumlah ELSE 0 END) AS total_setor_wajib,
    //             SUM(CASE WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN jumlah ELSE 0 END) AS total_tarik_wajib,
    //             SUM(CASE
    //                 WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN jumlah
    //                 WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN -jumlah
    //                 ELSE 0
    //             END) AS saldo_wajib,

    //             -- Simpanan Sukarela
    //             SUM(CASE WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN jumlah ELSE 0 END) AS total_setor_sukarela,
    //             SUM(CASE WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN jumlah ELSE 0 END) AS total_tarik_sukarela,
    //             SUM(CASE
    //                 WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN jumlah
    //                 WHEN LOWER(account.nama_account) LIKE ? AND jenis_transaksi = ? THEN -jumlah
    //                 ELSE 0
    //             END) AS saldo_sukarela
    //         ', [
    //             // Simpanan Pokok
    //             '%simpanan pokok%', 'setor',
    //             '%simpanan pokok%', 'tarik',
    //             '%simpanan pokok%', 'setor',
    //             '%simpanan pokok%', 'tarik',

    //             // Simpanan Wajib
    //             '%simpanan wajib%', 'setor',
    //             '%simpanan wajib%', 'tarik',
    //             '%simpanan wajib%', 'setor',
    //             '%simpanan wajib%', 'tarik',

    //             // Simpanan Sukarela
    //             '%simpanan sukarela%', 'setor',
    //             '%simpanan sukarela%', 'tarik',
    //             '%simpanan sukarela%', 'setor',
    //             '%simpanan sukarela%', 'tarik',
    //         ])
    //         ->join('account', 'simpanan.id_account', '=', 'account.id')
    //         ->where('simpanan.id_anggota', $anggotaId)
    //         ->groupBy('id_anggota')
    //         ->first();

    //     // Kalau anggota belum punya simpanan sama sekali, kembalikan default 0
    //     if (! $saldoPerAnggota) {
    //         $saldoPerAnggota = (object) [
    //             'saldo_pokok' => 0,
    //             'saldo_wajib' => 0,
    //             'saldo_sukarela' => 0,
    //         ];
    //     }

    //     return response()->json([
    //         'simpanan_pokok' => (float) $saldoPerAnggota->saldo_pokok,
    //         'simpanan_wajib' => (float) $saldoPerAnggota->saldo_wajib,
    //         'simpanan_sukarela' => (float) $saldoPerAnggota->saldo_sukarela,
    //     ]);
    // }

    // public function tarikStore(Request $request)
    // {
    //     $request->validate([
    //         'anggota_id' => 'required|exists:anggota,id',
    //         'account_id' => 'required|exists:account,id',
    //         'jumlah' => 'required|numeric|min:1',
    //         'nomor_bukti' => 'required|string',
    //         'tanggal' => 'required|date',
    //         'keterangan' => 'nullable|string',
    //         'bukti_transaksi' => 'nullable|image|max:2048',
    //     ]);

    //     // Cek saldo anggota pada account yang dipilih
    //     $saldo = Simpanan::where('id_anggota', $request->anggota_id)
    //         ->where('id_account', $request->account_id)
    //         ->selectRaw("
    //             SUM(CASE WHEN jenis_transaksi = 'setor' THEN jumlah ELSE 0 END) -
    //             SUM(CASE WHEN jenis_transaksi = 'tarik' THEN jumlah ELSE 0 END) AS saldo
    //         ")
    //         ->value('saldo') ?? 0;

    //     if ($request->jumlah > $saldo) {
    //         return back()->withErrors(['jumlah' => 'Jumlah penarikan melebihi saldo tersedia.'])->withInput();
    //     }

    //     $buktiPath = null;
    //     if ($request->hasFile('bukti_transaksi')) {
    //         $buktiPath = $request->file('bukti_transaksi')->store('bukti-transaksi', 'public');
    //     }

    //     Simpanan::create([
    //         'id_anggota' => $request->anggota_id,
    //         'id_user' => Auth::user()->id,
    //         'id_account' => $request->account_id,
    //         'nomor_bukti' => $request->nomor_bukti,
    //         'tanggal' => $request->tanggal,
    //         'jenis_transaksi' => 'tarik', // ini untuk tarik
    //         'jumlah' => $request->jumlah,
    //         'keterangan' => $request->keterangan,
    //         'bukti_transaksi' => $buktiPath,
    //     ]);

    //     return redirect()->route('transaksi.simpanan.index')->with('success', 'Penarikan simpanan berhasil disimpan.');
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
