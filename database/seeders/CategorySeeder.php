<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{


    public function run()
    {
        // $data = [
        //     [
        //         'level' => 1 , 'name' => '' ,
        //         'sub' => [
        //             [ 'level' => 2 , 'name' => '' ] ,
        //             [ 
        //                 'level' => 2 , 'name' => '' ,
        //                 'sub' => [
        //                     [ 'level' => 3 , 'name' => '' ]
        //                 ]
        //             ]
        //         ]
        //     ]
        // ];


        $c1 = Category::create([ "name" => "موبایل و کالای دیجیتال" , "level" => 1 ]); // 1
            Category::create([ "name" => "گوشی موبایل" , "level" => 2, "parent_id" => $c1->id ]); // 2
            $c12 = Category::create([ "name" => "لوازم جانبی موبایل و تبلت" , "level" => 2, "parent_id" => $c1->id ]); // 3
                Category::create([ "name" => "کیف و کاور گوشی" , "level" => 3, "parent_id" => $c12->id ]); // 4
                Category::create([ "name" => "شارژر گوشی" , "level" => 3, "parent_id" => $c12->id ]); // 5
                $c13 = Category::create([ "name" => "کابل و تبدیل" , "level" => 3, "parent_id" => $c12->id ]); // 6
                    Category::create([ "name" => "کابل USB Type A" , "level" => 4, "parent_id" => $c13->id ]); // 7
                    Category::create([ "name" => "کابل USB Type C" , "level" => 4, "parent_id" => $c13->id ]); // 8
                    Category::create([ "name" => "کابل USB Micro" , "level" => 4, "parent_id" => $c13->id ]); // 9
                    
        $c2 = Category::create([ "name" => "لپ‌تاپ کامپیوتر اداری" , "level" => 1 ]); // 10
            $c21 = Category::create([ "name" => "قطعات داخلی کامپیوتر و لپ تاپ" , "level" => 2, "parent_id" => $c2->id ]); // 11
                $c211 = Category::create([ "name" => "پردازنده" , "level" => 3, "parent_id" => $c21->id ]); // 12
                    Category::create([ "name" => "پردازنده نسل دوازدهم" , "level" => 4, "parent_id" => $c211->id ]); // 13
                    Category::create([ "name" => "پردازنده نسل یازدهم" , "level" => 4, "parent_id" => $c211->id ]); // 14
                Category::create([ "name" => "مادربورد" , "level" => 3, "parent_id" => $c21->id ]); // 15
                Category::create([ "name" => "کارت گرافیک" , "level" => 3, "parent_id" => $c21->id ]);// 16
            $c22 = Category::create([ "name" => "لوازم جانبی کامپیوتر و لپ تاپ" , "level" => 2, "parent_id" => $c2->id ]);  // 17
                Category::create([ "name" => "کیبورد" , "level" => 3, "parent_id" => $c22->id ]); // 18
                Category::create([ "name" => "ماوس" , "level" => 3, "parent_id" => $c22->id ]); // 19
                $c23 = Category::create([ "name" => "شارژر و کابل پاور" , "level" => 3, "parent_id" => $c22->id ]); // 20
                    Category::create([ "name" => "شارژر لپتاپ" , "level" => 4, "parent_id" => $c23->id ]); // 21
                    Category::create([ "name" => "کابل پاور مانیتور" , "level" => 4, "parent_id" => $c23->id ]); // 22
                    Category::create([ "name" => "کابل پاور کیس" , "level" => 4, "parent_id" => $c23->id ]); // 23

        $c3 = Category::create([ "name" => "مد و پوشاک" , "level" => 1 ]);
            $c31 = Category::create([ "name" => "پوشاک و کفش مردانه" , "level" => 2, "parent_id" => $c3->id ]);
                Category::create([ "name" => "ژاکت و پلیور مردانه" , "level" => 3, "parent_id" => $c31->id ]);
                Category::create([ "name" => "پیراهن مردانه" , "level" => 3, "parent_id" => $c31->id ]);
                Category::create([ "name" => "شلوارک مردانه" , "level" => 3, "parent_id" => $c31->id ]); 
            $c32 = Category::create(["name" => "پوشاک و کفش زنانه" , "level" => 2, "parent_id" => $c3->id ]);
                Category::create([ "name" => "شلوار و سرهمی زنانه" , "level" => 3, "parent_id" => $c32->id ]);
                Category::create([ "name" => "کفش و صندل زنانه" , "level" => 3, "parent_id" => $c32->id ]);

        // $c1 = Category::create([ "name" => "" , "level" => 1 ]);
        // $c2 = Category::create([ "name" => "" , "level" => 2, "parent_id" => $c1->id ]);
        // Category::create([ "name" => "" , "level" => 3, "parent_id" => $c2->id ]);
    }
}
