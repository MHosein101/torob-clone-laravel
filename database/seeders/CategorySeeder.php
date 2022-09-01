<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        
        $p5 = Category::create([ "name" => "موبایل و کالای دیجیتال" , "is_top" => true ]);

        $p6 = Category::create([ "name" => "لوارم جانبی موبایل و تبلت" , "is_top" => true, "parent_id" => $p5->id ]);
        Category::create([ "name" => "کیف و کاور گوشی" , "is_top" => false, "parent_id" => $p6->id ]);
        Category::create([ "name" => "شارژر" , "is_top" => false, "parent_id" => $p6->id ]);
        Category::create([ "name" => "کابل و تبدیل" , "is_top" => false, "parent_id" => $p6->id ]);
        Category::create([ "name" => "محافظ لنز دوربین" , "is_top" => false, "parent_id" => $p6->id ]);

        $p7 = Category::create([ "name" => "قطعات موبایل و تبلت" , "is_top" => true, "parent_id" => $p5->id ]);
        Category::create([ "name" => "کی پد گوشی" , "is_top" => false, "parent_id" => $p7->id ]);
        Category::create([ "name" => "باتری گوشی موبایل" , "is_top" => false, "parent_id" => $p7->id ]);
        Category::create([ "name" => "ویبره گوشی" , "is_top" => false, "parent_id" => $p7->id ]);
        Category::create([ "name" => "دوربین گوشی و تبلت" , "is_top" => false, "parent_id" => $p7->id ]);
        Category::create([ "name" => "برد گوشی" , "is_top" => false, "parent_id" => $p7->id ]);

        $p1 = Category::create([ "name" => "کفش و پوشاک" , "is_top" => true ]);
        
        $p2 = Category::create([ "name" => "مردانه" , "is_top" => true, "parent_id" => $p1->id ]);
        Category::create([ "name" => "کفش مردانه" , "is_top" => false, "parent_id" => $p2->id ]);
        Category::create([ "name" => "پیراهن و تیشرت مردانه" , "is_top" => false, "parent_id" => $p2->id ]);
        Category::create([ "name" => "کت و شلوار مردانه" , "is_top" => false, "parent_id" => $p2->id ]);

        $p3 = Category::create(["name" => "زنانه" , "is_top" => true, "parent_id" => $p1->id ]);
        Category::create([ "name" => "کفش زنانه" , "is_top" => false, "parent_id" => $p3->id ]);
        Category::create([ "name" => "مانتو و شال و روسری زنانه" , "is_top" => false, "parent_id" => $p3->id ]);
        
        $p4 = Category::create([ "name" => "زیبایی  و بهداشتی" , "is_top" => true ]);

        $p8 = Category::create([ "name" => "بهداشت دهان و دندان" , "is_top" => false, "parent_id" => $p4->id ]);
        Category::create([ "name" => "مسواک" , "is_top" => false, "parent_id" => $p8->id ]);
        Category::create([ "name" => "خمیر داندان" , "is_top" => false, "parent_id" => $p8->id ]);

        Category::create([ "name" => "تجهیزات آرایشی" , "is_top" => false, "parent_id" => $p4->id ]);

        // $p5 = Category::create([ "name" => "" , "is_top" => true ]);
        // $p5 = Category::create([ "name" => "" , "is_top" => false, "parent_id" => $p5->id ]);
        // Category::create([ "name" => "" , "is_top" => false, "parent_id" => $p5->id ]);
    }
}
