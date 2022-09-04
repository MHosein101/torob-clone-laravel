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
        $data = [];
        $topParentCategories = Category::where('level', '=', 1)->where('parent_id', '=', null)->get();

        foreach($topParentCategories as $currentTopParent) { // get second level categories

            $secondParentsCategoriesList = Category::where('parent_id', '=', $currentTopParent->id)->get();
            $subCategories = [];

            foreach($secondParentsCategoriesList as $currentSecondParent) { // get third level categories

                $brandsIDs = CategoryBrand::where('category_id', '=', $currentSecondParent->id)->get('brand_id');
                $brands = [];
                foreach($brandsIDs as $bid)
                    $brands[] = Brand::find($bid->brand_id);
                
                $currentSecondParent["brands"] = $brands;
                $childCategories = Category::where('parent_id', '=', $currentSecondParent->id)->get();
                $currentSecondParent["sub_categories"] = $childCategories;
                $subCategories[] = $currentSecondParent;
            }

            
            $currentTopParent["status"] = false;
            $currentTopParent["is_sub_category"] = true;
            $currentTopParent["sub_categories"] = $subCategories;
            $data[] = $currentTopParent;
        }

        return response()->json([
            'message' => 'Ok' ,
            'data' => $data
        ], 200);
    }

    public function getSubCategories(Request $request, $categoryName)
    {
        $subCategories = CategoryFunctions::GetSubCategoriesByName($categoryName);

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
            $cpid = $category[0]->parent_id;

            while( $cpid != null ) {
                $category = Category::where('id', '=', $cpid)->get();
                $path[] = $category[0];
                $cpid = $category[0]->parent_id;
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
