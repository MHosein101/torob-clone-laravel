<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    
    public function suggestion(Request $request, $text)
    {
        $matchedTitles = Product::where('title','LIKE', "%$text%")->take(6)->get('title');
        $queries = [];
        foreach($matchedTitles as $t) $queries[] = $t->title;

        $matchedCategories = Product::where('title','LIKE', "%$text%")->distinct('category_id')->take(4)->get('category_id');
        $categories =[];

        for($i = 0; $i < count($matchedCategories); $i++) {
            $cid = $matchedCategories[$i]->category_id;
            $categories[] = Category::where('id','=', $cid)->get()->first()->name;
        }

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok' ,
            'data' => [
                'suggested_queries' => $queries ,
                'suggested_categories' => $categories
            ]
        ], 200);
        
    }
    
    public function search(Request $request, $text) 
    {
        
        

        return response()->json([
            'code' => 200 ,
            'message' => 'Ok' ,
            'data' => $text
        ], 200);
        
    }
}
