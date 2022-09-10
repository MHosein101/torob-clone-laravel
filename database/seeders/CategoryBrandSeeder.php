<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryBrand;

class CategoryBrandSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [ 'category_id' => 2 , 'brand_id' => 1 ] ,
            [ 'category_id' => 2 , 'brand_id' => 2 ] ,
            [ 'category_id' => 2 , 'brand_id' => 3 ] ,
            [ 'category_id' => 2 , 'brand_id' => 4 ] ,
            [ 'category_id' => 2 , 'brand_id' => 5 ] ,

            [ 'category_id' => 12 , 'brand_id' => 6 ] ,
            [ 'category_id' => 12 , 'brand_id' => 7 ] ,
            [ 'category_id' => 13 , 'brand_id' => 6 ] ,
            [ 'category_id' => 13 , 'brand_id' => 7 ] ,
            [ 'category_id' => 14 , 'brand_id' => 6 ] ,
            [ 'category_id' => 14 , 'brand_id' => 7 ] ,

            [ 'category_id' => 16 , 'brand_id' => 8 ] ,
            [ 'category_id' => 16 , 'brand_id' => 9 ] ,
            [ 'category_id' => 16 , 'brand_id' => 10 ] ,
            [ 'category_id' => 16 , 'brand_id' => 11 ] ,
        ];

        foreach($data as $set)
            CategoryBrand::create($set);
    }
}
