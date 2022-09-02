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
        Product::create([ 'title' => 'گوشی سامسونگ A13' , 'brand_id' => 1 ]); // 1
        Product::create([ 'title' => 'گوشی سامسونگ A53 5G'  , 'brand_id' => 1 ]); // 2
        Product::create([ 'title' => 'گوشی اپل iPhone 13 Pro' , 'brand_id' => 3 ]); // 3
        Product::create([ 'title' => 'گوشی شیاعومی Redmi Note 11' , 'brand_id' => 2 ]); // 4

        Product::create([ 'title' => 'پردازنده Core i5-12400F Alder Lake' , 'brand_id' => 6 ]); // 5
        Product::create([ 'title' => 'پردازنده Core i3-10100H'  , 'brand_id' => 6 ]); // 6
        Product::create([ 'title' => 'پردازنده Ryzen 9 5900X' , 'brand_id' => 7 ]); // 7
        
        Product::create([ 'title' => 'کارت گرافیک Nvidia GTX1060 3GB' , 'brand_id' => 10 ]); // 8
        Product::create([ 'title' => 'کارت گرافیک RTX 2060 6GB' , 'brand_id' => 11 ]); // 9

        Product::create([ 'title' => 'کیبورد گیمینگ تسکو TSCO TK8124GA Gaming' , 'brand_id' => 8 ]); // 10
        Product::create([ 'title' => 'ماوس گیمینگ لاجیتک G502 HERO' , 'brand_id' => 8 ]); // 11

        // Product::create([ 'title' => '' , 'category_id' => 1 , 'brand_id' => 1 ]);

        // Product::create([
        //     'title' => '' ,
        //     'image_url' => '' ,
        //     'technical_specs' => '' ,
        //     'physical_specs' => '' ,
        // ]);
    }
}
