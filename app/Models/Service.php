<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_owner_id',
        'title',
        'description',
        'price',
        'status',
    ];

    // Relations
    public function owner()
    {
        return $this->belongsTo(ProjectOwner::class, 'project_owner_id');
    }

    public function orders()
    {
        return $this->hasMany(ServiceOrder::class, 'service_id');
    }
}