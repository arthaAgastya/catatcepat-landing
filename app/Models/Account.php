<?php

namespace App\Models;

use App\Models\New\Jurnal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'account';

    protected $fillable = [
        'no_account',
        'saldo_normal',
        'level',
        'nama_account',
        'id_category',
    ];

    /**
     * Relasi: Account belongsTo Category
     */
    public function category()
    {
        return $this->belongsTo(AccountCategory::class, 'id_category', 'id');
    }

    /**
     * Relasi One-to-One ke model SaldoAwalNeraca
     */
    public function saldoAwalNeraca()
    {
        return $this->hasOne(SaldoAwalNeraca::class);
    }

    /**
     * Relasi ke Simpanan
     */
    public function simpanan()
    {
        return $this->hasMany(Simpanan::class, 'id_account', 'id');
    }

    /**
     * Relasi ke Jurnal
     */
    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'id_account', 'id');
    }
}
