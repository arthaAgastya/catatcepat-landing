@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Transaksi Lain</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Transaksi</li>
                    <li class="breadcrumb-item text-gray-500">Transaksi Lain</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        {{-- Search/filter bisa ditambahkan di sini --}}
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('transaksi.transaksi-lain.create') }}" class="btn btn-sm btn-primary">
                            Tambah Transaksi Barang
                        </a>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table" id="tableData">
                            <thead>
                                <tr class="text-muted fw-bolder text-uppercase">
                                    <th class="text-center">#</th>
                                    <th>Tanggal</th>
                                    <th>Anggota</th>
                                    <th>Akun</th>
                                    <th>Total</th>
                                    <th>Deskripsi</th>
                                    <th>User</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @foreach ($transaksi as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ $item->anggota->nama ?? '-' }}</td>

                                        {{-- Tampilkan akun-akun jurnal --}}
                                        <td>
                                            @foreach ($item->jurnal as $j)
                                                <div>{{ $j->account->nama_account ?? '-' }} ({{ $j->tipe }})</div>
                                            @endforeach
                                        </td>

                                        {{-- Hitung total dari detail_transaksi --}}
                                        <td>
                                            Rp
                                            {{ number_format($item->jurnal->sum('jumlah'), 0, ',', '.') }}
                                        </td>

                                        <td>{{ $item->keterangan ?? '-' }}</td>
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('transaksi.transaksi-lain.edit', $item->id) }}"
                                                class="btn btn-icon btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('transaksi.transaksi-lain.destroy', $item->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-sm btn-danger"
                                                    onclick="return confirm('Yakin hapus transaksi ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            new DataTable('#tableData');
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
