<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showDetail(Request $request, $productTitle)
    {
        // $category = Category::where('name', '=', $categoryName)->get();
        // $brands = [];

        // if( count($category) == 1 ) {
        //     $brandsIDs = CategoryBrand::where('category_id', '=', $category[0]->id)->get('brand_id');
        //     foreach($brandsIDs as $bid)
        //         $brands[] = Brand::find($bid->brand_id);
        // }
        
        // return response()->json([
        //     'code' => 200 ,
        //     'message' => 'Ok' ,
        //     'data' => $brands
        // ], 200);
    }
}
