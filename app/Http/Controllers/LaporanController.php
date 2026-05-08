<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function simpanan()
    {
        $keywords_setor = [
            'simpanan pokok',
            'simpanan wajib',
            'simpanan sukarela',
        ];

        $keywords_tarik = [
            'pengambilan simpanan pokok',
            'pengambilan simpanan wajib',
            'pengambilan simpanan sukarela',
        ];

        // Ambil semua anggota
        $anggota = Anggota::all()->keyBy('id');

        $result = [];

        // Ambil data jurnal dengan join transaksi dan account
        $jurnals = DB::table('jurnal')
            ->join('transaksi', 'jurnal.id_transaksi', '=', 'transaksi.id')
            ->join('account', 'jurnal.id_account', '=', 'account.id')
            ->select(
                'transaksi.id_anggota',
                'account.nama_account',
                DB::raw('SUM(jurnal.jumlah) as total')
            )
            ->where(function ($query) use ($keywords_setor, $keywords_tarik) {
                foreach (array_merge($keywords_setor, $keywords_tarik) as $keyword) {
                    $query->orWhere('account.nama_account', 'like', "%$keyword%");
                }
            })
            ->groupBy('transaksi.id_anggota', 'account.nama_account')
            ->get();

        // Inisialisasi data anggota
        foreach ($anggota as $a) {
            $result[$a->id] = [
                'nomor' => $a->nomor_anggota,
                'nama' => $a->nama,
                'jenis_kelamin' => $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                'simpanan_pokok_setor' => 0,
                'simpanan_pokok_tarik' => 0,
                'simpanan_pokok_saldo' => 0,
                'simpanan_wajib_setor' => 0,
                'simpanan_wajib_tarik' => 0,
                'simpanan_wajib_saldo' => 0,
                'simpanan_sukarela_setor' => 0,
                'simpanan_sukarela_tarik' => 0,
                'simpanan_sukarela_saldo' => 0,
            ];
        }

        // Mapping nama_account ke jenis simpanan dan tipe setor/tarik
        foreach ($jurnals as $jurnal) {
            $idAnggota = $jurnal->id_anggota;
            $namaAccount = strtolower($jurnal->nama_account);
            $total = $jurnal->total;

            // Cek setor
            foreach ($keywords_setor as $keyword) {
                if (str_contains($namaAccount, $keyword)) {
                    $key = str_replace(' ', '_', $keyword); // contoh: 'simpanan_pokok'
                    $result[$idAnggota]["{$key}_setor"] += $total;
                }
            }

            // Cek tarik
            foreach ($keywords_tarik as $keyword) {
                if (str_contains($namaAccount, $keyword)) {
                    // Hilangkan 'pengambilan ' supaya key-nya sama dengan setor
                    $cleanKey = str_replace(['pengambilan ', ' '], ['', '_'], $keyword);
                    $result[$idAnggota]["{$cleanKey}_tarik"] += $total;
                }
            }
        }

        // Hitung saldo
        foreach ($result as &$item) {
            foreach (['simpanan_pokok', 'simpanan_wajib', 'simpanan_sukarela'] as $key) {
                $item["{$key}_saldo"] = $item["{$key}_setor"] - $item["{$key}_tarik"];
            }
        }
        unset($item);

        $data = collect(array_values($result));

        return view('laporan.simpanan.index2', compact('data'));
    }

    public function pinjaman()
    {
        // Ambil semua anggota
        $anggota = Anggota::all()->keyBy('id');

        $result = [];

        // Inisialisasi data anggota
        foreach ($anggota as $a) {
            $result[$a->id] = [
                'nomor' => $a->nomor_anggota,
                'nama' => $a->nama,
                'jenis_kelamin' => $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                'total_pinjaman' => 0,
                'total_angsuran' => 0,
                'saldo_pinjaman' => 0,
            ];
        }

        // Ambil data pinjaman yang sudah dicairkan
        $pinjaman = Pinjaman::with(['pencairan', 'jadwalAngsuran.pembayaran'])
            ->whereHas('pencairan')
            ->get();

        foreach ($pinjaman as $p) {
            $idAnggota = $p->id_anggota;
            $totalPinjaman = $p->pencairan->jumlah_cair ?? 0;

            // Hitung total angsuran yang sudah dibayar
            $totalAngsuran = 0;
            foreach ($p->jadwalAngsuran as $jadwal) {
                $totalAngsuran += $jadwal->pembayaran->sum('jumlah_bayar') ?? 0;
            }

            $result[$idAnggota]['total_pinjaman'] += $totalPinjaman;
            $result[$idAnggota]['total_angsuran'] += $totalAngsuran;
            $result[$idAnggota]['saldo_pinjaman'] = $result[$idAnggota]['total_pinjaman'] - $result[$idAnggota]['total_angsuran'];
        }

        $data = collect(array_values($result));

        return view('laporan.pinjaman.index2', compact('data'));
    }
}
