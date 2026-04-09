<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class photographer extends Model
{
    protected $table = 'photographers';

    protected $fillable = [
        'name',
        'phone',
    ];

    public function Transaction()
    {
        return $this->hasMany(Transaction::class, 'photographer_id', 'id');
    }
}
