<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'investment_id',
        'amount',
        'status',
    ];

    // Relations
    public function investment()
    {
        return $this->belongsTo(Investment::class, 'investment_id');
    }
}