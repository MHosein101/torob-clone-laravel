<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryBrand;

class CategoryBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryBrand::create([ 'category_id' => 2 , 'brand_id' => 1 ]);
        CategoryBrand::create([ 'category_id' => 2 , 'brand_id' => 2 ]);
        CategoryBrand::create([ 'category_id' => 2 , 'brand_id' => 3 ]);
        CategoryBrand::create([ 'category_id' => 2 , 'brand_id' => 4 ]);
        CategoryBrand::create([ 'category_id' => 2 , 'brand_id' => 5 ]);

        CategoryBrand::create([ 'category_id' => 12 , 'brand_id' => 6 ]);
        CategoryBrand::create([ 'category_id' => 12 , 'brand_id' => 7 ]);
        CategoryBrand::create([ 'category_id' => 13 , 'brand_id' => 6 ]);
        CategoryBrand::create([ 'category_id' => 13 , 'brand_id' => 7 ]);
        CategoryBrand::create([ 'category_id' => 14 , 'brand_id' => 6 ]);
        CategoryBrand::create([ 'category_id' => 14 , 'brand_id' => 7 ]);

        CategoryBrand::create([ 'category_id' => 16 , 'brand_id' => 8 ]);
        CategoryBrand::create([ 'category_id' => 16 , 'brand_id' => 9 ]);
        CategoryBrand::create([ 'category_id' => 16 , 'brand_id' => 10 ]);
        CategoryBrand::create([ 'category_id' => 16 , 'brand_id' => 11 ]);

        // CategoryBrand::create([ 'category_id' => 1 , 'brand_id' => 1 ]);
    }
}
