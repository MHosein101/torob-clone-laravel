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
        Favorite::createWithProductUpdate([ 'user_id' => 1 , 'product_id' => 1 ]);
        Favorite::createWithProductUpdate([ 'user_id' => 2 , 'product_id' => 1 ]);
        Favorite::createWithProductUpdate([ 'user_id' => 3 , 'product_id' => 1 ]);
        Favorite::createWithProductUpdate([ 'user_id' => 4 , 'product_id' => 1 ]);

        Favorite::createWithProductUpdate([ 'user_id' => 1 , 'product_id' => 2 ]);
        Favorite::createWithProductUpdate([ 'user_id' => 2 , 'product_id' => 2 ]);
        Favorite::createWithProductUpdate([ 'user_id' => 3 , 'product_id' => 2 ]);

        Favorite::createWithProductUpdate([ 'user_id' => 1 , 'product_id' => 3 ]);
        Favorite::createWithProductUpdate([ 'user_id' => 2 , 'product_id' => 3 ]);
        
        Favorite::createWithProductUpdate([ 'user_id' => 1 , 'product_id' => 4 ]);

        // Favorite::create([ 'user_id' => 1 , 'product_id' => 2 ]);
    }
}
