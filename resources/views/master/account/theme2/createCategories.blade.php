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
                                    <h2>Form Akun</h2>
                                </div>
                                <div class="card-toolbar">
                                    <a href="{{ route('master.akun.index') }}" class="btn btn-warning btn-sm">Batal</a>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form id="formAkun" action="{{ route('master.akun.kategori.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label for="kategori" class="form-label required">Kategori</label>

                                                <input list="kategoriList" name="kategori" id="kategori"
                                                    class="form-control @error('kategori') is-invalid @enderror"
                                                    value="{{ old('kategori') }}" autocomplete="off"
                                                    placeholder="Masukkan kategori akun (misal: Aset, Ekuitas, Beban, dll.)">

                                                <datalist id="kategoriList">
                                                    @foreach ($categories as $c)
                                                        <option value="{{ $c->category }}"></option>
                                                    @endforeach
                                                </datalist>

                                                @error('kategori')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                <label for="sub_kategori" class="form-label required">Sub Kategori</label>
                                                <input type="text" name="sub_kategori" id="sub_kategori"
                                                    autocomplete="off"
                                                    class="form-control @error('sub_kategori') is-invalid @enderror"
                                                    value="{{ old('sub_kategori') }}"
                                                    placeholder="Masukkan sub kategori akun (contoh: Kas, Piutang, dll.)">

                                                @error('sub_kategori')
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
