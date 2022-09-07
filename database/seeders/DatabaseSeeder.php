<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategorySeeder::class ,
            BrandSeeder::class ,
            CategoryBrandSeeder::class ,
            ProductModelSeeder::class ,
            ProductSeeder::class ,
            ProductCategorySeeder::class ,
            UserSeeder::class ,
            ShopSeeder::class ,
            FavoriteSeeder::class ,
            OfferSeeder::class ,
        ]);
        
    }
}
