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
                                    <h3 class="card-label">Laporan Arus Kas</h3>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead>
                                            <tr class="text-uppercase text-muted fw-bold">
                                                <th>Account</th>
                                                <th>Cash Inflows</th>
                                                <th>Cash Outflows</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="fw-bold text-primary">Kas dan Setara Kas</td>
                                            </tr>
                                            @foreach ($kasSetaraKas as $item)
                                                <tr>
                                                    <td>{{ $item['nama_account'] }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        @if ($item['saldo'] < 0)
                                                            Rp ({{ number_format(abs($item['saldo']), 2, ',', '.') }})
                                                        @else
                                                            Rp {{ number_format($item['saldo'], 2, ',', '.') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td colspan="4" class="fw-bold text-primary">Arus Kas Masuk</td>
                                            </tr>
                                            @foreach ($arusKasMasuk as $item)
                                                <tr>
                                                    <td>{{ $item['nama_account'] }}</td>
                                                    <td>
                                                        @if ($item['saldo'] < 0)
                                                            Rp ({{ number_format(abs($item['saldo']), 2, ',', '.') }})
                                                        @else
                                                            Rp {{ number_format($item['saldo'], 2, ',', '.') }}
                                                        @endif
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td colspan="4" class="fw-bold text-primary">Arus Kas Keluar</td>
                                            </tr>
                                            @foreach ($arusKasKeluar as $item)
                                                <tr>
                                                    <td>{{ $item['nama_account'] }}</td>
                                                    <td></td>
                                                    <td>
                                                        @if ($item['saldo'] < 0)
                                                            Rp ({{ number_format(abs($item['saldo']), 2, ',', '.') }})
                                                        @else
                                                            Rp {{ number_format($item['saldo'], 2, ',', '.') }}
                                                        @endif
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold text-dark">
                                                <td>Total</td>
                                                <td>
                                                    @if ($totalArusKasMasuk < 0)
                                                        Rp ({{ number_format(abs($totalArusKasMasuk), 2, ',', '.') }})
                                                    @else
                                                        Rp {{ number_format($totalArusKasMasuk, 2, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($totalArusKasKeluar < 0)
                                                        Rp ({{ number_format(abs($totalArusKasKeluar), 2, ',', '.') }})
                                                    @else
                                                        Rp {{ number_format($totalArusKasKeluar, 2, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($saldoAkhirKas < 0)
                                                        Rp ({{ number_format(abs($saldoAkhirKas), 2, ',', '.') }})
                                                    @else
                                                        Rp {{ number_format($saldoAkhirKas, 2, ',', '.') }}
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
