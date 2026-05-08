<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    protected $table = 'account_categories';

    protected $fillable = [
        'category',
        'sub_category',
    ];

    /**
     * Relasi: Category hasMany Accounts
     */
    public function accounts()
    {
        return $this->hasMany(Account::class, 'id_category', 'id');
    }
}
