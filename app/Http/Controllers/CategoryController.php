<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorites;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        $category = new Category();
        $category->image = $request->input('image');
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status') == TRUE ? '1' : '0';
        $category->popular = $request->input('popular') == TRUE ? '1' : '0';
        $category->meta_title = $request->input('meta_title');
        $category->meta_keywords = $request->input('meta_keywords');
        $category->meta_descrip = $request->input('meta_descrip');
        $category->save();
        return $category;
    }
    public function getAllPopularCategories(){
        $data = Category::where('categories.popular' , '1')->get();
        return $data;
    }
    public function getAllCategories(){
        return Category::all();
    }
    public function deleteCategoryById($id){
        $result = Category::where('id' , $id)->delete();
        if($result){
            return ["result" => "category has been deleted"];
        }else{
            return ["result" => "operation failed"];
        }
    }
    public function getProductsByCategories(){
        if(Category::where('categories.popular' , '1')){
            $data = Category::join('products' , 'products.category_name' , '=' , 'categories.name')->get(['products.*' ,]);
            return $data;
        }else{
            return array(["result" => "No Products in this category"]);
        }
    }
}
