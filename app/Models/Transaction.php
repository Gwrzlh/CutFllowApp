<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'customer_name', 'package_id', 'photographer_id', 
        'location_id', 'user_id', 'total_amount', 'amount_paid', 
        'cash_change', 'payment_status', 'booking_status', 
        'execution_date', 'notes'
    ];

    public function package() { return $this->belongsTo(packages::class, 'package_id'); }
    public function photographer() { return $this->belongsTo(photographer::class, 'photographer_id'); }
    public function lokasi() { return $this->belongsTo(lokasi::class, 'location_id'); }
    public function user() { return $this->belongsTo(User::class); }
    public function getLocationNameAttribute() {
    return $this->photographer->lokasi->name ?? 'No Location';
    }   
}