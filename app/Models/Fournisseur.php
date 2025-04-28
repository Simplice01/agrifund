<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
 
    protected $table = 'fournisseurs';

     
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse',
    ];

    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
