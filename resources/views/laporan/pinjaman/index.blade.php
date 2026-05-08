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
                                    <th>No</th>
                                    <th>Nomor Anggota</th>
                                    <th>Nama Anggota</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Total Pinjaman</th>
                                    <th>Total Angsuran</th>
                                    <th>Saldo Pinjaman</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item['nomor'] }}</td>
                                        <td>{{ $item['nama'] }}</td>
                                        <td>{{ $item['jenis_kelamin'] }}</td>
                                        <td>{{ number_format($item['total_pinjaman'], 0, ',', '.') }}</td>
                                        <td>{{ number_format($item['total_angsuran'], 0, ',', '.') }}</td>
                                        <td>{{ number_format($item['saldo_pinjaman'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
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
