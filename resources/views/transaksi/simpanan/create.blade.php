@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Tambah Simpanan Anggota</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Transaksi</li>
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('transaksi.simpanan.index') }}" class="text-gray-600 text-hover-primary">Simpanan
                            Anggota</a>
                    </li>
                    <li class="breadcrumb-item text-gray-500">Tambah</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2>Form Simpanan Anggota</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('transaksi.simpanan.index') }}" class="btn btn-warning btn-sm">Batal</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('transaksi.simpanan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            {{-- Nama Anggota --}}
                            <div class="mb-3">
                                <label for="id_anggota" class="form-label required">Nama Anggota</label>
                                <select name="id_anggota" id="id_anggota"
                                    class="form-select @error('id_anggota') is-invalid @enderror" required>
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach ($anggota as $a)
                                        <option value="{{ $a->id }}"
                                            {{ old('id_anggota') == $a->id ? 'selected' : '' }}>
                                            {{ $a->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_anggota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nomor Bukti --}}
                            <div class="col-md-6 mb-3">
                                <label for="nomor_bukti" class="form-label">Nomor Bukti</label>
                                <input type="text" name="nomor_bukti" class="form-control" readonly
                                    value="{{ 'TRX-' . now()->format('YmdHis') }}">
                            </div>

                            {{-- Tanggal --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal" class="form-label">Tanggal Transaksi</label>
                                <input type="date" name="tanggal" class="form-control" readonly
                                    value="{{ now()->toDateString() }}">
                            </div>

                            {{-- Keterangan --}}
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" name="keterangan"
                                    class="form-control @error('keterangan') is-invalid @enderror"
                                    value="{{ old('keterangan') }}">
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Simpanan Pokok --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="jumlah_pokok_format" class="form-label">Jumlah Simpanan Pokok (Rp)</label>
                                <input type="text" id="jumlah_pokok_format" data-format="rupiah"
                                    data-target="jumlah_pokok" class="form-control" placeholder="Rp 0"
                                    value="{{ old('jumlah_pokok') }}">
                                <input type="hidden" name="jumlah_pokok" id="jumlah_pokok"
                                    value="{{ old('jumlah_pokok') }}">
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="form-label">Terbilang</label>
                                <div class="form-control bg-light" id="jumlah_pokok_terbilang">-</div>
                            </div>

                            {{-- Simpanan Wajib --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="jumlah_wajib_format" class="form-label required">Jumlah Simpanan Wajib
                                    (Rp)</label>
                                <input type="text" id="jumlah_wajib_format" data-format="rupiah"
                                    data-target="jumlah_wajib"
                                    class="form-control @error('jumlah_wajib') is-invalid @enderror" placeholder="Rp 0"
                                    value="{{ old('jumlah_wajib') }}">
                                <input type="hidden" name="jumlah_wajib" id="jumlah_wajib"
                                    value="{{ old('jumlah_wajib') }}">
                                @error('jumlah_wajib')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="form-label">Terbilang</label>
                                <div class="form-control bg-light" id="jumlah_wajib_terbilang">-</div>
                            </div>

                            {{-- Simpanan Sukarela --}}
                            <div class="col-12 col-lg-6 mb-3">
                                <label for="jumlah_sukarela_format" class="form-label">Jumlah Simpanan Sukarela
                                    (Rp)</label>
                                <input type="text" id="jumlah_sukarela_format" data-format="rupiah"
                                    data-target="jumlah_sukarela" class="form-control" placeholder="Rp 0"
                                    value="{{ old('jumlah_sukarela') }}">
                                <input type="hidden" name="jumlah_sukarela" id="jumlah_sukarela"
                                    value="{{ old('jumlah_sukarela') }}">
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="form-label">Terbilang</label>
                                <div class="form-control bg-light" id="jumlah_sukarela_terbilang">-</div>
                            </div>

                            {{-- Bukti Transaksi --}}
                            <div class="mb-3">
                                <label for="bukti_transaksi" class="form-label">Bukti Transaksi (Opsional)</label>
                                <input type="file" name="bukti_transaksi"
                                    class="form-control @error('bukti_transaksi') is-invalid @enderror" accept="image/*">
                                @error('bukti_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Submit --}}
                            <div class="text-center mt-4">
                                <button type="button" id="btn-submit" class="btn btn-success btn-sm">Simpan</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT SECTION --}}
    <script>
        document.getElementById('btn-submit').addEventListener('click', function(e) {
            Swal.fire({
                title: 'Simpan Data?',
                text: "Pastikan data yang dimasukkan sudah benar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.closest('form').submit();
                }
            });
        });

        function terbilang(n) {
            const angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh",
                "sebelas"
            ];

            function toTerbilang(x) {
                x = Math.floor(x);
                if (x < 12) return angka[x];
                if (x < 20) return toTerbilang(x - 10) + " belas";
                if (x < 100) return toTerbilang(Math.floor(x / 10)) + " puluh " + toTerbilang(x % 10);
                if (x < 200) return "seratus " + toTerbilang(x - 100);
                if (x < 1000) return toTerbilang(Math.floor(x / 100)) + " ratus " + toTerbilang(x % 100);
                if (x < 2000) return "seribu " + toTerbilang(x - 1000);
                if (x < 1000000) return toTerbilang(Math.floor(x / 1000)) + " ribu " + toTerbilang(x % 1000);
                if (x < 1000000000) return toTerbilang(Math.floor(x / 1000000)) + " juta " + toTerbilang(x % 1000000);
                return "terlalu besar";
            }
            return toTerbilang(n).replace(/\s+/g, ' ').trim();
        }

        document.querySelectorAll('[data-format="rupiah"]').forEach(function(input) {
            const hidden = document.getElementById(input.dataset.target);
            const terbilangBox = document.getElementById(input.dataset.target + '_terbilang');

            function updateValue() {
                let value = input.value.replace(/[^,\d]/g, '');
                let numeric = parseInt(value || '0');

                hidden.value = isNaN(numeric) ? '' : numeric;
                input.value = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(numeric);

                terbilangBox.textContent = isNaN(numeric) || numeric === 0 ? '-' : terbilang(numeric) + ' rupiah';
            }

            input.addEventListener('input', updateValue);
            updateValue();
        });
    </script>
@endsection
