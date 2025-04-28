<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_owner_id',
        'title',
        'description',
        'goal_amount',
        'current_amount',
        'status',
    ];

    // Relations
    public function owner()
    {
        return $this->belongsTo(ProjectOwner::class, 'project_owner_id');
    }

    public function cagnotte()
    {
        return $this->hasOne(Cagnotte::class, 'project_id');
    }


}