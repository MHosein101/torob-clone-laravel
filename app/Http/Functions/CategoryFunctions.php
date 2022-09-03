<?php

namespace App\Http\Functions;

use App\Models\Category;

class CategoryFunctions {

    public static function GetSubCategories($val) {
        $categories = [];

        $subIDs = Category::where('parent_id', '=', $val)->get('id');
        foreach($subIDs as $sid) {
            $c = Category::where('id', '=', $sid->id)->first();
            $categories[] = $c->name;
        }

        return $categories;
    }

    public static function GetSubCategoriesByName($categoryName) {
        $category = Category::where('name', '=', $categoryName)->get();
        if( count($category) != 1 ) return;
    
        $category = $category[0];
        $subCategories = [];
        
        switch($category->level) {
            case 1:
                $category = CategoryFunctions::GetSubCategories($category->id);
                break;
            case 2:
                $category = Category::find($category->parent_id);
                $subCategories = CategoryFunctions::GetSubCategories($category->id);
                
                $category = [
                    'name' => $category->name ,
                    'sub_categories' => $subCategories
                ];
                break;
            case 3:
                $category = Category::find($category->parent_id);
                $second = clone $category;
                $category = Category::find($second->parent_id);
                $subCategories = CategoryFunctions::GetSubCategories($second->id);

                $category = [
                    'name' => $category->name ,
                    'sub_categories' => [
                        'name' => $second->name ,
                        'sub_categories' => $subCategories
                    ]
                ];
                break;
        }
        return $category;
    }

}