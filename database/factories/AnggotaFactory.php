<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_anggota' => $this->faker->unique()->numerify('ANG-#####'),
            'nama' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'alamat' => $this->faker->address(),
            'kecamatan' => $this->faker->city(),
            'kabupaten' => $this->faker->city(),
            'provinsi' => $this->faker->state(),
            'telepon' => $this->faker->phoneNumber(),
            'status_keluarga' => $this->faker->randomElement(['Kepala Keluarga', 'Anggota Keluarga']),
            'jumlah_tanggungan' => $this->faker->numberBetween(0, 5),
            'nama_ahli_waris' => $this->faker->name(),
            'hubungan_ahli_waris' => 'Saudara',
            'telepon_ahli_waris' => $this->faker->phoneNumber(),
            'pekerjaan' => $this->faker->jobTitle(),
            'alamat_pekerjaan' => $this->faker->address(),
            'tanggal_pendaftaran' => $this->faker->date(),
            'rekening_simpanan_pokok' => $this->faker->randomFloat(2, 100000, 1000000),
            'rekening_simpanan_wajib' => $this->faker->randomFloat(2, 100000, 500000),
            'rekening_simpanan_sukarela' => $this->faker->randomFloat(2, 0, 500000),
            'status' => 'aktif',
        ];
    }
}
