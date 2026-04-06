<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lokasi extends Model
{
    protected $table = 'locations';
    protected $fillable = [
        'name',
        'Kabupaten',
    ];

    public function photographer()
    {
        return $this->hasMany(photographer::class);
    }
}
