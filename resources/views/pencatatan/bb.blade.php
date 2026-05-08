@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Buku Besar</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Pencatatan</li>
                    <li class="breadcrumb-item text-gray-500">Buku Besar</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h3 class="card-label">Buku Besar</h3>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr class="text-uppercase text-muted fw-bold">
                                <th>Tanggal</th>
                                <th>Ref / Keterangan</th>
                                <th class="text-center">Nomor Anggota</th>
                                <th>Nama Anggota</th>
                                <th class="text-end">Nomor Account</th>
                                <th class="text-end">Debit</th>
                                <th class="text-end">Kredit</th>
                                <th>Nama Account</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jurnals as $jurnal)
                                <tr style="border-bottom: 1px solid #e0e0e0;">
                                    @if ($jurnal->rowspan > 0)
                                        <td rowspan="{{ $jurnal->rowspan }}">
                                            {{ $jurnal->tanggal ? \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d F Y') : '-' }}
                                        </td>
                                        <td rowspan="{{ $jurnal->rowspan }}">
                                            {{ $jurnal->ref ?: $jurnal->keterangan ?: '-' }}
                                        </td>
                                        <td rowspan="{{ $jurnal->rowspan }}" class="text-center">
                                            {{ $jurnal->nomor_anggota ?? '-' }}</td>
                                        <td rowspan="{{ $jurnal->rowspan }}">{{ $jurnal->nama_anggota ?? '-' }}</td>
                                    @endif
                                    <td class="text-end">{{ $jurnal->no_account ?? '-' }}</td>
                                    <td class="text-end">Rp{{ number_format($jurnal->debit ?? 0, 2, ',', '.') }}</td>
                                    <td class="text-end">Rp{{ number_format($jurnal->kredit ?? 0, 2, ',', '.') }}</td>
                                    <td>{{ $jurnal->nama_account ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold text-end">
                                <td colspan="4" class="text-start">Total Mutasi</td>
                                <td>Rp{{ number_format($totalDebit, 2, ',', '.') }}</td>
                                <td>Rp{{ number_format($totalKredit, 2, ',', '.') }}</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr class="fw-bold text-end">
                                <td colspan="4" class="text-start">Selisih Saldo</td>
                                <td colspan="2">
                                    @if ($seimbang)
                                        Rp0,00
                                    @else
                                        @if ($selisihSaldo < 0)
                                            Rp ({{ number_format(abs($selisihSaldo), 2, ',', '.') }})
                                        @else
                                            Rp {{ number_format($selisihSaldo, 2, ',', '.') }}
                                        @endif
                                    @endif
                                </td>
                                <td colspan="2">
                                    @if ($seimbang)
                                        <span class="badge badge-sm badge-primary">Seimbang</span>
                                    @else
                                        <span class="badge badge-sm badge-warning">Tidak Seimbang</span>
                                    @endif
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
