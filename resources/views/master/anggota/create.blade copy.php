@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Tambah Anggota</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Master</li>
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('master.anggota.index') }}" class="text-gray-600 text-hover-primary">Anggota</a>
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
                        <h2>Form Anggota</h2>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center py-2 py-md-1">
                            <a href="{{ route('master.anggota.index') }}" class="btn btn-warning btn-sm">Batal</a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <form action="{{ route('master.anggota.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            {{-- Kode Anggota --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="nomor_anggota" class="form-label required">Kode Anggota</label>
                                    <input type="text" id="nomor_anggota" class="form-control" name="nomor_anggota"
                                        value="{{ old('nomor_anggota') }}">
                                </div>
                            </div>

                            {{-- Nama --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label required">Nama Lengkap</label>
                                    <input type="text" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror" name="nama"
                                        value="{{ old('nama') }}">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Upload Gambar OCR --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="gambar_ocr" class="form-label">Upload Gambar (untuk OCR)</label>
                                    <input type="file" id="gambar_ocr" accept="image/*" class="form-control">
                                    <button type="button" id="proses_ocr_btn" class="btn btn-primary btn-sm mt-2">Proses
                                        OCR</button>
                                    <small id="ocr_status" class="form-text text-muted mt-1">Belum diproses</small>
                                </div>
                            </div>

                            {{-- Preview hasil OCR --}}
                            <div class="col-12 col-lg-6 text-center">
                                <canvas id="ocr_canvas" style="display: none;"></canvas>
                                <div class="mt-3 text-center">
                                    <img id="preview_bw" src=""
                                        style="max-width:50%; border:1px solid #ccc; border-radius:6px;">
                                </div>
                            </div>

                            {{-- Keterangan hasil OCR --}}
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan (hasil OCR)</label>
                                    <textarea id="keterangan" name="keterangan" class="form-control" rows="4">{{ old('keterangan') }}</textarea>
                                </div>
                            </div>

                            {{-- Telepon --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" id="telepon"
                                        class="form-control @error('telepon') is-invalid @enderror" name="telepon"
                                        value="{{ old('telepon') }}">
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin"
                                        class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kabupaten, Kecamatan, Provinsi --}}
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                    <input type="text" id="kabupaten" class="form-control" name="kabupaten"
                                        value="{{ old('kabupaten') }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <input type="text" id="kecamatan" class="form-control" name="kecamatan"
                                        value="{{ old('kecamatan') }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" id="provinsi" class="form-control" name="provinsi"
                                        value="{{ old('provinsi') }}">
                                </div>
                            </div>

                            {{-- Data keluarga & pekerjaan --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="status_keluarga" class="form-label">Status Keluarga</label>
                                    <input type="text" id="status_keluarga" class="form-control"
                                        name="status_keluarga" value="{{ old('status_keluarga') }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="jumlah_tanggungan" class="form-label">Jumlah Tanggungan</label>
                                    <input type="number" id="jumlah_tanggungan" class="form-control"
                                        name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan') }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="nama_ahli_waris" class="form-label">Nama Ahli Waris</label>
                                    <input type="text" id="nama_ahli_waris" class="form-control"
                                        name="nama_ahli_waris" value="{{ old('nama_ahli_waris') }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="hubungan_ahli_waris" class="form-label">Hubungan dengan Ahli Waris</label>
                                    <input type="text" id="hubungan_ahli_waris" class="form-control"
                                        name="hubungan_ahli_waris" value="{{ old('hubungan_ahli_waris') }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="telepon_ahli_waris" class="form-label">Telepon Ahli Waris</label>
                                    <input type="text" id="telepon_ahli_waris" class="form-control"
                                        name="telepon_ahli_waris" value="{{ old('telepon_ahli_waris') }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                    <input type="text" id="pekerjaan" class="form-control" name="pekerjaan"
                                        value="{{ old('pekerjaan') }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="alamat_pekerjaan" class="form-label">Alamat Pekerjaan</label>
                                    <textarea id="alamat_pekerjaan" name="alamat_pekerjaan" class="form-control" rows="2">{{ old('alamat_pekerjaan') }}</textarea>
                                </div>
                            </div>

                            {{-- Data rekening --}}
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="tanggal_pendaftaran" class="form-label">Tanggal Pendaftaran</label>
                                    <input type="date" id="tanggal_pendaftaran" class="form-control"
                                        name="tanggal_pendaftaran"
                                        value="{{ old('tanggal_pendaftaran', now()->toDateString()) }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="rekening_simpanan_pokok" class="form-label">Simpanan Pokok (Rp)</label>
                                    <input type="number" step="0.01" id="rekening_simpanan_pokok"
                                        class="form-control" name="rekening_simpanan_pokok"
                                        value="{{ old('rekening_simpanan_pokok', 0) }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="rekening_simpanan_wajib" class="form-label">Simpanan Wajib (Rp)</label>
                                    <input type="number" step="0.01" id="rekening_simpanan_wajib"
                                        class="form-control" name="rekening_simpanan_wajib"
                                        value="{{ old('rekening_simpanan_wajib', 0) }}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="rekening_simpanan_sukarela" class="form-label">Simpanan Sukarela
                                        (Rp)</label>
                                    <input type="number" step="0.01" id="rekening_simpanan_sukarela"
                                        class="form-control" name="rekening_simpanan_sukarela"
                                        value="{{ old('rekening_simpanan_sukarela', 0) }}">
                                </div>
                            </div>

                            {{-- Status Anggota --}}
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>
                                            Non-Aktif</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Tombol Submit --}}
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- === Script OCR === --}}
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5.0.1/dist/tesseract.min.js"></script>
    <script>
        document.getElementById('proses_ocr_btn').addEventListener('click', function() {
            const fileInput = document.getElementById('gambar_ocr');
            const file = fileInput.files[0];
            const statusText = document.getElementById('ocr_status');
            const keteranganField = document.getElementById('keterangan');
            const canvas = document.getElementById('ocr_canvas');
            const ctx = canvas.getContext('2d');
            const preview = document.getElementById('preview_bw');

            if (!file) {
                alert("Pilih gambar terlebih dahulu.");
                return;
            }

            statusText.textContent = "🔍 Memuat gambar...";

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    canvas.width = img.naturalWidth;
                    canvas.height = img.naturalHeight;
                    ctx.drawImage(img, 0, 0);

                    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const data = imageData.data;

                    const brightness = 130; // naikkan kecerahan lebih tinggi dari sebelumnya (misal 130)
                    const contrast = 1.20; // sedikit turunkan kontras biar teks tidak terlalu pudar

                    for (let i = 0; i < data.length; i += 4) {
                        const r = data[i];
                        const g = data[i + 1];
                        const b = data[i + 2];

                        // Grayscale 8-bit
                        let gray = 0.299 * r + 0.587 * g + 0.114 * b;

                        // Tambahkan brightness dan kontras
                        gray = ((gray - 128) * contrast) + 128 + brightness;

                        // Clamp nilai ke [0,255]
                        gray = Math.min(255, Math.max(0, gray));

                        // Set warna piksel ke grayscale hasil
                        data[i] = data[i + 1] = data[i + 2] = gray;
                    }

                    ctx.putImageData(imageData, 0, 0);

                    // Preview hasil lebih cerah
                    const bwDataUrl = canvas.toDataURL('image/png');
                    preview.src = bwDataUrl;
                    preview.style.display = 'block';
                    preview.style.border = "1px solid #ccc";
                    preview.style.borderRadius = "6px";

                    // Jalankan OCR
                    canvas.toBlob(function(blob) {
                        statusText.textContent = "🔍 Memulai OCR...";
                        keteranganField.value = "";

                        Tesseract.recognize(
                            blob,
                            'ind+eng', {
                                logger: m => {
                                    if (m.status === 'recognizing text') {
                                        statusText.textContent =
                                            `🔄 Memproses... ${Math.round(m.progress * 100)}%`;
                                    }
                                }
                            }
                        ).then(({
                            data: {
                                text
                            }
                        }) => {
                            keteranganField.value = text.trim();
                            statusText.textContent = "✅ OCR selesai.";
                        }).catch(err => {
                            console.error(err);
                            statusText.textContent = "❌ Gagal memproses OCR.";
                            keteranganField.value = "OCR gagal. Pastikan gambar jelas.";
                        });

                    }, 'image/png');
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
