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
                                    <h3 class="card-label">Jurnal</h3>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead>
                                            <tr class="text-uppercase text-muted fw-bold">
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
                                                        <td rowspan="{{ $jurnal->rowspan }}" class="text-center">
                                                            {{ $jurnal->nomor_anggota ?? '-' }}</td>
                                                        <td rowspan="{{ $jurnal->rowspan }}">
                                                            {{ $jurnal->nama_anggota ?? '-' }}</td>
                                                    @endif
                                                    <td class="text-end">{{ $jurnal->no_account ?? '-' }}</td>
                                                    <td class="text-end">
                                                        Rp{{ number_format($jurnal->debit ?? 0, 2, ',', '.') }}</td>
                                                    <td class="text-end">
                                                        Rp{{ number_format($jurnal->kredit ?? 0, 2, ',', '.') }}</td>
                                                    <td>{{ $jurnal->nama_account ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold text-end">
                                                <td colspan="3" class="text-start">Total Mutasi</td>
                                                <td>Rp{{ number_format($totalDebit, 2, ',', '.') }}</td>
                                                <td>Rp{{ number_format($totalKredit, 2, ',', '.') }}</td>
                                                <td colspan="1"></td>
                                            </tr>
                                            <tr class="fw-bold text-end">
                                                <td colspan="5" class="text-start">Selisih Saldo</td>
                                                <td colspan="1">
                                                    @if ($seimbang)
                                                        Rp0,00
                                                    @else
                                                        @if ($selisihSaldo < 0)
                                                            Rp ({{ number_format(abs($selisihSaldo), 2, ',', '.') }})
                                                        @else
                                                            Rp {{ number_format($selisihSaldo, 2, ',', '.') }}
                                                        @endif
                                                    @endif
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
                </div>
            </div>
        </div>
    </div>
@endsection
