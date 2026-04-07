<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class photographer extends Model
{
    protected $table = 'photographers';

    protected $fillable = [
        'name',
        'location_id',
        'phone',
    ];

    public function lokasi()
    {
        return $this->belongsTo(lokasi::class, 'location_id', 'id');
    }
}
