<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $title = ['خرید این محصول', 'خرید محصول با تخفیف', 'خرید ارزان قیمت', 'خرید با گارانتی معتبر', 'ارزان و گارانتی معتبر'];
        $av = [0,0,1,1,0,1,0,1,0,0,1,1,1,1,1,1,1,0,0,1,1,1,1,0,0,1,1,1,1,1,0,0,0,1,1,1,1,1,0,1,0,1,0,0,1,1,1];
        $avc = count($av) - 1;
        $gr = ['', 'گارانتی 12 ماهه', 'گارانتی 24 ماهه', 'گارانتی 5 ساله', 'گارانتی شرکتی', 'گارانتی اصل', 'گارانتی تعویض فروشگاهی'];

        for($i = 1; $i <= 15; $i++) {
            $rsh = random_int(3, 16);

            for($d = 1; $d <= $rsh; $d++) {
                $pm = floor( random_int(2500000, 5000000) );

                Offer::create([ 
                    'product_id' => $i , 
                    'shop_id' => $d , 
                    'title' => $title[random_int(0, 4)] , 
                    'is_available' => $av[random_int(0, $avc)] , 
                    'is_mobile_registered' => $av[random_int(0, $avc)]  ,
                    'guarantee' => $av[random_int(0, 6)] , 
                    'price' => random_int($pm, $pm+8000000) , 
                    'redirect_url' => 'https://www.google.com/search?q='.$title[random_int(0, 4)] ,
                    'last_update' => (time() - random_int(1999999, 8999999)) 
                ]);
            }
        }
        
        for($i = 1; $i <= 15; $i++) {
            $rsh = random_int(3, 16);

            for($d = 1; $d <= $rsh; $d++) {
                $pm = floor( random_int(2500000, 5000000) );

                Offer::create([ 
                    'product_id' => $i , 
                    'shop_id' => $d , 
                    'title' => $title[random_int(0, 4)] , 
                    'is_available' => $av[random_int(0, $avc)] , 
                    'is_mobile_registered' => $av[random_int(0, $avc)]  ,
                    'guarantee' => $av[random_int(0, 6)] , 
                    'price' => random_int($pm, $pm+8000000) , 
                    'redirect_url' => 'https://www.google.com/search?q='.$title[random_int(0, 4)] ,
                    'last_update' => (time() - random_int(1999999, 8999999)) 
                ]);
            }
        }
        
        for($i = 1; $i <= 15; $i++) {
            $rsh = random_int(3, 16);

            for($d = 1; $d <= $rsh; $d++) {
                $pm = floor( random_int(2500000, 5000000) );

                Offer::create([ 
                    'product_id' => $i , 
                    'shop_id' => $d , 
                    'title' => $title[random_int(0, 4)] , 
                    'is_available' => $av[random_int(0, $avc)] , 
                    'is_mobile_registered' => $av[random_int(0, $avc)]  ,
                    'guarantee' => $av[random_int(0, 6)] , 
                    'price' => random_int($pm, $pm+8000000) , 
                    'redirect_url' => 'https://www.google.com/search?q='.$title[random_int(0, 4)] ,
                    'last_update' => (time() - random_int(1999999, 8999999)) 
                ]);
            }
        }

    }
}
