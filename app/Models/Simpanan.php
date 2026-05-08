<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;

    protected $table = 'simpanan';

    protected $fillable = [
        'id_anggota',
        'id_user',
        'id_account',
        'nomor_bukti',
        'tanggal',
        'jenis_transaksi',
        'keterangan',
        'jumlah',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'id_account', 'id');
    }
}
