<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Functions\SearchFunctions;
use App\Http\Functions\ProductFunctions;
use App\Http\Functions\CategoryFunctions;

class ProductController extends Controller
{

    /**
     * Show detail of requested product
     *
     * @param product  product object from middleware
     * 
     * @return Json (Array of String , Product)
     */ 
    public function showDetail(Request $request)
    {
        $product = $request->product;
        
        $data = ProductFunctions::GetBrandAndCategories($product->id, $product->brand_id);
        $brand = $data[0]; $categories = $data[1];
        
        $productPath = ProductFunctions::MakeProductPath($brand, $categories);

        $pricesRange = ProductFunctions::GetPricesRange($product->id);

        $otherModels = ProductFunctions::GetOtherModels($product->model_name, $product->model_trait);

        $chartData = ProductFunctions::GetChartPricesData($product->id);
        
        $isMobile = ProductFunctions::IsMobile($product->title);
        $shopsOffers = ProductFunctions::GetShopsOffers($product->id, false);
        $firstCheapShop = ProductFunctions::GetShopsOffers($product->id, $isMobile)[0];
        
        unset($product["id"]);
        unset($product["brand_id"]);

        return response()->json([
            'message' => 'Ok' ,
            'data' => [
                'prices_range' => $pricesRange ,
                'path' => $productPath ,
                'cheapest_shop_url' => $firstCheapShop['offer']['redirect_url'] ,
                'product' => $product ,
                'models' => $otherModels ,
                'sales' => $shopsOffers ,
                'brand' => $brand ,
                'categories' => $categories ,
                'chart' => $chartData
            ]
        ], 200);
    }


    /**
     * Shops Offers filter default params
     * @var Array
     */
    private $soDefaultParams = [
        'provinces' => null ,
        'cities' => null
    ];

    /**
     * Get shops offers related to product >>>>>> TODO : filter by province and city
     *
     * @param product  product object from middleware
     * 
     * @return Json (Array of String , Product)
     */ 
    public function getShopsOffers(Request $request)
    {
        $product = $request->product;
        $params = SearchFunctions::ConfigQueryParams($request->query(), $this->soDefaultParams);

        $provinces = null;
        $cities = null;

        if($params['provinces'] != null)
            $provinces = explode('|', $params['provinces']);
            
        if($params['cities'] != null)
            $cities = explode('|', $params['cities']);


        $filteredShopsOffers = ProductFunctions::GetShopsOffers($product->id, false, $provinces, $cities);

        $ignoreIDs = [];
        foreach($filteredShopsOffers as $f)
            $ignoreIDs[] = $f['shop']['id'];

        $otherShopsOffers = ProductFunctions::GetShopsOffers($product->id, false, null, null, $ignoreIDs);
        
        return response()->json([
            'message' => 'Ok' ,
            'counts' => [  'filtered' => count($filteredShopsOffers) , 'others' => count($otherShopsOffers)  ] ,
            'data' => [
                'filtered' => $filteredShopsOffers ,
                'others' => $otherShopsOffers
            ]
        ], 200);
    }
    
    /**
     * Similar products pagination default params
     * @var Array
     */
    private $spDefaultParams = [
        'page' => 1 ,
        'perPage' => 24
    ];

    /**
     * Get similar products in brand and category of one product
     *
     * @param product  product object from middleware
     * 
     * @return Json (Array of String , Product)
     */ 
    public function getSimilarProducts(Request $request)
    {
        $product = $request->product;
        $params = SearchFunctions::ConfigQueryParams($request->query(), $this->spDefaultParams);

        $data = ProductFunctions::GetBrandAndCategories($product->id, $product->brand_id);
        $brand = $data[0]; 
        $category = $data[1][ count($data[1]) - 1 ];

        $take = $params["perPage"];
        $skip = ( $params["page"] - 1 ) * $params["perPage"];

        $qbuilder = SearchFunctions::joinTables( new Product );
        $suggestedQueries = SearchFunctions::SuggestSearchQuery($product->title, $take, $skip);
        $suggestedQueries[0] = $suggestedQueries[1];
        $qbuilder = SearchFunctions::LimitProductsWithQueries($suggestedQueries, clone $qbuilder);

        $categoryIDs = ProductCategory::where('category_id', $category->id)->select('product_id','category_id');
        $qbuilder = $qbuilder->leftJoinSub($categoryIDs, 'product_category_ids', function ($join) {
            $join->on('products.id', 'product_category_ids.product_id');
        })
        ->where('products.id', '!=', $product->id)
        ->where('price_start', '!=', null)
        ->orderBy('id', 'desc');

        $similarProducts = $qbuilder->take($take)->skip($skip)
        ->get(['id', 'hash_id', 'title', 'image_url', 'price_start', 'shops_count']);
        
        $similarProducts = SearchFunctions::processResults($similarProducts);
        
        return response()->json([
            'message' => 'Ok' ,
            'count' => count($similarProducts) ,
            'data' => $similarProducts
        ], 200);
    }


}
