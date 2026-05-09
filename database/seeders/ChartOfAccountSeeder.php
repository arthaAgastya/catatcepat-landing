<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coa = [
            // no_account, saldo_normal, level, nama_account, kelompok (Disesuaikan dengan Postgres Check Constraint)
            
            // AKTIVA (Kelompok 1 -> 'Aktiva')
            ['1000', 'debit', '1', 'Aktiva Lancar', 'Aktiva'],
            ['1010', 'debit', '1', 'Kas', 'Aktiva'],
            ['1011', 'debit', '2', 'Kas Simpan Pinjam', 'Aktiva'],
            ['1012', 'debit', '2', 'Kas Toko', 'Aktiva'],
            ['1211', 'debit', '2', 'Bank', 'Aktiva'],
            ['1311', 'debit', '2', 'Piutang Simpan Pinjam (Piutang Uang)', 'Aktiva'],
            ['1312', 'debit', '2', 'Piutang Barang (Toko)', 'Aktiva'],
            ['1320', 'debit', '2', 'Piutang Lain-lain', 'Aktiva'],
            ['1411', 'debit', '2', 'Persediaan Barang Dagangan', 'Aktiva'],
            ['1600', 'debit', '1', 'Harta Tetap', 'Aktiva'],
            ['1610', 'debit', '2', 'Tanah', 'Aktiva'],
            ['1620', 'debit', '2', 'Bangunan', 'Aktiva'],
            ['1621', 'kredit', '2', 'Akumulasi Penyusutan Bangunan', 'Aktiva'],
            ['1630', 'debit', '2', 'Peralatan', 'Aktiva'],
            ['1631', 'kredit', '2', 'Akumulasi Penyusutan Peralatan', 'Aktiva'],
            ['1640', 'debit', '2', 'Kendaraan', 'Aktiva'],
            ['1641', 'kredit', '2', 'Akumulasi Penyusutan Kendaraan', 'Aktiva'],
            ['1313', 'debit', '1', 'Piutang Simpan Pinjam Model A', 'Aktiva'],
            ['1319', 'kredit', '1', 'Penyisihan Penghapusan Piutang', 'Aktiva'],
            ['1412', 'debit', '1', 'Persediaan ATK', 'Aktiva'],

            // KEWAJIBAN (Kelompok 2 -> 'Kewajiban')
            ['2000', 'kredit', '1', 'Kewajiban', 'Kewajiban'],
            ['2110', 'kredit', '1', 'Kewajiban Lancar', 'Kewajiban'],
            ['2111', 'kredit', '2', 'Simpanan Sukarela (Tabkop)', 'Kewajiban'],
            ['2112', 'kredit', '2', 'Hutang Usaha Simpan Pinjam', 'Kewajiban'],
            ['2120', 'kredit', '2', 'Hutang Usaha Toko', 'Kewajiban'],
            ['2130', 'kredit', '2', 'Hutang Lain-lain', 'Kewajiban'],
            ['2141', 'kredit', '2', 'Dana-dana SHU Bagian Anggota', 'Kewajiban'],
            ['2142', 'kredit', '2', 'Dana Pendidikan', 'Kewajiban'],
            ['2143', 'kredit', '2', 'Dana Pembangunan Daerah', 'Kewajiban'],
            ['2144', 'kredit', '2', 'Dana Sosial', 'Kewajiban'],
            ['2145', 'kredit', '2', 'Dana Pengurus', 'Kewajiban'],
            ['2146', 'kredit', '2', 'Dana Karyawan', 'Kewajiban'],
            ['2151', 'kredit', '2', 'Hutang Pajak', 'Kewajiban'],
            ['2200', 'kredit', '1', 'Kewajiban Jangka Panjang', 'Kewajiban'],
            ['2210', 'kredit', '2', 'Hutang Bank', 'Kewajiban'],
            ['2220', 'kredit', '2', 'Hutang ke KPPDK', 'Kewajiban'],
            ['2112', 'kredit', '2', 'Utang Beban', 'Kewajiban'],

            // EKUITAS (Kelompok 3 -> 'Ekuitas')
            ['3000', 'kredit', '1', 'Ekuitas / Modal Sendiri', 'Ekuitas'],
            ['3010', 'kredit', '2', 'Simpanan Pokok', 'Ekuitas'],
            ['3020', 'kredit', '2', 'Simpanan Wajib', 'Ekuitas'],
            ['3030', 'kredit', '2', 'Penyertaan Modal dari KPPDK', 'Ekuitas'],
            ['3040', 'kredit', '2', 'Cadangan', 'Ekuitas'],
            ['3050', 'kredit', '2', 'Hibah / Donasi', 'Ekuitas'],
            ['3060', 'kredit', '2', 'Laba/Rugi - Sisa Hasil Usaha', 'Ekuitas'],

            // PENDAPATAN (Kelompok 4 -> 'Pendapatan')
            ['4000', 'kredit', '1', 'Partisipasi Anggota dan Pendapatan', 'Pendapatan'],
            ['4111', 'kredit', '2', 'Partisipasi Jasa Pinjaman Uang', 'Pendapatan'],
            ['4112', 'kredit', '2', 'Partisipasi Jasa Pinjaman Barang', 'Pendapatan'],
            ['4120', 'kredit', '2', 'Penjualan Barang', 'Pendapatan'],
            ['4130', 'kredit', '2', 'Jasa Giro', 'Pendapatan'],
            ['4140', 'kredit', '2', 'Penerimaan Lain-lain', 'Pendapatan'],
            ['4113', 'kredit', '2', 'Pendapatan Hasil Kerja Sama', 'Pendapatan'],

            // BEBAN (Kelompok 5 -> 'Beban Usaha' atau 'Beban Umum & Administrasi')
            ['5010', 'debit', '2', 'Pembelian', 'HPP'],
            ['6010', 'debit', '2', 'Harga Pokok Penjualan', 'HPP'],
            ['7000', 'debit', '2', 'Biaya-Biaya', 'Beban Usaha'],
            ['7011', 'debit', '2', 'Biaya Jasa Simpanan Anggota', 'Beban Usaha'],
            ['7012', 'debit', '2', 'Beban Bunga KPPDK Pusat', 'Beban Usaha'],
            ['7111', 'debit', '2', 'Gaji Pengurus', 'Beban Usaha'],
            ['7112', 'debit', '2', 'Gaji Karyawan', 'Beban Usaha'],
            ['7113', 'debit', '2', 'Biaya Lembur', 'Beban Usaha'],
            ['7114', 'debit', '2', 'Biaya Kesejahteraan', 'Beban Usaha'],
            ['7115', 'debit', '2', 'Biaya THR', 'Beban Usaha'],
            ['7210', 'debit', '2', 'Biaya Transportasi', 'Beban Usaha'],
            ['7220', 'debit', '2', 'Biaya Rapat Pengurus Pengawas', 'Beban Usaha'],
            ['7310', 'debit', '2', 'Biaya Administrasi dan Umum', 'Beban Umum & Administrasi'],
            ['7410', 'debit', '2', 'Biaya Penyusutan Aktiva Tetap', 'Beban Umum & Administrasi'],
            ['7510', 'debit', '2', 'Biaya RAT', 'Beban Umum & Administrasi'],
            ['7511', 'debit', '2', 'Biaya Pembinaan Anggota', 'Beban Umum & Administrasi'],
            ['7610', 'debit', '2', 'Biaya Penghapusan Piutang', 'Beban Umum & Administrasi'],
            ['7721', 'debit', '2', 'Biaya Administrasi Bank', 'Beban Umum & Administrasi'],
            ['7722', 'debit', '2', 'Pajak Jasa Giro', 'Beban Umum & Administrasi'],
            ['7811', 'debit', '2', 'Biaya Pajak dan Denda Pajak', 'Beban Umum & Administrasi'],
            ['7116', 'debit', '2', 'Beban Perlengkapan Kantor (ATK)', 'Beban Umum & Administrasi'],
            ['7117', 'debit', '2', 'Beban Listrik, Air dan Telepon', 'Beban Umum & Administrasi'],
            ['7118', 'debit', '2', 'Beban Rumah Tangga Kantor', 'Beban Umum & Administrasi'],
            ['7119', 'debit', '2', 'Beban Pemeliharaan', 'Beban Umum & Administrasi'],
            ['7311', 'debit', '2', 'Beban Cadangan Tujuan Resiko', 'Beban Umum & Administrasi'],
            ['7319', 'debit', '2', 'Biaya Lainnya', 'Beban Umum & Administrasi'],
            ['7411', 'debit', '2', 'Biaya Penyusutan Peralatan Kantor', 'Beban Umum & Administrasi'],

            // LAIN-LAIN
            ['7910', 'debit', '2', 'Zakat', 'Distribusi SHU / Zakat'],
        ];

        foreach ($coa as $akun) {
            DB::table('account')->updateOrInsert(
                ['no_account' => $akun[0]],
                [
                    'saldo_normal' => $akun[1],
                    'level'        => $akun[2],
                    'nama_account' => $akun[3],
                    'kelompok'     => $akun[4], // Sekarang berisi Teks (Aktiva, Kewajiban, dll)
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]
            );
        }
    }
}