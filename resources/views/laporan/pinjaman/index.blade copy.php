@extends('layouts.main')
@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Laporan Pinjaman</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Laporan</li>
                    <li class="breadcrumb-item text-gray-500">Pinjaman</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="card-label">Tabel Laporan Pinjaman Anggota</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="tablePinjaman">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Nomor Anggota</th>
                                    <th rowspan="2">Nama Anggota</th>
                                    <th rowspan="2">Jenis Kelamin</th>
                                    <th colspan="3" class="text-center">Pinjaman</th>
                                    <th colspan="3" class="text-center">Angsuran</th>
                                    <th colspan="3" class="text-center">Saldo Pinjaman</th>
                                </tr>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th>Pinjaman</th>
                                    <th>Pinjaman A</th>
                                    <th>Pinjaman B</th>
                                    <th>Pinjaman</th>
                                    <th>Pinjaman A</th>
                                    <th>Pinjaman B</th>
                                    <th>Pinjaman</th>
                                    <th>Pinjaman A</th>
                                    <th>Pinjaman B</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                {{-- Data Dummy --}}
                                {{-- <tr>
                                    <td class="text-center">1</td>
                                    <td>AG001</td>
                                    <td>Ahmad Fauzi</td>
                                    <td>Laki-laki</td>
                                    <td>5.000.000</td>
                                    <td>2.000.000</td>
                                    <td>1.000.000</td>
                                    <td>1.000.000</td>
                                    <td>500.000</td>
                                    <td>300.000</td>
                                    <td>4.000.000</td>
                                    <td>1.500.000</td>
                                    <td>700.000</td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>AG002</td>
                                    <td>Siti Aminah</td>
                                    <td>Perempuan</td>
                                    <td>6.000.000</td>
                                    <td>3.000.000</td>
                                    <td>2.000.000</td>
                                    <td>2.000.000</td>
                                    <td>1.000.000</td>
                                    <td>500.000</td>
                                    <td>4.000.000</td>
                                    <td>2.000.000</td>
                                    <td>1.500.000</td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>AG003</td>
                                    <td>Rudi Hartono</td>
                                    <td>Laki-laki</td>
                                    <td>4.000.000</td>
                                    <td>0</td>
                                    <td>500.000</td>
                                    <td>1.000.000</td>
                                    <td>0</td>
                                    <td>100.000</td>
                                    <td>3.000.000</td>
                                    <td>0</td>
                                    <td>400.000</td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td>AG004</td>
                                    <td>Dewi Lestari</td>
                                    <td>Perempuan</td>
                                    <td>2.000.000</td>
                                    <td>1.000.000</td>
                                    <td>1.000.000</td>
                                    <td>1.000.000</td>
                                    <td>800.000</td>
                                    <td>900.000</td>
                                    <td>1.000.000</td>
                                    <td>200.000</td>
                                    <td>100.000</td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td>AG005</td>
                                    <td>Yusuf Maulana</td>
                                    <td>Laki-laki</td>
                                    <td>7.000.000</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>2.000.000</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>5.000.000</td>
                                    <td>0</td>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td>AG006</td>
                                    <td>Rina Aprilia</td>
                                    <td>Perempuan</td>
                                    <td>3.000.000</td>
                                    <td>1.500.000</td>
                                    <td>1.000.000</td>
                                    <td>1.000.000</td>
                                    <td>500.000</td>
                                    <td>500.000</td>
                                    <td>2.000.000</td>
                                    <td>1.000.000</td>
                                    <td>500.000</td>
                                </tr>
                                <tr>
                                    <td class="text-center">7</td>
                                    <td>AG007</td>
                                    <td>Bagus Setiawan</td>
                                    <td>Laki-laki</td>
                                    <td>8.000.000</td>
                                    <td>4.000.000</td>
                                    <td>2.000.000</td>
                                    <td>3.000.000</td>
                                    <td>2.000.000</td>
                                    <td>1.000.000</td>
                                    <td>5.000.000</td>
                                    <td>2.000.000</td>
                                    <td>1.000.000</td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const table = new DataTable('#tablePinjaman', {
                                responsive: true,
                                paging: true,
                                searching: true,
                                info: false
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
