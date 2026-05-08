<?php

namespace App\Models;

use App\Models\New\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    // Mass assignable attributes
    protected $fillable = [
        'nomor_anggota',
        'nama',
        'jenis_kelamin',
        'alamat',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'telepon',
        'status_keluarga',
        'jumlah_tanggungan',
        'nama_ahli_waris',
        'hubungan_ahli_waris',
        'telepon_ahli_waris',
        'pekerjaan',
        'alamat_pekerjaan',
        'tanggal_pendaftaran',
        'rekening_simpanan_pokok',
        'rekening_simpanan_wajib',
        'rekening_simpanan_sukarela',
        'status',
    ];

    // Casts untuk data bertipe tertentu
    protected $casts = [
        'tanggal_pendaftaran' => 'date',
        'rekening_simpanan_pokok' => 'decimal:2',
        'rekening_simpanan_wajib' => 'decimal:2',
        'rekening_simpanan_sukarela' => 'decimal:2',
        'jumlah_tanggungan' => 'integer',
    ];

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class, 'id_anggota');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_anggota');
    }
}
