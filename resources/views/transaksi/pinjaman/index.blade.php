@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Daftar Pinjaman</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Transaksi</li>
                    <li class="breadcrumb-item text-gray-500">Pinjaman</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center py-2 py-md-1">
                            <a href="{{ route('transaksi.pinjaman.create') }}" class="btn btn-primary btn-sm">
                                <span class="svg-icon svg-icon-2 me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                            rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                        <rect x="4.364" y="11.364" width="16" height="2" rx="1"
                                            fill="black" />
                                    </svg>
                                </span>
                                Tambah Pinjaman
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle" id="tableData">
                            <thead>
                                <tr class="text-start text-muted fw-bolder text-uppercase">
                                    <th class="w-10px pe-2">#</th>
                                    <th class="">Pinjaman</th>
                                    <th class=" text-start">Jumlah Pinjaman</th>
                                    <th class="">Tenor</th>
                                    <th class="">Status</th>
                                    <th class="">Disetujui Oleh</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($pinjaman as $x)
                                    {{-- {{ dd($x) }} --}}
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $x->anggota->nama }}</td>
                                        <td class="text-start">Rp {{ number_format($x->jumlah_pinjaman, 0, ',', '.') }}</td>
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
                                                <span class="badge badge-light-success">Disetujui
                                                    {{ $x->pencairan != null ? '& Dicairkan' : '' }}</span>
                                            @elseif ($x->status == 'ditolak')
                                                <span class="badge badge-light-danger">Ditolak</span>
                                            @elseif ($x->status == 'lunas')
                                                <span class="badge badge-light-primary">Lunas</span>
                                            @endif
                                        </td>
                                        <td class="">
                                            {{ $x->persetujuan->petugas->name ?? '-' }}
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Aksi
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="black" />
                                                    </svg>
                                                </span>
                                            </a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                @if ($x->status == 'pending')
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('transaksi.pinjaman.persetujuan', $x->kode_pinjaman) }}"
                                                            class="menu-link px-3">Persetujuan</a>
                                                    </div>
                                                @endif
                                                @if ($x->persetujuan != null && $x->status == 'disetujui' && $x->pencairan == null)
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('transaksi.pinjaman.pencairan', $x->kode_pinjaman) }}"
                                                            class="menu-link px-3">Pencairan</a>
                                                    </div>
                                                @endif
                                                @if ($x->pencairan != null && $x->status == 'disetujui')
                                                    <div class="menu-item px-3">
                                                        <a href="{{ route('transaksi.pinjaman.show', $x->kode_pinjaman) }}"
                                                            class="menu-link px-3">Detail</a>
                                                    </div>
                                                @endif
                                            </div>
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
