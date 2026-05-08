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
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed" id="tableData">
                                        <thead>
                                            <tr class="text-start text-muted fw-bolder text-uppercase">
                                                <th class="w-10px pe-2">#</th>
                                                <th class="min-w-125px">Pinjaman</th>
                                                <th class="min-w-125px text-start">Jumlah Pinjaman</th>
                                                <th class="min-w-125px">Tenor</th>
                                                <th class="min-w-125px">Status</th>
                                                <th class="min-w-125px">Disetujui Oleh</th>
                                                <th class="text-end min-w-100px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold">
                                            @foreach ($pinjaman as $x)
                                                {{-- {{ dd($x) }} --}}
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $x->anggota->nama }}</td>
                                                    <td class="text-start">Rp
                                                        {{ number_format($x->jumlah_pinjaman, 0, ',', '.') }}</td>
                                                    @php
                                                        $mapping = [
                                                            'harian' => 'Hari',
                                                            'mingguan' => 'Minggu',
                                                            'bulanan' => 'Bulan',
                                                            'jatuh_tempo' => 'Jatuh Tempo',
                                                        ];

                                                        $jenis_angsuran = $mapping[$x->jenis_angsuran] ?? '-';
                                                    @endphp

                                                    <td>
                                                        @if ($x->jenis_angsuran == 'jatuh_tempo')
                                                            {{ $jenis_angsuran }}
                                                        @else
                                                            {{ $x->tenor . ' ' . $jenis_angsuran }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($x->status == 'pending')
                                                            <span class="badge badge-light-warning">Pending</span>
                                                        @elseif ($x->status == 'disetujui')
                                                            <span class="badge badge-light-success">Disetujui</span>
                                                        @elseif ($x->status == 'ditolak')
                                                            <span class="badge badge-light-danger">Ditolak</span>
                                                        @elseif ($x->status == 'lunas')
                                                            <span class="badge badge-light-primary">Lunas</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $x->persetujuan->petugas->name ?? '-' }}
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="{{ route('transaksi.pinjaman.persetujuan', $x->kode_pinjaman) }}"
                                                            class="btn btn-sm btn-info">Persetujuan</a>
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
    <script>
        new DataTable('#tableData');

        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi ulang dropdown setelah DataTable menggambar ulang konten
            const table = new DataTable('#tableData');
            table.on('draw', function() {
                // Inisialisasi ulang menu dropdown ketika DataTable menggambar ulang
                KTMenu.createInstances();
            });

            // Delegasi event untuk tombol hapus
            document.querySelector('#kt_content_container').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('delete-user')) {
                    e.preventDefault();
                    const userId = e.target.getAttribute('data-id');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data user akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + userId).submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection
