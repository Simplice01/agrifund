<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'investor_id',
        'service_id',
        'amount',
        'status',
    ];

    // Relations
    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}