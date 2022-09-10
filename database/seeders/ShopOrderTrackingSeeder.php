<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShopOrderTracking;

class ShopOrderTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];

        $ri = random_int(11,50);
        for($i = 1; $i < $ri; $i++)
            $data[] = [ 'user_id' => $i, 'shop_id' => 3 ];

        $ri = random_int(11,50);
        for($i = 1; $i < $ri; $i++)
            $data[] = [ 'user_id' => $i, 'shop_id' => 1 ];

        $ri = random_int(11,50);
        for($i = 1; $i < $ri; $i++)
            $data[] = [ 'user_id' => $i, 'shop_id' => 2 ];
            
        foreach($data as $set)
            ShopOrderTracking::create($set);
    }
}
