<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;
use App\Models\ProductPricesHistory;

class ProductPricesHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [1, 2, 3, 4, 5];
        $type = ['decrease', 'finished', 'increase', 'started'];

        foreach($products as $pid) {
            $offers = Offer::where('product_id', $pid)->take(10)->get();
            $offerIDs = [];
            $offerPrices = [];

            foreach($offers as $f) {
                $offerIDs[] = $f->id;
                $offerPrices[] = $f->price;
            }

            $oic = count($offerIDs) - 1;

            $round = random_int(5, 10);
            
            for($i = 0; $i < $round; $i++) {

                $or = random_int(0, $oic);
                $t =  $type[random_int(0, 3)];
                $oid =  $offerIDs[$or];
                $pr = floor(random_int($offerPrices[$or] , $offerPrices[$or] + 8000000) / 1000) * 1000;

                ProductPricesHistory::create([
                    'type' => $t ,
                    'new_price' => $pr ,
                    'change_time' => (time() - random_int(3600, 604800)) ,
                    'offer_id' => $oid ,
                    'product_id' => $pid
                ]);

            }
        }

    }
}
