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
                                        <label class="form-label">Suku Bunga Tahunan (%)</label>
                                        <input type="text" class="form-control"
                                            value="{{ number_format($pinjaman->suku_bunga_tahunan, 2, ',', '.') }}"
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
                        {{-- Simulasi Angsuran --}}
                        <div class="card card-xl-stretch mt-5">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">Simulasi Angsuran</div>
                            </div>
                            <div class="card-body pt-0">
                                @php
                                    $P = $pinjaman->jumlah_pinjaman;
                                    $n = $pinjaman->tenor;
                                    $r_tahunan = $pinjaman->suku_bunga_tahunan;
                                    $r = $r_tahunan / 12 / 100; // suku bunga bulanan (desimal)
                                    $saldo = $P;

                                    $jenis_bunga = strtolower($pinjaman->besaran_jasa); // flat, anuitas, persen (menurun)

                                    $totalPokok = 0;
                                    $totalBunga = 0;
                                    $totalBayar = 0;

                                    $pokokPerBulan = $P / $n;
                                @endphp
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-start text-muted fw-bolder text-uppercase">
                                                <th class="text-center">Angsuran Ke</th>
                                                <th>Saldo Awal</th>
                                                <th>Angsuran Pokok</th>
                                                <th>Bunga Pinjaman</th>
                                                <th>Jumlah Angsuran</th>
                                                <th>Saldo Akhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 1; $i <= $n; $i++)
                                                @php
                                                    if ($jenis_bunga == 'flat') {
                                                        $angsuran_pokok = $pokokPerBulan;
                                                        $bunga = $P * $r;
                                                        $jumlah_angsuran = $angsuran_pokok + $bunga;
                                                        $saldo_akhir = $saldo - $angsuran_pokok;
                                                    } elseif ($jenis_bunga == 'anuitas') {
                                                        // Rumus anuitas
                                                        $A = ($P * $r) / (1 - pow(1 + $r, -$n));
                                                        $bunga = $saldo * $r;
                                                        $angsuran_pokok = $A - $bunga;
                                                        $jumlah_angsuran = $A;
                                                        $saldo_akhir = $saldo - $angsuran_pokok;
                                                    } elseif ($jenis_bunga == 'persen') {
                                                        // Menurun = pokok sama, bunga hitung dari saldo
                                                        $angsuran_pokok = $pokokPerBulan;
                                                        $bunga = $saldo * $r;
                                                        $jumlah_angsuran = $angsuran_pokok + $bunga;
                                                        $saldo_akhir = $saldo - $angsuran_pokok;
                                                    } else {
                                                        $angsuran_pokok = 0;
                                                        $bunga = 0;
                                                        $jumlah_angsuran = 0;
                                                        $saldo_akhir = 0;
                                                    }

                                                    $totalPokok += $angsuran_pokok;
                                                    $totalBunga += $bunga;
                                                    $totalBayar += $jumlah_angsuran;

                                                    // Format untuk tampilan
                                                    $saldo_format = number_format($saldo, 0, ',', '.');
                                                    $angsuran_pokok_format = number_format(
                                                        $angsuran_pokok,
                                                        0,
                                                        ',',
                                                        '.',
                                                    );
                                                    $bunga_format = number_format($bunga, 0, ',', '.');
                                                    $jumlah_angsuran_format = number_format(
                                                        $jumlah_angsuran,
                                                        0,
                                                        ',',
                                                        '.',
                                                    );
                                                    $saldo_akhir_format = number_format(
                                                        max($saldo_akhir, 0),
                                                        0,
                                                        ',',
                                                        '.',
                                                    );

                                                    $saldo = $saldo_akhir;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td class="">Rp {{ $saldo_format }}</td>
                                                    <td class="">Rp {{ $angsuran_pokok_format }}</td>
                                                    <td class="">Rp {{ $bunga_format }}</td>
                                                    <td class="">Rp {{ $jumlah_angsuran_format }}</td>
                                                    <td class="">Rp {{ $saldo_akhir_format }}</td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                        <tfoot class="border-top">
                                            <tr class="fw-bold">
                                                <td colspan="2" class="text-center">TOTAL</td>
                                                <td class="">Rp {{ number_format($totalPokok, 0, ',', '.') }}</td>
                                                <td class="">Rp {{ number_format($totalBunga, 0, ',', '.') }}</td>
                                                <td class="">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        {{-- Form Persetujuan --}}
                        <div class="card card-xl-stretch mt-5">
                            <div class="card-body">
                                <form id="approval-form"
                                    action="{{ route('transaksi.pinjaman.persetujuan.store', $pinjaman->kode_pinjaman) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="status" id="form-status">

                                    <div class="mb-3">
                                        <label for="catatan" class="form-label">Catatan (opsional)</label>
                                        <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Isi catatan jika perlu...">{{ old('catatan') }}</textarea>
                                        @error('catatan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="text-center gap-3">
                                        <button type="button" class="btn btn-success btn-sm"
                                            onclick="confirmAction('disetujui')">Setujui</button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmAction('ditolak')">Tolak</button>
                                        <a href="{{ route('transaksi.pinjaman.index') }}"
                                            class="btn btn-secondary btn-sm">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmAction(status) {
            let title = status === 'disetujui' ? 'Setujui Pinjaman?' : 'Tolak Pinjaman?';
            let text = status === 'disetujui' ? 'Anda yakin ingin menyetujui pinjaman ini?' :
                'Anda yakin ingin menolak pinjaman ini?';
            let icon = status === 'disetujui' ? 'success' : 'warning';
            let confirmButtonText = status === 'disetujui' ? 'Ya, Setujui!' : 'Ya, Tolak!';

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: status === 'disetujui' ? '#28a745' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-status').value = status;
                    document.getElementById('approval-form').submit();
                }
            });
        }
    </script>
@endsection
