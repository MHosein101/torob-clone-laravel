<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\ProductPricesChart;

class ProductPricesChartSeeder extends Seeder
{
    public function run()
    {
        $month = ['تیر', 'مرداد', 'مهر', 'آذر', 'دی', 'بهمن', 'خرداد', 'بهمن'];

        $products = Product::get('id');
        
        foreach($products as $p) {

            $ri = random_int(7, 40);
            $m = $month[ random_int(0, 5) ];

            $pr_min = floor(random_int(2000000, 8000000)/ 1000) * 1000;
            $avr_min = floor(random_int(2000000, 8000000)/ 1000) * 1000;


            for($w = 0; $w < $ri; $w++) {

                $d = random_int(1, 30);
                $price = floor(random_int($pr_min, $pr_min + 10000000)/ 1000) * 1000;
                $average = floor(random_int($avr_min, $avr_min + 10000000)/ 1000) * 1000;

                ProductPricesChart::create([ 
                    'product_id' => $p->id , 
                    'date' => "$d $m 1401" , 
                    'price' => $price , 
                    'average_price' => $average 
                ]);
            }

        }
            
    }
}
