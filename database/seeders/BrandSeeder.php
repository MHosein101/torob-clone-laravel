<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'سامسونگ' , 'name_english' => 'Samsung' ] ,
            [ 'name' => 'شیاعومی' , 'name_english' => 'Xiaomi' ] ,
            [ 'name' => 'اپل' , 'name_english' => 'Apple' ] ,
            [ 'name' => 'هوآوی' , 'name_english' => 'Huawei' ] ,
            [ 'name' => 'توکیا' , 'name_english' => 'Nokia' ] ,

            [ 'name' => 'اینتل' , 'name_english' => 'Intel' ] ,
            [ 'name' => 'ای ام دی' , 'name_english' => 'AMD' ] ,

            [ 'name' => 'ایسوس' , 'name_english' => 'ASUS' ] ,
            [ 'name' => 'گیکابایت' , 'name_english' => 'GIGABYTE' ] ,
            [ 'name' => 'انویدیا' , 'name_english' => 'NVIDIA' ] ,
            [ 'name' => 'زوتک' , 'name_english' => 'ZOTAC' ] ,
        ];

        foreach($data as $set)
            Brand::create($set);
    }
}
