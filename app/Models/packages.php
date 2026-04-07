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
}
