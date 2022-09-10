<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Hash;

class Product extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    public static function customCreate($data) {
        // $hashStr = str_replace(' ', random_int(10,199) ,$data['title']);
        $data['hash_id'] = sha1($data['title']);

        Product::create($data);
    }

    public function getSpecsAttribute($value)
    {
        if($value == null)
            return '[]';
        
        return $value;
    }
}
