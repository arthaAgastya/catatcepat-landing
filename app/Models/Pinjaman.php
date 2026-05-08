<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';

    protected $fillable = [
        'id_anggota', 'kode_pinjaman', 'tanggal_pengajuan', 'jumlah_pinjaman',
        'tenor', 'jenis_angsuran',
        'besaran_jasa',
        'bunga_persen',
        'suku_bunga_tahunan',
        'biaya_admin',
        'tanggal_pengajuan',
        'tanggal_disetujui',
        'status',
    ];

    public static function generateKodePinjaman()
    {
        $prefix = 'PNJ';
        $datePart = date('ymd'); // '250929' untuk 29 Sep 2025
        $fullPrefix = $prefix.$datePart;

        // Cari kode pinjaman dengan prefix hari ini paling besar
        $lastPinjaman = self::where('kode_pinjaman', 'like', $fullPrefix.'%')
            ->orderBy('kode_pinjaman', 'desc')
            ->first();

        if (! $lastPinjaman) {
            $number = 1;
        } else {
            // Ambil nomor terakhir dari kode_pinjaman (misal PNJ250929000012 ambil 000012)
            $lastNumber = (int) substr($lastPinjaman->kode_pinjaman, strlen($fullPrefix));
            $number = $lastNumber + 1;
        }

        return $fullPrefix.str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id');
    }

    public function persetujuan()
    {
        return $this->hasOne(Persetujuan::class, 'id_pinjaman');
    }

    public function pencairan()
    {
        return $this->hasOne(Pencairan::class, 'id_pinjaman');
    }

    public function jadwalAngsuran()
    {
        return $this->hasMany(JadwalAngsuran::class, 'id_pinjaman');
    }
}
