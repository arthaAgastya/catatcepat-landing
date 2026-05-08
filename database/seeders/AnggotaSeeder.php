<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('anggota')->insert([
            [
                'nomor_anggota' => 'AGT001',
                'nama' => 'Ahmad Fauzi',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 10',
                'kecamatan' => 'Cibiru',
                'kabupaten' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'telepon' => '081234567890',
                'status_keluarga' => 'Kepala Keluarga',
                'jumlah_tanggungan' => 3,
                'nama_ahli_waris' => 'Siti Aminah',
                'hubungan_ahli_waris' => 'Istri',
                'telepon_ahli_waris' => '081234567891',
                'pekerjaan' => 'Karyawan Swasta',
                'alamat_pekerjaan' => 'Jl. Industri No. 7',
                'tanggal_pendaftaran' => now(),
                'rekening_simpanan_pokok' => '1234567890',
                'rekening_simpanan_wajib' => '1234567891',
                'rekening_simpanan_sukarela' => '1234567892',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_anggota' => 'AGT002',
                'nama' => 'Dewi Lestari',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Melati No. 5',
                'kecamatan' => 'Cicendo',
                'kabupaten' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'telepon' => '081234567892',
                'status_keluarga' => 'Ibu Rumah Tangga',
                'jumlah_tanggungan' => 2,
                'nama_ahli_waris' => 'Budi Santoso',
                'hubungan_ahli_waris' => 'Suami',
                'telepon_ahli_waris' => '081234567893',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'alamat_pekerjaan' => '-',
                'tanggal_pendaftaran' => now(),
                'rekening_simpanan_pokok' => '1234567893',
                'rekening_simpanan_wajib' => '1234567894',
                'rekening_simpanan_sukarela' => '1234567895',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
