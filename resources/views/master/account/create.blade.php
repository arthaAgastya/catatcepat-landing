@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Tambah Akun</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Master</li>
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('master.akun.index') }}" class="text-gray-600 text-hover-primary">Akun</a>
                    </li>
                    <li class="breadcrumb-item text-gray-500">Tambah</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <h2>Form Akun</h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('master.akun.index') }}" class="btn btn-warning btn-sm">Batal</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form id="formAkun" action="{{ route('master.akun.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="id_category" class="form-label required">Kategori</label>
                                    <select name="id_category" id="id_category"
                                        class="form-select @error('id_category') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                        @foreach ($categories as $category => $subCategories)
                                            <optgroup label="{{ $category }}">
                                                <!-- Menampilkan kategori sebagai label -->
                                                @foreach ($subCategories as $subCategory)
                                                    <option value="{{ $subCategory->id }}"
                                                        {{ old('id_category') == $subCategory->id ? 'selected' : '' }}>
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
                                        class="form-select @error('kelompok') is-invalid @enderror">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="Aktiva">Aktiva</option>
                                        <option value="Kewajiban">Kewajiban</option>
                                        <option value="Ekuitas">Ekuitas</option>
                                        <option value="Pendapatan">Pendapatan</option>
                                        <option value="HPP">HPP</option>
                                        <option value="Beban Usaha">Beban Usaha</option>
                                        <option value="Beban Umum & Administrasi">Beban Umum & Administrasi</option>
                                        <option value="Pendapatan/Beban Lain">Pendapatan/Beban Lain</option>
                                        <option value="Distribusi SHU / Zakat">Distribusi SHU / Zakat</option>
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
                                        value="{{ old('no_account') }}" readonly>
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
                                        value="{{ old('nama_account') }}">
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
                                        <option value="debit" {{ old('saldo_normal') == 'debit' ? 'selected' : '' }}>Debit
                                        </option>
                                        <option value="kredit" {{ old('saldo_normal') == 'kredit' ? 'selected' : '' }}>
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
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="1" {{ old('level') == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ old('level') == '2' ? 'selected' : '' }}>2</option>
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
                                        value="{{ old('saldo_awal') }}">
                                    @error('saldo_awal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
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
            if (!angka) return '';
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
            saldoInput.value = saldoInput.value.replace(/\./g, '');
        });
    </script>
    <script>
        const kelompokSelect = document.getElementById('kelompok');
        const noAccountInput = document.getElementById('no_account');

        // Awalan kode berdasarkan kelompok
        const kodeAwalKelompok = {
            "Aktiva": "1",
            "Kewajiban": "2",
            "Ekuitas": "3",
            "Pendapatan": "4",
            "HPP": "5",
            "Beban Usaha": "6",
            "Beban Umum & Administrasi": "7",
            "Pendapatan/Beban Lain": "8",
            "Distribusi SHU / Zakat": "9"
        };

        kelompokSelect.addEventListener('change', function() {
            const selected = this.value;
            const prefix = kodeAwalKelompok[selected];

            // Contoh: membuat kode akun otomatis dengan format "1XX"
            if (prefix) {
                fetch(`/master/generate-no-account/${prefix}`)
                    .then(response => response.json())
                    .then(data => {
                        noAccountInput.value = data.no_account;
                    })
                    .catch(error => {
                        console.error('Gagal ambil nomor akun otomatis:', error);
                        noAccountInput.value = prefix + '00';
                    });
            }
        });
    </script>
@endsection
