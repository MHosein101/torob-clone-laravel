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
        $data = [];

        $ri = random_int(49,999);
        for($i = 1; $i < $ri; $i++)
            $data[] = [ 'user_id' => $i, 'shop_id' => 3 ];

        $ri = random_int(49,999);
        for($i = 1; $i < $ri; $i++)
            $data[] = [ 'user_id' => $i, 'shop_id' => 1 ];

        $ri = random_int(49,999);
        for($i = 1; $i < $ri; $i++)
            $data[] = [ 'user_id' => $i, 'shop_id' => 2 ];

        foreach($data as $set)
            ShopOrder::create($set);
    }
}
