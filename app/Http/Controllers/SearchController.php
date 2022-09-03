<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Functions\SearchFunctions;
use App\Http\Functions\CategoryFunctions;

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

        $categories = SearchFunctions::SuggestCategoriesBySearchedText($text);

        return response()->json([
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
        $sp = SearchFunctions::ConfigQueryParams($request->query(), $this->defaultQueryParams);

        if( $sp["q"] == '' && $sp["category"] == null && $sp["brand"] == null ) {
            return response()->json([
                'message' => 'Define at least one of this : search query or category or brand'
            ], 400);
        }

        $products = Product::where('title','LIKE', "%{$sp["q"]}%");

        $_products = clone $products;
        if( count($_products->get()) == 0 ) {
            return response()->json([
                'message' => 'No results.'
            ], 200);
        }

        $suggestedCategories = null;
        
        // // join with favorites sub sql
        $favorites = Favorite::selectRaw('product_id, COUNT(user_id) as favorites_count')
        ->groupBy('product_id');

        $products = $products->leftJoinSub($favorites, 'product_favorites', function ($join) {
            $join->on('products.id', '=', 'product_favorites.product_id');
        });

        // join with offers sub sql
        $offers = Offer::selectRaw("product_id, MIN(price) as price_start, COUNT(shop_id) as shops_count")->groupBy('product_id');
        
        // if( isset( $request->query()['available'] ) )
        //     $offers = $offers->where('is_available', '=', false);

        // $offers = $offers->where('is_available', '=', true);

        $products = $products->leftJoinSub($offers, 'product_shops', function ($join) {
            $join->on('products.id', '=', 'product_shops.product_id');
        });

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

            $suggestedCategories = CategoryFunctions::GetSubCategoriesByName($sp["category"]);
        }
        else {
            $suggestedCategories = SearchFunctions::SuggestCategoriesBySearchedText($sp["q"]);
        }

        // brand
        if( $sp["brand"] ) {
            $bid = Brand::where('name', '=',  $sp["brand"]  )->get('id');
            if( count($bid) == 1 ) {
                $bid = $bid[0]->id;
                $products = $products->where('brand_id', '=', $bid);
            }
        }

        $productsPriceMin = clone $products;
        $productsPriceMax = clone $products;
        
        // sort by price
        $priceOrder = 'asc';
        if($sp['sort'] == 'priceMax')
            $priceOrder = 'desc';
        $products = $products->orderBy('price_start', $priceOrder);

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
        ->get(['title','image_url', 'price_start', 'shops_count']);
        // ->get();

        $productsPriceMin = $productsPriceMin->orderBy('price_start', 'asc')->first()->price_start;
        $productsPriceMax = $productsPriceMax->orderBy('price_start', 'desc')->get()->first()->price_start;

        return response()->json([
            'message' => 'Ok' ,
            'data' => [
                'price_range' => [ 'min' => $productsPriceMin , 'max' => $productsPriceMax ] ,
                'suggested_categories' => $suggestedCategories ,
                'products' => $products
            ]
        ], 200);
        
    }


}
