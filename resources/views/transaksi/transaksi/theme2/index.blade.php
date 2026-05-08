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
                                                            <div>{{ $j->account->nama_account ?? '-' }}
                                                                ({{ $j->tipe }})</div>
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
                                                        <form
                                                            action="{{ route('transaksi.transaksi-lain.destroy', $item->id) }}"
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
            </div>
        </div>
    </div>
@endsection
