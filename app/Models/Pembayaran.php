<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = ['id_jadwal', 'tanggal_bayar', 'jumlah_bayar', 'denda', 'status'];

    public function jadwal()
    {
        return $this->belongsTo(JadwalAngsuran::class, 'id_jadwal');
    }
}
