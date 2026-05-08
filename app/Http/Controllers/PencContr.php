<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\New\Jurnal;
use Illuminate\Support\Str;

class PencatatanController extends Controller
{
    public function neraca()
    {
        // Ambil semua akun & jurnal
        $accounts = Account::orderBy('no_account')->get();
        $jurnals = Jurnal::all();

        // Hitung saldo tiap akun
        $akunData = $accounts->map(function ($akun) use ($jurnals) {
            $jurnalAkun = $jurnals->where('id_account', $akun->id);

            $totalDebit = $jurnalAkun->where('tipe', 'debit')->sum('jumlah');
            $totalKredit = $jurnalAkun->where('tipe', 'kredit')->sum('jumlah');

            if ($akun->saldo_normal === 'debit') {
                $saldo = $totalDebit - $totalKredit;
            } else {
                $saldo = $totalKredit - $totalDebit;
            }

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

        // Pisahkan Aktiva, Kewajiban, Ekuitas
        $aktiva = $akunData->filter(fn ($a) => str_starts_with($a['no_account'], '1'));
        $kewajiban = $akunData->filter(fn ($a) => str_starts_with($a['no_account'], '2'));

        // Ekuitas termasuk akun laba/rugi - sisa hasil usaha
        $ekuitas = $akunData->filter(fn ($a) => str_starts_with($a['no_account'], '3') || strpos($a['nama_account'], 'Laba/Rugi - Sisa Hasil Usaha') !== false);

        // Hitung Total Laba/Rugi (Pendapatan - Beban)
        $pendapatan = $akunData->filter(fn ($a) => str_starts_with($a['no_account'], '4')); // Asumsi kode akun pendapatan diawali dengan '4'
        $beban = $akunData->filter(fn ($a) => str_starts_with($a['no_account'], '5')); // Asumsi kode akun beban diawali dengan '5'

        $totalPendapatan = $pendapatan->sum('saldo');
        $totalBeban = $beban->sum('saldo');

        // Hitung Laba/Rugi
        $labaRugi = $totalPendapatan - $totalBeban;

        // Tambahkan Laba/Rugi ke Ekuitas (Laba/Rugi - Sisa Hasil Usaha)
        $ekuitas = $ekuitas->map(function ($a) use ($labaRugi) {
            if (strpos($a['nama_account'], 'Laba/Rugi - Sisa Hasil Usaha') !== false) {
                $a['saldo'] += $labaRugi; // Update saldo laba/rugi
            }

            return $a;
        });

        // Hitung total aktiva dengan memperhatikan akun kontra
        $totalAktiva = $aktiva->reduce(function ($carry, $item) {
            if ($item['saldo_normal'] === 'debit') {
                return $carry + $item['saldo'];
            } else {
                // akun kontra, saldo normal kredit di Aktiva dikurangkan
                return $carry - $item['saldo'];
            }
        }, 0);

        // Hitung total kewajiban dan ekuitas, semua saldo normal kredit, jumlahkan langsung
        $totalKewajiban = $kewajiban->reduce(function ($carry, $item) {
            if ($item['saldo_normal'] === 'kredit') {
                return $carry + $item['saldo'];
            } else {
                return $carry - $item['saldo'];
            }
        }, 0);

        $totalEkuitas = $ekuitas->reduce(function ($carry, $item) {
            if ($item['saldo_normal'] === 'kredit') {
                return $carry + $item['saldo'];
            } else {
                return $carry - $item['saldo'];
            }
        }, 0);

        $totalPasiva = $totalKewajiban + $totalEkuitas;

        return view('pencatatan.neraca', compact(
            'aktiva', 'kewajiban', 'ekuitas',
            'totalAktiva', 'totalPasiva', 'labaRugi'
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

            // Gabungkan jurnal yang account nama mengandung 'kas' menjadi satu baris
            $kasItems = $items->filter(fn ($item) => $item->account && Str::contains(strtolower($item->account->nama_account), 'kas')
            );

            if ($kasItems->isNotEmpty()) {
                // Hitung total debit dan kredit kas berdasarkan tipe jurnal
                $kasDebit = $kasItems->where('tipe', 'debit')->sum('jumlah');
                $kasKredit = $kasItems->where('tipe', 'kredit')->sum('jumlah');

                $result[] = (object) [
                    'tanggal' => $transaksi->tanggal,
                    'transaksi' => $transaksi,
                    'ref' => $transaksi->ref,
                    'keterangan' => 'Kas Simpan Pinjam',
                    'no_account' => $kasItems->first()->account->no_account ?? '',
                    'nomor_anggota' => '',
                    'debit' => $kasDebit,
                    'kredit' => $kasKredit,
                    'nama_account' => 'Kas Simpan Pinjam',
                    'nama_anggota' => '',
                ];

                $totalDebit += $kasDebit;
                $totalKredit += $kasKredit;
            }

            // Jurnal selain kas
            $otherItems = $items->reject(fn ($item) => $item->account && Str::contains(strtolower($item->account->nama_account), 'kas')
            );

            foreach ($otherItems as $jurnal) {
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
                    'tanggal' => '', // supaya tanggal tidak duplikat
                    'transaksi' => $transaksi,
                    'ref' => '',
                    'keterangan' => $jurnal->transaksi->keterangan ?? '',
                    'no_account' => $jurnal->account->no_account ?? '',
                    'nomor_anggota' => $jurnal->transaksi->anggota->nomor_anggota ?? '',
                    'debit' => $debit,
                    'kredit' => $kredit,
                    'nama_account' => $jurnal->account->nama_account ?? '',
                    'nama_anggota' => $jurnal->transaksi->anggota->nama ?? '',
                ];
            }
        }

        $selisihSaldo = $totalDebit - $totalKredit;
        $seimbang = ($selisihSaldo == 0);

        return view('pencatatan.jurnal', [
            'jurnals' => collect($result),
            'totalDebit' => $totalDebit,
            'totalKredit' => $totalKredit,
            'selisihSaldo' => $selisihSaldo,
            'seimbang' => $seimbang,
        ]);
    }
}
