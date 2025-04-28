<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
 
    protected $table = 'produits';

     
    protected $fillable = [
        'nom',
        'codprod',
        'prix',
        'quantite',
        'quantite_alerte',
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
