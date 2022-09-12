<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    public function run()
    {

        $shop_names = [
            'تهران تخفیف', 'یه بادی', 'نایت جم شاپ', 'بی ایکس کالا', 'کالا در کالا', 'دی اس پی کالا', 'هاریکا', 'جنوب مال شاپ', 'تکنو استایل', 'شاپ لیدوما',
            'فروشگاه جبلی', 'کینگ شاپ', 'توربو جم', 'نیکسل', 'علی تخفیف', 'تک عمده', 'بلوباکس', 'ماهل كالا', 'کیمیا دیجیتال', 'زنبیل آنلاین',
            'سلین کالا', 'وینی لند', 'متی کالا', 'رایاد', 'آراز ارس', 'کافه قیمت', 'کالا شاپ', 'داریان شاپ', 'هانیس شاپ', 'ویز مارکت',
            'قشم مارکت', 'ایران موجو', 'پرشین ایکس', 'سان استایل', 'بندرکالا', 'رادین جانبی', 'قسطی کلاب', 'سینا شاپ', 'ایران ماهرو', 'کاسپین'
        ]; // 40
        
        $shop_del_att = ['', 'امکان ارسال رایگان در روش ارسال فوری فراهم نیست.', 'برای ارسال کالا های سنگین تماس بگیرید.'];
        $shop_del_methods = ['پیک|پست پیشتاز', 'پیک|شرکتهای پست خصوصی نظیر تیپاکس|پست پیشتاز', 'پست پیشتاز|پست سفارشی|دسترسی آنلاین', 'شرکتهای پست خصوصی نظیر تیپاکس|پست پیشتاز|پست سفارشی|پیک'];
        
        $pr_pay = number_format(floor(random_int(4000000,10000000)/ 1000) * 1000);
        $pr_free = number_format(floor(random_int(500000,5000000)/ 1000) * 1000);
        $shop_adv_pay = ['', 'امکان پرداخت در محل تا سقف مبلغ '. $pr_pay .' تومان'];
        $shop_adv_free = ['', 'امکان ارسال رایگان برای خریدهای بالای '. $pr_free .' تومان'];
        $shop_adv_del = ['', 'امکان تحویل در همان روز با هماهنگی'];

        $shop_provinces = ['تهران', 'مازندران', 'اصفهان', 'فارس', 'خراسان رضوی'];
        $shop_cities = [
            'تهران' => ['پردیس', 'رباط کریم', 'لواسان', 'ملارد', 'ورامین'] ,
            'اصفهان' => ['ابریشم', 'باغ بهادران', 'پیربکران', 'حسن آباد', 'داران', 'شهرضا'] ,
            'مازندران' => ['آمل', 'ساری', 'بابل', 'نکا', 'فرح اباد'] ,
            'فارس' => ['اردکان', 'بیضا', 'خاوران', 'شیراز', 'علامرودشت'] ,
            'خراسان رضوی' => ['بیدخت', 'تربت حیدریه', 'رباط سنگ', 'مشهد', 'فیض آباد']
        ];

        for($i = 0; $i < count($shop_names); $i++) {
            $province = $shop_provinces[random_int(0, 4)];
            $city = $shop_cities[$province][random_int(0, 4)];

            $data = [
                'title' => $shop_names[$i] ,
                'province' => $province ,
                'city' => $city ,
                'rate' => random_int(1, 5) ,
                'cooperation_activity' => (time() - random_int(10368000, 93312000)) ,
                'delivery_attention' => $shop_del_att[random_int(0, 2)] ,
                'delivery_methods' => $shop_del_methods[random_int(0, 3)] ,
                'advantage_inplace_pay' => $shop_adv_pay[random_int(0, 1)] ,
                'advantage_instant_delivery' => $shop_adv_del[random_int(0, 1)] ,
                'advantage_free_delivery' => $shop_adv_free[random_int(0, 1)]
            ];

            Shop::create($data);
            
        }
    }
}
