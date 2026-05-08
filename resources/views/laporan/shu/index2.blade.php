@extends('layouts.main2')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="row g-5 g-xl-8">
                    <div class="col-12">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-header">
                                <h3 class="card-title">Komponen Distribusi Sisa Hasil Usaha (SHU)<br><small>Koperasi Desa
                                        Merah Putih
                                        Berjaya - Tahun 2025</small></h3>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                        <tr class="fw-bold text-muted text-uppercase">
                                            <th>No</th>
                                            <th>Komponen</th>
                                            <th>Besar Prosentase</th>
                                            <th>Nilainya</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-700">
                                        <tr>
                                            <td>1</td>
                                            <td>Cadangan Koperasi</td>
                                            <td>20%</td>
                                            <td>Rp10.000</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Jasa Partisipasi Anggota Atas Simpanan</td>
                                            <td>20%</td>
                                            <td>Rp10.000</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Jasa Partisipasi Anggota Atas Transaksi</td>
                                            <td>20%</td>
                                            <td>Rp10.000</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>SHU Bagian Pengurus dan Pengawas</td>
                                            <td>10%</td>
                                            <td>Rp5.000</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>SHU Bagian Pegawai</td>
                                            <td>5%</td>
                                            <td>Rp2.500</td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>SHU Dana Pendidikan</td>
                                            <td>10%</td>
                                            <td>Rp5.000</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>SHU Dana Sosial</td>
                                            <td>5%</td>
                                            <td>Rp2.500</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>SHU Dana Pengembangan Wilayah Kerja</td>
                                            <td>5%</td>
                                            <td>Rp2.500</td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td colspan="3">Jumlah</td>
                                            <td>Rp50.000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-header">
                                <h3 class="card-title">Distribusi SHU Per Anggota<br><small>Koperasi Desa Merah Putih
                                        Berjaya - Tahun
                                        2025</small></h3>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableShu">
                                        <thead>
                                            <tr class="text-muted fw-bold fs-7 text-uppercase">
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Nomor Anggota</th>
                                                <th rowspan="2">Nama Anggota</th>
                                                <th colspan="2" class="text-center">Partisipasi Anggota</th>
                                                <th colspan="2" class="text-center">SHU Anggota</th>
                                                <th rowspan="2">Jumlah SHU</th>
                                            </tr>
                                            <tr class="text-muted fw-bold fs-7 text-uppercase">
                                                <th>Modal (SP+SW)</th>
                                                <th>Transaksi</th>
                                                <th>Atas Modal</th>
                                                <th>Atas Transaksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-700 fw-semibold">
                                            {{-- Data Dummy --}}
                                            <tr>
                                                <td>1</td>
                                                <td>3171234567890120</td>
                                                <td>Mira Setiawan</td>
                                                <td>Rp1.000.000</td>
                                                <td>Rp25.000.000</td>
                                                <td>Rp10.000</td>
                                                <td>Rp10.000</td>
                                                <td>Rp20.000</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>3171234567890121</td>
                                                <td>Andi Pratama</td>
                                                <td>Rp0</td>
                                                <td>Rp10.000.000</td>
                                                <td>Rp0</td>
                                                <td>Rp4.000</td>
                                                <td>Rp4.000</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>3171234567890122</td>
                                                <td>Sari Dewi</td>
                                                <td>Rp500.000</td>
                                                <td>Rp0</td>
                                                <td>Rp5.000</td>
                                                <td>Rp0</td>
                                                <td>Rp5.000</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold text-dark">
                                                <td colspan="3">Jumlah</td>
                                                <td>Rp1.500.000</td>
                                                <td>Rp35.000.000</td>
                                                <td>Rp15.000</td>
                                                <td>Rp14.000</td>
                                                <td>Rp29.000</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        new DataTable('#tableShu', {
                                            responsive: true,
                                            paging: false,
                                            searching: false,
                                            info: false
                                        });
                                    });
                                </script>

                                <div class="mt-5">
                                    <p><strong>Catatan:</strong></p>
                                    <ul>
                                        <li><strong>SP</strong> = Simpanan Pokok</li>
                                        <li><strong>SW</strong> = Simpanan Wajib</li>
                                        <li><strong>SHU Atas Modal</strong> = <em>(Modal anggota x Jasa Partisipasi
                                                Simpanan) ÷ Total
                                                Modal</em></li>
                                        <li><strong>SHU Atas Transaksi</strong> = <em>(Transaksi anggota x Jasa Partisipasi
                                                Transaksi) ÷
                                                Total Transaksi</em></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
