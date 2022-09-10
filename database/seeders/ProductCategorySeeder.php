<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        for($i = 1; $i <= 15; $i++) {
            ProductCategory::create([ 'product_id' => $i , 'category_id' => 1 ]);
            ProductCategory::create([ 'product_id' => $i , 'category_id' => 2 ]);
        }
    }
}
