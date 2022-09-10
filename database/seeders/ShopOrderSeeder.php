<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShopOrder;

class ShopOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 16; $i++) {
            $ri = random_int(39,999);
            for($a = 1; $a < $ri; $a++)
                ShopOrder::create([ 'user_id' => random_int(1,1000), 'shop_id' => $i ]);
        }
    }
}
