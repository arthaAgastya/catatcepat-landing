@extends('layouts.main')
@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Daftar Akun</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Master</li>
                    <li class="breadcrumb-item text-gray-500">Akun</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="d-flex flex-column flex-md-row rounded border p-10">
                <ul class="nav nav-tabs nav-pills border-0 flex-row flex-md-column me-5 mb-3 mb-md-0 fs-6">
                    <li class="nav-item w-md-150px me-0">
                        <a class="nav-link active" data-bs-toggle="tab" href="#akun">Akun</a>
                    </li>
                    <li class="nav-item w-md-150px me-0">
                        <a class="nav-link" data-bs-toggle="tab" href="#kategori_akun">Kategori Akun</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="akun" role="tabpanel">
                        <div class="card">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <h5>Data Akun</h5>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex align-items-center py-2 py-md-1">
                                        <a href="{{ route('master.akun.create') }}" class="btn btn-primary btn-sm">
                                            <span class="svg-icon svg-icon-2 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                        rx="1" transform="rotate(-90 11.364 20.364)"
                                                        fill="black" />
                                                    <rect x="4.364" y="11.364" width="16" height="2" rx="1"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                            Tambah Akun
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableData">
                                        <thead>
                                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="w-10px pe-2">#</th>
                                                <th class="min-w-125px">Akun</th>
                                                <th class="min-w-125px">Status</th>
                                                <th class="min-w-125px">Kategori</th>
                                                <th class="min-w-125px">Saldo Awal</th>
                                                <th class="min-w-125px">Saldo Saat Ini</th>
                                                <th class="text-end min-w-100px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold">
                                            @foreach ($accounts as $x)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <a href="#"
                                                                class="text-gray-800 text-hover-primary mb-1">{{ $x->nama_account }}</a>
                                                            <span>No Akun: <b>{{ $x->no_account }}</b></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <a href="#"
                                                                class="text-gray-800 text-hover-primary mb-1">{{ ucfirst($x->saldo_normal) }}</a>
                                                            <span>Level: {{ $x->level }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <a href="#" class="text-gray-800 text-hover-primary mb-1">
                                                                {{ $x->category != null ? $x->category->category . ' - ' . $x->category->sub_category : '' }}
                                                            </a>
                                                            <span>Level: {{ ucfirst($x->kelompok) }}</span>
                                                            {{-- <a href="#"
                                                            class="text-gray-800 text-hover-primary mb-1">{{ ucfirst($x->kelompok) }}</a> --}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        Rp.
                                                        {{ number_format($x->saldoAwalNeraca->saldo_awal ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        Rp. {{ number_format($x->saldo_saat_ini ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="#"
                                                            class="btn btn-light btn-active-light-primary btn-sm"
                                                            data-kt-menu-trigger="click"
                                                            data-kt-menu-placement="bottom-end">Aksi
                                                            <span class="svg-icon svg-icon-5 m-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <path
                                                                        d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                        fill="black" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                            data-kt-menu="true">
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('master.akun.edit', $x->id) }}"
                                                                    class="menu-link px-3">Edit</a>
                                                            </div>
                                                            <div class="menu-item px-3">
                                                                <!-- Form delete disembunyikan -->
                                                                <form id="delete-form-{{ $x->id }}"
                                                                    action="{{ route('master.akun.destroy', $x->id) }}"
                                                                    method="POST" style="display:none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                                <a href="#" class="menu-link px-3 delete-user"
                                                                    data-id="{{ $x->id }}">Delete</a>
                                                            </div>
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
                    <div class="tab-pane fade" id="kategori_akun" role="tabpanel">
                        <div class="card">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <h5>Tipe Akun</h5>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex align-items-center py-2 py-md-1">
                                        <a href="{{ route('master.akun.kategori.create') }}"
                                            class="btn btn-primary btn-sm">
                                            <span class="svg-icon svg-icon-2 me-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="11.364" y="20.364" width="16"
                                                        height="2" rx="1"
                                                        transform="rotate(-90 11.364 20.364)" fill="black" />
                                                    <rect x="4.364" y="11.364" width="16" height="2"
                                                        rx="1" fill="black" />
                                                </svg>
                                            </span>
                                            Tambah Tipe Akun
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr class="text-muted fw-bolder text-uppercase">
                                                <th>Kategori</th>
                                                <th class="text-center">Sub Kategori</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold border-0">
                                            @foreach ($kategori as $category => $subCategories)
                                                <tr>
                                                    <td rowspan="{{ $subCategories->count() }}">{{ $category }}</td>
                                                    <!-- Rowspan pada kategori -->
                                                    @php $nomor = 1; @endphp <!-- Inisialisasi nomor subkategori -->
                                                    @foreach ($subCategories as $index => $subCategory)
                                                        @if ($index > 0)
                                                            <!-- Pastikan hanya 1 kategori yang muncul per group -->
                                                <tr>
                                            @endif
                                            <td class="text-start">{{ $nomor }}. {{ $subCategory->sub_category }}
                                            </td>
                                            <!-- Nomor sub kategori -->
                                            <td>
                                                {{-- Aksi tombol edit atau delete jika perlu --}}
                                            </td>
                                            @if ($index > 0)
                                                </tr>
                                            @endif
                                            @php $nomor++; @endphp <!-- Increment nomor subkategori -->
                                            @endforeach
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
