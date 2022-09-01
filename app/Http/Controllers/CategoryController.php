<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    
    public function getAll(Request $request)
    {
        $data = [];
        $topParentCategories = Category::where('is_parent', '=', true)->where('parent_id', '=', null)->get();

        for($i = 0; $i < count($topParentCategories); $i++) {

            $currentTopParent = $topParentCategories[$i];

            $secondParentsCategoriesList = Category::where('parent_id', '=', $currentTopParent->id)->get();
            $subCategories = [];

            for($j = 0; $j < count($secondParentsCategoriesList); $j++) {
                $currentSecondParent = $secondParentsCategoriesList[$j];
                $childCategories = Category::where('parent_id', '=', $currentSecondParent->id)->get();

                $currentSecondParent["sub_categories"] = $childCategories;
                $subCategories[] = $currentSecondParent;
            }
            
            $currentTopParent["status"] = false;
            $currentTopParent["is_sub_category"] = (boolean)$currentTopParent->is_parent;
            $currentTopParent["sub_categories"] = $subCategories;
            $data[$i] = $currentTopParent;
        }

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok' ,
            'data' => $data
        ], 200);
    }

}
