<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\New\Jurnal;

class PencatatanController extends Controller
{
    public function neraca()
    {
        // Ambil semua akun dan jurnal
        $accounts = Account::orderBy('no_account')->get();
        $jurnals = Jurnal::all();

        // Proses akun dengan menghitung saldo berdasarkan jurnal terkait
        $akunData = $accounts->map(function ($akun) use ($jurnals) {
            $jurnalAkun = $jurnals->where('id_account', $akun->id);

            $totalDebit = $jurnalAkun->where('tipe', 'debit')->sum('jumlah');
            $totalKredit = $jurnalAkun->where('tipe', 'kredit')->sum('jumlah');

            $saldo = $akun->saldo_normal === 'debit'
                ? $totalDebit - $totalKredit
                : $totalKredit - $totalDebit;

            return [
                'no_account' => $akun->no_account,
                'nama_account' => $akun->nama_account,
                'kelompok' => $akun->kelompok,
                'saldo' => $saldo,
                'saldo_normal' => $akun->saldo_normal,
                'totalDebit' => $totalDebit,
                'totalKredit' => $totalKredit,
            ];
        });

        // Mengelompokkan berdasarkan 'kelompok' akun
        $aktiva = $akunData->filter(fn ($a) => $a['kelompok'] === 'Aktiva');
        $kewajiban = $akunData->filter(fn ($a) => $a['kelompok'] === 'Kewajiban');
        $ekuitas = $akunData->filter(fn ($a) => $a['kelompok'] === 'Ekuitas');
        $pendapatan = $akunData->filter(fn ($a) => $a['kelompok'] === 'Pendapatan');
        $beban = $akunData->filter(fn ($a) => $a['kelompok'] === 'Beban');

        // Menghitung total saldo untuk masing-masing kelompok
        $totalAktiva = $aktiva->reduce(function ($carry, $item) {
            return $carry + ($item['saldo_normal'] === 'debit' ? $item['saldo'] : -$item['saldo']);
        }, 0);

        $totalKewajiban = $kewajiban->reduce(function ($carry, $item) {
            return $carry + ($item['saldo_normal'] === 'kredit' ? $item['saldo'] : -$item['saldo']);
        }, 0);

        $totalEkuitas = $ekuitas->reduce(function ($carry, $item) {
            return $carry + ($item['saldo_normal'] === 'kredit' ? $item['saldo'] : -$item['saldo']);
        }, 0);

        $totalPasiva = $totalKewajiban + $totalEkuitas;

        // Menghitung total pendapatan dan beban
        $totalPendapatan = $pendapatan->sum('saldo');
        $totalBeban = $beban->sum('saldo');

        // Menghitung laba rugi
        $labaRugi = $totalPendapatan - $totalBeban;

        // Mengembalikan view dengan data yang sudah diproses
        return view('pencatatan.theme2.neraca', compact(
            'aktiva', 'kewajiban', 'ekuitas',
            'totalAktiva', 'totalPasiva',
            'pendapatan', 'beban', 'totalPendapatan', 'totalBeban', 'labaRugi'
        ));
    }

    public function lpu()
    {
        $accounts = Account::orderBy('no_account')->get();
        $jurnals = Jurnal::all();

        $akunData = $accounts->map(function ($akun) use ($jurnals) {
            $jurnalAkun = $jurnals->where('id_account', $akun->id);

            $totalDebit = $jurnalAkun->where('tipe', 'debit')->sum('jumlah');
            $totalKredit = $jurnalAkun->where('tipe', 'kredit')->sum('jumlah');

            $saldo = $akun->saldo_normal === 'debit'
                ? $totalDebit - $totalKredit
                : $totalKredit - $totalDebit;

            return [
                'no_account' => $akun->no_account,
                'nama_account' => $akun->nama_account,
                'level' => $akun->level,
                'saldo' => $saldo,
                'saldo_normal' => $akun->saldo_normal,
                'totalDebit' => $totalDebit,
                'totalKredit' => $totalKredit,
            ];
        });

        // Pendapatan and Beban
        $pendapatan = $akunData->filter(fn ($a) => str_starts_with($a['no_account'], '4'));
        // $beban = $akunData->filter(fn ($a) => str_starts_with($a['no_account'], '5'));
        $beban = $akunData->filter(fn ($a) => (int) substr($a['no_account'], 0, 1) >= 5);

        $totalPendapatan = $pendapatan->sum('saldo');
        $totalBeban = $beban->sum('saldo');

        $labaRugi = $totalPendapatan - $totalBeban;

        return view('pencatatan.theme2.lpu', compact(
            'pendapatan', 'beban', 'totalPendapatan', 'totalBeban', 'labaRugi'
        ));
    }

    public function jurnal()
    {
        $jurnals = \App\Models\New\Jurnal::with(['transaksi.anggota', 'account'])
            ->get()
            ->sortBy(fn ($jurnal) => $jurnal->transaksi->tanggal ?? null);

        $grouped = $jurnals->groupBy('id_transaksi');

        $result = [];
        $totalDebit = 0;
        $totalKredit = 0;

        foreach ($grouped as $idTransaksi => $items) {
            $transaksi = $items->first()->transaksi;
            $count = $items->count();
            $isFirst = true;

            foreach ($items as $jurnal) {
                $debit = 0;
                $kredit = 0;

                if ($jurnal->tipe == 'debit') {
                    $debit = $jurnal->jumlah;
                    $totalDebit += $jurnal->jumlah;
                } elseif ($jurnal->tipe == 'kredit') {
                    $kredit = $jurnal->jumlah;
                    $totalKredit += $jurnal->jumlah;
                }

                $result[] = (object) [
                    'tanggal' => $isFirst ? $transaksi->tanggal : '',
                    'transaksi' => $transaksi,
                    'ref' => $isFirst ? $transaksi->ref : '',
                    'keterangan' => $isFirst ? $jurnal->transaksi->keterangan ?? '' : '',
                    'no_account' => $jurnal->account->no_account ?? '',
                    'nomor_anggota' => $isFirst ? $jurnal->transaksi->anggota->nomor_anggota ?? '' : '',
                    'debit' => $debit,
                    'kredit' => $kredit,
                    'nama_account' => $jurnal->account->nama_account ?? '',
                    'nama_anggota' => $isFirst ? $jurnal->transaksi->anggota->nama ?? '' : '',
                    'rowspan' => $isFirst ? $count : 0,
                ];

                $isFirst = false;
            }
        }

        $selisihSaldo = $totalDebit - $totalKredit;
        $seimbang = ($selisihSaldo == 0);

        return view('pencatatan.theme2.jurnal', [
            'jurnals' => collect($result),
            'totalDebit' => $totalDebit,
            'totalKredit' => $totalKredit,
            'selisihSaldo' => $selisihSaldo,
            'seimbang' => $seimbang,
        ]);
    }

    public function bb()
    {
        $jurnals = \App\Models\New\Jurnal::with(['transaksi.anggota', 'account'])
            ->get()
            ->sortBy(fn ($jurnal) => $jurnal->transaksi->tanggal ?? null);

        $grouped = $jurnals->groupBy('id_transaksi');

        $result = [];
        $totalDebit = 0;
        $totalKredit = 0;

        foreach ($grouped as $idTransaksi => $items) {
            $transaksi = $items->first()->transaksi;
            $count = $items->count();
            $isFirst = true;

            foreach ($items as $jurnal) {
                $debit = 0;
                $kredit = 0;

                if ($jurnal->tipe == 'debit') {
                    $debit = $jurnal->jumlah;
                    $totalDebit += $jurnal->jumlah;
                } elseif ($jurnal->tipe == 'kredit') {
                    $kredit = $jurnal->jumlah;
                    $totalKredit += $jurnal->jumlah;
                }

                $result[] = (object) [
                    'tanggal' => $isFirst ? $transaksi->tanggal : '',
                    'transaksi' => $transaksi,
                    'ref' => $isFirst ? $transaksi->ref : '',
                    'keterangan' => $isFirst ? $jurnal->transaksi->keterangan ?? '' : '',
                    'no_account' => $jurnal->account->no_account ?? '',
                    'nomor_anggota' => $isFirst ? $jurnal->transaksi->anggota->nomor_anggota ?? '' : '',
                    'debit' => $debit,
                    'kredit' => $kredit,
                    'nama_account' => $jurnal->account->nama_account ?? '',
                    'nama_anggota' => $isFirst ? $jurnal->transaksi->anggota->nama ?? '' : '',
                    'rowspan' => $isFirst ? $count : 0,
                ];

                $isFirst = false;
            }
        }

        $selisihSaldo = $totalDebit - $totalKredit;
        $seimbang = ($selisihSaldo == 0);

        return view('pencatatan.theme2.bb', [
            'jurnals' => collect($result),
            'totalDebit' => $totalDebit,
            'totalKredit' => $totalKredit,
            'selisihSaldo' => $selisihSaldo,
            'seimbang' => $seimbang,
        ]);
    }

    public function ns()
    {
        // Eager load accounts with categories
        $accounts = Account::with('category')->orderBy('no_account')->get();
        $jurnals = Jurnal::all();

        // Prepare grouped accounts by category name
        $groupedAccounts = [];

        foreach ($accounts as $akun) {
            $jurnalAkun = $jurnals->where('id_account', $akun->id);

            $totalDebit = $jurnalAkun->where('tipe', 'debit')->sum('jumlah');
            $totalKredit = $jurnalAkun->where('tipe', 'kredit')->sum('jumlah');

            $saldo = $akun->saldo_normal === 'debit'
                ? $totalDebit - $totalKredit
                : $totalKredit - $totalDebit;

            $categoryName = $akun->category ? $akun->category->category : 'Uncategorized';

            $groupedAccounts[$categoryName][] = [
                'no_account' => $akun->no_account,
                'nama_account' => $akun->nama_account,
                'level' => $akun->level,
                'saldo' => $saldo,
                'saldo_normal' => $akun->saldo_normal,
                'totalDebit' => $totalDebit,
                'totalKredit' => $totalKredit,
            ];
        }

        return view('pencatatan.theme2.ns', compact('groupedAccounts'));
    }

    public function lak()
    {
        // Ambil data akun dan jurnal dengan eager load transaksi pada jurnal
        $accounts = Account::orderBy('no_account')->get();
        $jurnals = Jurnal::with('transaksi')->get();

        $akunData = $accounts->map(function ($akun) use ($jurnals) {
            // Jurnals di filter dengan id_account dan harus punya transaksi terkait (transaksi tidak null)
            $jurnalAkun = $jurnals->where('id_account', $akun->id)->filter(fn ($j) => $j->transaksi !== null);

            $totalDebit = $jurnalAkun->where('tipe', 'debit')->sum('jumlah');
            $totalKredit = $jurnalAkun->where('tipe', 'kredit')->sum('jumlah');

            $saldo = $akun->saldo_normal === 'debit'
                ? $totalDebit - $totalKredit
                : $totalKredit - $totalDebit;

            return [
                'no_account' => $akun->no_account,
                'nama_account' => $akun->nama_account,
                'kelompok' => $akun->kelompok,
                'saldo' => $saldo,
                'saldo_normal' => $akun->saldo_normal,
                'totalDebit' => $totalDebit,
                'totalKredit' => $totalKredit,
            ];
        });

        $kasSetaraKas = $akunData->filter(function ($a) {
            return $a['kelompok'] === 'Aktiva' &&
                   (str_contains(strtolower($a['nama_account']), 'kas') || str_contains(strtolower($a['nama_account']), 'bank'));
        });

        $arusKasMasuk = $akunData->filter(function ($a) {
            return $a['kelompok'] === 'Pendapatan';
        });

        $arusKasKeluar = $akunData->filter(function ($a) {
            return in_array($a['kelompok'], ['HPP', 'Beban Usaha', 'Beban Umum & Administrasi', 'Pendapatan/Beban Lain', 'Distribusi SHU / Zakat']);
        });

        $totalArusKasMasuk = $arusKasMasuk->sum('saldo');
        $totalArusKasKeluar = $arusKasKeluar->sum('saldo');
        $saldoAkhirKas = $kasSetaraKas->sum('saldo');

        return view('pencatatan.theme2.lak', compact(
            'kasSetaraKas', 'arusKasMasuk', 'arusKasKeluar',
            'totalArusKasMasuk', 'totalArusKasKeluar', 'saldoAkhirKas'
        ));
    }

    public function lpe()
    {
        // Accept optional year parameter from request, default current year
        $year = request()->input('year', date('Y'));

        // Calculate date boundaries for filtering journals
        $startOfYear = $year.'-01-01';
        $endOfYear = $year.'-12-31';

        // Load all accounts ordered
        $accounts = Account::orderBy('no_account')->get();

        // Get saldo awal from SaldoAwalNeraca table instead of calculating from Jurnal
        $saldoAwalNeracas = \App\Models\SaldoAwalNeraca::all();
        $saldoAwal = [];
        foreach ($accounts as $akun) {
            $saldoRecord = $saldoAwalNeracas->firstWhere('id_account', $akun->id);
            $saldoAwal[$akun->no_account] = $saldoRecord ? $saldoRecord->saldo_awal : 0;
        }

        // Load journals with transaksi relation, filtered by date ranges as needed
        $jurnalsAll = Jurnal::with('transaksi')->get();

        // Function to filter journals by date within year inclusive
        $filterJurnalByYear = fn ($startDate, $endDate) => $jurnalsAll->filter(function ($j) use ($startDate, $endDate) {
            return $j->transaksi && $j->transaksi->tanggal >= $startDate && $j->transaksi->tanggal <= $endDate;
        });

        // Calculate additions and reductions during year
        $jurnalYear = $filterJurnalByYear($startOfYear, $endOfYear);

        // Define equity account groups as per ChartOfAccountSeeder
        $equityAccountGroups = [
            'Simpanan Pokok' => ['3010'],
            'Simpanan Wajib' => ['3020'],
            'Cadangan' => ['3040'],
            'Penyertaan' => ['3030'],
            'Hibah' => ['3050'],
            'SHU' => ['3060'],
        ];

        $penambahan = [];
        $pengurangan = [];
        $saldoAkhir = [];

        foreach ($equityAccountGroups as $name => $accountNos) {
            $penambahan[$name] = 0;
            $pengurangan[$name] = 0;
            $saldoAkhir[$name] = 0;

            foreach ($accountNos as $accNo) {
                $akun = $accounts->firstWhere('no_account', $accNo);
                if (! $akun) {
                    continue;
                }

                // Filter journals for this account in the year
                $journalAcc = $jurnalYear->where('id_account', $akun->id);

                // Sums for debit and credit in this year
                $totalDebit = $journalAcc->where('tipe', 'debit')->sum('jumlah');
                $totalKredit = $journalAcc->where('tipe', 'kredit')->sum('jumlah');

                // Penambahan and Pengurangan depend on saldo_normal and journal types:
                // For kredit normal accounts, credit increases balance, debit decreases balance
                if ($akun->saldo_normal === 'kredit') {
                    $penambahan[$name] += $totalKredit;
                    $pengurangan[$name] += $totalDebit;
                } else {
                    // For debit normal accounts, debit increases balance, credit decreases balance
                    $penambahan[$name] += $totalDebit;
                    $pengurangan[$name] += $totalKredit;
                }

                // Ending saldo calculation = beginning saldo + penambahan - pengurangan
                $beginSaldo = $saldoAwal[$accNo] ?? 0;
                $saldoAkhir[$name] += $beginSaldo + (($akun->saldo_normal === 'kredit')
                    ? ($totalKredit - $totalDebit)
                    : ($totalDebit - $totalKredit)
                );
            }
        }

        // Calculate total sums for table total column
        $saldoAwalTotal = array_sum(array_map(fn ($accNos) => array_sum(array_map(fn ($accNo) => $saldoAwal[$accNo] ?? 0, $accNos)), $equityAccountGroups
        ));
        $penambahanTotal = array_sum($penambahan);
        $penguranganTotal = array_sum($pengurangan);
        $saldoAkhirTotal = array_sum($saldoAkhir);

        // Fallback: if saldoAkhirTotal is zero, use latest data available as of now for saldoAkhir
        if ($saldoAkhirTotal == 0) {
            foreach ($equityAccountGroups as $name => $accountNos) {
                $saldoAkhir[$name] = 0;
                foreach ($accountNos as $accNo) {
                    $akun = $accounts->firstWhere('no_account', $accNo);
                    if (! $akun) {
                        continue;
                    }

                    $journalAcc = $jurnalsAll->where('id_account', $akun->id);
                    $totalDebit = $journalAcc->where('tipe', 'debit')->sum('jumlah');
                    $totalKredit = $journalAcc->where('tipe', 'kredit')->sum('jumlah');
                    $saldoAkhir[$name] += $akun->saldo_normal === 'kredit'
                        ? $totalKredit - $totalDebit
                        : $totalDebit - $totalKredit;
                }
            }
            $saldoAkhirTotal = array_sum($saldoAkhir);
        }

        return view('pencatatan.theme2.lpe', compact(
            'year',
            'equityAccountGroups',
            'saldoAwal',
            'penambahan',
            'pengurangan',
            'saldoAkhir',
            'saldoAwalTotal',
            'penambahanTotal',
            'penguranganTotal',
            'saldoAkhirTotal',
        ));
    }
}
