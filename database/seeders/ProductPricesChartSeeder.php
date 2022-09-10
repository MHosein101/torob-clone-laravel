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
            [ 'product_id' => 2 , 'date' => '22 خرداد 1401' , 'price' => 34800000 , 'average_price' => 4800000 ] ,
            [ 'product_id' => 2 , 'date' => '25 خرداد 1401' , 'price' => 3400000 , 'average_price' => 5200000 ] ,
            [ 'product_id' => 2 , 'date' => '28 خرداد 1401' , 'price' => 3500000 , 'average_price' => 4900000 ] ,
            [ 'product_id' => 2 , 'date' => '31 خرداد 1401' , 'price' => 4000000 , 'average_price' => 5300000 ] ,
            [ 'product_id' => 2 , 'date' => '3 تیر 1401' , 'price' => 3910000 , 'average_price' => 4700000 ] ,
            [ 'product_id' => 2 , 'date' => '6 تیر 1401' , 'price' => 3900000 , 'average_price' => 4800000 ] ,
            [ 'product_id' => 2 , 'date' => '9 تیر 1401' , 'price' => 3950000 , 'average_price' => 5000000 ] ,
            [ 'product_id' => 2 , 'date' => '12 تیر 1401' , 'price' => 387000 , 'average_price' => 3730000 ] ,
            [ 'product_id' => 2 , 'date' => '15 تیر 1401' , 'price' => 4300000 , 'average_price' => 6800000 ] ,
            [ 'product_id' => 2 , 'date' => '18 تیر 1401' , 'price' => 4700000 , 'average_price' => 3000000 ] ,
            [ 'product_id' => 2 , 'date' => '21 تیر 1401' , 'price' => 5000000 , 'average_price' => 3500000 ] ,
            [ 'product_id' => 2 , 'date' => '24 تیر 1401' , 'price' => 5200000 , 'average_price' => 4500000 ] ,
            [ 'product_id' => 2 , 'date' => '27 تیر 1401' , 'price' => 5300000 , 'average_price' => 4700000 ] ,
            [ 'product_id' => 2 , 'date' => '30 تیر 1401' , 'price' => 4800000 , 'average_price' => 5800000 ] ,
            [ 'product_id' => 2 , 'date' => '2 مرداد 1401' , 'price' => 5500000 , 'average_price' => 4600000 ] ,
            [ 'product_id' => 2 , 'date' => '5 مرداد 1401' , 'price' => 4800000 , 'average_price' => 4400000 ] ,
            [ 'product_id' => 2 , 'date' => '8 مرداد 1401' , 'price' => 4200000 , 'average_price' => 4700000 ] ,
            [ 'product_id' => 2 , 'date' => '11 مرداد 1401' , 'price' => 3900000 , 'average_price' => 3300000 ] ,
            [ 'product_id' => 2 , 'date' => '14 مرداد 1401' , 'price' => 4000000 , 'average_price' => 3300000 ] ,
            [ 'product_id' => 2 , 'date' => '17 مرداد 1401' , 'price' => 3800000 , 'average_price' => 3700000 ] ,
        ];


        foreach($data as $set)
            ProductPricesChart::create($set);
            
    }
}
