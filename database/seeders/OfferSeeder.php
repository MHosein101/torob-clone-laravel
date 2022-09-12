<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    public function run()
    {
        $offer_available = [0,0,1,1,0,1,0,1,0,0,1,1,1,1,1,1,1,0,0,1,1,1,1,0,0,1,1,1,1,1,0,0,0,1,1,1,1,1,0,1,0,1,0,0,1,1,1];
        $offer_av_count = count($offer_available) - 1;
        $offer_guarantee = ['','گارانتی 8 ماهه', 'گارانتی 12 ماهه', 'گارانتی تعمیر توسط فروشگاه', 'گارانتی 18 ماهه', 'گارانتی 2 ساله', 'گارانتی شرکتی', 'گارانتی اصل', 'گارانتی 2 ماهه', 'گارانتی تعویض فروشگاهی'];

        $products = Product::get(['id', 'title']);
        
        foreach($products as $p) {
            $random_offers = random_int(5, 39);

            for($k = 1; $k <= $random_offers; $k++) {
                $pr_bottom = floor( random_int(2500000, 5000000) );
                $offer_price = floor(random_int($pr_bottom, $pr_bottom + 8000000) / 1000) * 1000;

                Offer::create([ 
                    'product_id' => $p->id , 
                    'shop_id' => $k , 
                    'title' => $p->title , 
                    'is_available' => $offer_available[random_int(0, $offer_av_count)] , 
                    'is_mobile_registered' => $offer_available[random_int(0, $offer_av_count)] ,
                    'guarantee' => $offer_guarantee[random_int(0, 6)] , 
                    'price' => $offer_price , 
                    'redirect_url' => 'https://www.google.com/search?q='.$p->title ,
                    'last_update' => (time() - random_int(300, 10368000))
                ]);
            }
        }

        // $lastTitles = [
        //     'گوشی موبایل هوآوی مدل Y9a', 
        //     'موبایل هوآوی Y9a دو سیم کارته', 
        //     'گوشی هوآوی Y9a ظرفیت 256', 
        //     'موبایل هوآوی Y9a رم 8', 
        //     'گوشی موبایل هوآوی Y9a حافظه 256', 
        //     'گوشی هوآوی Y9a 2020'
        // ];
        // $lastUrls = [
        //     'https://ahwaztel.ir/product-33', 
        //     'https://meghdadit.com/product/114914/huawei-y9a-128gb-8gb-ram', 
        //     'https://www.ekalato.com/huawei-y9a-8-128', 
        //     'https://payacenter.com/Product_Detail.aspx?pid=10757', 
        //     'https://avandmobile.com/product/huawei-y9a-128-8gb' ,
        //     'https://mashadkala.com/huawei-y9a-8gb-128gb-dual-sim-mobile-phone'
        // ];

        // $last_shops = random_int(12, 36);
        // for($d = 1; $d <= $last_shops; $d++) {
        //     $pr_bottom = floor( random_int(2500000, 5000000) );
        //     $offer_price = floor(random_int($pr_bottom, $pr_bottom + 8000000) / 1000) * 1000;

        //     Offer::create([ 
        //         'product_id' => 3 , 
        //         'shop_id' => $d , 
        //         'title' => $lastTitles[random_int(0, 5)] , 
        //         'is_available' => $offer_available[random_int(0, $offer_av_count)] , 
        //         'is_mobile_registered' => $offer_available[random_int(0, $offer_av_count)] ,
        //         'guarantee' => $offer_guarantee[random_int(0, 6)] , 
        //         'price' => $offer_price , 
        //         'redirect_url' => $lastUrls[random_int(0, 5)] ,
        //         'last_update' => (time() - random_int(300, 10368000)) 
        //     ]);
        // }

    }
}
