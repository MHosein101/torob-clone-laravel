<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Offer::create([
            'product_id' => 1 , 'shop_id' => 1 ,
            'is_available' => true , 'price' => 1000
        ]);
        Offer::create([
            'product_id' => 1 , 'shop_id' => 2 ,
            'is_available' => true , 'price' => 2000
        ]);
        
        Offer::create([
            'product_id' => 2 , 'shop_id' => 1 ,
            'is_available' => true , 'price' => 2000
        ]);
        Offer::create([
            'product_id' => 2 , 'shop_id' => 2 ,
            'is_available' => false , 'price' => 1000
        ]);
        Offer::create([
            'product_id' => 2 , 'shop_id' => 3 ,
            'is_available' => true , 'price' => 2010
        ]);
        
        Offer::create([
            'product_id' => 3 , 'shop_id' => 2 ,
            'is_available' => true , 'price' => 3000
        ]);
        
        Offer::create([
            'product_id' => 4 , 'shop_id' => 1 ,
            'is_available' => false , 'price' => 3000
        ]);
        Offer::create([
            'product_id' => 4 , 'shop_id' => 2 ,
            'is_available' => false , 'price' => 3400
        ]);
    }
}
