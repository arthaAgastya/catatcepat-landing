@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Pencairan Pinjaman</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Transaksi</li>
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('transaksi.pinjaman.index') }}"
                            class="text-gray-600 text-hover-primary">Pinjaman</a>
                    </li>
                    <li class="breadcrumb-item text-gray-500">Pencairan</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
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
                            <input type="text" class="form-control" value="{{ $pinjaman->anggota->nama }}" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Kode Anggota</label>
                            <input type="text" class="form-control" value="{{ $pinjaman->anggota->nomor_anggota }}"
                                readonly>
                        </div>

                        {{-- Detail Pinjaman --}}
                        <div class="col-4 mt-3">
                            <label class="form-label">Jumlah Pinjaman</label>
                            <input type="text" class="form-control"
                                value="{{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}" readonly>
                        </div>
                        <div class="col-4 mt-3">
                            <label class="form-label">Bunga (%)</label>
                            <input type="text" class="form-control" value="{{ $pinjaman->bunga_persen }}" readonly>
                        </div>
                        <div class="col-4 mt-3">
                            <label class="form-label">Tenor</label>
                            <input type="text" class="form-control" value="{{ $pinjaman->tenor }}" readonly>
                        </div>
                        <div class="col-4 mt-3">
                            <label class="form-label">Jenis Angsuran</label>
                            <input type="text" class="form-control" value="{{ ucfirst($pinjaman->jenis_angsuran) }}"
                                readonly>
                        </div>
                        <div class="col-4 mt-3">
                            <label class="form-label">Besaran Jasa</label>
                            <input type="text" class="form-control" value="{{ ucfirst($pinjaman->besaran_jasa) }}"
                                readonly>
                        </div>
                        <div class="col-4 mt-3">
                            <label class="form-label">Tanggal Pengajuan</label>
                            <input type="text" class="form-control"
                                value="{{ \Carbon\Carbon::parse($pinjaman->tanggal_pengajuan)->format('Y-m-d') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Simulasi Angsuran --}}
            <div class="card mt-5">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">Angsuran</div>
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
                                        $angsuran_pokok_format = number_format($angsuran_pokok, 0, ',', '.');
                                        $bunga_format = number_format($bunga, 0, ',', '.');
                                        $jumlah_angsuran_format = number_format($jumlah_angsuran, 0, ',', '.');
                                        $saldo_akhir_format = number_format(max($saldo_akhir, 0), 0, ',', '.');

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

            {{-- Form Pencairan --}}
            <div class="card mt-5">
                <div class="card-body">
                    <form id="pencairan-form"
                        action="{{ route('transaksi.pinjaman.pencairan.store', $pinjaman->kode_pinjaman) }}"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="tanggal_pencairan" class="form-label">Tanggal Pencairan</label>
                                    <input type="date" id="tanggal_pencairan" name="tanggal_pencairan"
                                        class="form-control" required value="{{ old('tanggal_pencairan', date('Y-m-d')) }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="jumlah_cair_format" class="form-label">Jumlah Pencairan</label>
                                    <input type="text" id="jumlah_cair_format" class="form-control"
                                        placeholder="Rp 10.000.000"
                                        value="{{ old('jumlah_cair') ? number_format(old('jumlah_cair'), 0, ',', '.') : number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}">
                                    <input type="hidden" name="jumlah_cair" id="jumlah_cair"
                                        value="{{ old('jumlah_cair') }}">
                                    @error('jumlah_cair')
                                        <div class="text-danger mt-1 small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="metode" class="form-label">Metode Pencairan</label>
                                    <select id="metode" name="metode" class="form-select" required>
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="transfer" {{ old('metode') == 'transfer' ? 'selected' : '' }}>
                                            Transfer</option>
                                        <option value="tunai" {{ old('metode') == 'tunai' ? 'selected' : '' }}>Tunai
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            <button type="submit" class="btn btn-primary">Pencairan Dana</button>
                            <a href="{{ route('transaksi.pinjaman.index') }}" class="btn btn-secondary ms-3">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formatRupiah = (angka) => {
                if (!angka || isNaN(angka)) return 'Rp 0';
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            };

            const jumlahCairFormatInput = document.getElementById('jumlah_cair_format');
            const jumlahCairHiddenInput = document.getElementById('jumlah_cair');
            const form = document.getElementById('pencairan-form');

            // Saat user mengetik di input tampilan
            jumlahCairFormatInput.addEventListener('input', function(e) {
                // Hilangkan semua non-digit
                let value = e.target.value.replace(/[^0-9]/g, '');
                let cleanValue = parseInt(value || '0');

                // Update hidden input
                jumlahCairHiddenInput.value = cleanValue;

                // Update tampilan jadi format rupiah
                e.target.value = formatRupiah(cleanValue);
            });

            // Saat halaman pertama kali load, formatkan input awal (jika ada)
            const initialValue = jumlahCairFormatInput.value.replace(/[^0-9]/g, '');
            if (initialValue) {
                jumlahCairFormatInput.value = formatRupiah(parseInt(initialValue));
                jumlahCairHiddenInput.value = parseInt(initialValue);
            }

            // Tambahkan konfirmasi SweetAlert sebelum submit
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // tahan dulu submit-nya

                const nominal = parseInt(jumlahCairHiddenInput.value || 0);

                if (nominal <= 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Nominal tidak valid',
                        text: 'Masukkan jumlah pencairan yang benar.',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Pencairan',
                    html: `Apakah Anda yakin ingin mencairkan pinjaman sebesar <b>${formatRupiah(nominal)}</b>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, cairkan!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // submit jika disetujui
                    }
                });
            });
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahCairFormatInput = document.getElementById('jumlah_cair_format');
            const jumlahCairHiddenInput = document.getElementById('jumlah_cair');
            const form = document.getElementById('pencairan-form');

            // Fungsi format angka ke format rupiah
            function formatRupiah(value) {
                if (!value) return '';
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            // Event saat mengetik di input tampilan
            jumlahCairFormatInput.addEventListener('input', function(e) {
                // Hapus semua karakter non-digit
                let value = e.target.value.replace(/[^0-9]/g, '');

                // Update input hidden dengan nilai murni
                jumlahCairHiddenInput.value = value;

                // Format tampilan input (Rp xxx.xxx)
                e.target.value = formatRupiah(value);
            });

            // Pastikan sebelum submit, nilai yang dikirim bersih tanpa titik
            form.addEventListener('submit', function() {
                const value = jumlahCairFormatInput.value.replace(/\./g, '');
                jumlahCairHiddenInput.value = value; // angka murni tanpa titik
            });
        });
    </script> --}}
@endsection
