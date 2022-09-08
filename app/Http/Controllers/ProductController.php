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
     * @param ptitle  product title
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

        $otherModels = ProductFunctions::GetOtherModels($product->model_id, $product->model_trait);

        $chartData = ProductFunctions::GetChartPricesData($product->id);

        return response()->json([
            'message' => 'Ok' ,
            'data' => [
                'prices_range' => $pricesRange ,
                'path' => $productPath ,
                'product' => $product ,
                'models' => $otherModels ,
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
     * @param ptitle  product title
     * 
     * @return Json (Array of String , Product)
     */ 
    public function getShopsOffers(Request $request)
    {
        $product = $request->product;
        $params = SearchFunctions::ConfigQueryParams($request->query(), $this->soDefaultParams);

        $shopsOffers = ProductFunctions::GetShopsOffers($product->id);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $shopsOffers
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
     * Get shops offers related to product >>>>>> TODO : filter by province and city
     *
     * @param ptitle  product title
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

        $qbuilder = SearchFunctions::joinTables( new Product )
        ->where('products.id', '!=', $product->id)
        ->where('products.brand_id', $brand->id);

        $categoryIDs = ProductCategory::where('category_id', $category->id)->select('product_id','category_id');

        $qbuilder = $qbuilder->leftJoinSub($categoryIDs, 'product_category_ids', function ($join) {
            $join->on('products.id', 'product_category_ids.product_id');
        });
        
        $similarProducts = $qbuilder->where('category_id', $category->id)
        ->orderBy('id', 'desc')
        ->take($take)->skip($skip)
        ->get(['hash_id', 'title', 'image_url', 'price_start', 'shops_count']);
        
        $similarProducts = SearchFunctions::processResults($similarProducts);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $similarProducts
        ], 200);
    }


}
