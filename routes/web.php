<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Master\AccountController;
use App\Http\Controllers\Master\AnggotaController;
use App\Http\Controllers\Master\PermissionController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\TransaksiController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\OCRController;
use App\Http\Controllers\PencatatanController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SimpananController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    // Route::resource('roles', RoleController::class);
    // Route::resource('users', UserController::class);

    Route::post('/ocr/parse', [OCRController::class, 'parse'])->name('ocr.parse');
    Route::post('/ocr/invoice/parse', [OCRController::class, 'parseInvoice'])->name('ocr.invoice.parse');

    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('pengelola', UserController::class);
        Route::resource('anggota', AnggotaController::class);
        Route::resource('akun', AccountController::class);
        Route::get('akun/kategori/create', [AccountController::class, 'createCategories'])->name('akun.kategori.create');
        Route::post('akun/kategori/store', [AccountController::class, 'storeCategories'])->name('akun.kategori.store');
        Route::get('generate-no-account/{prefix}', [AccountController::class, 'generateNoAccount']);
        Route::get('update-kelompok-akun', [AccountController::class, 'updateKelompokAkun'])->name('update.kelompok.akun');
    });

    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('pinjaman/persetujuan', [PinjamanController::class, 'menuPersetujuan'])->name('pinjaman.menuPersetujuan');
        Route::get('pinjaman/pencairan', [PinjamanController::class, 'menuPencairan'])->name('pinjaman.menuPencairan');
        Route::resource('pinjaman', PinjamanController::class);
        Route::get('pinjaman/simulasi', [PinjamanController::class, 'simulasi'])->name('pinjaman.simulasi');
        Route::get('pinjaman/{kodePinjaman}/persetujuan', [PinjamanController::class, 'persetujuan'])->name('pinjaman.persetujuan');
        Route::put('pinjaman/{kodePinjaman}/persetujuan', [PinjamanController::class, 'storePersetujuan'])->name('pinjaman.persetujuan.store');
        Route::get('pinjaman/{kodePinjaman}/pencairan', [PinjamanController::class, 'pencairan'])->name('pinjaman.pencairan');
        Route::post('pinjaman/{kodePinjaman}/pencairan', [PinjamanController::class, 'storePencairan'])->name('pinjaman.pencairan.store');

        // Transaksi Angsuran
        Route::get('angsuran', [TransaksiController::class, 'angsuran'])->name('angsuran.index');
        Route::post('angsuran/bayar/{kode}', [TransaksiController::class, 'bayarAngsuran'])->name('angsuran.bayar');

        // Route::resource('simpanan', SimpananController::class);
        Route::get('simpanan', [SimpananController::class, 'index'])->name('simpanan.index');
        Route::get('simpanan/create', [SimpananController::class, 'create'])->name('simpanan.create');
        Route::post('simpanan', [SimpananController::class, 'store'])->name('simpanan.store');
        Route::get('simpanan/tarik', [SimpananController::class, 'tarikForm'])->name('simpanan.tarik');
        Route::get('simpanan/saldo-anggota', [SimpananController::class, 'getSaldoAnggota'])->name('simpanan.saldo.anggota');
        Route::post('simpanan/tarik', [SimpananController::class, 'tarikStore'])->name('simpanan.tarik.store');

        Route::get('pengecekan-pinjaman', [PinjamanController::class, 'pengecekanPinjaman'])->name('pengecekanPinjaman');
        Route::post('ajax/pengecekan-pinjaman', [PinjamanController::class, 'getDataPinjaman'])->name('ajax.pengecekanPinjaman');

        // Transaksi Lain
        Route::get('transaksi-non-barang/create', [TransaksiController::class, 'createNonBarang'])->name('transaksiNonBarang.create');
        Route::post('transaksi-non-barang/store', [TransaksiController::class, 'storeNonBarang'])->name('transaksiNonBarang.store');
        Route::resource('transaksi-lain', TransaksiController::class);
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        // Laporan
        Route::get('simpanan', [LaporanController::class, 'simpanan'])->name('simpanan');
        // Route::get('simpanan', function () {
        //     return view('laporan.simpanan.index');
        // })->name('simpanan');
        Route::get('pinjaman', [LaporanController::class, 'pinjaman'])->name('pinjaman');
        Route::get('shu', function () {
            return view('laporan.shu.index');
        })->name('shu');
    });

    Route::prefix('pencatatan')->name('pencatatan.')->group(function () {
        Route::get('laporan-posisi-keuangan', [PencatatanController::class, 'neraca'])->name('neraca');
        Route::get('jurnal', [PencatatanController::class, 'jurnal'])->name('jurnal');
        Route::get('buku-besar', [PencatatanController::class, 'bb'])->name('bb');
        Route::get('laporan-perhitungan-usaha', [PencatatanController::class, 'lpu'])->name('lpu');
        Route::get('neraca-saldo', [PencatatanController::class, 'ns'])->name('ns');
        Route::get('laporan-arus-kas', [PencatatanController::class, 'lak'])->name('lak');
        Route::get('laporan-perubahan-ekuitas', [PencatatanController::class, 'lpe'])->name('lpe');
    });
});
