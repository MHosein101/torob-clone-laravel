<?php

namespace App\Models;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    public static function customCreate($data) {
        $data['hash_id'] = sha1($data['title']);
        
        $categoriesID = $data['category_ids'];
        unset($data['category_ids']);

        $data['image_url'] = $data['images'][0];
        unset($data['images']);
        
        $pid = Product::create($data)->id;

        foreach($categoriesID as $cid)
            ProductCategory::create([ 'product_id' => $pid , 'category_id' => $cid ]);
    }

    public function getSpecsAttribute($value)
    {
        if($value == null)
            return '[]';
        
        return $value;
    }
}
