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
                                    <h3 class="card-label">Tabel Laporan Simpanan Anggota</h3>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableSimpanan">
                                        <thead>
                                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th rowspan="2" class="text-center align-middle">No</th>
                                                <th rowspan="2" class="text-center align-middle">Nomor Anggota</th>
                                                <th rowspan="2" class="text-center align-middle">Nama Anggota</th>
                                                <th rowspan="2" class="text-center align-middle">Jenis Kelamin</th>
                                                <th colspan="3" class="text-center">Simpanan</th>
                                                <th colspan="3" class="text-center">Pengambilan</th>
                                                <th colspan="3" class="text-center">Saldo</th>
                                            </tr>
                                            <tr class="text-center text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th>Pokok</th>
                                                <th>Wajib</th>
                                                <th>Sukarela</th>
                                                <th>Pokok</th>
                                                <th>Wajib</th>
                                                <th>Sukarela</th>
                                                <th>Pokok</th>
                                                <th>Wajib</th>
                                                <th>Sukarela</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold">
                                            @forelse ($data as $i => $item)
                                                <tr>
                                                    <td class="text-center">{{ $i + 1 }}</td>
                                                    <td>{{ $item['nomor'] }}</td>
                                                    <td>{{ $item['nama'] }}</td>
                                                    <td>{{ $item['jenis_kelamin'] }}</td>

                                                    {{-- Simpanan Setor --}}
                                                    <td class="text-center text-info">
                                                        {{ number_format($item['simpanan_pokok_setor'] ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center text-info">
                                                        {{ number_format($item['simpanan_wajib_setor'] ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center text-info">
                                                        {{ number_format($item['simpanan_sukarela_setor'] ?? 0, 0, ',', '.') }}
                                                    </td>

                                                    {{-- Pengambilan Tarik --}}
                                                    <td class="text-center text-danger">
                                                        {{ number_format($item['simpanan_pokok_tarik'] ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center text-danger">
                                                        {{ number_format($item['simpanan_wajib_tarik'] ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center text-danger">
                                                        {{ number_format($item['simpanan_sukarela_tarik'] ?? 0, 0, ',', '.') }}
                                                    </td>

                                                    {{-- Saldo --}}
                                                    <td class="text-center text-primary">
                                                        {{ number_format($item['simpanan_pokok_saldo'] ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center text-primary">
                                                        {{ number_format($item['simpanan_wajib_saldo'] ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-center text-primary">
                                                        {{ number_format($item['simpanan_sukarela_saldo'] ?? 0, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="13" class="text-center">Data simpanan tidak ditemukan.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const table = new DataTable('#tableSimpanan', {
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
