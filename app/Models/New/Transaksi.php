<?php

namespace App\Models\New;

use App\Models\Anggota;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; // opsional, Laravel akan asumsikan otomatis

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_anggota', // nullable
        'id_user',
        'tanggal',
        'keterangan',
        'ref',
    ];

    // Relasi ke Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    // Relasi ke Jurnal
    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'id_transaksi');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
