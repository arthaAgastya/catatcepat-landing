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
                                    <h2>Form Penarikan Simpanan</h2>
                                </div>
                                <div class="card-toolbar">
                                    <a href="{{ route('transaksi.simpanan.index') }}"
                                        class="btn btn-warning btn-sm">Batal</a>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Terjadi kesalahan:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('transaksi.simpanan.tarik.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        {{-- Nama Anggota --}}
                                        <div class="mb-3">
                                            <label for="anggota_id" class="form-label required">Nama Anggota</label>
                                            <select name="anggota_id" id="anggota_id"
                                                class="form-select @error('anggota_id') is-invalid @enderror" required>
                                                <option value="">-- Pilih Anggota --</option>
                                                @foreach ($anggota as $a)
                                                    <option value="{{ $a->id }}"
                                                        {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                                                        {{ $a->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('anggota_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Info Saldo --}}
                                        <div id="saldo-info" class="alert alert-light d-none">
                                            <strong>Saldo Tersedia:</strong>
                                            <ul class="mb-0">
                                                <li>Simpanan Pokok: <span id="saldo_pokok">Rp 0</span></li>
                                                <li>Simpanan Wajib: <span id="saldo_wajib">Rp 0</span></li>
                                                <li>Simpanan Sukarela: <span id="saldo_sukarela">Rp 0</span></li>
                                            </ul>
                                        </div>

                                        {{-- Jenis Simpanan --}}
                                        <div class="col-12 col-lg-4">
                                            <div class="mb-3">
                                                <label for="account_id" class="form-label required">Jenis Simpanan</label>
                                                <select name="account_id" id="account_id"
                                                    class="form-select @error('account_id') is-invalid @enderror" required>
                                                    <option value="">-- Pilih Jenis Simpanan --</option>
                                                    @foreach ($account as $acc)
                                                        <option value="{{ $acc->id }}"
                                                            {{ old('account_id') == $acc->id ? 'selected' : '' }}>
                                                            {{ $acc->nama_account }} ({{ $acc->no_account }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('account_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Nomor Bukti --}}
                                        <div class="col-12 col-lg-4">
                                            <div class="mb-3">
                                                <label for="nomor_bukti" class="form-label">Nomor Bukti</label>
                                                <input type="text" name="nomor_bukti" class="form-control" readonly
                                                    value="{{ 'TRX-' . now()->format('YmdHis') }}">
                                            </div>
                                        </div>

                                        {{-- Tanggal --}}
                                        <div class="col-12 col-lg-4">
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal Transaksi</label>
                                                <input type="date" name="tanggal" class="form-control" readonly
                                                    value="{{ now()->toDateString() }}">
                                            </div>
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

                                        {{-- Jumlah --}}
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label for="jumlah_format" class="form-label required">Jumlah Tarik
                                                    (Rp)</label>
                                                <input type="text" id="jumlah_format"
                                                    class="form-control @error('jumlah') is-invalid @enderror"
                                                    placeholder="Rp 10.000.000" value="{{ old('jumlah') }}">
                                                <input type="hidden" name="jumlah" id="jumlah"
                                                    value="{{ old('jumlah') }}">
                                                @error('jumlah')
                                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Terbilang --}}
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Terbilang</label>
                                                <div class="form-control bg-light" id="terbilang-box">-</div>
                                            </div>
                                        </div>

                                        {{-- Bukti --}}
                                        <div class="mb-3">
                                            <label for="bukti_transaksi" class="form-label">Bukti Transaksi
                                                (Opsional)</label>
                                            <input type="file" name="bukti_transaksi"
                                                class="form-control @error('bukti_transaksi') is-invalid @enderror"
                                                accept="image/*">
                                            @error('bukti_transaksi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Tombol --}}
                                        <div class="mt-3 text-center">
                                            <button type="button" id="btn-submit"
                                                class="btn btn-sm btn-success">Simpan</button>
                                        </div>
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
        let saldoData = {
            simpanan_pokok: 0,
            simpanan_wajib: 0,
            simpanan_sukarela: 0
        };

        const anggotaSelect = document.getElementById('anggota_id');
        const accountSelect = document.getElementById('account_id');
        const jumlahFormat = document.getElementById('jumlah_format');
        const jumlahInput = document.getElementById('jumlah');
        const terbilangBox = document.getElementById('terbilang-box');

        // Elemen saldo
        const saldoPokokElem = document.getElementById('saldo_pokok');
        const saldoWajibElem = document.getElementById('saldo_wajib');
        const saldoSukarelaElem = document.getElementById('saldo_sukarela');

        // Format Rupiah
        const formatRupiah = (angka) => new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);

        // Konversi ke Terbilang
        function toTerbilang(x) {
            const angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh",
                "sebelas"
            ];
            x = Math.floor(x);
            if (x < 12) return angka[x];
            if (x < 20) return toTerbilang(x - 10) + " belas";
            if (x < 100) return toTerbilang(Math.floor(x / 10)) + " puluh " + toTerbilang(x % 10);
            if (x < 200) return "seratus " + toTerbilang(x - 100);
            if (x < 1000) return toTerbilang(Math.floor(x / 100)) + " ratus " + toTerbilang(x % 100);
            if (x < 2000) return "seribu " + toTerbilang(x - 1000);
            if (x < 1000000) return toTerbilang(Math.floor(x / 1000)) + " ribu " + toTerbilang(x % 1000);
            if (x < 1000000000) return toTerbilang(Math.floor(x / 1000000)) + " juta " + toTerbilang(x % 1000000);
            return "";
        }

        // Ambil saldo anggota saat memilih anggota
        anggotaSelect.addEventListener('change', function() {
            const anggotaId = this.value;
            if (!anggotaId) {
                document.getElementById('saldo-info').classList.add('d-none');
                saldoData = {
                    simpanan_pokok: 0,
                    simpanan_wajib: 0,
                    simpanan_sukarela: 0
                };
                saldoPokokElem.textContent = "Rp 0";
                saldoWajibElem.textContent = "Rp 0";
                saldoSukarelaElem.textContent = "Rp 0";
                return;
            }

            fetch(`{{ route('transaksi.simpanan.saldo.anggota') }}?anggota_id=${anggotaId}`)
                .then(res => res.json())
                .then(data => {
                    saldoData = data;
                    saldoPokokElem.textContent = formatRupiah(data.simpanan_pokok || 0);
                    saldoWajibElem.textContent = formatRupiah(data.simpanan_wajib || 0);
                    saldoSukarelaElem.textContent = formatRupiah(data.simpanan_sukarela || 0);
                    document.getElementById('saldo-info').classList.remove('d-none');
                })
                .catch(() => {
                    Swal.fire('Gagal!', 'Gagal mengambil data saldo anggota.', 'error');
                });
        });

        // Format input jumlah tarik dan update hidden input serta terbilang
        jumlahFormat.addEventListener('input', function() {
            let val = this.value.replace(/[^0-9]/g, '');
            if (!val) {
                jumlahInput.value = '';
                terbilangBox.textContent = '-';
                this.value = '';
                return;
            }

            const jumlah = parseInt(val);
            const accountText = accountSelect.options[accountSelect.selectedIndex]?.text.toLowerCase() || '';
            let saldoTersedia = 0;
            if (accountText.includes('pokok')) {
                saldoTersedia = saldoData.simpanan_pokok || 0;
            } else if (accountText.includes('wajib')) {
                saldoTersedia = saldoData.simpanan_wajib || 0;
            } else if (accountText.includes('sukarela')) {
                saldoTersedia = saldoData.simpanan_sukarela || 0;
            }

            if (jumlah > saldoTersedia) {
                this.value = formatRupiah(saldoTersedia);
                jumlahInput.value = saldoTersedia;
                terbilangBox.textContent = toTerbilang(saldoTersedia) + ' rupiah';
                Swal.fire('Perhatian', 'Jumlah tarik tidak boleh melebihi saldo yang tersedia.', 'warning');
            } else {
                jumlahInput.value = val;
                this.value = formatRupiah(jumlah);
                terbilangBox.textContent = toTerbilang(jumlah) + ' rupiah';
            }
        });

        // Validasi dan konfirmasi submit
        document.getElementById('btn-submit').addEventListener('click', function(e) {
            const anggotaId = anggotaSelect.value;
            if (!anggotaId) {
                Swal.fire('Perhatian', 'Silakan pilih anggota terlebih dahulu.', 'warning');
                return;
            }

            const accountText = accountSelect.options[accountSelect.selectedIndex]?.text.toLowerCase() || '';
            const jumlahTarik = parseInt(jumlahInput.value || 0);

            if (!accountSelect.value) {
                Swal.fire('Perhatian', 'Silakan pilih jenis simpanan.', 'warning');
                return;
            }

            if (jumlahTarik <= 0) {
                Swal.fire('Perhatian', 'Jumlah tarik harus lebih dari 0.', 'warning');
                return;
            }

            let saldoTersedia = 0;
            if (accountText.includes('pokok')) {
                saldoTersedia = saldoData.simpanan_pokok || 0;
            } else if (accountText.includes('wajib')) {
                saldoTersedia = saldoData.simpanan_wajib || 0;
            } else if (accountText.includes('sukarela')) {
                saldoTersedia = saldoData.simpanan_sukarela || 0;
            }

            if (jumlahTarik > saldoTersedia) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Saldo Tidak Cukup!',
                    text: `Jumlah penarikan melebihi saldo tersedia (${formatRupiah(saldoTersedia)}).`,
                });
                return;
            }

            Swal.fire({
                title: 'Simpan Data?',
                text: "Pastikan data sudah benar.",
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
    </script>
@endsection
