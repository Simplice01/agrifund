<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'verification_status',
        'justification_document',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'project_owner_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'project_owner_id');
    }
}