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
            [ 'product_id' => 2 , 'date' => '25 خرداد 1401' , 'price' => 3400 , 'average_price' => 5200 ] ,
            [ 'product_id' => 2 , 'date' => '28 خرداد 1401' , 'price' => 3500 , 'average_price' => 4900 ] ,
            [ 'product_id' => 2 , 'date' => '31 خرداد 1401' , 'price' => 4000 , 'average_price' => 5300 ] ,
            [ 'product_id' => 2 , 'date' => '3 تیر 1401' , 'price' => 3910 , 'average_price' => 4700 ] ,
            [ 'product_id' => 2 , 'date' => '6 تیر 1401' , 'price' => 3900 , 'average_price' => 4800 ] ,
            [ 'product_id' => 2 , 'date' => '9 تیر 1401' , 'price' => 3950 , 'average_price' => 5000 ] ,
            [ 'product_id' => 2 , 'date' => '12 تیر 1401' , 'price' => 3870 , 'average_price' => 3730 ] ,
            [ 'product_id' => 2 , 'date' => '15 تیر 1401' , 'price' => 4300 , 'average_price' => 6800 ] ,
            [ 'product_id' => 2 , 'date' => '18 تیر 1401' , 'price' => 4700 , 'average_price' => 3000 ] ,
            [ 'product_id' => 2 , 'date' => '21 تیر 1401' , 'price' => 5000 , 'average_price' => 3500 ] ,
            [ 'product_id' => 2 , 'date' => '24 تیر 1401' , 'price' => 5200 , 'average_price' => 4500 ] ,
            [ 'product_id' => 2 , 'date' => '27 تیر 1401' , 'price' => 5300 , 'average_price' => 4700 ] ,
            [ 'product_id' => 2 , 'date' => '30 تیر 1401' , 'price' => 4800 , 'average_price' => 5800 ] ,
            [ 'product_id' => 2 , 'date' => '2 مرداد 1401' , 'price' => 5500 , 'average_price' => 4600 ] ,
            [ 'product_id' => 2 , 'date' => '5 مرداد 1401' , 'price' => 4800 , 'average_price' => 4400 ] ,
            [ 'product_id' => 2 , 'date' => '8 مرداد 1401' , 'price' => 4200 , 'average_price' => 4700 ] ,
            [ 'product_id' => 2 , 'date' => '11 مرداد 1401' , 'price' => 3900 , 'average_price' => 3300 ] ,
            [ 'product_id' => 2 , 'date' => '14 مرداد 1401' , 'price' => 4000 , 'average_price' => 3300 ] ,
            [ 'product_id' => 2 , 'date' => '17 مرداد 1401' , 'price' => 3800 , 'average_price' => 3700 ] ,
        ];


        foreach($data as $set)
            ProductPricesChart::create($set);
            
    }
}
