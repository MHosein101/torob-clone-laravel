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
     * @return Response Json
     */ 
    public function getAnalytics(Request $request)
    {
        $user = Auth::guard('api')->user();
        $qbuilder = SearchFunctions::joinTables(); // get products query builder
        
        // user marked for analytic products table
        $analytics = UserAnalytic::select('user_analytics.*');
        
        // join with analytic sub sql to get each product prices histories in diffrent shops
        $qbuilder = $qbuilder->leftJoinSub($analytics, 'user_products_analytics', function ($join) {
            $join->on('products.id', 'user_products_analytics.product_id');
        })
        ->where('user_id', $user->id)
        ->orderBy('user_products_analytics.id', 'desc');

        $results = $qbuilder->get(['products.id', 'hash_id', 'products.title','image_url', 'price_start', 'shops_count']);
        $analyticsProducts = SearchFunctions::processResults($results, false);

        $i = 0;
        foreach($analyticsProducts as $p) {

            $pricesChartData = ProductPricesChart::where('product_id', $p->id)->get();
            $analyticsProducts[$i]['chart'] =  $pricesChartData;

            $qbuilder = ProductPricesHistory::where('product_id', $p->id)->take(4);

            $offers = Offer::selectRaw('id as offer_id, price, shop_id'); // get offers records related to product prices history

            $qbuilder = $qbuilder->leftJoinSub($offers, 'product_offers', function ($join) {
                $join->on('product_prices_histories.offer_id', 'product_offers.offer_id');
            })
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


        return response()
        ->json([
            'message' => 'Ok' ,
            'data' => $analyticsProducts
        ], 200);
    }

    /**
     * marked product to user analytics
     * 
     * @return Response Json
     */ 
    public function createAnalytic(Request $request)
    {
        $user = Auth::guard('api')->user();
        $product = $request->product;
        
        $check = UserAnalytic::where('user_id', $user->id)->where('product_id', $product->id)->get()->first();

        if($check == null) {
            $a = new UserAnalytic;
            $a->user_id = $user->id;
            $a->product_id = $product->id;
            $a->save();
        }

        return response()->json([ 'message' => 'Created' , ], 201);
    }

    /**
     * Delete product from user analytics
     * 
     * @return Response Json
     */ 
    public function deleteAnalytic(Request $request)
    {
        $user = Auth::guard('api')->user();
        $product = $request->product;
        
        UserAnalytic::where('user_id', $user->id)->where('product_id', $product->id)->delete();

        return response()->json([ 'message' => 'Deleted' , ], 200);
    }

    /**
     * Get user marked favorites products
     * 
     * @return Response Json
     */ 
    public function getFavorites(Request $request)
    {
        $user = Auth::guard('api')->user();
        $qbuilder = SearchFunctions::joinTables();
        
        // user favorites table
        $favorites = UserFavorite::select('user_favorites.*');
        
        // join with favorites sub sql to get each user marked products
        $qbuilder = $qbuilder->leftJoinSub($favorites, 'user_favorite_products', function ($join) {
            $join->on('products.id', 'user_favorite_products.product_id');
        })
        ->where('user_id', $user->id)
        ->orderBy('user_favorite_products.id', 'desc');

        $results = $qbuilder->get(['products.id', 'hash_id', 'products.title','image_url', 'price_start', 'shops_count']);
        $favoriteProducts = SearchFunctions::processResults($results);
        
        return response()
        ->json([
            'message' => 'Ok' ,
            'data' => $favoriteProducts
        ], 200);
    }

    /**
     * Add product to user favorite
     * 
     * @return Response Json
     */ 
    public function createFavorite(Request $request)
    {
        $user = Auth::guard('api')->user();
        $product = $request->product;
        
        $check = UserFavorite::where('user_id', $user->id)->where('product_id', $product->id)->get()->first();

        if($check == null) {
            $f = new UserFavorite;
            $f->user_id = $user->id;
            $f->product_id = $product->id;
            $f->save();
        }

        return response()->json([ 'message' => 'Created' , ], 201);
    }

    /**
     * Delete product from user favorites
     * 
     * @return Response Json
     */ 
    public function deleteFavorite(Request $request)
    {
        $user = Auth::guard('api')->user();
        $product = $request->product;
        
        UserFavorite::where('user_id', $user->id)->where('product_id', $product->id)->delete();

        return response()->json([ 'message' => 'Deleted' , ], 200);
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
     * @return Response Json
     */ 
    public function getHistory(Request $request)
    {
        $user = Auth::guard('api')->user();
        $params = SearchFunctions::ConfigQueryParams($request->query(), $this->uhDefaultParams);
        $qbuilder = SearchFunctions::joinTables();

        $take = $params["perPage"];
        $skip = ( $params["page"] - 1 ) * $params["perPage"]; // for pagination

        // user favorites table
        $history = UserHistory::select('user_histories.*');
        
        // join with offers sub sql to get each available product least price
        $qbuilder = $qbuilder->leftJoinSub($history, 'user_products_view_history', function ($join) {
            $join->on('products.id', 'user_products_view_history.product_id');
        })
        ->where('user_id', $user->id)
        ->orderBy('user_products_view_history.id', 'desc')
        ->take($take)->skip($skip);

        $results = $qbuilder->get(['products.id', 'hash_id', 'products.title','image_url', 'price_start', 'shops_count']);
        $historyProducts = SearchFunctions::processResults($results);
        
        return response()
        ->json([
            'message' => 'Ok' ,
            'data' => $historyProducts
        ], 200);
    }

    /**
     * Add viewed product to user history
     * 
     * @return Response Json
     */ 
    public function createHistory(Request $request)
    {
        $user = Auth::guard('api')->user();
        $product = $request->product;
        
        $check = UserHistory::where('user_id', $user->id)->where('product_id', $product->id)->get()->first();

        if($check == null) {
            $h = new UserHistory;
            $h->user_id = $user->id;
            $h->product_id = $product->id;
            $h->save();
        }

        return response()->json([ 'message' => 'Created' , ], 201);
    }

    /**
     * Clear all user product view history
     * 
     * @return Response Json
     */ 
    public function clearHistory(Request $request)
    {
        $user = Auth::guard('api')->user();
        
        UserHistory::where('user_id', $user->id)->delete();

        return response()->json([ 'message' => 'Cleared' , ], 200);
    }

}
