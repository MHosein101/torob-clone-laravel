<?php

namespace App\Http\Functions;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrand;

class CategoryFunctions {

    /**
     * Check if category exists
     *
     * @param categoryName category name
     * 
     * @return Category or false
     */ 
    public static function Exists($categoryName) {
        if( $categoryName == null ) return false;

        $category = Category::where('name', $categoryName)->get();

        if( count($category) == 0 ) return false;

        return $category[0];
    }

    /**
     * Get children of a parent category to the end
     *
     * @param id first parent category id
     * 
     * @return Category
     */ 
    public static function GetCategoriesTree($id) {

        $category = Category::find($id); // find category
        $subCategoriesIDs = Category::where('parent_id', $id)->get(); // find children ids
        $brandsIDs = CategoryBrand::where('category_id', $category->id)->get(); // find brands

        if( count($brandsIDs) > 0 ) { // if has any brands , find them and set them
            $brands = [];

            foreach($brandsIDs as $b)
                $brands[] = Brand::find($b->id);

            $category["brands"] = $brands;
        }

        if(  count($subCategoriesIDs) > 0  ) { // if has any children
            $subCategories = [];

            // get every childrens sub category 
            foreach($subCategoriesIDs as $subc)
                $subCategories[] = CategoryFunctions::GetCategoriesTree($subc->id);

            $category["status"] = false;
            $category["is_sub_category"] = true;
            $category["sub_categories"] = $subCategories;
        }

        return $category;
    }

    /**
     * Get children of a parent category
     *
     * @param pid parent category id
     * 
     * @return CategoryArray
     */ 
    public static function GetSubCategories($pid) {
        $categories = [];

        $subIDs = Category::where('parent_id', $pid)->get('id');
        foreach($subIDs as $sid)
            $categories[] = Category::find($sid->id);

        return $categories;
    }

    /**
     * Get children and direct parents of category to the top
     *
     * @param categoryName category name
     * 
     * @return Category
     */ 
    public static function GetSubCategoriesByName($categoryName) {

        // check category name
        $category = CategoryFunctions::Exists($categoryName);
        if( !$category ) return [];

        $subCategories = CategoryFunctions::GetSubCategories($category->id);

        // if has no children then get the parent and its children
        if( count($subCategories) == 0 ) {
            $category = Category::where('id', $category->parent_id)->get()->first();
            $subCategories = CategoryFunctions::GetSubCategories($category->id);
        }
            
        $category['sub_categories'] = $subCategories;

        // until category is not the first parent do these
        while( $category->level != 1 ) {
            // find parent and set the current data as parent sub_categories
            $parentCategory = Category::where('id', $category->parent_id)->get()->first();
            $parentCategory['sub_categories'] = $category;
            $category = $parentCategory;
        }

        return $category;
    }

    /**
     * Get category path to top parent
     *
     * @param category current category
     * 
     * @return CategoryArray
     */ 
    public static function GetCategoryPath($category) {
        $path = [];

        $path[] = [ 'type' => 'category' , 'title' => $category->name ];

        if($category->level != 1 ) { // if its not the first level parent
            while( $category->level != 1 ) { // until its not the first level parent do these
                $category = Category::where('id', $category->parent_id)->get()->first(); // get parent category
                $path[] = [ 'type' => 'category' , 'title' => $category->name ]; // add to path
            }
        }

        return array_reverse($path);
    }

    /**
     * Get brands in a category
     *
     * @param categoryID brands category id
     * 
     * @return BrandArray
     */ 
    public static function GetBrandsInCategory($categoryID) {
        $brandsIDs = CategoryBrand::where('category_id', $categoryID)->get('brand_id'); // find brands ids

        $brands = [];
        // get brands
        foreach($brandsIDs as $bid)
            $brands[] = Brand::find($bid)->first();

        return $brands;
    }

}