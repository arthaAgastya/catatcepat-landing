@extends('layouts.main')

@section('content')
    <style>
        .remove-akun:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Entri Jurnal</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Transaksi</li>
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('transaksi.transaksi-lain.index') }}"
                            class="text-gray-600 text-hover-primary">Entri Jurnal</a>
                    </li>
                    <li class="breadcrumb-item text-gray-500">Tambah</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <form action="{{ route('transaksi.transaksiNonBarang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                {{-- ================= DETAIL BARANG ================= --}}
                <div class="card mt-5">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <h4>Keterangan Transaksi</h4>
                        </div>
                        <div class="card-toolbar">
                            <button type="button" id="add-akun" class="btn btn-sm btn-primary">Tambah Akun</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Tanggal --}}
                            <div class="col-12 mb-3">
                                <label class="form-label required">Tanggal Transaksi</label>
                                <input type="date" name="tanggal_transaksi" class="form-control"
                                    value="{{ old('tanggal_transaksi', date('Y-m-d')) }}">
                            </div>

                            <div id="akun-container">
                                <p>NB: Tambahkan akun debit dan kredit sesuai kebutuhan. Total nominal debit harus sama
                                    dengan total nominal kredit.</p>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <strong>Total Debit: <span id="total-debit">Rp 0</span></strong>
                                    </div>
                                    <div class="col-6">
                                        <strong>Total Kredit: <span id="total-kredit">Rp 0</span></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-8 mb-3">
                                <label class="form-label">Lampiran</label>
                                <input type="file" name="lampiran" id="lampiran" class="form-control"
                                    accept="image/*,application/pdf">
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                            <a href="{{ route('transaksi.transaksi-lain.index') }}"
                                class="btn btn-danger btn-sm m-2">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= SCRIPT ================= --}}
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.akun-select').select2({
                placeholder: "Cari akun...",
                width: '100%'
            });

            function updateAkunDeleteButtons() {
                const akunRows = $('#akun-container .akun-row');
                const jumlah = akunRows.length;
                akunRows.find('.remove-akun').prop('disabled', jumlah <= 1);
            }

            // Tambah akun baru
            $('#add-akun').click(function() {
                const akunBaru = `
        <div class="row akun-row mb-3">
            <div class="col-6">
                <label class="form-label required">Akun</label>
                <select name="id_account[]" class="form-select akun-select">
                    <option value="">-- Pilih Akun --</option>
                    <optgroup label="Saldo Normal: Debit">
                        @foreach ($akun->where('saldo_normal', 'debit') as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->no_account }} - {{ $acc->nama_account }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Saldo Normal: Kredit">
                        @foreach ($akun->where('saldo_normal', 'kredit') as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->no_account }} - {{ $acc->nama_account }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            <div class="col-2">
                <label class="form-label required">Tipe Account</label>
                <select name="tipe_account[]" class="form-select">
                    <option value="debit">Debit</option>
                    <option value="kredit">Kredit</option>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label required">Nominal</label>
                <input type="text" name="nominal[]" class="form-control nominal-input" min="0" step="any">
            </div>
            <div class="col-1 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-danger remove-akun">X</button>
            </div>
        </div>`;
                const newElement = $(akunBaru);
                $('#akun-container').append(newElement);
                newElement.find('.akun-select').select2({
                    placeholder: "Cari akun...",
                    width: '100%'
                });
                updateAkunDeleteButtons();
            });

            // Hapus akun
            $(document).on('click', '.remove-akun', function() {
                $(this).closest('.akun-row').remove();
                updateAkunDeleteButtons();
            });





            function formatRupiahInput(value) {
                let angka = value.replace(/[^,\d]/g, '');
                if (!angka) return '';
                return 'Rp ' + angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function updateTotals() {
                let totalDebit = 0;
                let totalKredit = 0;

                $('#akun-container .akun-row').each(function() {
                    const nominal = parseInt($(this).find('input[name="nominal[]"]').val().replace(
                        /[^0-9]/g, '')) || 0;
                    const tipe = $(this).find('select[name="tipe_account[]"]').val();
                    if (tipe === 'debit') {
                        totalDebit += nominal;
                    } else if (tipe === 'kredit') {
                        totalKredit += nominal;
                    }
                });

                $('#total-debit').text(formatRupiahInput(totalDebit.toString()));
                $('#total-kredit').text(formatRupiahInput(totalKredit.toString()));
            }

            // ===== Format Rupiah untuk nominal akun =====
            $(document).on('input', '.nominal-input', function() {
                let value = $(this).val().replace(/[^,\d]/g, '');
                if (value) {
                    $(this).val(formatRupiahInput(value));
                } else {
                    $(this).val('');
                }
                updateTotals();
            });

            // Update totals when tipe_account changes
            $(document).on('change', 'select[name="tipe_account[]"]', function() {
                updateTotals();
            });

            // Saat submit form — validasi total nominal debit dan kredit harus sama, dan ubah semua nilai rupiah menjadi angka
            $('form').on('submit', function(e) {
                let sumDebit = 0,
                    sumKredit = 0,
                    debitCount = 0,
                    kreditCount = 0;

                $('#akun-container .akun-row').each(function() {
                    const nominal = parseInt($(this).find('input[name="nominal[]"]').val().replace(
                        /[^0-9]/g, '')) || 0;
                    const tipe = $(this).find('select[name="tipe_account[]"]').val();
                    if (tipe === 'debit') {
                        sumDebit += nominal;
                        debitCount++;
                    } else if (tipe === 'kredit') {
                        sumKredit += nominal;
                        kreditCount++;
                    }
                });

                if (debitCount < 1 || kreditCount < 1) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Akun Tidak Lengkap',
                        text: 'Minimal harus ada 1 akun debit dan 1 akun kredit.'
                    });
                    return false;
                }

                if (sumDebit !== sumKredit) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Total Debit dan Kredit Tidak Seimbang',
                        text: 'Total nominal debit (' + formatRupiahInput(sumDebit.toString()) +
                            ') harus sama dengan total nominal kredit (' + formatRupiahInput(
                                sumKredit.toString()) + ').'
                    });
                    return false;
                }

                // Ubah semua nilai rupiah menjadi angka
                $('.nominal-input').each(function() {
                    const num = $(this).val().replace(/[^0-9]/g, '');
                    $(this).val(num);
                });
            });

            // Jalankan saat awal - update totals dan updateAkunDeleteButtons
            updateTotals();
            updateAkunDeleteButtons();
        });
    </script>
@endsection
