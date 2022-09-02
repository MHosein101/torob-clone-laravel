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

        Brand::create([ 'name' => 'سامسونگ' , 'name_english' => 'Samsung' ]); // 1
        Brand::create([ 'name' => 'شیاعومی' , 'name_english' => 'Xiaomi' ]); // 2
        Brand::create([ 'name' => 'اپل' , 'name_english' => 'Apple' ]); // 3
        Brand::create([ 'name' => 'هوآوی' , 'name_english' => 'Huawei' ]); // 4
        Brand::create([ 'name' => 'توکیا' , 'name_english' => 'Nokia' ]); // 5

        Brand::create([ 'name' => 'اینتل' , 'name_english' => 'Intel' ]); // 6
        Brand::create([ 'name' => 'ای ام دی' , 'name_english' => 'AMD' ]); // 7
        
        Brand::create([ 'name' => 'ایسوس' , 'name_english' => 'ASUS' ]); // 8
        Brand::create([ 'name' => 'گیکابایت' , 'name_english' => 'GIGABYTE' ]); // 9
        Brand::create([ 'name' => 'انویدیا' , 'name_english' => 'NVIDIA' ]); // 10
        Brand::create([ 'name' => 'زوتک' , 'name_english' => 'ZOTAC' ]); // 11

        // Brand::create([ 'name' => '' , 'category_id' => 1 ]);
    }
}
