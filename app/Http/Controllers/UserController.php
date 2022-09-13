<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Offer;
use App\Models\Product;
use App\Models\UserHistory;
use App\Models\UserAnalytic;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use App\Models\ProductPricesChart;
use App\Models\ProductPricesHistory;
use Illuminate\Support\Facades\Auth;
use App\Http\Functions\SearchFunctions;

class UserController extends Controller
{
    
    /**
     * Get user marked products price analytics
     * 
     * @return Json
     */ 
    public function getAnalytics(Request $request)
    {
        $user = Auth::guard('api')->user();
        $qbuilder = SearchFunctions::joinTables();
        
        // user favorites table
        $analytics = UserAnalytic::select('user_analytics.*');
        
        // join with offers sub sql to get each available product least price
        $qbuilder = $qbuilder->leftJoinSub($analytics, 'user_products_analytics', function ($join) {
            $join->on('products.id', 'user_products_analytics.product_id');
        })
        ->where('user_id', $user->id)
        ->orderBy('user_products_analytics.id', 'desc');

        $results = $qbuilder->get(['products.id', 'hash_id', 'products.title','image_url', 'price_start', 'shops_count']);
        $analyticsProducts = SearchFunctions::processResults($results);
        

        $i = 0;
        foreach($analyticsProducts as $product) {
            $pid = Product::where('hash_id', $product->hash_id)->get()->first()->id;

            $pricesChartData = ProductPricesChart::where('product_id', $pid)->get();
            $analyticsProducts[$i]['chart'] =  $pricesChartData;

            $qbuilder = ProductPricesHistory::where('product_id', $pid)->take(4);
            $offers = Offer::selectRaw('id as offer_id, price, shop_id');

            $qbuilder = $qbuilder->leftJoinSub($offers, 'product_offers', function ($join) {
                $join->on('product_prices_histories.offer_id', 'product_offers.offer_id');
            })
            ->where('product_id', $pid)
            ->orderBy('product_prices_histories.id', 'desc');

            $pricesHistories = $qbuilder->get();

            $k = 0;
            foreach($pricesHistories as $ph) {
                unset($pricesHistories[$k]['id']);
                unset($pricesHistories[$k]['offer_id']);
                unset($pricesHistories[$k]['product_id']);

                $pricesHistories[$k]['shop_name'] = Shop::find($ph->shop_id)->title;
                unset($pricesHistories[$k]['shop_id']);

                $k++;
            }
            $analyticsProducts[$i]['history'] =  $pricesHistories;

            $i++;
        }


        return response()->json([
            'message' => 'Ok' ,
            'data' => $analyticsProducts
        ], 200);
    }

    /**
     * Get user marked favorites products
     * 
     * @return Json
     */ 
    public function getFavorites(Request $request)
    {
        $user = Auth::guard('api')->user();
        $qbuilder = SearchFunctions::joinTables();
        
        // user favorites table
        $favorites = UserFavorite::select('user_favorites.*');
        
        // join with offers sub sql to get each available product least price
        $qbuilder = $qbuilder->leftJoinSub($favorites, 'user_favorite_products', function ($join) {
            $join->on('products.id', 'user_favorite_products.product_id');
        })
        ->where('user_id', $user->id)
        ->orderBy('user_favorite_products.id', 'desc');

        $results = $qbuilder->get(['products.id', 'hash_id', 'products.title','image_url', 'price_start', 'shops_count']);
        $favoriteProducts = SearchFunctions::processResults($results);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $favoriteProducts
        ], 200);
    }

    /**
     * User product view history pagination default params
     * @var Array
     */
    private $uhDefaultParams = [
        'page' => 1 ,
        'perPage' => 24
    ];

    /**
     * Get user products view history
     * 
     * @return Json
     */ 
    public function getHistory(Request $request)
    {
        $user = Auth::guard('api')->user();
        $params = SearchFunctions::ConfigQueryParams($request->query(), $this->uhDefaultParams);
        $qbuilder = SearchFunctions::joinTables();

        // user favorites table
        $history = UserHistory::select('user_histories.*');
        
        // join with offers sub sql to get each available product least price
        $qbuilder = $qbuilder->leftJoinSub($history, 'user_products_view_history', function ($join) {
            $join->on('products.id', 'user_products_view_history.product_id');
        })
        ->where('user_id', $user->id)
        ->orderBy('user_products_view_history.id', 'desc');

        $results = $qbuilder->get(['products.id', 'hash_id', 'products.title','image_url', 'price_start', 'shops_count']);
        $historyProducts = SearchFunctions::processResults($results);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $historyProducts
        ], 200);
    }

}
