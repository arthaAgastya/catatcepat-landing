@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Edit Akun</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Master</li>
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('master.akun.index') }}" class="text-gray-600 text-hover-primary">Akun</a>
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
                        <h2>Form Edit Akun</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('master.akun.index') }}" class="btn btn-warning btn-sm">Batal</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form id="formAkun" action="{{ route('master.akun.update', $account->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="id_category" class="form-label required">Kategori</label>
                                    <select name="id_category" id="id_category"
                                        class="form-select @error('id_category') is-invalid @enderror">
                                        <option value="" disabled>-- Pilih Kategori --</option>
                                        @foreach ($categories as $category => $subCategories)
                                            <optgroup label="{{ $category }}">
                                                <!-- Menampilkan kategori sebagai label -->
                                                @foreach ($subCategories as $subCategory)
                                                    <option value="{{ $subCategory->id }}"
                                                        {{ old('id_category', $account->id_category) == $subCategory->id ? 'selected' : '' }}>
                                                        {{ $subCategory->sub_category }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('id_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="kelompok" class="form-label required">Kelompok Akun</label>
                                    <select name="kelompok" id="kelompok"
                                        class="form-select @error('kelompok') is-invalid @enderror" readonly>
                                        <option value="" disabled>-- Pilih Kelompok --</option>
                                        <option value="1"
                                            {{ old('kelompok', substr($account->no_account, 0, 1)) == '1' ? 'selected' : '' }}>
                                            1 - Aktiva</option>
                                        <option value="2"
                                            {{ old('kelompok', substr($account->no_account, 0, 1)) == '2' ? 'selected' : '' }}>
                                            2 - Kewajiban</option>
                                        <option value="3"
                                            {{ old('kelompok', substr($account->no_account, 0, 1)) == '3' ? 'selected' : '' }}>
                                            3 - Modal</option>
                                        <option value="4"
                                            {{ old('kelompok', substr($account->no_account, 0, 1)) == '4' ? 'selected' : '' }}>
                                            4 - Pendapatan</option>
                                        <option value="5"
                                            {{ old('kelompok', substr($account->no_account, 0, 1)) == '5' ? 'selected' : '' }}>
                                            5 - Beban</option>
                                        <option value="6"
                                            {{ old('kelompok', substr($account->no_account, 0, 1)) == '6' ? 'selected' : '' }}>
                                            6 - (opsional)</option>
                                        <option value="7"
                                            {{ old('kelompok', substr($account->no_account, 0, 1)) == '7' ? 'selected' : '' }}>
                                            7 - (opsional)</option>
                                        <option value="8"
                                            {{ old('kelompok', substr($account->no_account, 0, 1)) == '8' ? 'selected' : '' }}>
                                            8 - (opsional)</option>
                                        <option value="9"
                                            {{ old('kelompok', substr($account->no_account, 0, 1)) == '9' ? 'selected' : '' }}>
                                            9 - (opsional)</option>
                                    </select>
                                    @error('kelompok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="no_account" class="form-label required">No Akun</label>
                                    <input type="text" id="no_account"
                                        class="form-control @error('no_account') is-invalid @enderror" name="no_account"
                                        value="{{ old('no_account', $account->no_account) }}" readonly>
                                    @error('no_account')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="nama_account" class="form-label required">Nama Akun</label>
                                    <input type="text" id="nama_account"
                                        class="form-control @error('nama_account') is-invalid @enderror" name="nama_account"
                                        value="{{ old('nama_account', $account->nama_account) }}">
                                    @error('nama_account')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="saldo_normal" class="form-label required">Saldo Normal</label>
                                    <select name="saldo_normal" id="saldo_normal"
                                        class="form-select @error('saldo_normal') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="debit"
                                            {{ old('saldo_normal', $account->saldo_normal) == 'debit' ? 'selected' : '' }}>
                                            Debit</option>
                                        <option value="kredit"
                                            {{ old('saldo_normal', $account->saldo_normal) == 'kredit' ? 'selected' : '' }}>
                                            Kredit</option>
                                    </select>
                                    @error('saldo_normal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="level" class="form-label required">Level</label>
                                    <select name="level" id="level"
                                        class="form-select @error('level') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="1"
                                            {{ old('level', $account->level) == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2"
                                            {{ old('level', $account->level) == '2' ? 'selected' : '' }}>2</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="saldo_awal" class="form-label required">Saldo Awal</label>
                                    <input type="text" id="saldo_awal"
                                        class="form-control @error('saldo_awal') is-invalid @enderror" name="saldo_awal"
                                        value="{{ old('saldo_awal', $account->saldoAwalNeraca->saldo_awal ?? 0) }}">
                                    @error('saldo_awal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const saldoInput = document.getElementById('saldo_awal');
        const form = document.getElementById('formAkun');

        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString();
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah;
        }

        saldoInput.addEventListener('input', function(e) {
            let cursorPosition = this.selectionStart;
            let originalLength = this.value.length;

            this.value = formatRupiah(this.value);

            let newLength = this.value.length;
            cursorPosition = cursorPosition + (newLength - originalLength);
            this.setSelectionRange(cursorPosition, cursorPosition);
        });

        form.addEventListener('submit', function(e) {
            // Hilangkan semua titik dari input saldo_awal saat submit
            saldoInput.value = saldoInput.value.replace(/\./g, '');
        });
    </script>
@endsection
