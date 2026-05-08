@extends('layouts.main2')
@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <form action="{{ route('transaksi.transaksi-lain.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ================= FORM UTAMA ================= --}}
                    <div class="card">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <h4>Detail Transaksi</h4>
                            </div>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-info m-3" id="addForm">Tambah Field</button>
                                <a href="{{ route('transaksi.transaksi-lain.index') }}"
                                    class="btn btn-warning btn-sm">Batal</a>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Oops!</strong> Ada kesalahan input:<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                {{-- Upload Nota / Invoice --}}
                                <div class="col-12 col-lg-8 mb-3">
                                    <label class="form-label">Invoice / Nota</label>
                                    <input type="file" name="nota" id="nota_ocr" class="form-control"
                                        accept="image/*">
                                    <button type="button" id="proses_ocr_invoice" class="btn btn-sm btn-primary mt-2">🔍
                                        Proses
                                        OCR</button>
                                    <div class="mt-2" id="ocr_invoice_status">Status: Menunggu...</div>
                                </div>

                                {{-- Preview hasil OCR --}}
                                <div class="col-12 col-lg-4 mb-3">
                                    <label class="form-label">Preview (B/W)</label>
                                    <img id="preview_invoice_bw" style="display:none; max-width: 100%;">
                                    <canvas id="canvas_invoice_ocr" style="display:none;"></canvas>
                                </div>
                            </div>
                            <div id="form-container">
                                {{-- Row Header Label - PISAHKAN dari form-row --}}
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Nama Barang</label>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Jumlah</label>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">Harga Satuan</label>
                                    </div>
                                    <div class="col-1 d-flex align-items-end">
                                    </div>
                                </div>
                                {{-- Row Input Data - INI yang form-row --}}
                                <div class="row mb-3 form-row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="items[]" placeholder="Nama Barang">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="qty[]" placeholder="Jumlah"
                                            min="0" step="any">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control price-input" name="price[]"
                                            placeholder="Harga Satuan">
                                    </div>
                                    <div class="col-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-sm btn-danger remove-row">X</button>
                                    </div>
                                </div>
                            </div>

                            {{-- Diskon & Total --}}
                            <div class="row mb-3 mt-4">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Pajak / Tax</label>
                                    <input type="text" id="tax_input" name="tax" class="form-control" value="0"
                                        placeholder="Masukkan pajak (Rp)">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Diskon / Potongan</label>
                                    <input type="text" id="diskon_input" name="diskon" class="form-control"
                                        value="0" placeholder="Masukkan diskon (Rp)">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Total Harga</label>
                                    <input type="text" id="total_harga_display" class="form-control bg-light" readonly>
                                    <input type="hidden" name="total_transaksi" id="total_transaksi">
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    <p>NB: Tambahkan akun debit dan kredit sesuai kebutuhan. Total nominal tiap tipe harus
                                        sama
                                        dengan total harga.</p>
                                </div>

                                {{-- Deskripsi --}}
                                <div class="col-12 mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                                </div>
                            </div>

                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

            // Tambah field barang - PERBAIKAN: langsung trigger hitungTotalHarga setelah append
            $('#addForm').click(function() {
                $('#form-container').append(`
            <div class="row mb-3 form-row">
                <div class="col-6"><input type="text" class="form-control" name="items[]" placeholder="Nama Barang"></div>
                <div class="col-2"><input type="text" class="form-control" name="qty[]" min="0" step="any" placeholder="Jumlah"></div>
                <div class="col-3"><input type="text" class="form-control price-input" name="price[]" placeholder="Harga Satuan"></div>
                <div class="col-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-danger remove-row">X</button></div>
            </div>
        `);
                // Tidak perlu trigger di sini karena belum ada nilai
            });

            // Hapus baris barang
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.form-row').remove();
                hitungTotalHarga();
            });

            // ==== OCR Process ====
            $('#proses_ocr_invoice').click(async function() {
                const file = $('#nota_ocr')[0].files[0];
                if (!file) return alert('Pilih file nota terlebih dahulu!');

                const status = $('#ocr_invoice_status');
                const canvas = document.getElementById('canvas_invoice_ocr');
                const ctx = canvas.getContext('2d');
                const img = new Image();
                const reader = new FileReader();

                reader.onload = (e) => {
                    img.src = e.target.result;
                };

                img.onload = async () => {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);

                    const imageData = ctx.getImageData(0, 0, img.width, img.height);
                    const data = imageData.data;
                    for (let i = 0; i < data.length; i += 4) {
                        let gray = 0.3 * data[i] + 0.59 * data[i + 1] + 0.11 * data[i + 2];
                        data[i] = data[i + 1] = data[i + 2] = gray;
                    }
                    ctx.putImageData(imageData, 0, 0);
                    $('#preview_invoice_bw').attr('src', canvas.toDataURL()).show();

                    status.text('🔍 Memproses OCR...');
                    const {
                        data: {
                            text
                        }
                    } = await Tesseract.recognize(canvas, 'ind+eng', {
                        logger: m => status.text(`⏳ ${Math.round(m.progress * 100)}%`)
                    });

                    status.text('🤖 Mengirim hasil ke AI...');
                    const res = await fetch("{{ route('ocr.invoice.parse') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ocr_text: text
                        })
                    });

                    const json = await res.json();
                    if (json.success && json.json_data?.items) {
                        const form = $('#form-container').empty();
                        json.json_data.items.forEach(item => {
                            let price = parseFloat(item.price || 0);
                            let qty = parseFloat(item.quantity || 1);
                            form.append(`
                        <div class="row mb-3 form-row">
                            <div class="col-6"><input type="text" class="form-control" name="items[]" value="${item.name || ''}"></div>
                            <div class="col-2"><input type="text" class="form-control" name="qty[]" value="${qty}" min="0" step="any"></div>
                            <div class="col-3"><input type="text" class="form-control price-input" name="price[]" value="Rp ${price.toLocaleString('id-ID')}"></div>
                            <div class="col-1 d-flex align-items-end"><button type="button" class="btn btn-sm btn-danger remove-row">X</button></div>
                        </div>
                    `);
                        });

                        const diskon = json.json_data.discount || 0;
                        const pajak = json.json_data.tax || 0;
                        $('#diskon_input').val(formatRupiahInput(diskon.toString()));
                        $('#tax_input').val(formatRupiahInput(pajak.toString()));

                        hitungTotalHarga();
                        status.text('✅ OCR & AI selesai.');
                    } else {
                        const errorDetail = json.error || json.message ||
                            'Data tidak lengkap atau format tidak sesuai';
                        console.warn('AI Parsing Error:', errorDetail);
                        status.text(`⚠️ Gagal parsing dari AI: ${errorDetail}`);
                    }
                };
                reader.readAsDataURL(file);
            });

            // PERBAIKAN: Gunakan event delegation untuk input yang dinamis
            // Format Rupiah otomatis untuk harga, diskon, pajak
            $(document).on('input', '.price-input, #diskon_input, #tax_input', function() {
                this.value = formatRupiahInput(this.value);
                hitungTotalHarga();
            });

            // Handle input qty dengan event delegation
            $(document).on('input', 'input[name="qty[]"]', function() {
                this.value = this.value.replace(',', '.');
                hitungTotalHarga();
            });

            function formatRupiahInput(value) {
                let angka = value.replace(/[^,\d]/g, '');
                if (!angka) return '';
                return 'Rp ' + angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function hitungTotalHarga() {
                let total = 0;

                // Hanya proses row yang memiliki input qty dan price (bukan row label)
                $('#form-container .form-row').each(function() {
                    const qtyInput = $(this).find('input[name="qty[]"]');
                    const priceInput = $(this).find('input[name="price[]"]');

                    // Skip jika tidak ada input (row label)
                    if (qtyInput.length === 0 || priceInput.length === 0) {
                        return; // continue to next iteration
                    }

                    const qtyVal = qtyInput.val();
                    const priceVal = priceInput.val();

                    const qty = parseFloat(qtyVal) || 0;
                    const price = parseInt(priceVal.replace(/[^0-9]/g, '')) || 0;

                    total += qty * price;
                });

                const diskon = parseInt($('#diskon_input').val().replace(/[^0-9]/g, '')) || 0;
                const tax = parseInt($('#tax_input').val().replace(/[^0-9]/g, '')) || 0;

                const finalTotal = Math.max(total - diskon + tax, 0);

                $('#total_harga_display').val(formatRupiahInput(finalTotal.toString()));
                $('#total_transaksi').val(finalTotal);
            }

            // ===== Format Rupiah untuk nominal akun + Validasi total =====
            $(document).on('input', '.nominal-input', function() {
                let oldValue = $(this).data('old') || '';
                let value = $(this).val().replace(/[^,\d]/g, '');

                if (value) {
                    $(this).val(formatRupiahInput(value));
                } else {
                    $(this).val('');
                }

                if (!validateTotalNominal($(this))) {
                    $(this).val(oldValue);
                } else {
                    $(this).data('old', $(this).val());
                }
            });

            // Revalidate when tipe_account changes
            $(document).on('change', 'select[name="tipe_account[]"]', function() {
                const row = $(this).closest('.akun-row');
                const nominalInput = row.find('.nominal-input');
                if (nominalInput.val()) {
                    validateTotalNominal(nominalInput);
                }
            });

            function validateTotalNominal(currentInput) {
                const totalHarga = parseInt($('#total_harga_display').val().replace(/[^0-9]/g, '')) || 0;
                const tipeSekarang = currentInput.closest('.akun-row').find('select[name="tipe_account[]"]').val();
                const nominalSekarang = parseInt(currentInput.val().replace(/[^0-9]/g, '')) || 0;

                let sumOtherDebit = 0,
                    sumOtherKredit = 0;

                $('#akun-container .akun-row').each(function() {
                    if ($(this).find('input[name="nominal[]"]').is(currentInput)) return;
                    const nominal = parseInt($(this).find('input[name="nominal[]"]').val().replace(
                        /[^0-9]/g, '')) || 0;
                    const tipe = $(this).find('select[name="tipe_account[]"]').val();
                    if (tipe === 'debit') sumOtherDebit += nominal;
                    else if (tipe === 'kredit') sumOtherKredit += nominal;
                });

                if (tipeSekarang === 'debit') {
                    const remaining = totalHarga - sumOtherDebit;
                    if (nominalSekarang > remaining) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Nominal Debit Melebihi Sisa',
                            text: 'Nominal debit tidak boleh melebihi sisa (' + formatRupiahInput(remaining
                                .toString()) + ').'
                        });
                        return false;
                    }
                } else if (tipeSekarang === 'kredit') {
                    const remaining = totalHarga - sumOtherKredit;
                    if (nominalSekarang > remaining) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Nominal Kredit Melebihi Sisa',
                            text: 'Nominal kredit tidak boleh melebihi sisa (' + formatRupiahInput(remaining
                                .toString()) + ').'
                        });
                        return false;
                    }
                }
                return true;
            }

            // Saat submit form — validasi total nominal dan ubah semua nilai rupiah menjadi angka
            $('form').on('submit', function(e) {
                const totalHarga = parseInt($('#total_harga_display').val().replace(/[^0-9]/g, '')) || 0;
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

                if (sumDebit !== totalHarga) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Total Debit Tidak Sesuai',
                        text: 'Total nominal debit harus sama dengan total harga.'
                    });
                    return false;
                }

                if (sumKredit !== totalHarga) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Total Kredit Tidak Sesuai',
                        text: 'Total nominal kredit harus sama dengan total harga.'
                    });
                    return false;
                }

                // Ubah semua nilai rupiah menjadi angka
                $('.price-input, #diskon_input, #tax_input, .nominal-input').each(function() {
                    const num = $(this).val().replace(/[^0-9]/g, '');
                    $(this).val(num);
                });
            });

            // Jalankan saat awal - hitung total untuk row yang sudah ada
            hitungTotalHarga();
            updateAkunDeleteButtons();
        });
    </script>
@endsection
