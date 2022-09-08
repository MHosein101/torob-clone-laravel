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

        // for($i = 0; $i < 30; $i++) {
        //     Product::create([ 'title' => 'گوشی سامسونگ A13' , 'brand_id' => 1 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/YN/eE/YNeE9lEi7HLnRidI.png_/0x145.jpg' ]); // 1
        //     Product::create([ 'title' => 'گوشی سامسونگ A53 5G'  , 'brand_id' => 1 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/fj/js/fjjsB-fYMvuvDlZx.png_/0x145.jpg' ]); // 2
        //     Product::create([ 'title' => 'گوشی اپل iPhone 13 Pro' , 'brand_id' => 3 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/Np/T-/NpT-mU7_pyaDS9BX.jpg_/0x145.jpg' ]); // 3
        //     Product::create([ 'title' => 'گوشی شیاعومی Redmi Note 11' , 'brand_id' => 2 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/FP/Ca/FPCaA-ZEqqnyNFsh.png_/0x145.jpg' ]); // 4
        // }

        $testSpecs = '[{"title":"مشخصات کلی","details":[{"name":"تاریخ ساخت","value":"Dec 2021"},{"name":"ابعاد","value":"164x77x9 mm"},{"name":"وزن","value":"197 g"},{"name":"قطر صفحه نمایش","value":"6.63 inch"},{"name":"دقت صفحه نمایش","value":"2400x1080 pixel"},{"name":"ظرفیت باتری","value":"4300 mAh"},{"name":"سیستم عامل","value":"Android 10 with EMUI 10"}]},{"title":"مشخصات فنی","details":[{"name":"پردازنده مرکزی","value":"Mediatek Helio G80 8core"},{"name":"پردازنده گرافیکی","value":"Mali-G52 MC2"},{"name":"حافظه داخلی","value":"128/256 GB"},{"name":"رم","value":"6/8 GB"},{"name":"نوع پورت","value":"USB Type C"},{"name":"دوربین","value":"64/16 MP"},{"name":"بلوتوث","value":"5.1"},{"name":"شبکه بی سیم","value":"GSM/HSPA/LTE"}]}]';

        Product::customCreate([ 
            'title' => 'گوشی هوآوی Y9a | حافظه 128 رم 6 | Huawei Y9a' , 
            'model_id' => 1 ,
            'model_trait' => "128 GB - 6 GB" ,
            'brand_id' => 4 , 
            'specs' => $testSpecs ,
            'image_url' => 'https://storage.torob.com/backend-api/base/images/F8/gR/F8gRPsWAz0G7n4Ae.jpg_/216x216.jpg' 
        ]);

        Product::customCreate([ 
            'title' => 'گوشی هوآوی Y9a | حافظه 128 رم 8 | Huawei Y9a' , 
            'model_id' => 1 ,
            'model_trait' => "128 GB - 8 GB" ,
            'brand_id' => 4 , 
            'specs' => $testSpecs ,
            'image_url' => 'https://storage.torob.com/backend-api/base/images/Ye/rr/YerrJKWonvOCYlnt.jpg_/216x216.jpg' 
        ]);

        Product::customCreate([ 
            'title' => 'گوشی هوآوی Y9a | حافظه 265 رم 8 | Huawei Y9a' , 
            'model_id' => 1 ,
            'model_trait' => "256 GB - 8 GB" ,
            'brand_id' => 4 , 
            'specs' => $testSpecs ,
            'image_url' => 'https://storage.torob.com/backend-api/base/images/RO/Yp/ROYpbXL9AKDSrR9i.jpg_/216x216.jpg' 
        ]);



        // Product::create([ 'title' => 'پردازنده Core i5-12400F Alder Lake' , 'brand_id' => 6 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/KE/rG/KErGQXp4DEhcwi0x.jpg_/0x145.jpg' ]); // 5
        // Product::create([ 'title' => 'پردازنده Core i3-11300K'  , 'brand_id' => 6 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/RX/e8/RXe8ZCsHzl9w6Hg-.jpeg_/0x145.jpg' ]); // 6
        // Product::create([ 'title' => 'پردازنده Ryzen 9 5900X' , 'brand_id' => 7 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/FP/Wn/FPWn3CzZgxSaZZLu.jpg_/0x145.jpg' ]); // 7
        
        // Product::create([ 'title' => 'کارت گرافیک Nvidia GTX1060 3GB' , 'brand_id' => 10 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/BV/C_/BVC_FQYE_XshX_0Z_/0x145.jpg' ]); // 8
        // Product::create([ 'title' => 'کارت گرافیک RTX 2060 6GB' , 'brand_id' => 11 , 'image_url' => 'https://storage.torob.com/backend-api/base/images/_8/CL/_8CLqDxw-fAyzyGp.jpg_/0x145.jpg' ]); // 9

        // Product::create([ 'title' => 'کیبورد گیمینگ تسکو TSCO TK8124GA Gaming' , 'image_url' => 'https://storage.torob.com/backend-api/base/images/6f/uZ/6fuZlT_rW4CPGH6d.jpg_/0x145.jpg' ]); // 10
        // Product::create([ 'title' => 'ماوس گیمینگ لاجیتک G502 HERO' , 'image_url' => 'https://storage.torob.com/backend-api/base/images/xn/gh/xnghPNRl-yapJlfD.jpg_/0x145.jpg' ]); // 11

        // Product::create([ 'title' => '' , 'category_id' => 1 , 'brand_id' => 1 ]);

        // Product::create([
        //     'title' => '' ,
        //     'image_url' => '' ,
        //     'technical_specs' => '' ,
        //     'physical_specs' => '' ,
        // ]);


    }
}
