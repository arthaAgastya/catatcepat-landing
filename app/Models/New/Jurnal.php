<?php

namespace App\Models\New;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal'; // opsional

    protected $fillable = [
        'id_transaksi',
        'id_account',
        'tipe',
        'jumlah',
    ];

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    // Relasi ke Akun
    public function account()
    {
        return $this->belongsTo(Account::class, 'id_account');
    }

    public function files()
    {
        return $this->morphMany(\App\Models\File::class, 'fileable');
    }
}
