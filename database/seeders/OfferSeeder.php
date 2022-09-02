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
        
        Offer::create([ 'product_id' => 3 , 'shop_id' => 1 , 'is_available' => false , 'price' => 21000 ]);
        Offer::create([ 'product_id' => 3 , 'shop_id' => 2 , 'is_available' => false , 'price' => 19000 ]);

        Offer::create([ 'product_id' => 4 , 'shop_id' => 1 , 'is_available' => true , 'price' => 5000 ]);
        Offer::create([ 'product_id' => 4 , 'shop_id' => 2 , 'is_available' => false , 'price' => 4000 ]);
        Offer::create([ 'product_id' => 4 , 'shop_id' => 3 , 'is_available' => true , 'price' => 4500 ]);

        Offer::create([ 'product_id' => 2 , 'shop_id' => 1 , 'is_available' => true , 'price' => 8000 ]);
        Offer::create([ 'product_id' => 2 , 'shop_id' => 2 , 'is_available' => true , 'price' => 6000 ]);
        Offer::create([ 'product_id' => 2 , 'shop_id' => 3 , 'is_available' => true , 'price' => 7000 ]);

        Offer::create([ 'product_id' => 1 , 'shop_id' => 3 , 'is_available' => true , 'price' => 9000 ]);

        // Offer::create([ 'product_id' => 1 , 'shop_id' => 1 , 'is_available' => true , 'price' => 1000 ]);
    }
}
