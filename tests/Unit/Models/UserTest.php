<?php

namespace Tests\Unit\Models;

use App\Models\Anggota;
use App\Models\DetailPengelola;
use App\Models\Persetujuan;
use App\Models\Pinjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_has_fillable_attributes()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testuser',
            'password' => 'password123',
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('testuser', $user->username);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    #[Test]
    public function it_hides_sensitive_attributes()
    {
        $user = User::factory()->create();

        $userArray = $user->toArray();

        $this->assertArrayNotHasKey('password', $userArray);
        $this->assertArrayNotHasKey('remember_token', $userArray);
    }

    #[Test]
    public function it_casts_password_as_hashed()
    {
        $user = new User();

        $user->password = 'plainpassword';
        $this->assertTrue(Hash::check('plainpassword', $user->password));

        $user->email_verified_at = '2023-01-01';
        $this->assertInstanceOf(\Carbon\Carbon::class, $user->email_verified_at);
    }

    #[Test]
    public function it_has_detail_pengelola_relationship()
    {
        $user = User::factory()->create();

        $detailPengelola = DetailPengelola::create([
            'id_user' => $user->id,
            'nik' => '1234567890123456',
            'telepon' => '081234567890',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Test No. 1',
            'kecamatan' => 'Test Kecamatan',
            'kabupaten_kotamadya' => 'Test Kota',
            'provinsi' => 'DKI Jakarta',
            'tanggal_diangkat' => '2023-01-01',
            'nomor_induk_kepegawaian' => 'NIP123456',
            'nomor_telepon_hp' => '081234567890',
            'jabatan' => 'Manager',
        ]);

        $this->assertInstanceOf(DetailPengelola::class, $user->detailPengelola);
        $this->assertEquals($detailPengelola->id, $user->detailPengelola->id);
    }

    #[Test]
    public function it_has_persetujuan_relationship()
    {
        $user = User::factory()->create();
        $anggota = Anggota::factory()->create();

        $pinjaman = Pinjaman::create([
            'id_anggota' => $anggota->id,
            'kode_pinjaman' => 'PJN001',
            'tanggal_pengajuan' => '2023-01-01',
            'jumlah_pinjaman' => 1000000,
            'tenor' => 12,
            'jenis_angsuran' => 'bulanan',
            'besaran_jasa' => 'flat',
            'bunga_persen' => 1.5,
            'biaya_admin' => 50000,
            'status' => 'disetujui',
        ]);

        $persetujuan = Persetujuan::create([
            'id_user' => $user->id,
            'id_pinjaman' => $pinjaman->id,
            'tanggal_persetujuan' => '2023-01-01',
            'status' => 'disetujui',
            'catatan' => 'Approved by manager',
        ]);

        $this->assertInstanceOf(Persetujuan::class, $user->persetujuan->first());
        $this->assertCount(1, $user->persetujuan);
    }

    #[Test]
    public function it_uses_has_roles_trait()
    {
        $user = User::factory()->create();

        $this->assertTrue(method_exists($user, 'assignRole'));
        $this->assertTrue(method_exists($user, 'hasRole'));
        $this->assertTrue(method_exists($user, 'getRoleNames'));
    }

    #[Test]
    public function it_uses_notifiable_trait()
    {
        $user = User::factory()->create();

        $this->assertTrue(method_exists($user, 'notify'));
        $this->assertTrue(method_exists($user, 'notifications'));
    }

    #[Test]
    public function it_can_be_created_with_factory()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->id);
        $this->assertNotNull($user->name);
        $this->assertNotNull($user->email);
    }
}
