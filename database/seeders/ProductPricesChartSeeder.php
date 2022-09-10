<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductPricesChart;

class ProductPricesChartSeeder extends Seeder
{
    public function run()
    {
        $month = ['تیر', 'مرداد', 'مهر', 'آذر', 'دی', 'بهمن'];

        for($i = 1; $i <= 15; $i++) {

            $ri = random_int(7, 40);
            $m = $month[ random_int(0, 5) ];
            $mp = random_int(2000000, 8000000);
            $ma = random_int(2000000, 8000000);

            for($w = 0; $w < $ri; $w++) {

                $d = random_int(1, 30);

                ProductPricesChart::create([ 
                    'product_id' => $i , 
                    'date' => "$d $m 1401" , 
                    'price' => random_int($mp, $mp+20000000) , 
                    'average_price' => random_int($ma, $ma+20000000)  
                ]);
            }

        }
            
    }
}
