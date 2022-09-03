<?php

namespace App\Http\Functions;

use App\Models\Category;

class CategoryFunctions {

    public static function GetSubCategoriesByName($categoryName) {
        $category = Category::where('name', '=', $categoryName)->get();
        $secondOutput = [null];

        if( count($category) != 1 ) return;
        
        $category = $category[0];
        $subCategories = [];
        
        if($category->level == 1) {
            $secondOutput[] = $category->name;

            $subIDs = Category::where('parent_id', '=', $category->id)->get('id');
            foreach($subIDs as $sid) {
                $c = Category::where('id', '=', $sid->id)->first();
                $subCategories[] = $c;
                $secondOutput[] = $c->name;
            }
        }
        else if($category->level == 2) {
            
            $secondOutput[] = $category->name;

            $category = Category::find($category->parent_id);

            $secondOutput[] = $category->name;

            $subIDs = Category::where('parent_id', '=', $category->id)->get('id');
            foreach($subIDs as $sid) {
                $c = Category::where('id', '=', $sid->id)->first();
                $subCategories[] = $c;
                $secondOutput[] = $c->name;

            }
        }
        else if($category->level == 3) {
            $categorySub = Category::find($category->parent_id);

            $secondOutput[1] = $categorySub->name;

            $category = Category::find($categorySub->parent_id);

            $secondOutput[0] = $category->name;

            $subIDs = Category::where('parent_id', '=', $categorySub->id)->get('id');
            foreach($subIDs as $sid) {
                $c = Category::where('id', '=', $sid->id)->first();
                $subCategories[] = $c;
                $secondOutput[] = $c->name;
            }

            $categorySub["status"] = false;
            $categorySub["is_sub_category"] = true;
            $categorySub["sub_categories"] = $subCategories;
            $category["status"] = false;
            $category["is_sub_category"] = true;
            $category["sub_categories"] = $categorySub;
        }
        
        // return $category;
        return $secondOutput;
    }

}