<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        
        $c1 = Category::create([ "name" => "موبایل و کالای دیجیتال" , "level" => 1 ]); // 1

        $c11 = Category::create([ "name" => "گوشی موبایل" , "level" => 2, "parent_id" => $c1->id ]); // 2

        $c12 = Category::create([ "name" => "لوازم جانبی موبایل و تبلت" , "level" => 2, "parent_id" => $c1->id ]); // 3
        Category::create([ "name" => "کیف و کاور گوشی" , "level" => 3, "parent_id" => $c12->id ]); // 4
        Category::create([ "name" => "شارژر" , "level" => 3, "parent_id" => $c12->id ]); // 5
        Category::create([ "name" => "کابل و تبدیل" , "level" => 3, "parent_id" => $c12->id ]); // 6
        Category::create([ "name" => "محافظ لنز دوربین" , "level" => 3, "parent_id" => $c12->id ]); // 7

        $c2 = Category::create([ "name" => "لپ‌تاپ کامپیوتر اداری" , "level" => 1 ]); // 8

        $c21 = Category::create([ "name" => "قطعات داخلی کامپیوتر و لپ تاپ" , "level" => 2, "parent_id" => $c2->id ]); // 9
        Category::create([ "name" => "پردازنده" , "level" => 3, "parent_id" => $c21->id ]); // 10
        Category::create([ "name" => "مادربورد" , "level" => 3, "parent_id" => $c21->id ]); // 11
        Category::create([ "name" => "کارت گرافیک" , "level" => 3, "parent_id" => $c21->id ]); // 12
        
        $c22 = Category::create([ "name" => "لوازم جانبی کامپیوتر و لپ تاپ" , "level" => 2, "parent_id" => $c2->id ]); // 13
        Category::create([ "name" => "کیبورد" , "level" => 3, "parent_id" => $c22->id ]); // 14
        Category::create([ "name" => "ماوس" , "level" => 3, "parent_id" => $c22->id ]); // 15
        Category::create([ "name" => "شارژر لپتاپ" , "level" => 3, "parent_id" => $c22->id ]); // 16

        $c3 = Category::create([ "name" => "مد و پوشاک" , "level" => 1 ]); // 17
        
        $c31 = Category::create([ "name" => "پوشاک و کفش مردانه" , "level" => 2, "parent_id" => $c3->id ]); // 18
        Category::create([ "name" => "ژاکت و پلیور مردانه" , "level" => 3, "parent_id" => $c31->id ]); // 19
        Category::create([ "name" => "پیراهن مردانه" , "level" => 3, "parent_id" => $c31->id ]); // 20
        Category::create([ "name" => "شلوارک مردانه" , "level" => 3, "parent_id" => $c31->id ]); // 21

        $c32 = Category::create(["name" => "پوشاک و کفش زنانه" , "level" => 2, "parent_id" => $c3->id ]); // 22
        Category::create([ "name" => "شلوار و سرهمی زنانه" , "level" => 3, "parent_id" => $c32->id ]); // 23
        Category::create([ "name" => "کفش و صندل زنانه" , "level" => 3, "parent_id" => $c32->id ]); // 24

        // $c1 = Category::create([ "name" => "" , "level" => true ]);
        // $c2 = Category::create([ "name" => "" , "level" => true, "parent_id" => $c1->id ]);
        // Category::create([ "name" => "" , "level" => 3, "parent_id" => $c2->id ]);
    }
}
