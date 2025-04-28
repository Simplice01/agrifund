<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_type',
        'entity_id',
        'admin_id',
        'status',
        'comments',
    ];

    // Relations
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}