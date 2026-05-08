<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\DetailPengelola;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
    //     $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $currentUser = Auth::user();

        // Ambil semua user jika super-admin, selain itu exclude user dengan role super-admin
        if ($currentUser->hasRole('super-admin')) {
            $users = User::with('roles')->get();
        } else {
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super-admin');
            })->get();
        }

        return view('master.user.theme2.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        // $roles = Role::pluck('name', 'name')->all();
        $roles = Role::where('name', '!=', 'super-admin')->pluck('name', 'name')->all();

        return view('master.user.theme2.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Data Diri
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nik' => 'required|string|unique:detail_pengelola,nik',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten_kotamadya' => 'required|string',
            'kecamatan' => 'required|string',

            // Keterangan Diri
            'tanggal_diangkat' => 'required|date',
            'nomor_induk_kepegawaian' => 'required|string|unique:detail_pengelola,nomor_induk_kepegawaian',
            'telepon' => 'required|string',
            'status_keluarga' => 'nullable|string',
            'jumlah_tanggungan' => 'nullable|integer',
            'nama_ahli_waris' => 'nullable|string',
            'hubungan_ahli_waris' => 'nullable|string',
            'roles' => 'required|string',

            // Dokumen
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'KTP' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanda_tangan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            // Pesan Error Bahasa Indonesia
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            'username.unique' => 'Username sudah digunakan.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal harus 6 karakter.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.string' => 'NIK harus berupa teks.',
            'nik.unique' => 'NIK sudah terdaftar.',

            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',

            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',

            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',

            'provinsi.required' => 'Provinsi wajib diisi.',
            'provinsi.string' => 'Provinsi harus berupa teks.',

            'kabupaten_kotamadya.required' => 'Kabupaten/Kotamadya wajib diisi.',
            'kabupaten_kotamadya.string' => 'Kabupaten/Kotamadya harus berupa teks.',

            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kecamatan.string' => 'Kecamatan harus berupa teks.',

            'tanggal_diangkat.required' => 'Tanggal diangkat wajib diisi.',
            'tanggal_diangkat.date' => 'Tanggal diangkat tidak valid.',

            'nomor_induk_kepegawaian.required' => 'Nomor Induk Kepegawaian wajib diisi.',
            'nomor_induk_kepegawaian.string' => 'Nomor Induk Kepegawaian harus berupa teks.',
            'nomor_induk_kepegawaian.unique' => 'Nomor Induk Kepegawaian sudah terdaftar.',

            'telepon.required' => 'Nomor telepon wajib diisi.',
            'telepon.string' => 'Nomor telepon harus berupa teks.',

            'status_keluarga.string' => 'Status keluarga harus berupa teks.',
            'jumlah_tanggungan.integer' => 'Jumlah tanggungan harus berupa angka.',
            'nama_ahli_waris.string' => 'Nama ahli waris harus berupa teks.',
            'hubungan_ahli_waris.string' => 'Hubungan ahli waris harus berupa teks.',

            'roles.required' => 'Role wajib diisi.',
            'roles.string' => 'Role harus berupa teks.',

            // Dokumen
            'foto.image' => 'Foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',

            'KTP.mimes' => 'KTP harus berformat PDF, JPG, JPEG, atau PNG.',
            'KTP.max' => 'Ukuran file KTP maksimal 2MB.',

            'tanda_tangan.image' => 'Tanda tangan harus berupa gambar.',
            'tanda_tangan.mimes' => 'Tanda tangan harus berformat JPG, JPEG, atau PNG.',
            'tanda_tangan.max' => 'Ukuran tanda tangan maksimal 2MB.',
        ]);

        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role
        $user->assignRole($request->roles);

        // Upload dokumen (opsional)
        $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('pengelola/foto', 'public') : null;
        $ktpPath = $request->hasFile('KTP') ? $request->file('KTP')->store('pengelola/ktp', 'public') : null;
        $ttdPath = $request->hasFile('tanda_tangan') ? $request->file('tanda_tangan')->store('pengelola/tanda_tangan', 'public') : null;

        // Simpan detail_pengelola
        DetailPengelola::create([
            'id_user' => $user->id,
            'nik' => $request->nik,
            'telepon' => $request->telepon,
            'nomor_telepon_hp' => $request->telepon,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten_kotamadya' => $request->kabupaten_kotamadya,
            'kecamatan' => $request->kecamatan,

            'tanggal_diangkat' => $request->tanggal_diangkat,
            'nomor_induk_kepegawaian' => $request->nomor_induk_kepegawaian,
            'status_keluarga' => $request->status_keluarga,
            'jumlah_tanggungan' => $request->jumlah_tanggungan,
            'nama_ahli_waris' => $request->nama_ahli_waris,
            'hubungan_ahli_waris' => $request->hubungan_ahli_waris,
            'jabatan' => $request->roles,

            'foto' => $fotoPath,
            'ktp' => $ktpPath,
            'tanda_tangan' => $ttdPath,
        ]);

        return redirect()->route('master.pengelola.index')->with('success', 'Pengelola berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('master.user.theme2.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username,'.$id,
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|min:6|same:password_confirmation',
            'roles' => 'required|string',
            'nik' => 'required|string|max:30',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten_kotamadya' => 'required|string',
            'kecamatan' => 'required|string',
            'tanggal_diangkat' => 'required|date',
            'nomor_induk_kepegawaian' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'KTP' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'tanda_tangan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update User
        $input = $request->only(['name', 'username', 'email']);
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }
        $user->update($input);

        // Update Role
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));

        // Update Detail Pengelola
        $detail = $user->detailPengelola ?? $user->detailPengelola()->create([]);

        $detail->nik = $request->nik;
        $detail->tempat_lahir = $request->tempat_lahir;
        $detail->tanggal_lahir = $request->tanggal_lahir;
        $detail->jenis_kelamin = $request->jenis_kelamin;
        $detail->alamat = $request->alamat;
        $detail->provinsi = $request->provinsi;
        $detail->kabupaten_kotamadya = $request->kabupaten_kotamadya;
        $detail->kecamatan = $request->kecamatan;
        $detail->tanggal_diangkat = $request->tanggal_diangkat;
        $detail->nomor_induk_kepegawaian = $request->nomor_induk_kepegawaian;
        $detail->telepon = $request->telepon;
        $detail->status_keluarga = $request->status_keluarga;
        $detail->jumlah_tanggungan = $request->jumlah_tanggungan;
        $detail->nama_ahli_waris = $request->nama_ahli_waris;
        $detail->hubungan_ahli_waris = $request->hubungan_ahli_waris;

        // Upload Dokumen (jika ada)
        if ($request->hasFile('foto')) {
            if ($detail->foto) {
                Storage::delete($detail->foto);
            }
            $detail->foto = $request->file('foto')->store('pengelola/foto');
        }

        if ($request->hasFile('KTP')) {
            if ($detail->ktp) {
                Storage::delete($detail->ktp);
            }
            $detail->ktp = $request->file('KTP')->store('pengelola/ktp');
        }

        if ($request->hasFile('tanda_tangan')) {
            if ($detail->tanda_tangan) {
                Storage::delete($detail->tanda_tangan);
            }
            $detail->tanda_tangan = $request->file('tanda_tangan')->store('pengelola/ttd');
        }

        $detail->save();

        return redirect()->route('master.pengelola.index')
            ->with('success', 'Pengelola berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();

        return redirect()->route('master.pengelola.index')
            ->with('success', 'User deleted successfully');
    }
}
