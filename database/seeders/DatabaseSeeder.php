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
            ProductSeeder::class ,
            ProductPricesChartSeeder::class ,
            UserSeeder::class ,
            ShopSeeder::class ,
            FavoriteSeeder::class ,
            OfferSeeder::class ,
            ShopOrderSeeder::class ,
            ShopOrderTrackingSeeder::class ,
        ]);
        
    }
}
