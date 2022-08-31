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
        Brand::create([ 'name' => 'اپل' , 'category_id' => 14 ]);
        Brand::create([ 'name' => 'سامسونگ' , 'category_id' => 14 ]);
        Brand::create([ 'name' => 'هواوی' , 'category_id' => 14 ]);

        // Brand::create([ 'name' => '' , 'category_id' => 1 ]);
    }
}
