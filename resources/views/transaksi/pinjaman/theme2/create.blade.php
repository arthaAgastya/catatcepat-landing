@extends('layouts.main2')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="row g-5 g-xl-8">
                    <div class="col-12">
                        <div class="card card-xl-stretch mb-5 mb-xl-8">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">Form Pengajuan Pinjaman</div>
                            </div>
                            <div class="card-body pt-0">
                                <form action="{{ route('transaksi.pinjaman.store') }}" method="POST" id="formPinjaman"
                                    class="row g-3">
                                    @csrf

                                    {{-- Nama Anggota --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Anggota</label>
                                        <select name="id_anggota" id="id_anggota"
                                            class="form-select @error('id_anggota') is-invalid @enderror" required>
                                            <option value="">-- Pilih Anggota --</option>
                                            @foreach ($anggota as $a)
                                                <option value="{{ $a->id }}" data-nik="{{ $a->nomor_anggota }}"
                                                    {{ old('id_anggota') == $a->id ? 'selected' : '' }}>
                                                    {{ $a->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_anggota')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- NIK --}}
                                    <div class="col-md-6">
                                        <label class="form-label">NIK</label>
                                        <input type="text" name="nik" id="nik" class="form-control"
                                            value="{{ old('nik') }}" readonly>
                                    </div>

                                    {{-- Jumlah Pinjaman --}}
                                    <div class="col-6">
                                        <label class="form-label">Jumlah Pinjaman</label>
                                        <input type="text" id="jumlah_format" class="form-control"
                                            placeholder="Rp 10.000.000" value="{{ old('jumlah') }}">
                                        <input type="hidden" name="jumlah" id="jumlah" value="{{ old('jumlah') }}">
                                        @error('jumlah')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Tingkat Suku Bunga Tahunan --}}
                                    <div class="col-3">
                                        <label class="form-label">Tingkat Suku Bunga Tahunan (%)</label>
                                        <input type="number" step="0.01" name="suku_bunga_tahunan"
                                            id="suku_bunga_tahunan"
                                            class="form-control @error('suku_bunga_tahunan') is-invalid @enderror"
                                            placeholder="9.5" value="{{ old('suku_bunga_tahunan') }}" required>
                                        @error('suku_bunga_tahunan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Bunga (%) --}}
                                    <div class="col-3">
                                        <label class="form-label">Bunga (%)</label>
                                        <input type="number" step="0.01" name="bunga" id="bunga"
                                            class="form-control @error('bunga') is-invalid @enderror" placeholder="0.75"
                                            value="{{ old('bunga') }}" required>
                                        @error('bunga')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Tenor --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Tenor</label>
                                        <input type="number" name="tenor" id="tenor"
                                            class="form-control @error('tenor') is-invalid @enderror" placeholder="12"
                                            value="{{ old('tenor') }}" required>
                                        @error('tenor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Jenis Angsuran --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Jenis Angsuran</label>
                                        <select name="jenis_angsuran" id="jenis"
                                            class="form-select @error('jenis_angsuran') is-invalid @enderror" required>
                                            <option value="harian"
                                                {{ old('jenis_angsuran') == 'harian' ? 'selected' : '' }}>Harian
                                            </option>
                                            <option value="mingguan"
                                                {{ old('jenis_angsuran') == 'mingguan' ? 'selected' : '' }}>
                                                Mingguan</option>
                                            <option value="bulanan"
                                                {{ old('jenis_angsuran') == 'bulanan' ? 'selected' : '' }}>Bulanan
                                            </option>
                                            <option value="jatuh_tempo"
                                                {{ old('jenis_angsuran') == 'jatuh_tempo' ? 'selected' : '' }}>
                                                Jatuh Tempo</option>
                                        </select>
                                        @error('jenis_angsuran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Besaran Jasa --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Besaran Jasa</label>
                                        <select name="besaran_jasa" id="besaran"
                                            class="form-select @error('besaran_jasa') is-invalid @enderror" required>
                                            <option value="flat" {{ old('besaran_jasa') == 'flat' ? 'selected' : '' }}>
                                                Flat</option>
                                            <option value="anuitas"
                                                {{ old('besaran_jasa') == 'anuitas' ? 'selected' : '' }}>Anuitas
                                            </option>
                                            <option value="persen" {{ old('besaran_jasa') == 'persen' ? 'selected' : '' }}>
                                                Persen
                                            </option>
                                        </select>
                                        @error('besaran_jasa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="col-md-12 mt-5 text-center">
                                        <button type="button" id="btnHitung" class="btn btn-info">Hitung Simulasi</button>
                                        <button type="submit" class="btn btn-primary">Simpan Pinjaman</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card card-xl-stretch mt-5" id="hasilCard" style="display:none;">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">Hasil Simulasi Angsuran</div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table-bordered" id="tabelHasil">
                                    <thead>
                                        <tr class="text-start text-muted fw-bolder text-uppercase">
                                            <th class="text-center">Angsuran Ke</th>
                                            <th>Tanggal Jatuh Tempo</th>
                                            <th>Pokok</th>
                                            <th>Bunga</th>
                                            <th>Total Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot class="border-top">
                                        <tr class="fw-bolder text-uppercase">
                                            <td colspan="2" class="text-end">TOTAL</td>
                                            <td id="totalPokok">0</td>
                                            <td id="totalBunga">0</td>
                                            <td id="totalBayar">0</td>
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

    <script>
        $(document).ready(function() {
            $('#id_anggota').change(function() {
                var nik = $(this).find(':selected').data('nik') || '';
                $('#nik').val(nik);
            });
        });
    </script>

    <script>
        const formatRupiah = (angka) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        document.getElementById('jumlah_format').addEventListener('input', function(e) {
            // Hilangkan semua non-digit
            let value = e.target.value.replace(/[^,\d]/g, '').toString();

            // Ubah ke angka dan set ke hidden input
            let cleanValue = parseInt(value || '0');
            document.getElementById('jumlah').value = cleanValue;

            // Update input tampilan
            this.value = formatRupiah(cleanValue);
        });

        // Tambahan agar nilai tetap tampil dalam format saat reload (edit page misalnya)
        window.addEventListener('DOMContentLoaded', function() {
            let currentValue = document.getElementById('jumlah').value;
            if (currentValue) {
                document.getElementById('jumlah_format').value = formatRupiah(currentValue);
            }
        });
    </script>

    {{-- Script Simulasi --}}
    <script>
        document.getElementById('btnHitung').addEventListener('click', function() {
            const jumlah = parseFloat(document.getElementById('jumlah').value);
            const bungaInput = document.getElementById('suku_bunga_tahunan').value;
            // Pakai nilai suku_bunga_tahunan jika diisi, kalau tidak pakai bunga biasa
            const bungaTahun = bungaInput ? parseFloat(bungaInput) : parseFloat(document.getElementById('bunga')
                .value);

            const tenor = parseInt(document.getElementById('tenor').value);
            const jenis = document.getElementById('jenis').value;
            const besaran = document.getElementById('besaran').value;

            if (isNaN(jumlah) || isNaN(bungaTahun) || isNaN(tenor)) {
                Swal.fire('Error', 'Mohon isi semua field dengan benar.', 'error');
                return;
            }

            let tbody = document.querySelector('#tabelHasil tbody');
            tbody.innerHTML = '';
            let now = new Date();

            let pokokPerBulan = jumlah / tenor;
            let bungaBulanan = bungaTahun / 12 / 100;

            let sisaPokok = jumlah;

            let totalPokok = 0,
                totalBunga = 0,
                totalBayar = 0;

            for (let i = 1; i <= tenor; i++) {
                let jatuhTempo = new Date(now);
                if (jenis === 'harian') jatuhTempo.setDate(now.getDate() + i);
                else if (jenis === 'mingguan') jatuhTempo.setDate(now.getDate() + (i * 7));
                else if (jenis === 'bulanan') jatuhTempo.setMonth(now.getMonth() + i);
                else if (jenis === 'jatuh_tempo') jatuhTempo.setMonth(now.getMonth() + tenor);

                let pokok = pokokPerBulan;
                let bungaHitung = 0;
                let total = 0;

                if (besaran === 'flat') {
                    bungaHitung = jumlah * bungaBulanan;
                    total = pokok + bungaHitung;

                } else if (besaran === 'anuitas') {
                    let angsuran = jumlah * bungaBulanan / (1 - Math.pow(1 + bungaBulanan, -tenor));
                    bungaHitung = sisaPokok * bungaBulanan;
                    pokok = angsuran - bungaHitung;
                    total = angsuran;

                } else if (besaran === 'persen') {
                    bungaHitung = sisaPokok * bungaBulanan;
                    total = pokok + bungaHitung;
                }

                if (jenis === 'jatuh_tempo') {
                    pokok = jumlah;
                    bungaHitung = jumlah * bungaBulanan * tenor;
                    total = pokok + bungaHitung;
                    i = tenor; // hanya satu kali cicilan
                }

                sisaPokok -= pokok;
                totalPokok += pokok;
                totalBunga += bungaHitung;
                totalBayar += total;

                tbody.insertAdjacentHTML('beforeend', `
            <tr>
                <td class="text-center">${i}</td>
                <td>${jatuhTempo.toISOString().split('T')[0]}</td>
                <td>${pokok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
                <td>${bungaHitung.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
                <td>${total.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
            </tr>
        `);

                if (jenis === 'jatuh_tempo') break;
            }

            document.getElementById('totalPokok').innerText = totalPokok.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g,
                ".");
            document.getElementById('totalBunga').innerText = totalBunga.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g,
                ".");
            document.getElementById('totalBayar').innerText = totalBayar.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g,
                ".");

            document.getElementById('hasilCard').style.display = 'block';
        });
    </script>
@endsection
