<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalAngsuran extends Model
{
    use HasFactory;

    protected $table = 'jadwal_angsuran';

    protected $fillable = [
        'id_pinjaman', 'kode_angsuran', 'angsuran_ke', 'tanggal_jatuh_tempo',
        'jumlah_pokok', 'jumlah_bunga', 'jumlah_total', 'status',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_jadwal');
    }
}
