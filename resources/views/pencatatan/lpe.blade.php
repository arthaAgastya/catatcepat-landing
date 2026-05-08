@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Laporan Perubahan Ekuitas - Tahun {{ $year }}</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Pencatatan</li>
                    <li class="breadcrumb-item text-gray-500">Laporan Perubahan Ekuitas</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h3 class="card-label">Laporan Perubahan Ekuitas</h3>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-end">
                        <thead>
                            <tr class="text-uppercase text-muted fw-bold text-center">
                                <th class="text-start">Keterangan</th>
                                @foreach ($equityAccountGroups as $component => $accountNos)
                                    <th>{{ $component }}</th>
                                @endforeach
                                <th>Total Ekuitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Saldo Awal --}}
                            <tr>
                                <td class="text-start fw-bold">Saldo Awal 1 Jan {{ $year }}</td>
                                @foreach ($equityAccountGroups as $component => $accountNos)
                                    <td>
                                        @php
                                            $sumSaldoAwal = 0;
                                            foreach ($accountNos as $accNo) {
                                                $sumSaldoAwal += $saldoAwal[$accNo] ?? 0;
                                            }
                                        @endphp
                                        {{ number_format($sumSaldoAwal, 2, ',', '.') }}
                                    </td>
                                @endforeach
                                <td>{{ number_format($saldoAwalTotal, 2, ',', '.') }}</td>
                            </tr>

                            {{-- Penambahan Tahun Berjalan --}}
                            @php
                                $rowspan = count($equityAccountGroups);
                                $first = true;
                            @endphp
                            <tr class="fw-bold">
                                <td class="text-start">Penambahan Tahun Berjalan:</td>
                                <td colspan="{{ count($equityAccountGroups) + 1 }}"></td>
                            </tr>
                            @foreach ($equityAccountGroups as $component => $accountNos)
                                <tr>
                                    <td class="text-start"> Penambahan {{ $component }}</td>
                                    @foreach ($equityAccountGroups as $compCol => $aNos)
                                        <td>
                                            @if ($component === $compCol)
                                                {{ number_format($penambahan[$compCol] ?? 0, 2, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                    {{-- Total Ekuitas (rowspan hanya sekali) --}}
                                    @if ($first)
                                        <td rowspan="{{ $rowspan }}">
                                            {{ number_format($penambahanTotal, 2, ',', '.') }}
                                        </td>
                                    @endif

                                    @php $first = false; @endphp
                                </tr>
                            @endforeach

                            {{-- Pengurangan --}}
                            @php
                                $rowspan = count($equityAccountGroups);
                                $first = true;
                            @endphp
                            <tr class="fw-bold">
                                <td class="text-start">Pengurangan:</td>
                                <td colspan="{{ count($equityAccountGroups) + 1 }}"></td>
                            </tr>
                            @foreach ($equityAccountGroups as $component => $accountNos)
                                <tr>
                                    <td class="text-start"> Pengurangan {{ $component }}</td>
                                    @foreach ($equityAccountGroups as $compCol => $aNos)
                                        <td>
                                            @if ($component === $compCol)
                                                ({{ number_format($pengurangan[$compCol] ?? 0, 2, ',', '.') }})
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                    {{-- Total Ekuitas (rowspan hanya sekali) --}}
                                    @if ($first)
                                        <td rowspan="{{ $rowspan }}">
                                            ({{ number_format($penguranganTotal, 2, ',', '.') }})
                                        </td>
                                    @endif

                                    @php $first = false; @endphp
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td class="text-start">Saldo Akhir 31 Des {{ $year }}</td>
                                @foreach ($equityAccountGroups as $component => $accountNos)
                                    <td>{{ number_format($saldoAkhir[$component] ?? 0, 2, ',', '.') }}</td>
                                @endforeach
                                <td>{{ number_format($saldoAkhirTotal, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
