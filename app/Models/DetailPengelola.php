<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPengelola extends Model
{
    use HasFactory;

    protected $table = 'detail_pengelola';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'id_user',
        'nik',
        'telepon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kecamatan',
        'kabupaten_kotamadya',
        'provinsi',
        'tanggal_diangkat',
        'nomor_induk_kepegawaian',
        'nomor_telepon_hp',
        'status_keluarga',
        'jumlah_tanggungan',
        'nama_ahli_waris',
        'hubungan_ahli_waris',
        'jabatan',
        'foto',
        'ktp',
        'tanda_tangan',
    ];

    /**
     * Relasi ke User (detail_pengelola milik satu user)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
