<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    public function suggestion(Request $request, $text)
    {
        $matchedTitles = Product::where('title','LIKE', "%$text%")->take(6)->get('title');
        $queries = [];
        foreach($matchedTitles as $t) $queries[] = $t->title;

        $matchedCategories = Product::where('title','LIKE', "%$text%")->distinct('category_id')->take(4)->get('category_id');
        $categories =[];

        for($i = 0; $i < count($matchedCategories); $i++) {
            $cid = $matchedCategories[$i]->category_id;
            $categories[] = Category::where('id','=', $cid)->get()->first()->name;
        }

        return response()->json([
            'code' => 200 ,
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
        'sort' => 'dateNew' , // priceMin , priceMax , dateNew , mostFavorite
        'priceMin' => 0 ,
        'priceMax' => 10000000000 ,
        'available' => false ,
        'page' => 1 ,
        'perPage' => 20
    ];
    

    public function search(Request $request) 
    {
        $sp = $this->parseParams( $request->query() );

        $products = Product::where('title','LIKE', "%{$sp["q"]}%");
        
        // join with favorites sub sql
        $favorites = Favorite::selectRaw('product_id, COUNT(user_id) as favorites_count')
        ->groupBy('product_id');

        $products = $products->leftJoinSub($favorites, 'product_favorites', function ($join) {
            $join->on('products.id', '=', 'product_favorites.product_id');
        });

        // join with offers sub sql
        $priceFunc = 'MIN';
        if($sp['sort'] == 'priceMax') 
            $priceFunc = 'MAX';

        $offers = Offer::selectRaw("product_id, is_available, $priceFunc(price) as price_start, COUNT(shop_id) as shops_count");
        
        if( isset( $request->query()['available'] ) )
            $offers = $offers->where('is_available', '=', true);

        $offers = $offers->groupBy('product_id', 'is_available');

        $products = $products->leftJoinSub($offers, 'product_shops', function ($join) {
            $join->on('products.id', '=', 'product_shops.product_id');
        });

        // category
        if( $sp["category"] ) {
            $cid = Category::where('name', '=',  $sp["category"]  )->get('id');
            if( count($cid) == 1 ) {
                $cid = $cid[0]->id;
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
        if(  $sp['sort'] == 'dateNew' ) {
            $products = $products->orderBy('id', 'desc');
        }

        // favorite filter
        if(  $sp['sort'] == 'mostFavorite' ) {
            $products = $products->orderBy('favorites_count', 'desc');
        }

        // price filter
        if(  isset( $request->query()['priceMin'] ) || isset( $request->query()['priceMax'] ) ) {
            $products = $products->where('price_start', '>=', $sp['priceMin'])->where('price_start', '<=', $sp['priceMax']);
        }

        // pagination
        $products = $products
            ->skip( ($sp["page"] - 1) * $sp["perPage"] )
            ->take( $sp["perPage"] );

        $products = $products->get(['title','image_url', 'is_available', 'price_start', 'shops_count', 'products.id', 'products.brand_id', 'products.category_id']);

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
