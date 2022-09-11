<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    public function run()
    {

        $shnames = ['تهران تخفیف', 'یه بادی', 'نایت جم شاپ', 'بی ایکس کالا', 'کالا در کالا', 'دی اس پی کالا', 'هاریکا', 'جنوب مال شاپ', 'تکنو استایل', 'شاپ لیدوما', 'فروشگاه جبلی', 'کینگ شاپ', 'توربو جم', 'نیکسل', 'علی تخفیف', 'تک عمده'];
        $shprovinces = ['تهران', 'مازندران', 'اصفهان', 'گیلان', 'گلستان', 'ایلام', 'سمنان', 'کرمان', 'همدان', 'یزد'];
        $shdelatt = ['', 'امکان ارسال رایگان در روش ارسال فوری فراهم نیست.', 'برای ارسال کالا های سنگین تماس بگیرید.'];
        $shdelmeth = ['پیک|پست پیشتاز', 'پیک|شرکتهای پست خصوصی نظیر تیپاکس|پست پیشتاز', 'پست پیشتاز|پست سفارشی|دسترسی آنلاین', 'شرکتهای پست خصوصی نظیر تیپاکس|پست پیشتاز|پست سفارشی|خودروی فروشگاه|باربری های درون شهری یا برون شهری|پیک'];
        $shadvpay = ['', 'امکان پرداخت در محل تا سقف مبلغ '. (floor(random_int(4000000,10000000)/ 1000) * 1000) .' تومان'];
        $shadvdel = ['', 'امکان تحویل در همان روز با هماهنگی'];
        $shadvfree = ['', 'امکان ارسال رایگان برای خریدهای بالای '. (floor(random_int(500000,5000000)/ 1000) * 1000) .' تومان'];

        for($i = 0; $i < 16; $i++) {
            $prov = $shnames[random_int(0, 9)];

            $data = [
                'title' => $shnames[$i] ,
                'province' => $prov ,
                'city' => $prov ,
                'rate' => random_int(1, 5) ,
                'cooperation_activity' => (time() - random_int(99999999, 999999999)) ,
                'delivery_attention' => $shnames[random_int(0, 2)] ,
                'delivery_methods' => $shdelmeth[random_int(0, 3)] ,
                'advantage_inplace_pay' => $shadvpay[random_int(0, 1)] ,
                'advantage_instant_delivery' => $shadvdel[random_int(0, 1)] ,
                'advantage_free_delivery' => $shadvfree[random_int(0, 1)]
            ];

            Shop::create($data);
        }
    }
}
