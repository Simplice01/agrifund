<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cagnotte_id',
        'amount',
        'status',
        'anonymat',
    ];

    // Relations
    public function investor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Cagnotte::class, 'cagnotte_id');
    }

    public function refund()
    {
        return $this->hasOne(Refund::class, 'investment_id');
    }
}