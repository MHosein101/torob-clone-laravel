<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category_ids' => [ 2 ] ,
                'brands' => [
                    [ 'name' => 'سامسونگ' , 'name_english' => 'Samsung' ] ,
                    [ 'name' => 'شیاعومی' , 'name_english' => 'Xiaomi' ] ,
                    [ 'name' => 'اپل' , 'name_english' => 'Apple' ] ,
                    [ 'name' => 'هوآوی' , 'name_english' => 'Huawei' ] ,
                ]
            ] ,

            [
                'category_ids' => [ 12 ] ,
                'brands' => [
                    [ 'name' => 'اینتل' , 'name_english' => 'Intel' ] ,
                    [ 'name' => 'ای ام دی' , 'name_english' => 'AMD' ] ,
                ]
            ] ,
            [
                'category_ids' => [ 16 ] ,
                'brands' => [
                    [ 'name' => 'ایسوس' , 'name_english' => 'ASUS' ] ,
                    [ 'name' => 'گیکابایت' , 'name_english' => 'GIGABYTE' ] ,
                    [ 'name' => 'انویدیا' , 'name_english' => 'NVIDIA' ] ,
                    [ 'name' => 'زوتک' , 'name_english' => 'ZOTAC' ] ,
                ]
            ] ,
        ];

        foreach($data as $set)
            Brand::customCreate($set);
    }
}
