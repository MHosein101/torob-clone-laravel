<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductPricesChart;

class ProductPricesChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'product_id' => 2 , 'date' => '22 خرداد 1401' , 'price' => 3480 , 'average_price' => 4800 ] ,
            [ 'product_id' => 2 , 'date' => '23 خرداد 1401' , 'price' => 3400 , 'average_price' => 5200 ] ,
            [ 'product_id' => 2 , 'date' => '25 خرداد 1401' , 'price' => 3500 , 'average_price' => 4900 ] ,
            [ 'product_id' => 2 , 'date' => '26 خرداد 1401' , 'price' => 4000 , 'average_price' => 5300 ] ,
            [ 'product_id' => 2 , 'date' => '30 خرداد 1401' , 'price' => 4200 , 'average_price' => 5600 ] ,
            [ 'product_id' => 2 , 'date' => '1 تیر 1401' , 'price' => 3910 , 'average_price' => 4700 ] ,
            [ 'product_id' => 2 , 'date' => '3 تیر 1401' , 'price' => 3900 , 'average_price' => 4800 ] ,
            [ 'product_id' => 2 , 'date' => '4 تیر 1401' , 'price' => 3950 , 'average_price' => 5000 ] ,
            [ 'product_id' => 2 , 'date' => '5 تیر 1401' , 'price' => 3800 , 'average_price' => 3700 ] ,
        ];


        foreach($data as $set)
            ProductPricesChart::create($set);
            
    }
}
