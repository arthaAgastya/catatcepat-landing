<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'size',
        'description',
        'type',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
