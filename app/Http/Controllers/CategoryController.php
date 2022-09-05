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

    public function getSubCategories(Request $request)
    {
        $category = $request->category;

        $subCategories = CategoryFunctions::GetSubCategoriesByName($category->name);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $subCategories
        ], 200);
    }

    public function getBrands(Request $request, $categoryName)
    {
        $category = $request->category;
        $brands = CategoryFunctions::GetBrandsInCategory($category->id);

        return response()->json([
            'message' => 'Ok' ,
            'data' => $brands
        ], 200);
    }

    public function getPath(Request $request, $categoryName)
    {
        $path = [];
        $category = $request->category;

        $path[] = $category;
        if($category->level != 1 ) {
            while( $category->level != 1 ) {
                $category = Category::where('id', '=', $category->parent_id)->get();
                $category = $category[0];
                $path[] = $category;
            }
        }
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => array_reverse($path)
        ], 200);

    }

}
