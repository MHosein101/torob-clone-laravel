<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        
        $c1 = Category::create([ "name" => "موبایل و کالای دیجیتال" , "is_parent" => true ]); // 1

        $c11 = Category::create([ "name" => "گوشی موبایل" , "is_parent" => true, "parent_id" => $c1->id ]); // 2

        $c12 = Category::create([ "name" => "لوازم جانبی موبایل و تبلت" , "is_parent" => true, "parent_id" => $c1->id ]); // 3
        Category::create([ "name" => "کیف و کاور گوشی" , "is_parent" => false, "parent_id" => $c12->id ]); // 4
        Category::create([ "name" => "شارژر" , "is_parent" => false, "parent_id" => $c12->id ]); // 5
        Category::create([ "name" => "کابل و تبدیل" , "is_parent" => false, "parent_id" => $c12->id ]); // 6
        Category::create([ "name" => "محافظ لنز دوربین" , "is_parent" => false, "parent_id" => $c12->id ]); // 7

        $c2 = Category::create([ "name" => "لپ‌تاپ کامپیوتر اداری" , "is_parent" => true ]); // 8

        $c21 = Category::create([ "name" => "قطعات داخلی کامپیوتر و لپ تاپ" , "is_parent" => true, "parent_id" => $c2->id ]); // 9
        Category::create([ "name" => "پردازنده" , "is_parent" => false, "parent_id" => $c21->id ]); // 10
        Category::create([ "name" => "مادربورد" , "is_parent" => false, "parent_id" => $c21->id ]); // 11
        Category::create([ "name" => "کارت گرافیک" , "is_parent" => false, "parent_id" => $c21->id ]); // 12
        
        $c22 = Category::create([ "name" => "لوازم جانبی کامپیوتر و لپ تاپ" , "is_parent" => true, "parent_id" => $c2->id ]); // 13
        Category::create([ "name" => "کیبورد" , "is_parent" => false, "parent_id" => $c22->id ]); // 14
        Category::create([ "name" => "ماوس" , "is_parent" => false, "parent_id" => $c22->id ]); // 15
        Category::create([ "name" => "شارژر لپتاپ" , "is_parent" => false, "parent_id" => $c22->id ]); // 16

        $c3 = Category::create([ "name" => "مد و پوشاک" , "is_parent" => true ]); // 17
        
        $c31 = Category::create([ "name" => "پوشاک و کفش مردانه" , "is_parent" => true, "parent_id" => $c3->id ]); // 18
        Category::create([ "name" => "ژاکت و پلیور مردانه" , "is_parent" => false, "parent_id" => $c31->id ]); // 19
        Category::create([ "name" => "پیراهن مردانه" , "is_parent" => false, "parent_id" => $c31->id ]); // 20
        Category::create([ "name" => "شلوارک مردانه" , "is_parent" => false, "parent_id" => $c31->id ]); // 21

        $c32 = Category::create(["name" => "پوشاک و کفش زنانه" , "is_parent" => true, "parent_id" => $c3->id ]); // 22
        Category::create([ "name" => "شلوار و سرهمی زنانه" , "is_parent" => false, "parent_id" => $c32->id ]); // 23
        Category::create([ "name" => "کفش و صندل زنانه" , "is_parent" => false, "parent_id" => $c32->id ]); // 24

        // $c1 = Category::create([ "name" => "" , "is_parent" => true ]);
        // $c2 = Category::create([ "name" => "" , "is_parent" => true, "parent_id" => $c1->id ]);
        // Category::create([ "name" => "" , "is_parent" => false, "parent_id" => $c2->id ]);
    }
}
