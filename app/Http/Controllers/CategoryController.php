<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    
    public function getAll(Request $request)
    {
        $data = [];
        $topsCategories = Category::where('is_top', '=', true)->where('parent_id', '=', null)->get();

        for($i = 0; $i < count($topsCategories); $i++) {

            $currentTop = $topsCategories[$i];
            $secondCategoriesList = Category::where('parent_id', '=', $currentTop->id)->get();
            $subCategories = [];

            for($j = 0; $j < count($secondCategoriesList); $j++) {
                $currentSecond = $secondCategoriesList[$j];
                $childCategories = Category::where('parent_id', '=', $currentSecond->id)->get();
                $currentSecond["sub_categories"] = $childCategories;
                $subCategories[] = $currentSecond;
            }
            
            $data[$i] = $currentTop;
            $data[$i]["sub_categories"] = $subCategories;
        }

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok' ,
            'data' => $data
        ], 200);
    }

}
