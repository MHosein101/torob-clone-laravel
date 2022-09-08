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
        
        $data = [
            [ 'product_id' => 1 , 'shop_id' => 1 , 'is_available' => true , 'price' => 3000 , 'last_change_time' => (time() - random_int(10000, 999999)) ] ,
            [ 'product_id' => 1 , 'shop_id' => 2 , 'is_available' => true , 'price' => 3200 , 'last_change_time' => (time() - random_int(10000, 999999)) ] ,
            [ 'product_id' => 1 , 'shop_id' => 3 , 'is_available' => true , 'price' => 2900 , 'last_change_time' => (time() - random_int(10000, 999999)) ] ,
            
            [ 'product_id' => 2 , 'shop_id' => 1 , 'is_available' => true , 'price' => 3900 , 'last_change_time' => (time() - random_int(10000, 999999)) ] ,
            [ 'product_id' => 2 , 'shop_id' => 2 , 'is_available' => false , 'price' => 3700 , 'last_change_time' => (time() - random_int(10000, 999999)) ] ,
            [ 'product_id' => 2 , 'shop_id' => 3 , 'is_available' => true , 'price' => 3800 , 'last_change_time' => (time() - random_int(10000, 999999)) ] ,
            
            [ 'product_id' => 3 , 'shop_id' => 1 , 'is_available' => false , 'price' => 4300 , 'last_change_time' => (time() - random_int(10000, 999999)) ] ,
            [ 'product_id' => 3 , 'shop_id' => 2 , 'is_available' => false , 'price' => 4500 , 'last_change_time' => (time() - random_int(10000, 999999)) ] ,
            [ 'product_id' => 3 , 'shop_id' => 3 , 'is_available' => false , 'price' => 4100 , 'last_change_time' => (time() - random_int(10000, 999999)) ] ,
        ];

        foreach($data as $set)
            Offer::create($set);
        
        // for($i = 1; $i < 121; $i+=4) {
        //     Offer::create([ 'product_id' => ($i+2) , 'shop_id' => 1 , 'is_available' => false , 'price' => 21000 ]);
        //     Offer::create([ 'product_id' => ($i+2) , 'shop_id' => 2 , 'is_available' => false , 'price' => 19000 ]);

        //     Offer::create([ 'product_id' => ($i+3) , 'shop_id' => 1 , 'is_available' => true , 'price' => 5000 ]);
        //     Offer::create([ 'product_id' => ($i+3) , 'shop_id' => 2 , 'is_available' => false , 'price' => 4000 ]);
        //     Offer::create([ 'product_id' => ($i+3) , 'shop_id' => 3 , 'is_available' => true , 'price' => 4500 ]);

        //     Offer::create([ 'product_id' => ($i+1) , 'shop_id' => 1 , 'is_available' => true , 'price' => 8000 ]);
        //     Offer::create([ 'product_id' => ($i+1) , 'shop_id' => 3 , 'is_available' => true , 'price' => 7000 ]);

        //     Offer::create([ 'product_id' => ($i) , 'shop_id' => 3 , 'is_available' => true , 'price' => 9000 ]);
        // }

        // Offer::create([ 'product_id' => 5 , 'shop_id' => 1 , 'is_available' => true , 'price' => 3000 ]);
        // Offer::create([ 'product_id' => 5 , 'shop_id' => 2 , 'is_available' => true , 'price' => 3200 ]);
        // Offer::create([ 'product_id' => 5 , 'shop_id' => 3 , 'is_available' => false , 'price' => 2900 ]);

        // Offer::create([ 'product_id' => 6 , 'shop_id' => 1 , 'is_available' => false , 'price' => 2500 ]);
        // Offer::create([ 'product_id' => 6 , 'shop_id' => 2 , 'is_available' => false , 'price' => 1900 ]);
        // Offer::create([ 'product_id' => 6 , 'shop_id' => 3 , 'is_available' => false , 'price' => 1900 ]);

        // Offer::create([ 'product_id' => 7 , 'shop_id' => 1 , 'is_available' => true , 'price' => 4000 ]);
        // Offer::create([ 'product_id' => 7 , 'shop_id' => 3 , 'is_available' => true , 'price' => 3900 ]);

        // Offer::create([ 'product_id' => 8 , 'shop_id' => 1 , 'is_available' => true , 'price' => 15000 ]);
        // Offer::create([ 'product_id' => 8 , 'shop_id' => 2 , 'is_available' => true , 'price' => 11000 ]);
        // Offer::create([ 'product_id' => 8 , 'shop_id' => 3 , 'is_available' => true , 'price' => 17000 ]);

        // Offer::create([ 'product_id' => 9 , 'shop_id' => 1 , 'is_available' => true , 'price' => 21000 ]);
        // Offer::create([ 'product_id' => 9 , 'shop_id' => 2 , 'is_available' => true , 'price' => 22000 ]);
        // Offer::create([ 'product_id' => 9 , 'shop_id' => 3 , 'is_available' => true , 'price' => 19000 ]);

        // Offer::create([ 'product_id' => 10 , 'shop_id' => 2 , 'is_available' => false , 'price' => 150 ]);
        // Offer::create([ 'product_id' => 10 , 'shop_id' => 3 , 'is_available' => true , 'price' => 200 ]);

        // Offer::create([ 'product_id' => 11 , 'shop_id' => 1 , 'is_available' => false , 'price' => 90 ]);
        // Offer::create([ 'product_id' => 11 , 'shop_id' => 2 , 'is_available' => false , 'price' => 120 ]);
        // Offer::create([ 'product_id' => 11 , 'shop_id' => 3 , 'is_available' => true , 'price' => 100 ]);


        // Offer::create([ 'product_id' => 1 , 'shop_id' => 1 , 'is_available' => true , 'price' => 1000 ]);
    }
}
