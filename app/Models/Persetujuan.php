<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    use HasFactory;

    protected $table = 'persetujuan';

    protected $fillable = ['id_pinjaman','id_user','tanggal_persetujuan','status','catatan'];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'id_pinjaman');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

