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
        $delimiters = [' ', '.', '-', ',', '|', '\\', '/', '(', ')'];
        $newText = str_replace($delimiters, $delimiters[0], $text);
        $searchedWords = explode($delimiters[0], $newText);

        $productsTitle = [];
        foreach($searchedWords as $s) {
            $matchedProducts = Product::where('title','LIKE', "%$s%")->take(20)->get('title');
            foreach($matchedProducts as $p)
                $productsTitle[] = $p->title;
        }
        
        $queries = [];
        foreach($productsTitle as $title) {
            $newTitle = str_replace($delimiters, $delimiters[0], $title);
            $words = explode($delimiters[0], $newTitle);
            
            foreach($words as $w) {
                foreach($searchedWords as $s) {
                    if( strpos( strtolower($w), strtolower($s) ) !== false )
                        $queries[] = $w; 
                }
            }
        }
        $queries = array_reverse( array_unique($queries) );

        $categories = SearchFunctions::SuggestCategoriesBySearchedText($text);

        return response()->json([
            'message' => 'Ok' ,
            'data' => [
                'suggested_queries' => $queries ,
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
        $searchBrands = null;
        
        // // join with favorites sub sql
        $favorites = Favorite::selectRaw('product_id, COUNT(user_id) as favorites_count')
        ->groupBy('product_id');

        $products = $products->leftJoinSub($favorites, 'product_favorites', function ($join) {
            $join->on('products.id', '=', 'product_favorites.product_id');
        });

        // join with offers sub sql
        $offers = Offer::selectRaw("product_id, MIN(price) as price_start, COUNT(shop_id) as shops_count")
        ->where('is_available','=', true)->groupBy('product_id');
        $products = $products->leftJoinSub($offers, 'product_prices', function ($join) {
            $join->on('products.id', '=', 'product_prices.product_id');
        });

        // $offersAvailable = Offer::selectRaw("product_id, SUM(is_available), COUNT(shop_id)")->groupBy('product_id')
        // ->havingRaw('COUNT(shop_id) + SUM(is_available) = COUNT(shop_id)');
        // $products = $products->leftJoinSub($offersAvailable, 'product_availability', function ($join) {
        //     $join->on('products.id', '=', 'product_availability.product_id');
        // });

        // category
        if( $sp["category"] != null ) {
            $cid = Category::where('name', '=',  $sp["category"]  )->get('id');

            if( count($cid) == 1 ) {
                $cid = $cid[0]->id;

                $categoryIDs = ProductCategory::where('category_id', '=', $cid)->select('product_id','category_id');

                $products = $products->leftJoinSub($categoryIDs, 'product_category_ids', function ($join) {
                    $join->on('products.id', '=', 'product_category_ids.product_id');
                });

                $products = $products->where('category_id', '=', $cid);

                // $suggestedCategories = CategoryFunctions::GetSubCategoriesByName($sp["category"]);
                $searchBrands = CategoryFunctions::GetBrandsInCategory($cid);
            }
        }
        else { 
            // $suggestedCategories = SearchFunctions::SuggestCategoriesBySearchedText($sp["q"]); 
            $searchBrands = SearchFunctions::GetBrandsInSearch($sp["q"]);
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
        
        // just available results
        if( isset( $request->query()['available'] ) )
            $products = $products->where('price_start', '!=', null);

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

        $i = 0;
        foreach($products as $p) {
            if(  $p->price_start == null ) {
                $products[$i]["shops_count"] = 0;
                $products[$i]["is_available"] = false;
            }
            else
                $products[$i]["is_available"] = true;
            $i++;
        }

        $productsPriceMin = $productsPriceMin->where('price_start', '!=', null)->orderBy('price_start', 'asc')->get()->first()->price_start;
        $productsPriceMax = $productsPriceMax->where('price_start', '!=', null)->orderBy('price_start', 'desc')->get()->first()->price_start;

        return response()->json([
            'message' => 'Ok' ,
            'data' => [
                'price_range' => [ 'min' => $productsPriceMin , 'max' => $productsPriceMax ] ,
                'brands' => $searchBrands ,
                'suggested_categories' => $suggestedCategories ,
                'products' => $products
            ]
        ], 200);
        
    }


}
