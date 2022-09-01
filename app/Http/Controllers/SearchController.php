<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Offer;

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
        'category' => null ,
        'brand' => null ,
        'sort' => 'dateNew' , // priceMin , priceMax , dateNew , mostFavorite
        'priceMin' => 0 ,
        'priceMax' => 10000000000 ,
        'available' => false ,
        'page' => 1 ,
        'perPage' => 20
    ];
    

    public function search(Request $request, $text) 
    {
        $sp = $this->parseParams( $request->query() );

        $products = Product::where('title','LIKE', "%$text%");

        // category
        if( $sp["category"] ) {
            $cid = Category::where('name', '=',  $sp["category"]  )->get('id');
            if($cid) {
                $cid = $cid[0]->id;
            }
            $products = $products->where('category_id', '=', $cid);
        }

        // pagination
        $products = $products
            ->skip( ($sp["page"] - 1) * $sp["perPage"] )
            ->take( $sp["perPage"] );
        
        
        // get each product shops count
        $shopsCount = DB::table('offers')
        ->selectRaw('product_id, COUNT(shop_id) as shops_count')
        ->groupBy('product_id');

        $products = $products->leftJoinSub($shopsCount, 'product_shops_count', function ($join) {
            $join->on('products.id', '=', 'product_shops_count.product_id');
        });

        // sort
        switch( $sp["sort"] ) {
            case 'mostFavorite':
                $products = $products->orderBy('marked_as_favorite', 'desc'); break;
            
            case 'dateNew':
                $products = $products->orderBy('id', 'desc'); break;
                
            case 'priceMin':
                $products = $this->sortByPrice(true, $products); break;

            case 'priceMax':
                $products = $this->sortByPrice(false, $products); break;
        }

        // for($i = 0 ; $i < count($products); $i++) {
        //     $p = $products[$i];

        //     $poffers = Offer::where('product_id', '=', $p->id)->orderBy('price')->get();

        //     $products[$i]["shops_count"] = count($poffers);
        //     $products[$i]["price_start"] = $poffers[0]->price;
            
        //     $pav = Offer::where('product_id', '=', $p->id)->where('is_available', '=', 1)->get();
        //     if( count($pav) == 0 ) 
        //         $products[$i]["price_start"] = -1;

        // }

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok' ,
            'data' =>  $products->get()
        ], 200);
        
    }

    private function parseParams($query) 
    {
        $params = $this->defaultQueryParams;

        foreach($this->defaultQueryParams as $key => $val)
            $params[$key] = isset($query[$key]) ? $query[$key] : $val;

        return $params;
    }

    private function sortByPrice($isMinPrice, $products) 
    {

        return $products;
    }


}
