<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // under category 1 , 2
        Favorite::create([ 'user_id' => 1 , 'product_id' => 3 ]);
        Favorite::create([ 'user_id' => 2 , 'product_id' => 3 ]);
        Favorite::create([ 'user_id' => 3 , 'product_id' => 3 ]);
        Favorite::create([ 'user_id' => 4 , 'product_id' => 3 ]);
        Favorite::create([ 'user_id' => 5 , 'product_id' => 3 ]);
        Favorite::create([ 'user_id' => 6 , 'product_id' => 3 ]);
        
        Favorite::create([ 'user_id' => 2 , 'product_id' => 2 ]);
        Favorite::create([ 'user_id' => 3 , 'product_id' => 2 ]);
        Favorite::create([ 'user_id' => 4 , 'product_id' => 2 ]);
        Favorite::create([ 'user_id' => 5 , 'product_id' => 2 ]);

        Favorite::create([ 'user_id' => 5 , 'product_id' => 4 ]);

        // under category 8 , 9
        Favorite::create([ 'user_id' => 1 , 'product_id' => 8 ]);
        Favorite::create([ 'user_id' => 2 , 'product_id' => 8 ]);
        Favorite::create([ 'user_id' => 3 , 'product_id' => 8 ]);
        Favorite::create([ 'user_id' => 4 , 'product_id' => 8 ]);
        Favorite::create([ 'user_id' => 5 , 'product_id' => 8 ]);
        Favorite::create([ 'user_id' => 6 , 'product_id' => 8 ]);
        
        Favorite::create([ 'user_id' => 3 , 'product_id' => 6 ]);
        Favorite::create([ 'user_id' => 4 , 'product_id' => 6 ]);
        Favorite::create([ 'user_id' => 5 , 'product_id' => 6 ]);
        Favorite::create([ 'user_id' => 6 , 'product_id' => 6 ]);
        
        Favorite::create([ 'user_id' => 6 , 'product_id' => 9 ]);

        Favorite::create([ 'user_id' => 4 , 'product_id' => 10 ]);
        Favorite::create([ 'user_id' => 6 , 'product_id' => 10 ]);

        // Favorite::create([ 'user_id' => 1 , 'product_id' => 2 ]);
    }
}
