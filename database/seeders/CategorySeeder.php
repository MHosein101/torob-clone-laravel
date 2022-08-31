<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $p1 = Category::create([ "name" => "کفش و پوشاک" , "is_top" => true ]);
        
        $p2 = Category::create([ "name" => "مردانه" , "is_top" => true, "parent_id" => $p1->id ]);
        Category::create([ "name" => "کفش مردانه" , "is_top" => false, "parent_id" => $p2->id ]);
        Category::create([ "name" => "پیراهن و تیشرت مردانه" , "is_top" => false, "parent_id" => $p2->id ]);

        $p3 = Category::create(["name" => "زنانه" , "is_top" => true, "parent_id" => $p1->id ]);
        Category::create([ "name" => "کفش زنانه" , "is_top" => false, "parent_id" => $p3->id ]);
        Category::create([ "name" => "مانتو و شال و روسری زنانه" , "is_top" => false, "parent_id" => $p3->id ]);
        
        $p4 = Category::create([ "name" => "زیبایی  و بهداشتی" , "is_top" => true ]);
        Category::create([ "name" => "تجهیزات آرایشی" , "is_top" => false, "parent_id" => $p4->id ]);
        Category::create([ "name" => "بهداشت دهان و دندان" , "is_top" => false, "parent_id" => $p4->id ]);

    }
}
