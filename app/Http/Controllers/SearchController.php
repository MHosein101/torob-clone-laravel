<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;

class SearchController extends Controller
{
    public $defaultQueryParams = [
        'category' => null ,
        'brand' => null ,
        'sort' => 'dateNew' , // priceMin , priceMax , dateNew , mostFavorite
        'priceMin' => 0 ,
        'priceMax' => 10000000000 ,
        'available' => false ,
        'page' => 1 ,
        'perPage' => 20
    ];
    
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
    
    public function search(Request $request, $text) 
    {
        $searchParams = $this->parseParams( $request->query() );

        // $products = Product::where('title','LIKE', "%$text%");

        // if($searchParams["category"]) {
        //     $cid = Category::where('name', '=', $searchParams["category"])->get('id');
        //     if($cid) {
        //         $cid = $cid[0]->id;
        //     }
        //     $products = $products->where('category_id', '=', $cid);
        // }

        // $products = $products
        //     ->skip( ($searchParams['page'] - 1) * $searchParams['perPage'] )
        //     ->take($searchParams['perPage'])
        //     ->get();

        // for($i = 0 ; $i < count($products); $i++) {
        //     $p = $products[$i];

        //     $poffers = Offer::where('product_id', '=', $p->id)->orderBy('price')->get();

        //     $products[$i]["shops_count"] = count($poffers);
        //     $products[$i]["price_start"] = $poffers[0]->price;
            
        //     $pav = Offer::where('product_id', '=', $p->id)->where('is_available', '=', 1)->get();
        //     if( count($pav) == 0 ) 
        //         $products[$i]["price_start"] = -1;

        // }

        $p1 = Product::where('title','LIKE', "%$text%")->get();

        // $p2 = DB::table('products')
        // ->leftJoin('offers', 'products.id', '=', 'offers.product_id')
        // ->where('products.title','LIKE', "%$text%")
        // ->selectRaw('products.title , offers.price, offers.is_available, COUNT(shop_id) as shops_count')
        // ->groupBy('shop_id', 'products.title' , 'offers.price', 'offers.is_available')
        // ->get();

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok' ,
            'data' =>  $p1
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
