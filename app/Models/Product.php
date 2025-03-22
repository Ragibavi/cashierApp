<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $incrementing = false; 
    protected $keyType = 'string'; 
    
    protected $fillable = [
        'name',
        'image',
        'quantity',
        'price',
    ];
}
