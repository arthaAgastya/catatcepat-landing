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
                                    <h2>Pengecekan Pinjaman Anggota</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form action="{{ route('transaksi.ajax.pengecekanPinjaman') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-lg-8">
                                            <div class="mb-3">
                                                <label class="form-label required">Nama Anggota</label>
                                                <select name="id_anggota" id="id_anggota" class="form-control" required>
                                                    <option value="" selected disabled>Pilih Anggota</option>
                                                    @foreach ($anggota as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">NIK</label>
                                                <input type="text" class="form-control" id="nik" name="nik"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Jumlah Pengajuan Pinjaman</label>
                                                <input type="text" class="form-control" id="pengajuan" name="pengajuan"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Besaran Jasa</label>
                                                <input type="text" class="form-control" id="besaran_jasa"
                                                    name="besaran_jasa" readonly>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Biaya Pinjaman</label>
                                                <input type="text" class="form-control" id="biaya_pinjaman"
                                                    name="biaya_pinjaman" readonly>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Status:
                                                <span id="status_badge" class="badge badge-secondary">-</span>
                                            </label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nomor Akad</label>
                                            <input type="text" class="form-control" id="nomor_akad" name="nomor_akad"
                                                readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Akad</label>
                                            <input type="text" class="form-control" id="tanggal_akad" name="tanggal_akad"
                                                readonly>
                                        </div>
                                    </div>
                                    {{-- Table Angsuran --}}
                                    <div class="mb-3">
                                        <label class="form-label">Tabel Angsuran</label>
                                        <div id="tabel_angsuran" class="table-responsive"></div>
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
        // Format angka ke Rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        function formatTanggalIndonesia(dateStr) {
            const date = new Date(dateStr);
            return new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }).format(date);
        }

        function formatTanggalIndonesia2(tanggalString) {
            if (!tanggalString) return '-';

            const parts = tanggalString.split('-');
            if (parts.length !== 3) return '-'; // validasi format

            const [dd, mm, yyyy] = parts;

            // Buat objek Date dari bagian-bagian tanggal
            const date = new Date(`${yyyy}-${mm}-${dd}`);

            if (isNaN(date)) return '-'; // jika gagal parse tanggal

            return new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }).format(date);
        }


        document.getElementById('id_anggota').addEventListener('change', function() {
            const idAnggota = this.value;

            Swal.fire({
                title: 'Memuat data pinjaman...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            fetch("{{ route('transaksi.ajax.pengecekanPinjaman') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        id_anggota: idAnggota
                    })
                })
                .then(res => {
                    if (!res.ok) throw res;
                    return res.json();
                })
                .then(data => {
                    Swal.close();

                    document.getElementById('nik').value = data.nik || '';
                    document.getElementById('pengajuan').value = data.pengajuan ? new Intl.NumberFormat(
                        'id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data.pengajuan) : '';
                    document.getElementById('besaran_jasa').value = data.besaran_jasa || '';
                    document.getElementById('biaya_pinjaman').value = data.biaya_pinjaman ? new Intl
                        .NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data.biaya_pinjaman) : '';
                    document.getElementById('nomor_akad').value = data.nomor_akad || '';
                    document.getElementById('tanggal_akad').value = data.tanggal_akad || '';

                    // Status badge
                    const badge = document.getElementById('status_badge');
                    badge.textContent = data.status || '-';
                    badge.className = 'badge';
                    if (data.status === 'Disetujui') {
                        badge.classList.add('badge-primary');
                    } else if (data.status === 'Ditolak') {
                        badge.classList.add('badge-danger');
                    } else {
                        badge.classList.add('badge-secondary');
                    }

                    if (data.status === 'Disetujui' && data.jadwal_angsuran) {
                        // Render jadwal angsuran dari backend
                        let tableHTML = `<table class="table table-bordered ">
                <thead>
                    <tr class="fw-bolder text-uppercase"><th>#</th><th>Tanggal</th><th>Pokok</th><th>Bunga</th><th>Total</th><th>Status</th></tr>
                </thead><tbody>`;

                        data.jadwal_angsuran.forEach(item => {
                            tableHTML += `<tr>
        <td>${item.angsuran_ke}</td>
        <td>${formatTanggalIndonesia2(item.tanggal)}</td>
        <td>${new Intl.NumberFormat('id-ID', {style:'currency', currency:'IDR'}).format(item.jumlah_pokok)}</td>
        <td>${new Intl.NumberFormat('id-ID', {style:'currency', currency:'IDR'}).format(item.jumlah_bunga)}</td>
        <td>${new Intl.NumberFormat('id-ID', {style:'currency', currency:'IDR'}).format(item.jumlah_total)}</td>
        <td><span class="badge badge-${item.status === 'lunas' ? 'success' : 'warning'}">${item.status === 'lunas' ? 'Lunas' : 'Belum Lunas'}</span></td>
    </tr>`;
                        });

                        tableHTML += '</tbody></table>';
                        document.getElementById('tabel_angsuran').innerHTML = tableHTML;

                    } else if (data.status === 'Ditolak' && data.manual_calc) {
                        // Hitung manual sesuai data
                        hitungManual(data.manual_calc);
                    } else {
                        document.getElementById('tabel_angsuran').innerHTML =
                            '<p class="text-muted">Tidak ada data angsuran</p>';
                    }
                })
                .catch(async (err) => {
                    Swal.close();
                    let message = 'Terjadi kesalahan saat memuat data.';
                    if (err.json) {
                        const errData = await err.json();
                        message = errData.error || message;
                    }
                    Swal.fire('Gagal', message, 'error');
                });
        });

        function hitungManual(data) {
            const jumlah = parseFloat(data.jumlah);
            const bunga = Number(data.bunga) / 100;
            const tenor = parseInt(data.tenor);
            const jenis = data.jenis;
            const besaran = data.besaran;

            if (!jumlah || !bunga || !tenor || !jenis || !besaran) {
                document.getElementById('tabel_angsuran').innerHTML =
                    '<p class="text-danger">Data perhitungan tidak valid.</p>';
                return;
            }

            let now = new Date();
            let pokokPerAngsuran = jumlah / tenor;
            let tableHTML = `<table class="table table-bordered">
        <thead>
            <tr class="fw-bolder text-uppercase"><th>#</th><th>Tanggal</th><th>Pokok</th><th>Bunga</th><th>Total</th></tr>
        </thead><tbody>`;

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
                    if (i > 1) break; // hanya satu kali
                }

                let pokok = pokokPerAngsuran;
                let bungaHitung = 0;
                let total = 0;

                if (besaran === 'flat') {
                    bungaHitung = jumlah * bunga / tenor;
                    total = pokok + bungaHitung;
                } else if (besaran === 'anuitas') {
                    let rate = bunga;
                    let angsuran = (jumlah * rate) / (1 - Math.pow(1 + rate, -tenor));
                    bungaHitung = (jumlah - (pokokPerAngsuran * (i - 1))) * rate;
                    pokok = angsuran - bungaHitung;
                    total = angsuran;
                } else if (besaran === 'persen') {
                    let totalBunga = jumlah * bunga;
                    bungaHitung = totalBunga / tenor;
                    total = pokok + bungaHitung;
                }

                if (jenis === 'jatuh_tempo') {
                    pokok = jumlah;
                    bungaHitung = jumlah * bunga;
                    total = pokok + bungaHitung;
                }

                tableHTML += `<tr>
            <td>${i}</td>
            <td>${formatTanggalIndonesia(jatuhTempo)}</td>
            <td>${formatRupiah(pokok)}</td>
            <td>${formatRupiah(bungaHitung)}</td>
            <td>${formatRupiah(total)}</td>
        </tr>`;
            }

            tableHTML += '</tbody></table>';
            document.getElementById('tabel_angsuran').innerHTML = tableHTML;
        }
    </script>
@endsection
