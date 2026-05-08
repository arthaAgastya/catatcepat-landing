@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Transaksi Angsuran</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Transaksi</li>
                    <li class="breadcrumb-item text-gray-500">Angsuran</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="row">
                <div class="col-12 col-lg-3"></div>

                {{-- Form Pilih Anggota --}}
                <div class="col-12 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @php use Illuminate\Support\Facades\Crypt; @endphp

                            <form action="" method="GET">
                                <div class="mb-5">
                                    <label class="form-label required">Pilih Anggota</label>
                                    <select name="param" id="param" class="form-select">
                                        <option value="" disabled selected>Pilih Anggota</option>
                                        @foreach ($anggotas as $item)
                                            @php
                                                $encryptedId = Crypt::encrypt($item->id);
                                            @endphp
                                            <option value="{{ $encryptedId }}"
                                                {{ request('param') == $encryptedId ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Cek Angsuran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-3"></div>

                {{-- Detail Pinjaman & Angsuran --}}
                @if (request('param') && $pinjaman)
                    <div class="col-12 mt-10">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Detail Pinjaman</h3>
                            </div>
                            <div class="card-body">

                                {{-- Informasi Pinjaman --}}
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p><strong>Nama Anggota:</strong> {{ $pinjaman->anggota->nama }}</p>
                                        <p><strong>Kode Pinjaman:</strong> {{ $pinjaman->kode_pinjaman }}</p>
                                        <p><strong>Jumlah Pinjaman:</strong> Rp
                                            {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</p>
                                        <p><strong>Tenor:</strong> {{ $pinjaman->tenor }} bulan</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Bunga Tahunan:</strong> {{ $pinjaman->suku_bunga_tahunan ?? 0 }}%</p>
                                        <p><strong>Bunga Perhitungan:</strong> {{ $pinjaman->bunga_persen ?? 0 }}%</p>
                                        <p><strong>Jenis Angsuran:</strong> {{ ucfirst($pinjaman->jenis_angsuran) }}</p>
                                        <p><strong>Jenis Bunga:</strong> {{ ucfirst($pinjaman->besaran_jasa) }}</p>
                                    </div>
                                </div>

                                {{-- Statistik Angsuran --}}
                                @php
                                    $totalPokok = 0;
                                    $totalBunga = 0;
                                    $totalBayar = 0;
                                    $sisaPokok = 0;
                                    $sisaBayar = 0;
                                    $sisaAngsuran = 0;
                                @endphp

                                @foreach ($pinjaman->jadwalAngsuran as $jadwal)
                                    @php
                                        $totalPokok += $jadwal->jumlah_pokok;
                                        $totalBunga += $jadwal->jumlah_bunga;
                                        $totalBayar += $jadwal->jumlah_total;

                                        if ($jadwal->status == 'belum') {
                                            $sisaPokok += $jadwal->jumlah_pokok;
                                            $sisaBayar += $jadwal->jumlah_total;
                                            $sisaAngsuran++;
                                        }
                                    @endphp
                                @endforeach

                                {{-- Ringkasan --}}
                                <div class="row mb-5">
                                    <div class="col-md-4">
                                        <div class="alert alert-secondary text-center">
                                            <strong>Sisa Pinjaman</strong><br>
                                            <h7 class="fw-bolder text-black">Rp
                                                {{ number_format($sisaPokok, 0, ',', '.') }}</h7>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-secondary text-center">
                                            <strong>Sisa Pembayaran</strong><br>
                                            <h7 class="fw-bolder text-black">Rp
                                                {{ number_format($sisaBayar, 0, ',', '.') }}</h7>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="alert alert-secondary text-center">
                                            <strong>Sisa Angsuran</strong><br>
                                            <span class="fs-5 text-dark"></span>
                                            <h7 class="fw-bolder text-black">{{ $sisaAngsuran }}x</h7>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tabel Jadwal Angsuran --}}
                                @if ($pinjaman->jadwalAngsuran->count())
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle">
                                            <thead class="border-bottom">
                                                <tr class="fw-bold text-center">
                                                    <th>Angsuran Ke</th>
                                                    <th>Tanggal Jatuh Tempo</th>
                                                    <th>Pokok</th>
                                                    <th>Bunga</th>
                                                    <th>Total Bayar</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $today = \Carbon\Carbon::today();
                                                @endphp
                                                @foreach ($pinjaman->jadwalAngsuran as $jadwal)
                                                    @php
                                                        $jatuhTempo = \Carbon\Carbon::parse(
                                                            $jadwal->tanggal_jatuh_tempo,
                                                        );

                                                        // Menghitung 20 hari sebelum jatuh tempo
                                                        $batasBayar = $jatuhTempo->copy()->subDays(20);

                                                        // Boleh bayar jika status belum dan hari ini >= (Jatuh Tempo - 20 Hari)
                                                        $bolehBayar =
                                                            $jadwal->status == 'belum' &&
                                                            $today->greaterThanOrEqualTo($batasBayar);
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $jadwal->angsuran_ke }}</td>
                                                        <td>{{ $jatuhTempo->translatedFormat('d F Y') }}</td>
                                                        <td class="text-center">Rp
                                                            {{ number_format($jadwal->jumlah_pokok, 0, ',', '.') }}</td>
                                                        <td class="text-center">Rp
                                                            {{ number_format($jadwal->jumlah_bunga, 0, ',', '.') }}</td>
                                                        <td class="text-center">Rp
                                                            {{ number_format($jadwal->jumlah_total, 0, ',', '.') }}</td>
                                                        <td class="text-center">
                                                            @if ($jadwal->status == 'belum')
                                                                <form method="POST"
                                                                    action="{{ route('transaksi.angsuran.bayar', $jadwal->kode_angsuran) }}"
                                                                    class="form-bayar-angsuran d-inline">
                                                                    @csrf
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-success btn-confirm-bayar"
                                                                        data-angsuran="{{ $jadwal->angsuran_ke }}">Bayar</button>
                                                                </form>
                                                                {{-- @if ($bolehBayar)
                                                                    <!-- Tombol Bayar -->
                                                                    <form method="POST"
                                                                        action="{{ route('transaksi.angsuran.bayar', $jadwal->kode_angsuran) }}"
                                                                        class="form-bayar-angsuran d-inline">
                                                                        @csrf
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-success btn-confirm-bayar"
                                                                            data-angsuran="{{ $jadwal->angsuran_ke }}">Bayar</button>
                                                                    </form>
                                                                @else
                                                                    <span class="badge badge-light-warning">Belum Bisa
                                                                        Dibayar</span>
                                                                @endif --}}
                                                            @else
                                                                <span class="badge badge-light-success">Sudah Bayar</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="fw-bold text-center">
                                                <tr>
                                                    <td colspan="2" class="text-end">TOTAL</td>
                                                    <td>Rp {{ number_format($totalPokok, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($totalBunga, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-warning">Belum ada jadwal angsuran untuk pinjaman ini.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif(request('param'))
                    <div class="col-12 mt-10">
                        <div class="alert alert-warning">Tidak ada data pinjaman aktif untuk anggota ini.</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.btn-confirm-bayar');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const angsuranKe = this.dataset.angsuran;
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Konfirmasi Pembayaran',
                        text: `Apakah Anda yakin ingin membayar angsuran ke-${angsuranKe}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, bayar sekarang!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
