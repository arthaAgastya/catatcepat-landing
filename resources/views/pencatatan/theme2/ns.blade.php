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
                                    <h3 class="card-label">Neraca Saldo</h3>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead>
                                            <tr class="text-uppercase text-muted fw-bold">
                                                <th>No Account</th>
                                                <th>Nama Account</th>
                                                <th>Level</th>
                                                <th class="text-end">Total Debit</th>
                                                <th class="text-end">Total Kredit</th>
                                                <th class="text-end">Saldo</th>
                                                <th>Saldo Normal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $grandTotalDebit = 0;
                                                $grandTotalKredit = 0;
                                                $grandTotalSaldo = 0;
                                            @endphp

                                            @foreach ($groupedAccounts as $category => $accounts)
                                                <tr class="table-primary">
                                                    <td colspan="7" class="fw-bolder">{{ $category }}</td>
                                                </tr>

                                                @php
                                                    $totalDebit = 0;
                                                    $totalKredit = 0;
                                                    $totalSaldo = 0;
                                                @endphp

                                                @foreach ($accounts as $akun)
                                                    <tr>
                                                        <td>{{ $akun['no_account'] }}</td>
                                                        <td>{{ $akun['nama_account'] }}</td>
                                                        <td>{{ $akun['level'] }}</td>
                                                        <td class="text-end">
                                                            Rp{{ number_format($akun['totalDebit'], 2, ',', '.') }}</td>
                                                        <td class="text-end">
                                                            Rp{{ number_format($akun['totalKredit'], 2, ',', '.') }}</td>
                                                        <td class="text-end">
                                                            @if ($akun['saldo'] < 0)
                                                                Rp ({{ number_format(abs($akun['saldo']), 2, ',', '.') }})
                                                            @else
                                                                Rp{{ number_format($akun['saldo'], 2, ',', '.') }}
                                                            @endif
                                                        </td>
                                                        <td>{{ ucfirst($akun['saldo_normal']) }}</td>
                                                    </tr>
                                                    @php
                                                        $totalDebit += $akun['totalDebit'];
                                                        $totalKredit += $akun['totalKredit'];
                                                        $totalSaldo += $akun['saldo'];
                                                    @endphp
                                                @endforeach

                                        <tfoot>
                                            <tr class="fw-bold text-end table-secondary">
                                                <td colspan="3" class="text-start">Total {{ $category }}</td>
                                                <td>Rp{{ number_format($totalDebit, 2, ',', '.') }}</td>
                                                <td>Rp{{ number_format($totalKredit, 2, ',', '.') }}</td>
                                                <td>Rp{{ number_format($totalSaldo, 2, ',', '.') }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>

                                        @php
                                            $grandTotalDebit += $totalDebit;
                                            $grandTotalKredit += $totalKredit;
                                            $grandTotalSaldo += $totalSaldo;
                                        @endphp
                                        @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr class="fw-bold text-end">
                                                <td colspan="3" class="text-start">Grand Total</td>
                                                <td>Rp{{ number_format($grandTotalDebit, 2, ',', '.') }}</td>
                                                <td>Rp{{ number_format($grandTotalKredit, 2, ',', '.') }}</td>
                                                <td>Rp{{ number_format($grandTotalSaldo, 2, ',', '.') }}</td>
                                                <td></td>
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
