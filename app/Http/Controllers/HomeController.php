<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountCategory;
use App\Models\Anggota;
use App\Models\DetailPengelola;
use App\Models\File;
use App\Models\JadwalAngsuran;
use App\Models\New\DetailTransaksi;
use App\Models\New\Jurnal;
use App\Models\New\Transaksi;
use App\Models\Pembayaran;
use App\Models\Pencairan;
use App\Models\Persetujuan;
use App\Models\Pinjaman;
use App\Models\SaldoAwalNeraca;
use App\Models\Simpanan;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Statistik Anggota
        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'aktif')->count();
        $anggotaTidakAktif = Anggota::where('status', '!=', 'aktif')->count();

        // Statistik Pinjaman
        $totalPinjaman = Pinjaman::count();
        $pinjamanDisetujui = Pinjaman::where('status', 'disetujui')->count();
        $pinjamanDitolak = Pinjaman::where('status', 'ditolak')->count();
        $pinjamanPending = Pinjaman::where('status', 'pending')->count();
        $totalNilaiPinjaman = Pinjaman::where('status', 'disetujui')->sum('jumlah_pinjaman');

        // Statistik Simpanan
        $totalSimpanan = Simpanan::count();
        $totalNilaiSimpanan = Simpanan::sum('jumlah');
        $simpananPokok = Simpanan::whereHas('account', function ($q) {
            $q->where('nama_account', 'like', '%pokok%');
        })->sum('jumlah');
        $simpananWajib = Simpanan::whereHas('account', function ($q) {
            $q->where('nama_account', 'like', '%wajib%');
        })->sum('jumlah');
        $simpananSukarela = Simpanan::whereHas('account', function ($q) {
            $q->where('nama_account', 'like', '%sukarela%');
        })->sum('jumlah');

        // Statistik Account
        $totalAccount = Account::count();
        $totalAccountCategory = AccountCategory::count();

        // Statistik User
        $totalUser = User::count();

        // Statistik Transaksi
        $totalTransaksi = Transaksi::count();
        $totalJurnal = Jurnal::count();
        $totalDetailTransaksi = DetailTransaksi::count();

        // Statistik Pembayaran
        $totalPembayaran = Pembayaran::count();
        $totalNilaiPembayaran = Pembayaran::sum('jumlah_bayar');

        // Statistik Jadwal Angsuran
        $totalJadwalAngsuran = JadwalAngsuran::count();
        $jadwalAngsuranLunas = JadwalAngsuran::where('status', 'lunas')->count();
        $jadwalAngsuranBelumLunas = JadwalAngsuran::where('status', 'belum_lunas')->count();

        // Statistik Persetujuan
        $totalPersetujuan = Persetujuan::count();
        $persetujuanDisetujui = Persetujuan::where('status', 'disetujui')->count();
        $persetujuanDitolak = Persetujuan::where('status', 'ditolak')->count();

        // Statistik Pencairan
        $totalPencairan = Pencairan::count();
        $totalNilaiPencairan = Pencairan::sum('jumlah_cair');

        // Statistik File
        $totalFile = File::count();

        // Statistik Saldo Awal Neraca
        $totalSaldoAwalNeraca = SaldoAwalNeraca::count();
        $totalNilaiSaldoAwal = SaldoAwalNeraca::sum('saldo_awal');

        // Statistik Detail Pengelola
        $totalDetailPengelola = DetailPengelola::count();

        return view('home2', compact(
            'totalAnggota', 'anggotaAktif', 'anggotaTidakAktif',
            'totalPinjaman', 'pinjamanDisetujui', 'pinjamanDitolak', 'pinjamanPending', 'totalNilaiPinjaman',
            'totalSimpanan', 'totalNilaiSimpanan', 'simpananPokok', 'simpananWajib', 'simpananSukarela',
            'totalAccount', 'totalAccountCategory',
            'totalUser',
            'totalTransaksi', 'totalJurnal', 'totalDetailTransaksi',
            'totalPembayaran', 'totalNilaiPembayaran',
            'totalJadwalAngsuran', 'jadwalAngsuranLunas', 'jadwalAngsuranBelumLunas',
            'totalPersetujuan', 'persetujuanDisetujui', 'persetujuanDitolak',
            'totalPencairan', 'totalNilaiPencairan',
            'totalFile',
            'totalSaldoAwalNeraca', 'totalNilaiSaldoAwal',
            'totalDetailPengelola'
        ));
    }
}
