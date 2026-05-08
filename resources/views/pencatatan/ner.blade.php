@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Laporan Neraca</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Pencatatan</li>
                    <li class="breadcrumb-item text-gray-500">Neraca</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h3 class="card-label">Neraca Per {{ now()->translatedFormat('d F Y') }}</h3>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="row">
                        {{-- Aktiva --}}
                        <div class="col-md-6">
                            <h5>Aktiva</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-muted fw-bolder text-uppercase">
                                            <th>No Akun</th>
                                            <th>Nama Akun</th>
                                            <th class="text-end">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aktiva as $akun)
                                            <tr>
                                                <td>{{ $akun['no_account'] }}</td>
                                                <td>{{ $akun['nama_account'] }}</td>
                                                <td class="text-end">
                                                    @php
                                                        $formattedSaldo =
                                                            $akun['saldo'] < 0
                                                                ? 'Rp (' .
                                                                    number_format(abs($akun['saldo']), 2, ',', '.') .
                                                                    ')'
                                                                : 'Rp ' . number_format($akun['saldo'], 2, ',', '.');
                                                    @endphp
                                                    {{ $formattedSaldo }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2"><strong>Total Aktiva</strong></td>
                                            <td class="text-end">
                                                @php
                                                    $formattedTotalAktiva =
                                                        $totalAktiva < 0
                                                            ? 'Rp (' .
                                                                number_format(abs($totalAktiva), 2, ',', '.') .
                                                                ')'
                                                            : 'Rp ' . number_format($totalAktiva, 2, ',', '.');
                                                @endphp
                                                <strong>{{ $formattedTotalAktiva }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Kewajiban & Ekuitas --}}
                        <div class="col-md-6">
                            <h5>Kewajiban & Ekuitas</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-muted fw-bolder text-uppercase">
                                            <th class="text-end">No Akun</th>
                                            <th>Nama Akun</th>
                                            <th class="text-end">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kewajiban as $akun)
                                            <tr>
                                                <td class="text-end">{{ $akun['no_account'] }}</td>
                                                <td>{{ $akun['nama_account'] }}</td>
                                                <td class="text-end">
                                                    @php
                                                        $formattedSaldo =
                                                            $akun['saldo'] < 0
                                                                ? 'Rp (' .
                                                                    number_format(abs($akun['saldo']), 2, ',', '.') .
                                                                    ')'
                                                                : 'Rp ' . number_format($akun['saldo'], 2, ',', '.');
                                                    @endphp
                                                    {{ $formattedSaldo }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($ekuitas as $akun)
                                            <tr>
                                                <td class="text-end">{{ $akun['no_account'] }}</td>
                                                <td>{{ $akun['nama_account'] }}</td>
                                                <td class="text-end">
                                                    @php
                                                        $formattedSaldo =
                                                            $akun['saldo'] < 0
                                                                ? 'Rp (' .
                                                                    number_format(abs($akun['saldo']), 2, ',', '.') .
                                                                    ')'
                                                                : 'Rp ' . number_format($akun['saldo'], 2, ',', '.');
                                                    @endphp
                                                    {{ $formattedSaldo }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2"><strong>Total Kewajiban + Ekuitas</strong></td>
                                            <td class="text-end">
                                                @php
                                                    $formattedTotalPasiva =
                                                        $totalPasiva < 0
                                                            ? 'Rp (' .
                                                                number_format(abs($totalPasiva), 2, ',', '.') .
                                                                ')'
                                                            : 'Rp ' . number_format($totalPasiva, 2, ',', '.');
                                                @endphp
                                                <strong>{{ $formattedTotalPasiva }}</strong>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Status Neraca --}}
                    <div class="text-end mt-4">
                        @php
                            $selisih = abs($totalAktiva - $totalPasiva);
                        @endphp
                        @if ($selisih < 1)
                            <span class="badge badge-success fs-6 px-4 py-2">
                                Neraca Seimbang
                            </span>
                        @else
                            <span class="badge badge-danger fs-6 px-4 py-2">
                                Neraca Tidak Seimbang (Selisih: Rp{{ number_format($selisih, 2, ',', '.') }})
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
