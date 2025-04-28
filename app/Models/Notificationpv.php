<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificationpv extends Model {
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'message', 'type', 'lu'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
