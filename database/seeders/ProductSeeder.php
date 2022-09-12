<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {

        $testSpecs = '[{"title":"مشخصات کلی","details":[{"name":"تاریخ ساخت","value":"2022"},{"name":"وزن","value":"9999 kg"}]},{"title":"مشخصات فنی","details":[{"name":"ویژگی اول","value":"test"},{"name":"ویژگی دوم","value":"example"}]}]';

        $data = [
            [ 
                'title' => 'گوشی شیائومی Poco X4 Pro 5G حافظه 256 رم 8 گیگابایت Xiaomi Poco X4 Pro 5G 256,8 GB' , 
                'model_name' => 'Xiaomi Poco X4 Pro' , 'model_trait' => '256 GB - 8 GB' ,
                'brand_id' => 2 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/m4/xA/m4xABtrWlalKKoj3.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی هوآوی Y9a حافظه 265 رم 8 Huawei Y9a' , 
                'model_name' => 'Huawei Y9a' , 'model_trait' => '256 GB - 8 GB' ,
                'brand_id' => 4 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/RO/Yp/ROYpbXL9AKDSrR9i.jpg_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی سامسونگ A13 حافظه 64 رم 4 گیگابایت Samsung Galaxy A13 64,4 GB' , 
                'model_name' => 'Samsung Galaxy A13' , 'model_trait' => '64 GB - 4 GB' ,
                'brand_id' => 1 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/YN/eE/YNeE9lEi7HLnRidI.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی سامسونگ A13 حافظه 128 رم 6 گیگابایت Samsung Galaxy A13 128,6 GB' , 
                'model_name' => 'Samsung Galaxy A13' , 'model_trait' => '128 GB - 6 GB' ,
                'brand_id' => 1 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/bc/6n/bc6n_-XAH0yDDLd9.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی هوآوی Y9a حافظه 128 رم 6 Huawei Y9a' , 
                'model_name' => 'Huawei Y9a' , 'model_trait' => '128 GB - 6 GB' ,
                'brand_id' => 4 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/F8/gR/F8gRPsWAz0G7n4Ae.jpg_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی سامسونگ A13 حافظه 32 رم 3 گیگابایت Samsung Galaxy A13 32,3 GB' , 
                'model_name' => 'Samsung Galaxy A13' , 'model_trait' => '32 GB - 3 GB' ,
                'brand_id' => 1 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/Zm/az/Zmazh826U1bOVkmb.jpg_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی سامسونگ A53 5G حافظه 256 رم 8 گیگابایت Samsung Galaxy A53 5G 256,8 GB' , 
                'model_name' => 'Samsung Galaxy A53' , 'model_trait' => '256 GB - 8 GB' ,
                'brand_id' => 1 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/fj/js/fjjsB-fYMvuvDlZx.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی سامسونگ A53 5G حافظه 128 رم 8 گیگابایت Samsung Galaxy A53 5G 128,8 GB' , 
                'model_name' => 'Samsung Galaxy A53' , 'model_trait' => '128 GB - 8 GB' ,
                'brand_id' => 1 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/j5/MN/j5MNg789WK-6ZR3L.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل iPhone 13 Pro max (Not Active) حافظه 128 گیگابایت Apple iPhone 13 Pro max (Not Active) 128 GB' , 
                'model_name' => 'Apple iPhone 13 Pro max' , 'model_trait' => '128 GB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/T9/rc/T9rctxsw6OmLjpf9.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی سامسونگ A52s 5G حافظه 256 رم 8 گیگابایت Samsung Galaxy A52s 5G 256,8 GB' , 
                'model_name' => 'Samsung Galaxy A52s' , 'model_trait' => '256 GB - 8 GB' ,
                'brand_id' => 1 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/Dp/Cl/DpClEshiODN4-EPP.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی سامسونگ A22 5G حافظه 64 رم 4 گیگابایت Samsung Galaxy A22 5G 64,4 GB' , 
                'model_name' => 'Samsung Galaxy A22' , 'model_trait' => '64 GB - 4 GB' ,
                'brand_id' => 1 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/fR/or/fRorgfFcoi6vfFUx.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی شیائومی Redmi Note 11 Pro حافظه 128 رم 8 گیگابایت Xiaomi Redmi Note 11 Pro 128,8 GB' , 
                'model_name' => 'Xiaomi Redmi Note 11 Pro' , 'model_trait' => '128 GB - 8 GB' ,
                'brand_id' => 2 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/9k/-0/9k-0oee4Ef97gwiM.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی سامسونگ A13 حافظه 128 رم 4 گیگابایت Samsung Galaxy A13 128,4 GB' , 
                'model_name' => 'Samsung Galaxy A13' , 'model_trait' => '128 GB - 4 GB' ,
                'brand_id' => 1 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/HV/CK/HVCKsnIFC3pva98_.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی شیائومی Poco X4 Pro 5G حافظه 128 رم 8 گیگابایت Xiaomi Poco X4 Pro 5G 128,8 GB' , 
                'model_name' => 'Xiaomi Poco X4 Pro' , 'model_trait' => '128 GB - 8 GB' ,
                'brand_id' => 2 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/ly/LY/lyLYu_0NOEbK9coP.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی شیائومی 11T Pro 5G حافظه 256 رم 8 گیگابایت Xiaomi 11T Pro 5G 256,8 GB' , 
                'model_name' => 'Xiaomi 11T Pro' , 'model_trait' => '256 GB - 8 GB' ,
                'brand_id' => 2 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/j8/4Y/j84Ygn3ILvJ8h47b.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی شیائومی Redmi Note 10 Pro حافظه 128 رم 8 گیگابایت Xiaomi Redmi Note 10 Pro 128,8 GB' , 
                'model_name' => 'Xiaomi Redmi Note 10 Pro' , 'model_trait' => '128 GB - 8 GB' ,
                'brand_id' => 2 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/EY/9T/EY9T7ce20FIs7Yoz.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل iPhone 13 Pro Max (Not Active) حافظه 512 گیگابایت Apple iPhone 13 Pro Max (Not Active) 512 GB' , 
                'model_name' => 'Apple iPhone 13 Pro max' , 'model_trait' => '512 GB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/1f/rT/1frTfnitWG0HcxjR.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی شیائومی Redmi Note 10 Pro حافظه 64 رم 6 گیگابایت Xiaomi Redmi Note 10 Pro 64,6 GB' , 
                'model_name' => 'Xiaomi Redmi Note 10 Pro' , 'model_trait' => '64 GB - 8 GB' ,
                'brand_id' => 2 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/oP/Zp/oPZp9pNeMHHSdjG8.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل (استوک) iPhone XS حافظه 256 گیگابایت Apple iPhone XS (Stock) 256 GB' , 
                'model_name' => 'Apple iPhone XS' , 'model_trait' => '256 GB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/YY/eC/YYeCpM24pg_wIZNb.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی هوآوی nova Y70 حافظه 128 رم 4 گیگابایت Huawei nova Y70 128,4 GB' , 
                'model_name' => 'Huawei nova Y70' , 'model_trait' => '128 GB - 4 GB' ,
                'brand_id' => 4 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/hH/TD/hHTDbJPQUZcaFhsl.jpg_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی هواوی P50 Pro حافظه 256 رم 8 گیگابایت Huawei P50 Pro 256,8 GB' , 
                'model_name' => 'Huawei P50 Pro' , 'model_trait' => '256 GB - 8 GB' ,
                'brand_id' => 4 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/N7/_p/N7_pJLrHD_LHgmlP.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی هواوی P50 Pro حافظه 128 رم 8 گیگابایت Huawei P50 Pro 128,8 GB' , 
                'model_name' => 'Huawei P50 Pro' , 'model_trait' => '128 GB - 8 GB' ,
                'brand_id' => 4 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/Ck/NB/CkNBB1J8cgP9JGFU.jpg_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی هوآوی Y7 Prime 2019 حافظه 32 رم 3 گیگابایت Huawei Y7 Prime 2019 32,3 GB' , 
                'model_name' => 'Huawei Y7 Prime' , 'model_trait' => '32 GB - 3 GB' ,
                'brand_id' => 4 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/xH/ms/xHmsDRR8dUByiurL.gif_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل iPhone 13 Pro Max (Not Active) حافظه 1 ترابایت Apple iPhone 13 Pro Max (Not Active) 1 TB' , 
                'model_name' => 'Apple iPhone 13 Pro max' , 'model_trait' => '1 TB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/7R/Ys/7RYsNFTK_HoYm_ov.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل iPhone SE 2022 (Active) حافظه 128 گیگابایت Apple iPhone SE 2022 (Active) 128 GB' , 
                'model_name' => 'Apple iPhone SE' , 'model_trait' => '128 GB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/kN/9Q/kN9Q19w6ay4dEHLg.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل iPhone SE 2022 (Active) حافظه 64 گیگابایت Apple iPhone SE 2022 (Active) 64 GB' , 
                'model_name' => 'Apple iPhone SE' , 'model_trait' => '64 GB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/V6/w4/V6w4KhdieEDbi1Sv.jpg_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی شیائومی Redmi Note 10 pro حافظه 128 رم 6 گیگابایت Xiaomi Redmi Note 10 Pro 128,6 GB' , 
                'model_name' => 'Xiaomi Redmi Note 10 Pro' , 'model_trait' => '128 GB - 6 GB' ,
                'brand_id' => 2 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/oP/Zp/oPZp9pNeMHHSdjG8.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل (استوک) iPhone 11 حافظه 128 گیگابایت Apple iPhone 11 (Stock) 128 GB' , 
                'model_name' => 'Apple iPhone 11' , 'model_trait' => '128 GB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/js/ph/jsphrWJtL2N0dGgW.jpg_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل iPhone 12 Pro Max (Active) حافظه 256 گیگابایت Apple iPhone 12 Pro Max (Active) 256 GB' , 
                'model_name' => 'Apple iPhone 12 Pro Max' , 'model_trait' => '256 GB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/19/u5/19u52NibQbI2noGU.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی سامسونگ A73 5G حافظه 256 رم 8 گیگابایت Samsung Galaxy A73 5G 256,8 GB' , 
                'model_name' => 'Samsung Galaxy A73' , 'model_trait' => '256 GB - 8 GB' ,
                'brand_id' => 1 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/hL/1l/hL1lYgtDlYCuXtJn.png_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل iPhone 12 Pro Max (Active) حافظه 512 گیگابایت Apple iPhone 12 Pro Max (Active) 512 GB' , 
                'model_name' => 'Apple iPhone 12 Pro Max' , 'model_trait' => '512 GB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/PH/yP/PHyPrknXiVDAnrAi.jpg_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی هوآوی Y9a حافظه 128 رم 8 Huawei Y9a' , 
                'model_name' => 'Huawei Y9a' , 'model_trait' => '128 GB - 8 GB' ,
                'brand_id' => 4 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/Ye/rr/YerrJKWonvOCYlnt.jpg_/216x216.jpg']
            ] ,
            [ 
                'title' => 'گوشی اپل iPhone 13 Pro max (Not Active) حافظه 256 گیگابایت Apple iPhone 13 Pro max (Not Active) 256 GB' , 
                'model_name' => 'Apple iPhone 13 Pro max' , 'model_trait' => '256 GB' ,
                'brand_id' => 3 , 'category_ids' => [1, 2] ,
                'specs' => $testSpecs ,
                'images' => ['https://storage.torob.com/backend-api/base/images/Np/T-/NpT-mU7_pyaDS9BX.jpg_/216x216.jpg']
            ] ,
        ];
        
        foreach($data as $set)
            Product::customCreate($set);
        
    }
}
