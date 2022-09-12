<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShopOrderTracking;

class ShopOrderTrackingSeeder extends Seeder
{
    public function run()
    {
        
        for($i = 0; $i < 16; $i++) {

            $ri = random_int(5,29);

            for($a = 1; $a < $ri; $a++)
                ShopOrderTracking::create([ 'user_id' => random_int(1,199), 'shop_id' => $i ]);
        }

    }
}
