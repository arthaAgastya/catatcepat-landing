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
                                    <h3 class="card-label">Laporan Perhitungan Usaha Per
                                        {{ now()->translatedFormat('d F Y') }}</h3>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="row">
                                    {{-- Laporan Laba/Rugi --}}
                                    <div class="mt-10">
                                        <div class="row">
                                            {{-- Pendapatan --}}
                                            <div class="col-md-6">
                                                <h6>Pendapatan</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr class="text-muted fw-bolder text-uppercase">
                                                                <th>No Akun</th>
                                                                <th>Saldo Normal</th>
                                                                <th>Nama Akun</th>
                                                                <th class="text-end">Saldo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($pendapatan as $akun)
                                                                <tr>
                                                                    <td>{{ $akun['no_account'] }}</td>
                                                                    <td>{{ $akun['saldo_normal'] }}</td>
                                                                    <td>{{ $akun['nama_account'] }}</td>
                                                                    <td class="text-end">
                                                                        @if ($akun['saldo'] < 0)
                                                                            (Rp
                                                                            {{ number_format(abs($akun['saldo']), 2, ',', '.') }})
                                                                        @else
                                                                            Rp{{ number_format($akun['saldo'], 2, ',', '.') }}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="2"><strong>Total Pendapatan</strong></td>
                                                                <td class="text-end">
                                                                    <strong>Rp{{ number_format($totalPendapatan, 2, ',', '.') }}</strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- Beban --}}
                                            <div class="col-md-6">
                                                <h6>Beban</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr class="text-muted fw-bolder text-uppercase">
                                                                <th>No Akun</th>
                                                                <th>Saldo Normal</th>
                                                                <th>Nama Akun</th>
                                                                <th class="text-end">Saldo</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($beban as $akun)
                                                                <tr>
                                                                    <td>{{ $akun['no_account'] }}</td>
                                                                    <td>{{ $akun['saldo_normal'] }}</td>
                                                                    <td>{{ $akun['nama_account'] }}</td>
                                                                    <td class="text-end">
                                                                        @if ($akun['saldo'] < 0)
                                                                            (Rp
                                                                            {{ number_format(abs($akun['saldo']), 2, ',', '.') }})
                                                                        @else
                                                                            Rp{{ number_format($akun['saldo'], 2, ',', '.') }}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td colspan="2"><strong>Total Beban</strong></td>
                                                                <td class="text-end">
                                                                    <strong>Rp{{ number_format($totalBeban, 2, ',', '.') }}</strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Laba / Rugi --}}
                                        <div class="text-end mt-4">
                                            @if ($labaRugi >= 0)
                                                <span class="badge badge-success fs-6 px-4 py-2">
                                                    Laba Bersih: Rp{{ number_format($labaRugi, 2, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="badge badge-danger fs-6 px-4 py-2">
                                                    Rugi Bersih: Rp{{ number_format(abs($labaRugi), 2, ',', '.') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
