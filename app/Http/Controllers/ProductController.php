<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
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
        $brand = $data[0];
        $categories = $data[1];

        $pricesRange = ProductFunctions::GetPricesRange($product->id);

        $otherModels = ProductFunctions::GetOtherModels($product->model_id, $product->model_trait);

        return response()->json([
            'message' => 'Ok' ,
            'data' => [
                'prices_range' => $pricesRange ,
                'product' => $product ,
                'models' => $otherModels ,
                'brand' => $brand ,
                'categories' => $categories
            ]
        ], 200);
    }

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
        $shopsOffers = ProductFunctions::GetShopsOffers($product->id);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $shopsOffers
        ], 200);
    }
    

}
