<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryBrand;
use App\Http\Functions\CategoryFunctions;

class CategoryController extends Controller
{
    
    public function getAll(Request $request)
    {
        $date = [];
        $topCategoriesIDs = Category::where('level', 1)->get();

        foreach($topCategoriesIDs as $topc)
            $data[] = CategoryFunctions::GetCategoriesTree($topc->id);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $data
        ], 200);
    }

    public function getSubCategories(Request $request, $categoryName)
    {
        $category = Category::where('name', $categoryName)->get();
        
        if( count($category) != 1 ) 
            return response()->json([
                'message' => 'No category found.'
            ], 404);

        $subCategories = CategoryFunctions::GetSubCategoriesByName($category[0]->name);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $subCategories
        ], 200);
    }

    public function getBrands(Request $request, $categoryName)
    {
        $category = Category::where('name', '=', $categoryName)->get();
        $brands = [];

        if( count($category) != 1 ) return;
        
        $brandsIDs = CategoryBrand::where('category_id', '=', $category[0]->id)->get('brand_id');
        foreach($brandsIDs as $bid)
            $brands[] = Brand::find($bid->brand_id);
                
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $brands
        ], 200);
    }

    public function getPath(Request $request, $categoryName)
    {
        $path = [];
        $category = Category::where('name', '=', $categoryName)->get();
        if( count($category) == 0 ) return;

        if($category[0]->level != 1 ) {
            $path[] = $category[0];
            $category = $category[0];

            while( $category->level != 1 ) {
                $category = Category::where('id', '=', $category->parent_id)->get();
                $category = $category[0];
                $path[] = $category;
            }
        }
        else
            $path[] = $category[0];
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => array_reverse($path)
        ], 200);

    }

}
