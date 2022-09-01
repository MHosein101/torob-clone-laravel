<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([ 'title' => 'مسواک قرمز' , 'category_id' => 23 , 'brand_id' => 1 ]);
        Product::create([ 'title' => 'مسواک جدید' , 'category_id' => 23 , 'brand_id' => 1 ]);
        Product::create([ 'title' => 'مسواک خارجی' , 'category_id' => 23 , 'brand_id' => 1 ]);
        Product::create([ 'title' => 'مسواک بچگانه' , 'category_id' => 23 , 'brand_id' => 1 ]);
        Product::create([ 'title' => 'کابل usb' , 'category_id' => 18 , 'brand_id' => 2 ]);
        Product::create([ 'title' => 'کابل تایپ سی type c' , 'category_id' => 17 , 'brand_id' => 3 ]);
        Product::create([ 'title' => 'ویبره گوشی نوکیا' , 'category_id' => 23 , 'brand_id' => 2 ]);
        Product::create([ 'title' => 'برد نوکیا' , 'category_id' => 25 , 'brand_id' => 1 ]);
        Product::create([ 'title' => 'لباس زیر مردانه' , 'category_id' => 2 , 'brand_id' => 2 ]);
        Product::create([ 'title' => 'جوراب مردانه' , 'category_id' => 2 , 'brand_id' => 1 ]);
        Product::create([ 'title' => 'تیشرت مردانه' , 'category_id' => 4 , 'brand_id' => 1 ]);
        Product::create([ 'title' => 'شلوارک مردانه' , 'category_id' => 5 , 'brand_id' => 3 ]);
        Product::create([ 'title' => 'کفش آدیداس مردانه' , 'category_id' => 3 , 'brand_id' => 3 ]);
        Product::create([ 'title' => 'برچسب موبایل' , 'category_id' => 15 , 'brand_id' => 2 ]);
        Product::create([ 'title' => 'دوربین موبایل' , 'category_id' => 15 , 'brand_id' => 3 ]);

        // Product::create([ 'title' => '' , 'category_id' => 1 , 'brand_id' => 1 ]);

        // Product::create([
        //     'title' => '' ,
        //     'image_url' => '' ,
        //     'technical_specs' => '' ,
        //     'physical_specs' => '' ,
        // ]);
    }
}
