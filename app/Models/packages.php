<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class packages extends Model
{
    protected $table = 'packages';

    protected $fillable = [
        'name',
        'price',
        'description',
        'is_active'
    ];

    public function Transaction()
    {
        return $this->hasMany(Transaction::class, 'package_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
