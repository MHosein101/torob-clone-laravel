<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Offer;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    public function suggestion(Request $request, $text)
    {
        $matchedProducts = Product::where('title','LIKE', "%$text%")->take(3)->get('title');
        $firstMatchWord = "";
        $queries = [];
        foreach($matchedProducts as $t) { 
            $queries[] = $t->title; 

            $words = explode(' ', $t->title);
            foreach($words as $w)
                if( strpos($w, $text) !== false )
                    $firstMatchWord = $w;
        }

        $matchedProductsIDs = Product::where('title','LIKE', "%$text%")->take(10);
        
        $categoryIDs = ProductCategory::leftJoinSub($matchedProductsIDs, 'products_date', function ($join) {
            $join->on('product_categories.product_id', '=', 'products_date.id');
        })->select('category_id')->distinct()->get();

        $categories =[];
        foreach($categoryIDs as $cid)
            $categories[] = Category::find($cid)->first()->name;

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok' ,
            'data' => [
                'first_match' => $firstMatchWord ,
                'suggested_queries' => array_reverse($queries) ,
                'suggested_categories' => $categories
            ]
        ], 200);
        
    }
    
    private $defaultQueryParams = [
        'q' => '' ,
        'category' => null ,
        'brand' => null ,
        'sort' => 'mostFavorite' , // priceMin , priceMax , dateRecent , mostFavorite
        'fromPrice' => 0 ,
        'toPrice' => 10000000000 ,
        'available' => false ,
        'page' => 1 ,
        'perPage' => 20
    ];
    

    public function search(Request $request) 
    {
        $sp = $this->parseParams( $request->query() );

        if( $sp["q"] == '' && $sp["category"] == null && $sp["brand"] == null ) {
            return response()->json([
                'code' => 400 ,
                'message' => 'Define at least one of this : search query or category or brand'
            ], 400);
        }

        $products = Product::where('title','LIKE', "%{$sp["q"]}%");
        
        // // join with favorites sub sql
        $favorites = Favorite::selectRaw('product_id, COUNT(user_id) as favorites_count')
        ->groupBy('product_id');

        $products = $products->leftJoinSub($favorites, 'product_favorites', function ($join) {
            $join->on('products.id', '=', 'product_favorites.product_id');
        });

        // join with offers sub sql
        $priceFunc = 'MIN';
        $priceOrder = 'asc';
        if($sp['sort'] == 'priceMax') {
            $priceFunc = 'MAX';
            $priceOrder = 'desc';
        }

        $offers = Offer::selectRaw("product_id, is_available, $priceFunc(price) as price_start, COUNT(shop_id) as shops_count");
        
        // if( isset( $request->query()['available'] ) )
        //     $offers = $offers->where('is_available', '=', false);

        $offers = $offers->groupBy('product_id', 'is_available');

        $products = $products->leftJoinSub($offers, 'product_shops', function ($join) {
            $join->on('products.id', '=', 'product_shops.product_id');
        })
        ->orderBy('price_start', $priceOrder); // sort by price

        // category
        if( $sp["category"] ) {
            $cid = Category::where('name', '=',  $sp["category"]  )->get('id');
            if( count($cid) == 1 ) {
                $cid = $cid[0]->id;

                $categoryIDs = ProductCategory::where('category_id', '=', $cid)->select('product_id','category_id');

                $products = $products->leftJoinSub($categoryIDs, 'product_category_ids', function ($join) {
                    $join->on('products.id', '=', 'product_category_ids.product_id');
                });

                $products = $products->where('category_id', '=', $cid);
            }
        }

        // brand
        if( $sp["brand"] ) {
            $bid = Brand::where('name', '=',  $sp["brand"]  )->get('id');
            if( count($bid) == 1 ) {
                $bid = $bid[0]->id;
                $products = $products->where('brand_id', '=', $bid);
            }
        }

        // date filter
        if(  $sp['sort'] == 'dateRecent' ) {
            $products = $products->orderBy('id', 'desc');
        }

        // // favorite filter
        if(  $sp['sort'] == 'mostFavorite' ) {
            $products = $products->orderBy('favorites_count', 'desc');
        }

        // // price filter
        if(  isset( $request->query()['fromPrice'] ) || isset( $request->query()['toPrice'] ) ) {
            $products = $products->where('price_start', '>=', $sp['fromPrice'])->where('price_start', '<=', $sp['toPrice']);
        }

        // pagination
        $products = $products
            ->skip( ($sp["page"] - 1) * $sp["perPage"] )
            ->take( $sp["perPage"] );

        $products = $products
        ->get(['title','image_url', 'is_available', 'price_start', 'shops_count']);
        // ->get();

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok' ,
            'data' => $products
        ], 200);
        
    }

    private function parseParams($query) 
    {
        $params = $this->defaultQueryParams;

        foreach($this->defaultQueryParams as $key => $val)
            $params[$key] = isset($query[$key]) ? $query[$key] : $val;

        return $params;
    }


}
