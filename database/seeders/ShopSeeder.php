<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'title' => 'بلوباکس' ,
                'province' => 'فارس' ,
                'city' => 'فارس' ,
                'rate' => 4 ,
                'cooperation_activity' => (time() - random_int(100000, 9999999)) ,
                'delivery_attention' => '' ,
                'delivery_methods' => 'پیک|پست پیشتاز' ,
                'advantage_inplace_pay' => 'امکان پرداخت در محل در فارس تا سقف مبلغ ۲۰٫۰۰۰٫۰۰۰ تومان' ,
                'advantage_instant_delivery' => '' ,
                'advantage_free_delivery' => ''
            ] ,
            [
                'title' => 'رونیکا' ,
                'province' => 'آذربایجان غربی' ,
                'city' => 'آذربایجان غربی' ,
                'rate' => 4.5 ,
                'cooperation_activity' => (time() - random_int(100000, 9999999)) ,
                'delivery_attention' => 'امکان ارسال رایگان در روش ارسال فوری فراهم نیست.' ,
                'delivery_methods' => 'پیک|شرکتهای پست خصوصی نظیر تیپاکس|پست پیشتاز' ,
                'advantage_inplace_pay' => '' ,
                'advantage_instant_delivery' => 'امکان تحویل در همان روز برای آذربایجان غربی با هماهنگی' ,
                'advantage_free_delivery' => 'امکان ارسال رایگان برای خریدهای بالای ۳۰۰٫۰۰۰ تومان'
            ] ,
            [
                'title' => 'شایان کامپیوتر' ,
                'province' => 'اصفهان' ,
                'city' => 'اصفهان' ,
                'rate' => 5 ,
                'cooperation_activity' => (time() - random_int(100000, 9999999)) ,
                'delivery_attention' => '' ,
                'delivery_methods' => 'پیک|شرکتهای پست خصوصی نظیر تیپاکس|پست پیشتاز' ,
                'advantage_inplace_pay' => 'امکان پرداخت در محل در اصفهان تا سقف مبلغ ۲۰٫۰۰۰٫۰۰۰ تومان' ,
                'advantage_instant_delivery' => 'امکان تحویل در همان روز برای اصفهان با هماهنگی' ,
                'advantage_free_delivery' => 'امکان ارسال رایگان برای خریدهای بالای ۳۰۰٫۰۰۰ تومان'
            ]
        ];
        
        foreach($data as $set)
            Shop::create($set);
    }
}
