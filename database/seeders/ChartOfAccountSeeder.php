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
            // no_account, saldo_normal, level, nama_account, kelompok
            ['1000', 'debit', '1', 'Aktiva Lancar', '1'],
            ['1010', 'debit', '1', 'Kas', '1'],
            ['1011', 'debit', '2', 'Kas Simpan Pinjam', '1'],
            ['1012', 'debit', '2', 'Kas Toko', '1'],
            ['1211', 'debit', '2', 'Bank', '1'],
            ['1311', 'debit', '2', 'Piutang Simpan Pinjam (Piutang Uang)', '1'],
            ['1312', 'debit', '2', 'Piutang Barang (Toko)', '1'],
            ['1320', 'debit', '2', 'Piutang Lain-lain', '1'],
            ['1411', 'debit', '2', 'Persediaan Barang Dagangan', '1'],
            ['1600', 'debit', '1', 'Harta Tetap', '1'],
            ['1610', 'debit', '2', 'Tanah', '1'],
            ['1620', 'debit', '2', 'Bangunan', '1'],
            ['1621', 'kredit', '2', 'Akumulasi Penyusutan Bangunan', '1'],
            ['1630', 'debit', '2', 'Peralatan', '1'],
            ['1631', 'kredit', '2', 'Akumulasi Penyusutan Peralatan', '1'],
            ['1640', 'debit', '2', 'Kendaraan', '1'],
            ['1641', 'kredit', '2', 'Akumulasi Penyusutan Kendaraan', '1'],

            // Kewajiban
            ['2000', 'kredit', '1', 'Kewajiban', '2'],
            ['2110', 'kredit', '1', 'Kewajiban Lancar', '2'],
            ['2111', 'kredit', '2', 'Simpanan Sukarela (Tabkop)', '2'],
            ['2112', 'kredit', '2', 'Hutang Usaha Simpan Pinjam', '2'],
            ['2120', 'kredit', '2', 'Hutang Usaha Toko', '2'],
            ['2130', 'kredit', '2', 'Hutang Lain-lain', '2'],
            ['2141', 'kredit', '2', 'Dana-dana SHU Bagian Anggota', '2'],
            ['2142', 'kredit', '2', 'Dana Pendidikan', '2'],
            ['2143', 'kredit', '2', 'Dana Pembangunan Daerah', '2'],
            ['2144', 'kredit', '2', 'Dana Sosial', '2'],
            ['2145', 'kredit', '2', 'Dana Pengurus', '2'],
            ['2146', 'kredit', '2', 'Dana Karyawan', '2'],
            ['2151', 'kredit', '2', 'Hutang Pajak', '2'],
            ['2200', 'kredit', '1', 'Kewajiban Jangka Panjang', '2'],
            ['2210', 'kredit', '2', 'Hutang Bank', '2'],
            ['2220', 'kredit', '2', 'Hutang ke KPPDK', '2'],

            // Ekuitas
            ['3000', 'kredit', '1', 'Ekuitas / Modal Sendiri', '3'],
            ['3010', 'kredit', '2', 'Simpanan Pokok', '3'],
            ['3020', 'kredit', '2', 'Simpanan Wajib', '3'],
            ['3030', 'kredit', '2', 'Penyertaan Modal dari KPPDK', '3'],
            ['3040', 'kredit', '2', 'Cadangan', '3'],
            ['3050', 'kredit', '2', 'Hibah / Donasi', '3'],
            ['3060', 'kredit', '2', 'Laba/Rugi - Sisa Hasil Usaha', '3'],

            // Pendapatan
            ['4000', 'kredit', '1', 'Partisipasi Anggota dan Pendapatan', '4'],
            ['4111', 'kredit', '2', 'Partisipasi Jasa Pinjaman Uang', '4'],
            ['4112', 'kredit', '2', 'Partisipasi Jasa Pinjaman Barang', '4'],
            ['4120', 'kredit', '2', 'Penjualan Barang', '4'],
            ['4130', 'kredit', '2', 'Jasa Giro', '4'],
            ['4140', 'kredit', '2', 'Penerimaan Lain-lain', '4'],

            // Beban
            ['5010', 'debit', '2', 'Pembelian', '5'],
            ['6010', 'debit', '2', 'Harga Pokok Penjualan', '5'],
            ['7000', 'debit', '2', 'Biaya-Biaya', '5'],
            ['7011', 'debit', '2', 'Biaya Jasa Simpanan Anggota', '5'],
            ['7012', 'debit', '2', 'Beban Bunga KPPDK Pusat', '5'],
            ['7111', 'debit', '2', 'Gaji Pengurus', '5'],
            ['7112', 'debit', '2', 'Gaji Karyawan', '5'],
            ['7113', 'debit', '2', 'Biaya Lembur', '5'],
            ['7114', 'debit', '2', 'Biaya Kesejahteraan', '5'],
            ['7115', 'debit', '2', 'Biaya THR', '5'],
            ['7210', 'debit', '2', 'Biaya Transportasi', '5'],
            ['7220', 'debit', '2', 'Biaya Rapat Pengurus Pengawas', '5'],
            ['7310', 'debit', '2', 'Biaya Administrasi dan Umum', '5'],
            ['7410', 'debit', '2', 'Biaya Penyusutan Aktiva Tetap', '5'],
            ['7510', 'debit', '2', 'Biaya RAT', '5'],
            ['7511', 'debit', '2', 'Biaya Pembinaan Anggota', '5'],
            ['7610', 'debit', '2', 'Biaya Penghapusan Piutang', '5'],
            ['7721', 'debit', '2', 'Biaya Administrasi Bank', '5'],
            ['7722', 'debit', '2', 'Pajak Jasa Giro', '5'],
            ['7811', 'debit', '2', 'Biaya Pajak dan Denda Pajak', '5'],

            // Tambahan Akun Baru
            ['1313', 'debit', '1', 'Piutang Simpan Pinjam Model A', '1'],
            ['1319', 'kredit', '1', 'Penyisihan Penghapusan Piutang', '1'],
            ['1412', 'debit', '1', 'Persediaan ATK', '1'],
            ['2112', 'kredit', '2', 'Utang Beban', '2'],
            ['4113', 'kredit', '2', 'Pendapatan Hasil Kerja Sama', '4'],
            ['7116', 'debit', '2', 'Beban Perlengkapan Kantor (ATK)', '5'],
            ['7117', 'debit', '2', 'Beban Listrik, Air dan Telepon', '5'],
            ['7118', 'debit', '2', 'Beban Rumah Tangga Kantor', '5'],
            ['7119', 'debit', '2', 'Beban Pemeliharaan', '5'],
            ['7311', 'debit', '2', 'Beban Cadangan Tujuan Resiko', '5'],
            ['7319', 'debit', '2', 'Biaya Lainnya', '5'],
            ['7411', 'debit', '2', 'Biaya Penyusutan Peralatan Kantor', '5'],
            ['7910', 'debit', '2', 'Zakat', '9'],
        ];

        foreach ($coa as $akun) {
            DB::table('account')->updateOrInsert(
                ['no_account' => $akun[0]],
                [
                    'saldo_normal' => $akun[1],
                    'level' => $akun[2],
                    'nama_account' => $akun[3],
                    'kelompok' => $akun[4],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
