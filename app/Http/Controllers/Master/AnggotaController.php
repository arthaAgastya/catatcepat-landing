<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::all();

        return view('master.anggota.theme2.index', compact('anggotas'));
    }

    public function create()
    {
        return view('master.anggota.theme2.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
    'nomor_anggota' => 'required|numeric|unique:anggota,nomor_anggota',
    'nama' => 'required|string|max:255',
    'jenis_kelamin' => 'required|in:L,P',

    'alamat' => 'required|string',
    'kecamatan' => 'required|string|max:100',
    'kabupaten' => 'required|string|max:100',
    'provinsi' => 'required|string|max:100',

    'telepon' => 'required|string|max:20',
    'email' => 'nullable|email|max:255|unique:anggota,email',

    'status_keluarga' => 'required|string|max:100',
    'jumlah_tanggungan' => 'required|integer|min:0',

    'nama_ahli_waris' => 'nullable|string|max:255',
    'hubungan_ahli_waris' => 'nullable|string|max:100',
    'telepon_ahli_waris' => 'nullable|string|max:20',

    'pekerjaan' => 'nullable|string|max:255',
    'alamat_pekerjaan' => 'nullable|string|max:255',

    'tanggal_pendaftaran' => 'required|date',

    'status' => 'required|in:aktif,non-aktif',

    'gambar_ocr' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

    'keterangan' => 'nullable|string',
    'deskripsi' => 'nullable|string',

    ], [

        // ===== FIELD WAJIB =====
        'nomor_anggota.required' => 'Kode anggota (NIK) wajib diisi.',
        'nomor_anggota.numeric' => 'Kode anggota harus berupa angka.',
        'nomor_anggota.unique' => 'Kode anggota sudah terdaftar.',

        'nama.required' => 'Nama lengkap wajib diisi.',
        'nama.string' => 'Nama harus berupa teks.',
        'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',

        'alamat.required' => 'Alamat wajib diisi.',
        'alamat.string' => 'Alamat harus berupa teks.',

        'kecamatan.required' => 'Kecamatan wajib diisi.',
        'kecamatan.string' => 'Kecamatan harus berupa teks.',
        'kecamatan.max' => 'Kecamatan tidak boleh lebih dari 100 karakter.',

        'kabupaten.required' => 'Kabupaten wajib diisi.',
        'kabupaten.string' => 'Kabupaten harus berupa teks.',
        'kabupaten.max' => 'Kabupaten tidak boleh lebih dari 100 karakter.',

        'provinsi.required' => 'Provinsi wajib diisi.',
        'provinsi.string' => 'Provinsi harus berupa teks.',
        'provinsi.max' => 'Provinsi tidak boleh lebih dari 100 karakter.',

        'telepon.required' => 'Nomor telepon wajib diisi.',
        'telepon.string' => 'Nomor telepon harus berupa teks.',
        'telepon.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',

        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'email.max' => 'Email tidak boleh lebih dari 255 karakter.',

        'status_keluarga.required' => 'Status keluarga wajib diisi.',
        'status_keluarga.string' => 'Status keluarga harus berupa teks.',
        'status_keluarga.max' => 'Status keluarga tidak boleh lebih dari 100 karakter.',

        'jumlah_tanggungan.required' => 'Jumlah tanggungan wajib diisi.',
        'jumlah_tanggungan.integer' => 'Jumlah tanggungan harus berupa angka.',
        'jumlah_tanggungan.min' => 'Jumlah tanggungan minimal 0.',


        // ===== OPSIONAL =====
        'nama_ahli_waris.string' => 'Nama ahli waris harus berupa teks.',
        'nama_ahli_waris.max' => 'Nama ahli waris tidak boleh lebih dari 255 karakter.',

        'hubungan_ahli_waris.string' => 'Hubungan ahli waris harus berupa teks.',
        'hubungan_ahli_waris.max' => 'Hubungan ahli waris tidak boleh lebih dari 100 karakter.',

        'telepon_ahli_waris.string' => 'Telepon ahli waris harus berupa teks.',
        'telepon_ahli_waris.max' => 'Telepon ahli waris tidak boleh lebih dari 20 karakter.',

        'pekerjaan.string' => 'Pekerjaan harus berupa teks.',
        'pekerjaan.max' => 'Pekerjaan tidak boleh lebih dari 255 karakter.',

        'alamat_pekerjaan.string' => 'Alamat pekerjaan harus berupa teks.',
        'alamat_pekerjaan.max' => 'Alamat pekerjaan tidak boleh lebih dari 255 karakter.',


        // ===== TANGGAL DAN STATUS =====
        'tanggal_pendaftaran.required' => 'Tanggal pendaftaran wajib diisi.',
        'tanggal_pendaftaran.date' => 'Tanggal pendaftaran tidak valid.',

        'status.required' => 'Status wajib dipilih.',
        'status.in' => 'Status harus aktif atau non-aktif.',


        // ===== FILE =====
        'gambar_ocr.file' => 'File tidak valid.',
        'gambar_ocr.mimes' => 'Format gambar OCR harus JPG, JPEG, atau PNG.',
        'gambar_ocr.max' => 'Ukuran gambar OCR maksimal 2MB.',
    ]);

        $validated['jumlah_tanggungan'] = $validated['jumlah_tanggungan'] ?? 0;

        // Simpan data anggota
        $anggota = Anggota::create($validated);

        // Jika ada file gambar_ocr di-upload
        if ($request->hasFile('gambar_ocr')) {
            $file = $request->file('gambar_ocr');
            $filename = 'ocr_'.uniqid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/anggota', $filename, 'public'); // simpan ke storage/app/public/uploads/anggota

            // Simpan relasi file polymorphic
            $anggota->files()->create([
                'name' => $filename,
                'path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'description' => 'Hasil upload OCR',
                'type' => 'image',
            ]);
        }

        return redirect()->route('master.anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    public function edit($id)
    {
        $anggota = Anggota::with('files')->findOrFail($id);

        return view('master.anggota.theme2.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $validated = $request->validate([
            // 'nomor_anggota' => 'required|unique:anggota,nomor_anggota,'.$anggota->id.',id',
            'nomor_anggota' => 'required|unique:anggota,nomor_anggota,'.$anggota->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'status_keluarga' => 'nullable|string|max:50',
            'jumlah_tanggungan' => 'nullable|integer|min:0',
            'nama_ahli_waris' => 'nullable|string|max:255',
            'hubungan_ahli_waris' => 'nullable|string|max:100',
            'telepon_ahli_waris' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:255',
            'alamat_pekerjaan' => 'nullable|string',
            'tanggal_pendaftaran' => 'required|date',
            'rekening_simpanan_pokok' => 'nullable|numeric|min:0',
            'rekening_simpanan_wajib' => 'nullable|numeric|min:0',
            'rekening_simpanan_sukarela' => 'nullable|numeric|min:0',
            'status' => 'required|in:aktif,non-aktif',
            'gambar_ocr' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ], [
            // --- Custom Error Messages ---
            'nomor_anggota.required' => 'Nomor anggota wajib diisi.',
            'nomor_anggota.unique' => 'Nomor anggota ini sudah terdaftar.',

            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',

            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'telepon_ahli_waris.max' => 'Nomor telepon ahli waris maksimal 20 karakter.',

            'jumlah_tanggungan.integer' => 'Jumlah tanggungan harus berupa angka.',
            'jumlah_tanggungan.min' => 'Jumlah tanggungan minimal 0.',

            'tanggal_pendaftaran.required' => 'Tanggal pendaftaran wajib diisi.',
            'tanggal_pendaftaran.date' => 'Format tanggal pendaftaran tidak valid.',

            'rekening_simpanan_pokok.numeric' => 'Nilai simpanan pokok harus berupa angka.',
            'rekening_simpanan_wajib.numeric' => 'Nilai simpanan wajib harus berupa angka.',
            'rekening_simpanan_sukarela.numeric' => 'Nilai simpanan sukarela harus berupa angka.',
            'rekening_simpanan_pokok.min' => 'Nilai simpanan pokok tidak boleh negatif.',
            'rekening_simpanan_wajib.min' => 'Nilai simpanan wajib tidak boleh negatif.',
            'rekening_simpanan_sukarela.min' => 'Nilai simpanan sukarela tidak boleh negatif.',

            'status.required' => 'Status anggota wajib diisi.',
            'status.in' => 'Status anggota harus antara aktif atau non-aktif.',

            'gambar_ocr.file' => 'File OCR harus berupa file yang valid.',
            'gambar_ocr.mimes' => 'File OCR hanya boleh berupa JPG, JPEG, atau PNG.',
            'gambar_ocr.max' => 'Ukuran file OCR maksimal 2MB.',

            'keterangan.string' => 'Keterangan harus berupa teks.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
        ]);

        $validated['jumlah_tanggungan'] = $validated['jumlah_tanggungan'] ?? 0;

        // Update data anggota
        $anggota->update($validated);

        // Jika ada file gambar_ocr di-upload
        if ($request->hasFile('gambar_ocr')) {
            $file = $request->file('gambar_ocr');
            $filename = 'ocr_'.uniqid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/anggota', $filename, 'public'); // simpan ke storage/app/public/uploads/anggota

            // Simpan relasi file polymorphic
            $anggota->files()->create([
                'name' => $filename,
                'path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'description' => 'Hasil upload OCR',
                'type' => 'image',
            ]);
        }

        return redirect()->route('master.anggota.index')->with('success', 'Data anggota berhasil diperbarui');
    }

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        return redirect()->route('master.anggota.index')->with('success', 'Anggota berhasil dihapus');
    }
}
