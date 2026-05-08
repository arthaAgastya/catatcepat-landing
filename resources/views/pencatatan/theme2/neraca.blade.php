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
                                    <h3 class="card-label">Laporan Posisi Keuangan Per
                                        {{ now()->translatedFormat('d F Y') }}</h3>
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
                                                        <td colspan="2"><strong>Total Aktiva</strong></td>
                                                        <td class="text-end">
                                                            <strong>
                                                                @if ($totalAktiva < 0)
                                                                    (Rp {{ number_format(abs($totalAktiva), 2, ',', '.') }})
                                                                @else
                                                                    Rp{{ number_format($totalAktiva, 2, ',', '.') }}
                                                                @endif
                                                            </strong>
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
                                                                @if ($akun['saldo'] < 0)
                                                                    (Rp
                                                                    {{ number_format(abs($akun['saldo']), 2, ',', '.') }})
                                                                @else
                                                                    Rp{{ number_format($akun['saldo'], 2, ',', '.') }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @foreach ($ekuitas as $akun)
                                                        <tr>
                                                            <td class="text-end">{{ $akun['no_account'] }}</td>
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
                                                        <td colspan="2"><strong>Total Kewajiban + Ekuitas</strong></td>
                                                        <td class="text-end">
                                                            <strong>
                                                                @if ($totalPasiva < 0)
                                                                    (Rp
                                                                    {{ number_format(abs($totalPasiva), 2, ',', '.') }})
                                                                @else
                                                                    Rp{{ number_format($totalPasiva, 2, ',', '.') }}
                                                                @endif
                                                            </strong>
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
                                            Seimbang
                                        </span>
                                    @else
                                        <span class="badge badge-danger fs-6 px-4 py-2">
                                            Tidak Seimbang (Selisih: Rp{{ number_format($selisih, 2, ',', '.') }})
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
@endsection
