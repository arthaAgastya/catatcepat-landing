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
                                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                        <a href="{{ route('master.pengelola.index') }}"
                                            class="btn btn-sm btn-warning">Batal</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form action="{{ route('master.pengelola.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">Data Diri</h5>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label required">Nama</label>
                                                        <input type="text" id="name"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name" value="{{ old('name') }}">
                                                        @error('name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="username" class="form-label required">Username</label>
                                                        <input type="text" id="username"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            name="username" value="{{ old('username') }}">
                                                        @error('username')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="nik" class="form-label required">NIK</label>
                                                        <input type="text" id="nik"
                                                            class="form-control @error('nik') is-invalid @enderror"
                                                            name="nik" value="{{ old('nik') }}">
                                                        @error('nik')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label required">Email</label>
                                                        <input type="email" id="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" value="{{ old('email') }}">
                                                        @error('email')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label required">Password</label>
                                                        <input type="password" id="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password">
                                                        @error('password')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="tempat_lahir" class="form-label required">Tempat
                                                            Lahir</label>
                                                        <input type="text" id="tempat_lahir"
                                                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                            name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                                                        @error('tempat_lahir')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="tanggal_lahir" class="form-label required">Tanggal
                                                            Lahir</label>
                                                        <input type="date" id="tanggal_lahir"
                                                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                            name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                                        @error('tanggal_lahir')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="jenis_kelamin" class="form-label required">Jenis
                                                            Kelamin</label>
                                                        <select name="jenis_kelamin" id="jenis_kelamin"
                                                            class="form-control">
                                                            <option value="" selected disabled>Pilih Jenis Kelamin
                                                            </option>
                                                            <option value="L"
                                                                {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                                                Laki-laki</option>
                                                            <option value="P"
                                                                {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                                                Perempuan</option>
                                                        </select>
                                                        @error('jenis_kelamin')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="provinsi" class="form-label required">Provinsi</label>
                                                        <input type="text" id="provinsi"
                                                            class="form-control @error('provinsi') is-invalid @enderror"
                                                            name="provinsi" value="{{ old('provinsi') }}">
                                                        @error('provinsi')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="kabupaten_kotamadya"
                                                            class="form-label required">Kabupaten</label>
                                                        <input type="text" id="kabupaten_kotamadya"
                                                            class="form-control @error('kabupaten_kotamadya') is-invalid @enderror"
                                                            name="kabupaten_kotamadya"
                                                            value="{{ old('kabupaten_kotamadya') }}">
                                                        @error('kabupaten_kotamadya')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="kecamatan"
                                                            class="form-label required">Kecamatan</label>
                                                        <input type="text" id="kecamatan"
                                                            class="form-control @error('kecamatan') is-invalid @enderror"
                                                            name="kecamatan" value="{{ old('kecamatan') }}">
                                                        @error('kecamatan')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="alamat" class="form-label required">Alamat</label>
                                                        <textarea name="alamat" id="alamat" class="form-control" cols="30" rows="3">{{ old('alamat') }}</textarea>
                                                        @error('alamat')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">Keterangan Diri</h5>
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="tanggal_diangkat" class="form-label required">Tanggal
                                                            Diangkat</label>
                                                        <input type="date" id="tanggal_diangkat"
                                                            class="form-control @error('tanggal_diangkat') is-invalid @enderror"
                                                            name="tanggal_diangkat"
                                                            value="{{ old('tanggal_diangkat') }}">
                                                        @error('tanggal_diangkat')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="nomor_induk_kepegawaian"
                                                            class="form-label required">Nomor Induk
                                                            Kepegawaian</label>
                                                        <input type="text" id="nomor_induk_kepegawaian"
                                                            class="form-control @error('nomor_induk_kepegawaian') is-invalid @enderror"
                                                            name="nomor_induk_kepegawaian"
                                                            value="{{ old('nomor_induk_kepegawaian') }}">
                                                        @error('nomor_induk_kepegawaian')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="telepon" class="form-label required">Telepon</label>
                                                        <input type="text" id="telepon"
                                                            class="form-control @error('telepon') is-invalid @enderror"
                                                            name="telepon" value="{{ old('telepon') }}">
                                                        @error('telepon')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="status_keluarga" class="form-label required">Status
                                                            Keluarga</label>
                                                        <input type="text" id="status_keluarga"
                                                            class="form-control @error('status_keluarga') is-invalid @enderror"
                                                            name="status_keluarga" value="{{ old('status_keluarga') }}">
                                                        @error('status_keluarga')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="jumlah_tanggungan" class="form-label required">Jumlah
                                                            Tanggungan</label>
                                                        <input type="number" id="jumlah_tanggungan"
                                                            class="form-control @error('jumlah_tanggungan') is-invalid @enderror"
                                                            name="jumlah_tanggungan">
                                                        @error('jumlah_tanggungan')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="nama_ahli_waris" class="form-label required">Nama Ahli
                                                            Waris</label>
                                                        <input type="text" id="nama_ahli_waris"
                                                            class="form-control @error('nama_ahli_waris') is-invalid @enderror"
                                                            name="nama_ahli_waris" value="{{ old('nama_ahli_waris') }}">
                                                        @error('nama_ahli_waris')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="hubungan_ahli_waris"
                                                            class="form-label required">Hubungan Ahli
                                                            Waris</label>
                                                        <input type="text" id="hubungan_ahli_waris"
                                                            class="form-control @error('hubungan_ahli_waris') is-invalid @enderror"
                                                            name="hubungan_ahli_waris"
                                                            value="{{ old('hubungan_ahli_waris') }}">
                                                        @error('hubungan_ahli_waris')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="roles" class="form-label required">Jabatan</label>
                                                        <select name="roles" id="roles" class="form-control">
                                                            <option value="" selected disabled>Pilih Jabatan</option>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role }}"
                                                                    {{ old('roles') == $role ? 'selected' : '' }}>
                                                                    {{ $role }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('roles')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-6">
                                        <div class="card-body">
                                            <h5 class="card-title mb-4">Dokumen</h5>
                                            <div class="row">
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="foto" class="form-label required">Foto</label>
                                                        <input type="file" id="foto"
                                                            class="form-control @error('foto') is-invalid @enderror"
                                                            name="foto" value="{{ old('foto') }}">
                                                        @error('foto')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="KTP" class="form-label required">KTP</label>
                                                        <input type="file" id="KTP"
                                                            class="form-control @error('KTP') is-invalid @enderror"
                                                            name="KTP" value="{{ old('KTP') }}">
                                                        @error('KTP')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="tanda_tangan" class="form-label required">Tanda
                                                            Tangan</label>
                                                        <input type="file" id="tanda_tangan"
                                                            class="form-control @error('tanda_tangan') is-invalid @enderror"
                                                            name="tanda_tangan" value="{{ old('tanda_tangan') }}">
                                                        @error('tanda_tangan')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
