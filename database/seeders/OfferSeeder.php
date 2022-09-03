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


        Offer::create([ 'product_id' => 5 , 'shop_id' => 1 , 'is_available' => true , 'price' => 3000 ]);
        Offer::create([ 'product_id' => 5 , 'shop_id' => 2 , 'is_available' => true , 'price' => 3200 ]);
        Offer::create([ 'product_id' => 5 , 'shop_id' => 3 , 'is_available' => false , 'price' => 2900 ]);

        Offer::create([ 'product_id' => 6 , 'shop_id' => 1 , 'is_available' => false , 'price' => 2500 ]);
        Offer::create([ 'product_id' => 6 , 'shop_id' => 2 , 'is_available' => false , 'price' => 1900 ]);
        Offer::create([ 'product_id' => 6 , 'shop_id' => 3 , 'is_available' => false , 'price' => 1900 ]);

        Offer::create([ 'product_id' => 7 , 'shop_id' => 1 , 'is_available' => true , 'price' => 4000 ]);
        Offer::create([ 'product_id' => 7 , 'shop_id' => 3 , 'is_available' => true , 'price' => 3900 ]);

        Offer::create([ 'product_id' => 8 , 'shop_id' => 1 , 'is_available' => true , 'price' => 15000 ]);
        Offer::create([ 'product_id' => 8 , 'shop_id' => 2 , 'is_available' => true , 'price' => 11000 ]);
        Offer::create([ 'product_id' => 8 , 'shop_id' => 3 , 'is_available' => true , 'price' => 17000 ]);

        Offer::create([ 'product_id' => 9 , 'shop_id' => 1 , 'is_available' => true , 'price' => 21000 ]);
        Offer::create([ 'product_id' => 9 , 'shop_id' => 2 , 'is_available' => true , 'price' => 22000 ]);
        Offer::create([ 'product_id' => 9 , 'shop_id' => 3 , 'is_available' => true , 'price' => 19000 ]);

        Offer::create([ 'product_id' => 10 , 'shop_id' => 1 , 'is_available' => true , 'price' => 130 ]);
        Offer::create([ 'product_id' => 10 , 'shop_id' => 2 , 'is_available' => true , 'price' => 150 ]);
        Offer::create([ 'product_id' => 10 , 'shop_id' => 3 , 'is_available' => true , 'price' => 200 ]);

        Offer::create([ 'product_id' => 11 , 'shop_id' => 1 , 'is_available' => true , 'price' => 90 ]);
        Offer::create([ 'product_id' => 11 , 'shop_id' => 2 , 'is_available' => true , 'price' => 120 ]);
        Offer::create([ 'product_id' => 11 , 'shop_id' => 3 , 'is_available' => true , 'price' => 100 ]);


        // Offer::create([ 'product_id' => 1 , 'shop_id' => 1 , 'is_available' => true , 'price' => 1000 ]);
    }
}
