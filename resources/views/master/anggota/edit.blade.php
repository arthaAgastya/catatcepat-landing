@extends('layouts.main')

@section('content')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-dark fw-bolder my-1 fs-3">Edit Anggota</h1>
                <ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 text-hover-primary">Beranda</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Master</li>
                    <li class="breadcrumb-item text-gray-600">
                        <a href="{{ route('master.anggota.index') }}" class="text-gray-600 text-hover-primary">Anggota</a>
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
                        <h2>Form Edit Anggota</h2>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex align-items-center py-2 py-md-1">
                            <a href="{{ route('master.anggota.index') }}" class="btn btn-warning btn-sm">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('master.anggota.update', $anggota->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- Kode Anggota --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="nomor_anggota" class="form-label required">Kode Anggota (NIK)</label>
                                    <input type="text" id="nomor_anggota"
                                        class="form-control @error('nomor_anggota') is-invalid @enderror"
                                        name="nomor_anggota" value="{{ old('nomor_anggota', $anggota->nomor_anggota) }}">
                                    @error('nomor_anggota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nama --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label required">Nama Lengkap</label>
                                    <input type="text" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror" name="nama"
                                        value="{{ old('nama', $anggota->nama) }}">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Upload Gambar OCR --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="gambar_ocr" class="form-label">Upload Gambar (untuk OCR)</label>
                                    <input type="file" id="gambar_ocr" name="gambar_ocr" accept="image/*"
                                        class="form-control @error('gambar_ocr') is-invalid @enderror">
                                    @error('gambar_ocr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <button type="button" id="proses_ocr_btn" class="btn btn-primary btn-sm mt-2">Proses
                                        OCR</button>
                                    <small id="ocr_status" class="form-text text-muted mt-1">Belum diproses</small>
                                </div>
                            </div>

                            {{-- Preview hasil OCR --}}
                            <div class="col-12 col-lg-6 text-center">
                                <canvas id="ocr_canvas" style="display: none;"></canvas>
                                <div class="mt-3 text-center">
                                    @if ($anggota->files->where('type', 'image')->count() > 0)
                                        @foreach ($anggota->files->where('type', 'image') as $file)
                                            {{-- {{ dd($file->path) }} --}}
                                            <img src="{{ asset('storage/' . $file->path) }}" alt="Gambar OCR"
                                                style="max-width:50%; border:1px solid #ccc; border-radius:6px; margin-bottom:10px;">
                                        @endforeach
                                    @endif
                                    <img id="preview_bw" src=""
                                        style="max-width:50%; border:1px solid #ccc; border-radius:6px;">
                                </div>
                            </div>

                            {{-- Keterangan hasil OCR --}}
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan (Data Mentah)</label>
                                    <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                        rows="2">{{ old('keterangan', $anggota->keterangan ?? '') }}</textarea>
                                    @error('keterangan')
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
                                        <option value="L"
                                            {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="P"
                                            {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Telepon --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" id="telepon"
                                        class="form-control @error('telepon') is-invalid @enderror" name="telepon"
                                        value="{{ old('telepon', $anggota->telepon) }}">
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3">{{ old('alamat', $anggota->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Kecamatan, Kabupaten, Provinsi --}}
                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <input type="text" id="kecamatan"
                                        class="form-control @error('kecamatan') is-invalid @enderror" name="kecamatan"
                                        value="{{ old('kecamatan', $anggota->kecamatan) }}">
                                    @error('kecamatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                    <input type="text" id="kabupaten"
                                        class="form-control @error('kabupaten') is-invalid @enderror" name="kabupaten"
                                        value="{{ old('kabupaten', $anggota->kabupaten) }}">
                                    @error('kabupaten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-4">
                                <div class="mb-3">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <input type="text" id="provinsi"
                                        class="form-control @error('provinsi') is-invalid @enderror" name="provinsi"
                                        value="{{ old('provinsi', $anggota->provinsi) }}">
                                    @error('provinsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status Keluarga, Tanggungan --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="status_keluarga" class="form-label">Status Keluarga</label>
                                    <input type="text" id="status_keluarga"
                                        class="form-control @error('status_keluarga') is-invalid @enderror"
                                        name="status_keluarga"
                                        value="{{ old('status_keluarga', $anggota->status_keluarga) }}">
                                    @error('status_keluarga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="jumlah_tanggungan" class="form-label">Jumlah Tanggungan</label>
                                    <input type="number" id="jumlah_tanggungan"
                                        class="form-control @error('jumlah_tanggungan') is-invalid @enderror"
                                        name="jumlah_tanggungan"
                                        value="{{ old('jumlah_tanggungan', $anggota->jumlah_tanggungan) }}">
                                    @error('jumlah_tanggungan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Ahli Waris --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="nama_ahli_waris" class="form-label">Nama Ahli Waris</label>
                                    <input type="text" id="nama_ahli_waris"
                                        class="form-control @error('nama_ahli_waris') is-invalid @enderror"
                                        name="nama_ahli_waris"
                                        value="{{ old('nama_ahli_waris', $anggota->nama_ahli_waris) }}">
                                    @error('nama_ahli_waris')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="hubungan_ahli_waris" class="form-label">Hubungan</label>
                                    <input type="text" id="hubungan_ahli_waris"
                                        class="form-control @error('hubungan_ahli_waris') is-invalid @enderror"
                                        name="hubungan_ahli_waris"
                                        value="{{ old('hubungan_ahli_waris', $anggota->hubungan_ahli_waris) }}">
                                    @error('hubungan_ahli_waris')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="telepon_ahli_waris" class="form-label">Telp Ahli Waris</label>
                                    <input type="text" id="telepon_ahli_waris"
                                        class="form-control @error('telepon_ahli_waris') is-invalid @enderror"
                                        name="telepon_ahli_waris"
                                        value="{{ old('telepon_ahli_waris', $anggota->telepon_ahli_waris) }}">
                                    @error('telepon_ahli_waris')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                    <input type="text" id="pekerjaan"
                                        class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan"
                                        value="{{ old('pekerjaan', $anggota->pekerjaan) }}">
                                    @error('pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="alamat_pekerjaan" class="form-label">Alamat Pekerjaan</label>
                                    <textarea id="alamat_pekerjaan" name="alamat_pekerjaan"
                                        class="form-control @error('alamat_pekerjaan') is-invalid @enderror" rows="3">{{ old('alamat_pekerjaan', $anggota->alamat_pekerjaan) }}</textarea>
                                    @error('alamat_pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tanggal Pendaftaran --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="tanggal_pendaftaran" class="form-label required">Tanggal
                                        Pendaftaran</label>
                                    <input type="date" id="tanggal_pendaftaran"
                                        class="form-control @error('tanggal_pendaftaran') is-invalid @enderror"
                                        name="tanggal_pendaftaran"
                                        value="{{ old('tanggal_pendaftaran', $anggota->tanggal_pendaftaran->format('Y-m-d')) }}">
                                    @error('tanggal_pendaftaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            {{-- Status --}}
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                        <option value="aktif"
                                            {{ old('status', $anggota->status) == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="non-aktif"
                                            {{ old('status', $anggota->status) == 'non-aktif' ? 'selected' : '' }}>
                                            Non-Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                        rows="2">{{ old('deskripsi', $anggota->deskripsi ?? '') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- === Script OCR & Auto-Fill === --}}
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

            // Reset tampilan sebelum proses
            statusText.textContent = "🔍 Memuat gambar...";
            keteranganField.value = "";
            preview.style.display = 'none';
            preview.src = "";
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    canvas.width = img.naturalWidth;
                    canvas.height = img.naturalHeight;
                    ctx.drawImage(img, 0, 0);

                    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const data = imageData.data;

                    const brightness = 130;
                    const contrast = 1.20;

                    for (let i = 0; i < data.length; i += 4) {
                        const r = data[i];
                        const g = data[i + 1];
                        const b = data[i + 2];

                        let gray = 0.299 * r + 0.587 * g + 0.114 * b;
                        gray = ((gray - 128) * contrast) + 128 + brightness;
                        gray = Math.min(255, Math.max(0, gray));

                        data[i] = data[i + 1] = data[i + 2] = gray;
                    }

                    ctx.putImageData(imageData, 0, 0);

                    const bwDataUrl = canvas.toDataURL('image/png');
                    preview.src = bwDataUrl;
                    preview.style.display = 'block';
                    preview.style.border = "1px solid #ccc";
                    preview.style.borderRadius = "6px";

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
                            const cleanedText = text.trim();
                            keteranganField.value = cleanedText;
                            statusText.textContent = "✅ OCR selesai. Mengirim ke AI...";

                            fetch("{{ route('ocr.parse') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({
                                        ocr_text: cleanedText
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success && data.json_data) {
                                        statusText.textContent =
                                            "✅ Data berhasil diekstrak.";

                                        const result = data.json_data;

                                        // Auto-fill ke form
                                        if (result.nik) document.getElementById(
                                            'nomor_anggota').value = result.nik;
                                        if (result.name) document.getElementById('nama')
                                            .value = result.name;
                                        if (result.address) document.getElementById(
                                            'alamat').value = result.address;
                                        if (result.kecamatan) document.getElementById(
                                            'kecamatan').value = result.kecamatan;
                                        if (result.kelurahan) document.getElementById(
                                            'kabupaten').value = result.kelurahan;
                                        if (result.provinsi) document.getElementById(
                                            'provinsi').value = result.provinsi;
                                        if (result.occupation) document.getElementById(
                                            'pekerjaan').value = result.occupation;
                                        if (result.deskripsi) document.getElementById(
                                            'deskripsi').value = result.deskripsi;
                                        if (result.gender) {
                                            const genderNormalized = result.gender
                                                .toLowerCase().replace(/[\s\-]/g, '');
                                            if (genderNormalized.includes('laki')) {
                                                document.getElementById('jenis_kelamin')
                                                    .value = 'L';
                                            } else if (genderNormalized.includes(
                                                    'perempuan') || genderNormalized
                                                .includes('wanita')) {
                                                document.getElementById('jenis_kelamin')
                                                    .value = 'P';
                                            } else {
                                                document.getElementById('jenis_kelamin')
                                                    .value = '';
                                            }
                                        }
                                    } else {
                                        statusText.textContent =
                                            "⚠️ AI gagal memahami data.";
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    statusText.textContent = "❌ Gagal menghubungi AI.";
                                });
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
