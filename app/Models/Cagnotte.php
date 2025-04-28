<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cagnotte extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'thumbnail',
        'target_amount',
        'collected_amount',
        'status',
    ];

    // Relations
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function investments()
    {
        return $this->hasMany(Investment::class, 'cagnotte_id');
    }
}

