@extends('layouts.main2')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="row g-5 g-xl-8">
                    <div class="col-12">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
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
            </div>
        </div>
    </div>
@endsection
