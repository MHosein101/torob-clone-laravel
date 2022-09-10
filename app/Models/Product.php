<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    public static function customCreate($data) {
        $data['hash_id'] = sha1($data['title']);
        $p = Product::create($data);
    }

    public function getSpecsAttribute($value)
    {
        if($value == null)
            return '[]';
        
        return $value;
    }
}
