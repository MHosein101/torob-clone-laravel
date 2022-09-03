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
        Product::create([ 'title' => 'گوشی سامسونگ A13' , 'brand_id' => 1 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/YN/eE/YNeE9lEi7HLnRidI.png_/0x145.jpg' ]); // 1
        Product::create([ 'title' => 'گوشی سامسونگ A53 5G'  , 'brand_id' => 1 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/fj/js/fjjsB-fYMvuvDlZx.png_/0x145.jpg' ]); // 2
        Product::create([ 'title' => 'گوشی اپل iPhone 13 Pro' , 'brand_id' => 3 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/Np/T-/NpT-mU7_pyaDS9BX.jpg_/0x145.jpg' ]); // 3
        Product::create([ 'title' => 'گوشی شیاعومی Redmi Note 11' , 'brand_id' => 2 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/FP/Ca/FPCaA-ZEqqnyNFsh.png_/0x145.jpg' ]); // 4

        Product::create([ 'title' => 'پردازنده Core i5-12400F Alder Lake' , 'brand_id' => 6 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/KE/rG/KErGQXp4DEhcwi0x.jpg_/0x145.jpg' ]); // 5
        Product::create([ 'title' => 'پردازنده Core i3-10100H'  , 'brand_id' => 6 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/RX/e8/RXe8ZCsHzl9w6Hg-.jpeg_/0x145.jpg' ]); // 6
        Product::create([ 'title' => 'پردازنده Ryzen 9 5900X' , 'brand_id' => 7 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/FP/Wn/FPWn3CzZgxSaZZLu.jpg_/0x145.jpg' ]); // 7
        
        Product::create([ 'title' => 'کارت گرافیک Nvidia GTX1060 3GB' , 'brand_id' => 10 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/BV/C_/BVC_FQYE_XshX_0Z_/0x145.jpg' ]); // 8
        Product::create([ 'title' => 'کارت گرافیک RTX 2060 6GB' , 'brand_id' => 11 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/_8/CL/_8CLqDxw-fAyzyGp.jpg_/0x145.jpg' ]); // 9

        Product::create([ 'title' => 'کیبورد گیمینگ تسکو TSCO TK8124GA Gaming' , 'brand_id' => 8 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/6f/uZ/6fuZlT_rW4CPGH6d.jpg_/0x145.jpg' ]); // 10
        Product::create([ 'title' => 'ماوس گیمینگ لاجیتک G502 HERO' , 'brand_id' => 8 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/xn/gh/xnghPNRl-yapJlfD.jpg_/0x145.jpg' ]); // 11

        // Product::create([ 'title' => '' , 'category_id' => 1 , 'brand_id' => 1 ]);

        // Product::create([
        //     'title' => '' ,
        //     'image_url' => '' ,
        //     'technical_specs' => '' ,
        //     'physical_specs' => '' ,
        // ]);
    }
}
