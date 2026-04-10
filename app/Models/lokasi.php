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
    public function Transaction()
    {
        return $this->hasMany(Transaction::class, 'location_id', 'id');
    }
}

