<?php

namespace App\Models;

use App\Models\CategoryBrand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    public $timestamps = false;

    
    public static function customCreate($data) {
        
        foreach($data['category_ids'] as $cid) {
            foreach($data['brands'] as $b) {
                $bid = Brand::create($b)->id;
                CategoryBrand::create([ 'category_id' => $cid , 'brand_id' => $bid ]);
            }
        }
        
    }
}
