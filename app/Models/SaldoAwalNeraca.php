<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoAwalNeraca extends Model
{
    use HasFactory;
    protected $table = 'saldo_awal_neraca';
    protected $fillable = ['id_account', 'saldo_awal'];

    // Relasi One-to-One ke model Account
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
