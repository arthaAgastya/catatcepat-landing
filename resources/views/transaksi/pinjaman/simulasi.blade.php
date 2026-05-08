@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Simulasi Pinjaman</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Pinjaman</li>
                    <li class="breadcrumb-item text-gray-500">Simulasi</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        Masukkan parameter pinjaman
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form id="formSimulasi" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Pinjaman</label>
                            <input type="number" class="form-control" id="jumlah" placeholder="10000000" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Bunga (%)</label>
                            <input type="number" step="0.1" class="form-control" id="bunga" placeholder="2"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tenor</label>
                            <input type="number" class="form-control" id="tenor" placeholder="12" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Angsuran</label>
                            <select class="form-select" id="jenis" required>
                                <option value="harian">Harian</option>
                                <option value="mingguan">Mingguan</option>
                                <option value="bulanan" selected>Bulanan</option>
                                <option value="jatuh_tempo">Jatuh Tempo</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Besaran Jasa</label>
                            <select class="form-select" id="besaran" required>
                                <option value="flat" selected>Flat</option>
                                <option value="anuitas">Anuitas</option>
                                <option value="persen">Persen</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="button" id="btnHitung" class="btn btn-primary">Hitung Simulasi</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel hasil simulasi --}}
            <div class="card mt-5" id="hasilCard" style="display:none;">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">Hasil Simulasi</div>
                </div>
                <div class="card-body pt-0">
                    <table class="table table-bordered" id="tabelHasil">
                        <thead>
                            <tr>
                                <th>Angsuran Ke</th>
                                <th>Tanggal Jatuh Tempo</th>
                                <th>Pokok</th>
                                <th>Bunga</th>
                                <th>Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Script JS --}}
    <script>
        document.getElementById('btnHitung').addEventListener('click', function() {
            const jumlah = parseFloat(document.getElementById('jumlah').value);
            const bunga = parseFloat(document.getElementById('bunga').value) / 100;
            const tenor = parseInt(document.getElementById('tenor').value);
            const jenis = document.getElementById('jenis').value;
            const besaran = document.getElementById('besaran').value;

            if (isNaN(jumlah) || isNaN(bunga) || isNaN(tenor)) {
                Swal.fire('Error', 'Mohon isi semua field dengan benar.', 'error');
                return;
            }

            let tbody = document.querySelector('#tabelHasil tbody');
            tbody.innerHTML = '';
            let now = new Date();

            // perhitungan simulasi
            let pokokPerAngsuran = jumlah / tenor;

            for (let i = 1; i <= tenor; i++) {
                let jatuhTempo = new Date(now);

                if (jenis === 'harian') {
                    jatuhTempo.setDate(now.getDate() + i);
                } else if (jenis === 'mingguan') {
                    jatuhTempo.setDate(now.getDate() + (i * 7));
                } else if (jenis === 'bulanan') {
                    jatuhTempo.setMonth(now.getMonth() + i);
                } else if (jenis === 'jatuh_tempo') {
                    jatuhTempo.setMonth(now.getMonth() + tenor);
                    i = tenor; // hanya sekali angsuran
                }

                let pokok = pokokPerAngsuran;
                let bungaHitung = 0;
                let total = 0;

                if (besaran === 'flat') {
                    // bunga tetap tiap periode
                    bungaHitung = jumlah * bunga / tenor;
                    total = pokok + bungaHitung;
                } else if (besaran === 'anuitas') {
                    // rumus anuitas
                    let rate = bunga; // asumsi bunga per bulan
                    let angsuran = (jumlah * rate) / (1 - Math.pow(1 + rate, -tenor));
                    bungaHitung = (jumlah - (pokokPerAngsuran * (i - 1))) * rate;
                    pokok = angsuran - bungaHitung;
                    total = angsuran;
                } else if (besaran === 'persen') {
                    // bunga sekali di awal dibagi rata
                    let totalBunga = jumlah * bunga;
                    bungaHitung = totalBunga / tenor;
                    total = pokok + bungaHitung;
                }

                if (jenis === 'jatuh_tempo') {
                    pokok = jumlah;
                    bungaHitung = jumlah * bunga;
                    total = pokok + bungaHitung;
                }

                let row = `<tr>
                    <td>${i}</td>
                    <td>${jatuhTempo.toISOString().split('T')[0]}</td>
                    <td>${pokok.toFixed(2).toLocaleString()}</td>
                    <td>${bungaHitung.toFixed(2).toLocaleString()}</td>
                    <td>${total.toFixed(2).toLocaleString()}</td>
                </tr>`;

                tbody.insertAdjacentHTML('beforeend', row);

                if (jenis === 'jatuh_tempo') break;
            }

            document.getElementById('hasilCard').style.display = 'block';
        });
    </script>
@endsection
