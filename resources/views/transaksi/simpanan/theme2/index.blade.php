@extends('layouts.main2')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="row g-5 g-xl-8">
                    <div class="col-12">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-header border-0">
                                <h3 class="card-title fw-bolder text-dark">Simpanan</h3>
                                <div class="card-toolbar">
                                    <div class="d-flex align-items-center py-2 py-md-1">
                                        <a href="{{ route('transaksi.simpanan.create') }}"
                                            class="btn btn-primary btn-sm">Setor</a>
                                        <a href="{{ route('transaksi.simpanan.tarik') }}"
                                            class="btn btn-warning btn-sm m-2">Tarik</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <h5 class="mb-4 mt-5">Statistik Simpanan</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Total Setoran</th>
                                                <td>Rp {{ number_format($statistik['total_setor'], 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total Penarikan</th>
                                                <td>Rp {{ number_format($statistik['total_tarik'], 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Jumlah Transaksi</th>
                                                <td>{{ $statistik['jumlah_transaksi'] }} transaksi</td>
                                            </tr>
                                            <tr>
                                                <th>Jumlah Anggota Menabung</th>
                                                <td>{{ $statistik['jumlah_anggota'] }} anggota</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <h6 class="mt-4">Total per Jenis Simpanan:</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr class="text-muted fw-bolder text-uppercase">
                                                <th>Jenis Simpanan</th>
                                                <th>Total Setoran</th>
                                                <th>Total Penarikan</th>
                                                <th class="text-center">Jumlah Transaksi Setor</th>
                                                <th class="text-center">Jumlah Transaksi Tarik</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($statistik['per_jenis_simpanan'] as $jenis)
                                                <tr>
                                                    <td>{{ $jenis['nama_account'] }}</td>
                                                    <td>Rp {{ number_format($jenis['total_setor'], 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($jenis['total_tarik'], 0, ',', '.') }}</td>
                                                    <td class="text-center">{{ $jenis['jumlah_transaksi_setor'] }}</td>
                                                    <td class="text-center">{{ $jenis['jumlah_transaksi_tarik'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-body pt-0">
                                <div class="table-responsive mt-4">
                                    <table class="table" id="tableData">
                                        <thead>
                                            <tr class="text-muted fw-bolder text-uppercase">
                                                <th class="w-10px pe-2">#</th>
                                                <th class="min-w-150px">Nama Anggota</th>
                                                <th class="min-w-150px">Jenis Simpanan</th>
                                                <th class="min-w-150px">Nomor Transaksi</th>
                                                <th class="min-w-125px">Tanggal Transaksi</th>
                                                <th class="min-w-150px">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold">
                                            @foreach ($simpanan as $transaksi)
                                                @php
                                                    $jumlahTransaksi = 0;
                                                    $isTarik = false;

                                                    foreach ($transaksi->jurnal as $jurnal) {
                                                        // hanya cek akun simpanan
                                                        if (!in_array($jurnal->id_account, $akun_simpanan)) {
                                                            continue;
                                                        }

                                                        if ($jurnal->tipe == 'kredit') {
                                                            $jumlahTransaksi += $jurnal->jumlah;
                                                        } elseif ($jurnal->tipe == 'debit') {
                                                            $jumlahTransaksi -= $jurnal->jumlah;
                                                            $isTarik = true;
                                                        }
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $transaksi->anggota->nama ?? '-' }}</td>
                                                    <td>
                                                        @foreach ($transaksi->jurnal as $jurnal)
                                                            @if (in_array($jurnal->id_account, $akun_simpanan))
                                                                {{ $jurnal->account->nama_account ?? '-' }}<br>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{ $transaksi->ref ?? '-' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('j F Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($isTarik)
                                                            <span class="text-danger">- Rp
                                                                {{ number_format(abs($jumlahTransaksi), 0, ',', '.') }}</span>
                                                        @else
                                                            Rp {{ number_format($jumlahTransaksi, 0, ',', '.') }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
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
