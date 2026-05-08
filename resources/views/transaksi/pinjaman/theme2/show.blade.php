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
                                    <h2>Detail Pinjaman</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    {{-- Data Anggota --}}
                                    <div class="col-6">
                                        <label class="form-label">Nama Anggota</label>
                                        <input type="text" class="form-control" value="{{ $pinjaman->anggota->nama }}"
                                            readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Kode Anggota</label>
                                        <input type="text" class="form-control"
                                            value="{{ $pinjaman->anggota->nomor_anggota }}" readonly>
                                    </div>

                                    {{-- Detail Pinjaman --}}
                                    <div class="col-4 mt-3">
                                        <label class="form-label">Jumlah Pinjaman</label>
                                        <input type="text" class="form-control"
                                            value="{{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}" readonly>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <label class="form-label">Bunga (%)</label>
                                        <input type="text" class="form-control" value="{{ $pinjaman->bunga_persen }}"
                                            readonly>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <label class="form-label">Tenor</label>
                                        <input type="text" class="form-control" value="{{ $pinjaman->tenor }}" readonly>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <label class="form-label">Jenis Angsuran</label>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst($pinjaman->jenis_angsuran) }}" readonly>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <label class="form-label">Besaran Jasa</label>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst($pinjaman->besaran_jasa) }}" readonly>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <label class="form-label">Tanggal Pengajuan</label>
                                        <input type="text" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($pinjaman->tanggal_pengajuan)->format('Y-m-d') }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card card-xl-stretch mt-5">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">Angsuran</div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table-bordered">
                                    <thead class="border-bottom">
                                        <tr class="fw-bold capitalize">
                                            <th class="text-center">Angsuran Ke</th>
                                            <th>Tanggal Jatuh Tempo</th>
                                            <th class="text-center">Pokok</th>
                                            <th class="text-center">Bunga</th>
                                            <th class="text-center">Total Bayar</th>
                                            <th class="text-center">Status Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pinjaman->jadwalAngsuran as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->angsuran_ke }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                                                <td class="text-center">
                                                    {{ number_format($item->jumlah_pokok, 0, ',', '.') }}</td>
                                                <td class="text-center">
                                                    {{ number_format($item->jumlah_bunga, 0, ',', '.') }}</td>
                                                <td class="text-center">
                                                    {{ number_format($item->jumlah_total, 0, ',', '.') }}</td>
                                                <td class="text-center">
                                                    @if ($item->status == 'lunas')
                                                        <span class="badge badge-success">Lunas</span>
                                                    @else
                                                        <span class="badge badge-warning">Belum Lunas</span>
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
@endsection
