<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {

        $testSpecs = '[{"title":"مشخصات کلی","details":[{"name":"تاریخ ساخت","value":"2022"},{"name":"وزن","value":"9999 kg"}]},{"title":"مشخصات فنی","details":[{"name":"ویژگی اول","value":"test"},{"name":"ویژگی دوم","value":"example"}]}]';
        
        $mobilesData = [
            [
                'brand' => 1 ,
                'title' => ['گوشی سامسونگ Samsung Galaxy A13 ', 'گوشی سامسونگ Samsung Galaxy A53 5G', 'گوشی سامسونگ Samsung Galaxy A32', 'گوشی سامسونگ Samsung Galaxy A23'] ,
                'specs' => $testSpecs ,
                'image_url' => [
                    'https://storage.torob.com/backend-api/base/images/HV/CK/HVCKsnIFC3pva98_.png_/216x216.jpg' ,
                    'https://storage.torob.com/backend-api/base/images/fj/js/fjjsB-fYMvuvDlZx.png_/216x216.jpg' ,
                    'https://storage.torob.com/backend-api/base/images/uy/h1/uyh10UKKmYFAy-sf.png_/216x216.jpg' ,
                    'https://storage.torob.com/backend-api/base/images/Bm/rg/Bmrg38BQ25lRXXrO.png_/216x216.jpg' ,
                ]
            
            ] ,
            [
                'brand' => 2 ,
                'title' => ['گوشی شیائومی Xiaomi Redmi Note 11 Pro', 'گوشی شیائومی 11 Xiaomi T Pro 5G', 'گوشی شیائومی Xiaomi Poco X4 Pro 5G', 'گوشی شیائومی Xiaomi Redmi Note 11'] ,
                'specs' => $testSpecs ,
                'image_url' => [
                    'https://storage.torob.com/backend-api/base/images/9k/-0/9k-0oee4Ef97gwiM.png_/216x216.jpg' ,
                    'https://storage.torob.com/backend-api/base/images/G6/KB/G6KBdNfxV7YniYJL.png_/216x216.jpg' ,
                    'https://storage.torob.com/backend-api/base/images/m4/xA/m4xABtrWlalKKoj3.png_/216x216.jpg' ,
                    'https://storage.torob.com/backend-api/base/images/FP/Ca/FPCaA-ZEqqnyNFsh.png_/216x216.jpg' ,
                ]
            
            ] ,
            [
                'brand' => 3 ,
                'title' => ['گوشی اپل Apple iPhone 13', 'گوشی اپل (استوک) Apple iPhone 11', 'گوشی اپل Apple iPhone 13 Pro max (Active)', 'گوشی اپل (استوک) Apple iPhone 11 Pro'] ,
                'specs' => $testSpecs ,
                'image_url' => [
                    'https://storage.torob.com/backend-api/base/images/Tn/Gu/TnGu_-6l-Qxx9Ylo.png_/216x216.jpg' ,
                    'https://storage.torob.com/backend-api/base/images/js/ph/jsphrWJtL2N0dGgW.jpg_/216x216.jpg' ,
                    'https://storage.torob.com/backend-api/base/images/1f/rT/1frTfnitWG0HcxjR.png_/216x216.jpg' ,
                    'https://storage.torob.com/backend-api/base/images/Fd/yV/FdyVmdLOXkmYvMi-.png_/216x216.jpg' ,
                ]
            
            ]
        ];

        foreach($mobilesData as $md) {
            for($i = 0; $i < 4; $i++) {
                Product::customCreate([
                    'title' => $md['title'][$i] , 
                    'model_trait' => '' ,
                    'brand_id' => $md['brand'] , 
                    'specs' => $testSpecs ,
                    'image_url' => $md['image_url'][$i]
                ]);
            }
        }

        $data = [
            [ 
                'title' => 'گوشی هوآوی Y9a | حافظه 128 رم 6 | Huawei Y9a' , 
                'model_id' => 1 ,
                'model_trait' => "128 GB - 6 GB" ,
                'brand_id' => 4 , 
                'specs' => $testSpecs ,
                'image_url' => 'https://storage.torob.com/backend-api/base/images/F8/gR/F8gRPsWAz0G7n4Ae.jpg_/216x216.jpg' 
            ] ,
            [ 
                'title' => 'گوشی هوآوی Y9a | حافظه 128 رم 8 | Huawei Y9a' , 
                'model_id' => 1 ,
                'model_trait' => "128 GB - 8 GB" ,
                'brand_id' => 4 , 
                'specs' => $testSpecs ,
                'image_url' => 'https://storage.torob.com/backend-api/base/images/Ye/rr/YerrJKWonvOCYlnt.jpg_/216x216.jpg' 
            ] ,
            [ 
                'title' => 'گوشی هوآوی Y9a | حافظه 265 رم 8 | Huawei Y9a' , 
                'model_id' => 1 ,
                'model_trait' => "256 GB - 8 GB" ,
                'brand_id' => 4 , 
                'specs' => $testSpecs ,
                'image_url' => 'https://storage.torob.com/backend-api/base/images/RO/Yp/ROYpbXL9AKDSrR9i.jpg_/216x216.jpg' 
            ]
        ];

        foreach($data as $set)
            Product::customCreate($set);

    }
}
