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
                                <div class="card-toolbar">
                                    <div class="d-flex align-items-center py-2 py-md-1">
                                        <a href="{{ route('master.anggota.create') }}" class="btn btn-primary btn-sm">
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
                                            Tambah Anggota
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
                                                <th class="min-w-125px">Anggota</th>
                                                <th class="min-w-125px">Alamat</th>
                                                <th class="min-w-125px">Surel</th>
                                                <th class="min-w-125px">Bergabung</th>
                                                <th class="min-w-125px">File</th>
                                                <th class="text-end min-w-100px">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold">
                                            @foreach ($anggotas as $a)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <a href="#"
                                                                class="text-gray-800 text-hover-primary mb-1">{{ $a->nama }}</a>
                                                            <span>{{ $a->nomor_anggota }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $a->alamat }}</td>
                                                    <td class="d-flex align-items-center">
                                                        <div class="d-flex flex-column">
                                                            <a href="#"
                                                                class="text-gray-800 text-hover-primary mb-1">{{ $a->email }}</a>
                                                            <span>{{ $a->telepon }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($a->created_at)->diffForHumans() }}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach ($a->files as $file)
                                                                <li>{{ $file->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="#"
                                                            class="btn btn-light btn-active-light-primary btn-sm"
                                                            data-kt-menu-trigger="click"
                                                            data-kt-menu-placement="bottom-end">Actions
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
                                                                <a href="{{ route('master.anggota.edit', $a->id) }}"
                                                                    class="menu-link px-3">Edit</a>
                                                            </div>
                                                            <div class="menu-item px-3">
                                                                <!-- Form delete disembunyikan -->
                                                                <form id="delete-form-{{ $a->id }}"
                                                                    action="{{ route('master.anggota.destroy', $a->id) }}"
                                                                    method="POST" style="display:none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                                <a href="#" class="menu-link px-3 delete-user"
                                                                    data-id="{{ $a->id }}">Delete</a>
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

            const deleteLinks = document.querySelectorAll('.delete-user');
            deleteLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.getAttribute('data-id');

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
                });
            });
        });
    </script>
@endsection
