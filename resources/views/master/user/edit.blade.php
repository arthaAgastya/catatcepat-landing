@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Edit Pengelola</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Master</li>
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('master.pengelola.index') }}"
                            class="text-gray-600 text-hover-primary">Pengelola</a>
                    </li>
                    <li class="breadcrumb-item text-gray-500">Edit</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2>Edit Data Pengelola</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('master.pengelola.index') }}" class="btn btn-sm btn-warning">Batal</a>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <form action="{{ route('master.pengelola.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- === Card 1: Data Diri === --}}
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Data Diri</h5>
                                <div class="row">
                                    {{-- Nama --}}
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label required">Nama</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ old('name', $user->name) }}">
                                        </div>
                                    </div>

                                    {{-- Username --}}
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label required">Username</label>
                                            <input type="text" id="username" name="username" class="form-control"
                                                value="{{ old('username', $user->username) }}">
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label required">Email</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password Baru (Kosongkan jika tidak
                                                diganti)</label>
                                            <input type="password" id="password" name="password" class="form-control">
                                        </div>
                                    </div>

                                    {{-- NIK --}}
                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="nik" class="form-label required">NIK</label>
                                            <input type="text" id="nik" name="nik" class="form-control"
                                                value="{{ old('nik', $user->detailPengelola->nik ?? '') }}">
                                        </div>
                                    </div>

                                    {{-- Tempat & Tanggal Lahir --}}
                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label for="tempat_lahir" class="form-label required">Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" class="form-control"
                                                value="{{ old('tempat_lahir', $user->detailPengelola->tempat_lahir ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" class="form-control"
                                                value="{{ old('tanggal_lahir', $user->detailPengelola->tanggal_lahir ?? '') }}">
                                        </div>
                                    </div>

                                    {{-- Jenis Kelamin --}}
                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-control">
                                                <option value="L"
                                                    {{ old('jenis_kelamin', $user->detailPengelola->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="P"
                                                    {{ old('jenis_kelamin', $user->detailPengelola->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Alamat --}}
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label required">Alamat</label>
                                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $user->detailPengelola->alamat ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Provinsi, Kabupaten, Kecamatan --}}
                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label for="provinsi" class="form-label required">Provinsi</label>
                                            <input type="text" name="provinsi" class="form-control"
                                                value="{{ old('provinsi', $user->detailPengelola->provinsi ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label for="kabupaten_kotamadya" class="form-label required">Kabupaten</label>
                                            <input type="text" name="kabupaten_kotamadya" class="form-control"
                                                value="{{ old('kabupaten_kotamadya', $user->detailPengelola->kabupaten_kotamadya ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-4">
                                        <div class="mb-3">
                                            <label for="kecamatan" class="form-label required">Kecamatan</label>
                                            <input type="text" name="kecamatan" class="form-control"
                                                value="{{ old('kecamatan', $user->detailPengelola->kecamatan ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- === Card 2: Keterangan Diri === --}}
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Keterangan Diri</h5>
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="tanggal_diangkat" class="form-label required">Tanggal Diangkat</label>
                                        <input type="date" name="tanggal_diangkat" class="form-control"
                                            value="{{ old('tanggal_diangkat', $user->detailPengelola->tanggal_diangkat ?? '') }}">
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label for="nomor_induk_kepegawaian" class="form-label required">Nomor Induk
                                            Kepegawaian</label>
                                        <input type="text" name="nomor_induk_kepegawaian" class="form-control"
                                            value="{{ old('nomor_induk_kepegawaian', $user->detailPengelola->nomor_induk_kepegawaian ?? '') }}">
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label for="telepon" class="form-label required">Telepon</label>
                                        <input type="text" name="telepon" class="form-control"
                                            value="{{ old('telepon', $user->detailPengelola->telepon ?? '') }}">
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label for="status_keluarga" class="form-label">Status Keluarga</label>
                                        <input type="text" name="status_keluarga" class="form-control"
                                            value="{{ old('status_keluarga', $user->detailPengelola->status_keluarga ?? '') }}">
                                    </div>

                                    <div class="col-lg-4 mb-3">
                                        <label for="jumlah_tanggungan" class="form-label">Jumlah Tanggungan</label>
                                        <input type="number" name="jumlah_tanggungan" class="form-control"
                                            value="{{ old('jumlah_tanggungan', $user->detailPengelola->jumlah_tanggungan ?? '') }}">
                                    </div>

                                    <div class="col-lg-4 mb-3">
                                        <label for="nama_ahli_waris" class="form-label">Nama Ahli Waris</label>
                                        <input type="text" name="nama_ahli_waris" class="form-control"
                                            value="{{ old('nama_ahli_waris', $user->detailPengelola->nama_ahli_waris ?? '') }}">
                                    </div>

                                    <div class="col-lg-4 mb-3">
                                        <label for="hubungan_ahli_waris" class="form-label">Hubungan Ahli Waris</label>
                                        <input type="text" name="hubungan_ahli_waris" class="form-control"
                                            value="{{ old('hubungan_ahli_waris', $user->detailPengelola->hubungan_ahli_waris ?? '') }}">
                                    </div>

                                    {{-- Role/Jabatan --}}
                                    <div class="col-12 mb-3">
                                        <label for="roles" class="form-label required">Jabatan</label>
                                        <select name="roles" class="form-control">
                                            <option disabled selected>Pilih Jabatan</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}"
                                                    {{ in_array($role, $userRole) ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- === Card 3: Dokumen === --}}
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Dokumen</h5>
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <label for="foto" class="form-label">Foto (Opsional)</label>
                                        <input type="file" name="foto" class="form-control">
                                        @if ($user->detailPengelola && $user->detailPengelola->foto)
                                            <small class="text-muted">Saat ini:
                                                {{ basename($user->detailPengelola->foto) }}</small>
                                        @endif
                                    </div>

                                    <div class="col-lg-4 mb-3">
                                        <label for="KTP" class="form-label">KTP (Opsional)</label>
                                        <input type="file" name="KTP" class="form-control">
                                        @if ($user->detailPengelola && $user->detailPengelola->ktp)
                                            <small class="text-muted">Saat ini:
                                                {{ basename($user->detailPengelola->ktp) }}</small>
                                        @endif
                                    </div>

                                    <div class="col-lg-4 mb-3">
                                        <label for="tanda_tangan" class="form-label">Tanda Tangan (Opsional)</label>
                                        <input type="file" name="tanda_tangan" class="form-control">
                                        @if ($user->detailPengelola && $user->detailPengelola->tanda_tangan)
                                            <small class="text-muted">Saat ini:
                                                {{ basename($user->detailPengelola->tanda_tangan) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- === Submit Button === --}}
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
