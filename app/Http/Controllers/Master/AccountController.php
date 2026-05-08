<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AccountCategory;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Menampilkan daftar akun
     */
    public function index()
    {
        // Ambil semua kategori dan subkategori
        $kategori = AccountCategory::all()->groupBy('category');

        // Ambil akun dan relasi yang diperlukan
        $accounts = Account::with('saldoAwalNeraca', 'jurnal', 'category')->orderBy('no_account', 'ASC')->get();

        // Hitung saldo saat ini untuk setiap akun
        foreach ($accounts as $account) {
            $saldoAwal = $account->saldoAwalNeraca->saldo_awal ?? 0;
            $totalJurnal = $account->jurnal->sum(function ($jurnal) {
                return $jurnal->tipe === 'debit' ? $jurnal->jumlah : -$jurnal->jumlah;
            });
            $account->saldo_saat_ini = $saldoAwal + $totalJurnal;
        }

        return view('master.account.theme2.index', compact('accounts', 'kategori'));
    }

    /**
     * Form tambah akun
     */
    public function create()
    {
        // Mengambil semua kategori untuk dipilih pada form
        $categories = AccountCategory::all()->groupBy('category');

        return view('master.account.theme2.create', compact('categories'));
    }

    public function createCategories()
    {
        $categories = AccountCategory::select('category')->distinct()->get();

        return view('master.account.theme2.createCategories', compact('categories'));
    }

    public function storeCategories(Request $request)
    {
        // Validasi input
        $request->validate([
            'kategori' => 'required|string|max:255',
            'sub_kategori' => 'required|string|max:255|unique:account_categories,sub_category',
        ], [
            'kategori.required' => 'Kategori akun wajib diisi.',
            'sub_kategori.required' => 'Sub kategori akun wajib diisi.',
            'sub_kategori.unique' => 'Sub kategori akun sudah terdaftar.',
        ]);

        // Simpan data kategori akun dengan nama kolom yang benar
        AccountCategory::create([
            'category' => $request->kategori,  // Ganti 'kategori' dengan 'category' sesuai kolom tabel
            'sub_category' => $request->sub_kategori,
        ]);

        return redirect()->route('master.akun.index')->with('success', 'Kategori akun berhasil ditambahkan.');
    }

    public function generateNoAccount($prefix)
    {
        // Ambil akun terakhir dengan prefix tertentu, urutkan dari yang terbesar
        $lastAccount = Account::where('no_account', 'like', "$prefix%")
            ->orderBy('no_account', 'desc')
            ->first();

        if ($lastAccount) {
            $lastNumber = (int) $lastAccount->no_account;
            $newNumber = $lastNumber + 1;
        } else {
            // Default awal jika belum ada
            $newNumber = (int) $prefix.'000';
        }

        return response()->json([
            'no_account' => (string) $newNumber,
        ]);
    }

    /**
     * Simpan akun baru
     */
    public function store(Request $request)
    {
        // Validasi input termasuk saldo_awal dan kelompok
        $request->validate([
            'id_category' => 'required|exists:account_categories,id', // Validasi kategori
            'no_account' => 'required|string|max:50|unique:account,no_account',
            'saldo_normal' => 'required|in:debit,kredit',
            'level' => 'required|in:1,2',
            'nama_account' => 'required|string|max:255',
            'kelompok' => 'required|in:1,2,3,4,5,6,7,8,9', // sesuaikan kelompok yang ada
            'saldo_awal' => 'nullable|numeric',
        ], [
            'id_category.required' => 'Kategori akun wajib dipilih.',
            'id_category.exists' => 'Kategori yang dipilih tidak valid.',
            'no_account.required' => 'Nomor akun wajib diisi.',
            'no_account.unique' => 'Nomor akun sudah terdaftar.',
            'no_account.max' => 'Nomor akun maksimal 50 karakter.',
            'saldo_normal.required' => 'Saldo normal wajib dipilih.',
            'saldo_normal.in' => 'Saldo normal harus bernilai debit atau kredit.',
            'level.required' => 'Level akun wajib dipilih.',
            'level.in' => 'Level harus bernilai 1 atau 2.',
            'nama_account.required' => 'Nama akun wajib diisi.',
            'nama_account.max' => 'Nama akun maksimal 255 karakter.',
            'kelompok.required' => 'Kelompok akun wajib dipilih.',
            'kelompok.in' => 'Kelompok akun tidak valid.',
            'saldo_awal.numeric' => 'Saldo awal harus berupa angka.',
        ]);

        // Simpan data akun, termasuk kelompok
        $account = Account::create([
            'id_category' => $request->id_category,
            'no_account' => $request->no_account,
            'saldo_normal' => $request->saldo_normal,
            'level' => $request->level,
            'nama_account' => $request->nama_account,
            'kelompok' => $request->kelompok,
        ]);

        // Simpan saldo awal jika ada (jika model dan relasi sudah benar)
        $account->saldoAwalNeraca()->create([
            'saldo_awal' => $request->saldo_awal ?? 0,
        ]);

        return redirect()->route('master.akun.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    /**
     * Form edit akun
     */
    public function edit($id)
    {
        // Ambil akun yang akan diedit
        $account = Account::findOrFail($id);

        // Ambil semua kategori yang sudah dikelompokkan berdasarkan kategori
        $categories = AccountCategory::all()->groupBy('category');

        return view('master.account.theme2.edit', compact('account', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        // Validasi request
        $request->validate([
            'no_account' => 'required|string|max:50|unique:account,no_account,'.$account->id,
            'saldo_normal' => 'required|in:debit,kredit',
            'level' => 'required|in:1,2',
            'nama_account' => 'required|string|max:255',
            'kelompok' => 'required|in:1,2,3,4,5,6,7,8,9', // Validasi kelompok
            'saldo_awal' => 'nullable|numeric', // Validasi saldo_awal, bisa kosong atau angka
            'id_category' => 'required|exists:account_categories,id', // Validasi kategori
        ], [
            'no_account.required' => 'Nomor akun wajib diisi.',
            'no_account.unique' => 'Nomor akun sudah terdaftar.',
            'saldo_normal.required' => 'Saldo normal wajib dipilih.',
            'level.required' => 'Level akun wajib dipilih.',
            'nama_account.required' => 'Nama akun wajib diisi.',
            'kelompok.required' => 'Kelompok akun wajib dipilih.',
            'id_category.required' => 'Kategori akun wajib dipilih.',
            'id_category.exists' => 'Kategori yang dipilih tidak valid.',
            'saldo_awal.numeric' => 'Saldo awal harus berupa angka.',
        ]);

        // Update data akun
        $account->update([
            'no_account' => $request->no_account,
            'saldo_normal' => $request->saldo_normal,
            'level' => $request->level,
            'nama_account' => $request->nama_account,
            'kelompok' => $request->kelompok,
            'id_category' => $request->id_category, // Menyimpan kategori yang dipilih
        ]);

        // Cek apakah saldo_awal diberikan, jika iya update saldo_awal
        if ($request->has('saldo_awal')) {
            $account->saldoAwalNeraca()->updateOrCreate(
                ['account_id' => $account->id],
                ['saldo_awal' => $request->saldo_awal ?: 0]
            );
        }

        return redirect()->route('master.akun.index')->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Fungsi untuk mengecek dan memperbarui kelompok akun berdasarkan no_account.
     */
    public function updateKelompokAkun()
    {
        // Ambil semua data akun
        $accounts = Account::all();

        // Looping untuk memeriksa dan update kelompok
        foreach ($accounts as $account) {
            // Ambil awalan no_account, dan tentukan kelompok
            $kelompok = $this->getKelompokByNoAccount($account->no_account);

            // Update kelompok jika perlu
            if ($kelompok && $account->kelompok != $kelompok) {
                $account->update([
                    'kelompok' => $kelompok,
                ]);
            }
        }

        return redirect()->route('master.akun.index')->with('success', 'Kelompok akun berhasil diperbarui.');
    }

    /**
     * Fungsi untuk menentukan kelompok akun berdasarkan awalan no_account.
     *
     * @param  string  $no_account
     * @return string|null
     */
    private function getKelompokByNoAccount($no_account)
    {
        // Tentukan kelompok berdasarkan awalan no_account
        $prefix = substr($no_account, 0, 1); // Ambil 1 karakter pertama dari no_account

        switch ($prefix) {
            case '1':
                return '1'; // Aktiva
            case '2':
                return '2'; // Kewajiban
            case '3':
                return '3'; // Ekuitas
            case '4':
                return '4'; // Pendapatan
            case '5':
                return '5'; // Beban
            case '6':
                return '6'; // HPP (opsional)
            case '7':
                return '7'; // (opsional)
            case '8':
                return '8'; // (opsional)
            case '9':
                return '9'; // (opsional)
            default:
                return null; // Tidak ditemukan
        }
    }

    /**
     * Hapus akun
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        // Cek apakah akun memiliki relasi dengan jurnal atau saldo awal neraca
        if ($account->jurnal()->exists() || $account->saldoAwalNeraca()->exists()) {
            return redirect()->route('master.akun.index')->with('error', 'Akun tidak dapat dihapus karena memiliki relasi dengan data lain.');
        }
        $account->delete();

        return redirect()->route('master.akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}
