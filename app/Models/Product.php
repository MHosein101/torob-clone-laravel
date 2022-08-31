<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $hidden = [
        // 'category_id' ,
        'brand_id' ,
        'created_at',
        'updated_at',
    ];
}
