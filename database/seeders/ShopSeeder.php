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
        Shop::create([
            'title' => 'بلوباکس' ,
            'province' => 'فارس' ,
            'address' => 'بخش مرکزی ، شهر شیراز، محله عادل آباد ، خیابان فتح المبین ، بلوار پاسارگادشرقی ، پلاک 23 ، طبقه همکف' ,
            'owner' => 'شاهین والای تجارت' ,
            'status' => 'فعال' ,
            'site_url' => 'https://bluebox.ir/' ,
            'logo_url' => 'https://storage3.torob.com/backend-api/internet_shop/logos/6f8c326eb0a0.png' ,
        ]);
        
        Shop::create([
            'title' => 'رونیکا' ,
            'province' => 'آذربایجان غربی' ,
            'address' => 'شهرستان : پیرانشهر، بخش : مرکزی، شهر: پیرانشهر، محله: مسجد امام خمینی، کوچه شیلان، بن بست شیلان، پلاک: 1282.0، طبقه: اول،' ,
            'owner' => 'محبت حسني راد' ,
            'status' => 'فعال' ,
            'site_url' => 'https://ronica.shop/' ,
            'logo_url' => 'https://storage3.torob.com/backend-api/internet_shop/logos/e7958b92869e.png' ,
        ]);

        Shop::create([
            'title' => 'شایان کامپیوتر' ,
            'province' => 'اصفهان' ,
            'address' => 'استان: اصفهان، شهرستان : اصفهان، بخش : مرکزی، شهر: اصفهان، محله: رحیم آباد، خیابان غرضی، بن بست بهاران 2[6]، پلاک: 7.0، طبقه: اول،' ,
            'owner' => 'شايان زاهدي دهوئي' ,
            'status' => 'فعال' ,
            'site_url' => 'https://shayancomputer.com/' ,
            'logo_url' => 'https://storage3.torob.com/backend-api/internet_shop/logos/78440c5a0883.png' ,
        ]);
        
        // Shop::create([
        //     'title' => '' ,
        //     'province' => '' ,
        //     'address' => '' ,
        //     'owner' => '' ,
        //     'status' => 'فعال' ,
        //     'site_url' => '' ,
        //     'logo_url' => '' ,
        // ]);
    }
}
