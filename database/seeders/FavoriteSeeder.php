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
        
        $data = [ 
            [ 'user_id' => 1 , 'product_id' => 1 ] ,
        ];

        foreach($data as $set)
            Favorite::create($set);
        
    }
}
