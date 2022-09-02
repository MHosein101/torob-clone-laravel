<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;

class CategoryController extends Controller
{
    
    public function getAll(Request $request)
    {
        $data = [];
        $topParentCategories = Category::where('is_parent', '=', true)->where('parent_id', '=', null)->get();

        foreach($topParentCategories as $currentTopParent) { // get second level categories

            $secondParentsCategoriesList = Category::where('parent_id', '=', $currentTopParent->id)->get();
            $subCategories = [];

            foreach($secondParentsCategoriesList as $currentSecondParent) { // get third level categories

                $brandsList = Brand::where('category_id', '=', $currentSecondParent->id)->get('name');
                $brands = [];
                if($brandsList) {
                    foreach($brandsList as $b)
                        $brands[] = $b->name;
                }
                
                $currentSecondParent["brands"] = $brands;
                $childCategories = Category::where('parent_id', '=', $currentSecondParent->id)->get();
                $currentSecondParent["sub_categories"] = $childCategories;
                $subCategories[] = $currentSecondParent;
            }

            
            $currentTopParent["status"] = false;
            $currentTopParent["is_sub_category"] = (boolean)$currentTopParent->is_parent;
            $currentTopParent["sub_categories"] = $subCategories;
            $data[] = $currentTopParent;
        }

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok' ,
            'data' => $data
        ], 200);
    }

    public function getBrands(Request $request, $cname)
    {
        $cat = Category::where('name', '=', $cname)->get();
        if( count($cat) == 1 ) {
            $brands = Brand::where('category_id', '=', $cat[0]->id)->get('name');
            $data = [];
            foreach($brands as $b) 
                $data[] = $b->name;
            
            return response()->json([
                'code' => 200 ,
                'message' => 'Ok' ,
                'data' => $data
            ], 200);
        }
    }

    public function getPath(Request $request, $cname)
    {

        $path = [ $cname ];
        $category = Category::where('name', '=', $cname)->get();
        if( count($category) == 1 && $category[0]->parent_id != null ) {

            $cpid = $category[0]->parent_id;
            while( $cpid != null ) {

                $category = Category::where('id', '=', $cpid)->get();
                $path[] = $category[0]->name;
                $cpid = $category[0]->parent_id;
            }
        }

    }

}
