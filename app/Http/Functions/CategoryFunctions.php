<?php

namespace App\Http\Functions;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrand;

class CategoryFunctions {

    public static function GetSubCategories($val) {
        $categories = [];

        $subIDs = Category::where('parent_id', '=', $val)->get('id');
        foreach($subIDs as $sid) {
            $c = Category::where('id', '=', $sid->id)->first();
            $categories[] = $c;
        }

        return $categories;
    }

    public static function GetSubCategoriesByName($categoryName) {
        $category = Category::where('name', '=', $categoryName)->get();
        if( count($category) != 1 ) return;
    
        $category = $category[0];
        $subCategory = null;
        $subCategorySubCategories = null;
        
        switch($category->level) {
            case 1:
                return [
                    'id' => $category->id ,
                    'name' => $category->name ,
                    'sub_categories' => CategoryFunctions::GetSubCategories($category->id)
                ];
                break;
            case 2:
                $subCategory = clone $category;
                $category = Category::find($category->parent_id);
                $subCategorySubCategories = CategoryFunctions::GetSubCategories($subCategory->id);
                break;
            case 3:
                $subCategory = Category::find($category->parent_id);
                $category = Category::find($subCategory->parent_id);
                $subCategorySubCategories = CategoryFunctions::GetSubCategories($subCategory->id);
                break;
        }
        
        return [
            'id' => $category->id ,
            'name' => $category->name ,
            'sub_categories' => [
                'id' => $subCategory->id ,
                'name' => $subCategory->name ,
                'sub_categories' => $subCategorySubCategories
            ]
        ];
    }

    public static function GetBrandsInCategory($categoryID) {
        $brandsIDs = CategoryBrand::where('category_id', '=', $categoryID)->get('brand_id');

        $brands = [];
        foreach($brandsIDs as $bid)
            $brands[] = Brand::find($bid);

        return $brands;
    }

}