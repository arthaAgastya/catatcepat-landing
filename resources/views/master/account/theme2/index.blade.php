@extends('layouts.main2')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container">
            <div class="col-12">
                <div class="mb-10">
                    <ul class="nav row mb-10">
                        <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                            <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px active"
                                data-bs-toggle="tab" href="#akun_data">
                                <span class="svg-icon svg-icon-3x mb-5 mx-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3"
                                            d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                            fill="black"></path>
                                        <path
                                            d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                            fill="black"></path>
                                    </svg>
                                </span>
                                <span class="fs-6 fw-bold">Data
                                    <br>Akun</span>
                            </a>
                        </li>
                        <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                            <a class="nav-link btn btn-flex btn-color-gray-400 btn-outline btn-outline-default btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-1250px h-lg-175px"
                                data-bs-toggle="tab" href="#kategori_data">
                                <span class="svg-icon svg-icon-3x mb-5 mx-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3"
                                            d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z"
                                            fill="black"></path>
                                        <path
                                            d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z"
                                            fill="black"></path>
                                    </svg>
                                </span>
                                <span class="fs-6 fw-bold">Data
                                    <br>Ketegori Akun</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="akun_data">
                            <div class="card">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder fs-3 mb-1">Data Akun</span>
                                    </h3>
                                    <div class="card-toolbar">
                                        <div class="d-flex align-items-center py-2 py-md-1">
                                            <a href="{{ route('master.akun.create') }}" class="btn btn-primary btn-sm">
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
                                                Tambah Akun
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-3">
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
                                                                <a href="#"
                                                                    class="text-gray-800 text-hover-primary mb-1">
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
                        <div class="tab-pane fade" id="kategori_data">
                            <div class="card">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder fs-3 mb-1">Data Ketegori Akun</span>
                                    </h3>
                                    <div class="card-toolbar">
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
                                            Tambah Kategori Akun
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body py-3">
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
                                                        <td rowspan="{{ $subCategories->count() }}">{{ $category }}
                                                        </td>
                                                        <!-- Rowspan pada kategori -->
                                                        @php $nomor = 1; @endphp <!-- Inisialisasi nomor subkategori -->
                                                        @foreach ($subCategories as $index => $subCategory)
                                                            @if ($index > 0)
                                                                <!-- Pastikan hanya 1 kategori yang muncul per group -->
                                                    <tr>
                                                @endif
                                                <td class="text-start">{{ $nomor }}.
                                                    {{ $subCategory->sub_category }}
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
