<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for($i = 1; $i < 121; $i+=4) {
            ProductCategory::create([ 'product_id' => ($i) , 'category_id' => 1 ]);
            ProductCategory::create([ 'product_id' => ($i) , 'category_id' => 2 ]);
            
            ProductCategory::create([ 'product_id' => ($i+1) , 'category_id' => 1 ]);
            ProductCategory::create([ 'product_id' => ($i+1) , 'category_id' => 2 ]);
            
            ProductCategory::create([ 'product_id' => ($i+2) , 'category_id' => 1 ]);
            ProductCategory::create([ 'product_id' => ($i+2) , 'category_id' => 2 ]);
            
            ProductCategory::create([ 'product_id' => ($i+3) , 'category_id' => 1 ]);
            ProductCategory::create([ 'product_id' => ($i+3) , 'category_id' => 2 ]);
        }


        // ProductCategory::create([ 'product_id' => 1 , 'category_id' => 1 ]);
        // ProductCategory::create([ 'product_id' => 1 , 'category_id' => 2 ]);

        // ProductCategory::create([ 'product_id' => 2 , 'category_id' => 1 ]);
        // ProductCategory::create([ 'product_id' => 2 , 'category_id' => 2 ]);

        // ProductCategory::create([ 'product_id' => 3 , 'category_id' => 1 ]);
        // ProductCategory::create([ 'product_id' => 3 , 'category_id' => 2 ]);

        // ProductCategory::create([ 'product_id' => 4 , 'category_id' => 1 ]);
        // ProductCategory::create([ 'product_id' => 4 , 'category_id' => 2 ]);
        
        // ProductCategory::create([ 'product_id' => 5 , 'category_id' => 10 ]);
        // ProductCategory::create([ 'product_id' => 5 , 'category_id' => 11 ]);
        // ProductCategory::create([ 'product_id' => 5 , 'category_id' => 12 ]);
        // ProductCategory::create([ 'product_id' => 5 , 'category_id' => 13 ]);
        
        // ProductCategory::create([ 'product_id' => 6 , 'category_id' => 10 ]);
        // ProductCategory::create([ 'product_id' => 6 , 'category_id' => 11 ]);
        // ProductCategory::create([ 'product_id' => 6 , 'category_id' => 12 ]);
        // ProductCategory::create([ 'product_id' => 6 , 'category_id' => 14 ]);
        
        // ProductCategory::create([ 'product_id' => 7 , 'category_id' => 10 ]);
        // ProductCategory::create([ 'product_id' => 7 , 'category_id' => 11 ]);
        // ProductCategory::create([ 'product_id' => 7 , 'category_id' => 12 ]);
        // ProductCategory::create([ 'product_id' => 7 , 'category_id' => 13 ]);
        
        // ProductCategory::create([ 'product_id' => 8 , 'category_id' => 10 ]);
        // ProductCategory::create([ 'product_id' => 8 , 'category_id' => 11 ]);
        // ProductCategory::create([ 'product_id' => 8 , 'category_id' => 16 ]);
        
        // ProductCategory::create([ 'product_id' => 9 , 'category_id' => 10 ]);
        // ProductCategory::create([ 'product_id' => 9 , 'category_id' => 11 ]);
        // ProductCategory::create([ 'product_id' => 9 , 'category_id' => 16 ]);
        
        // ProductCategory::create([ 'product_id' => 10 , 'category_id' => 10 ]);
        // ProductCategory::create([ 'product_id' => 10 , 'category_id' => 17 ]);
        // ProductCategory::create([ 'product_id' => 10 , 'category_id' => 18 ]);
        
        // ProductCategory::create([ 'product_id' => 11 , 'category_id' => 10 ]);
        // ProductCategory::create([ 'product_id' => 11 , 'category_id' => 17 ]);
        // ProductCategory::create([ 'product_id' => 11 , 'category_id' => 19 ]);
        
        // ProductCategory::create([ 'product_id' => 1 , 'category_id' => 1 ]);
    }
}
