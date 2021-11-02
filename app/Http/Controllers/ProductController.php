<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    public function createProduct(Request  $request){
        $this->validate($request, [
            'name' => 'required',
        ]);
        $this->validate($request, [
            'description' => 'required',
        ]);
        $this->validate($request, [
            'selling_price' => 'required',
        ]);
        $this->validate($request, [
            'image' => 'required',
        ]);
        $this->validate($request, [
            'original_price' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->category_name = $request->input('category_name');
        $product->category_id = $request->input('category_id');
        $product->quantity = $request->input('quantity');
        $product->tax = $request->input('tax');
        $product->description = $request->input('description');
        $product->small_description = $request->input('small_description');
        $product->image = $request->input('image');
        $product->original_price = $request->input('original_price');
        $product->selling_price = $request->input('selling_price');
        $product->status = $request->input('status') == TRUE ? '1' : '0';
        $product->trending = $request->input('trending') == TRUE ? '1' : '0';
        $product->save();
        return $product;
    }
    public function getAllProducts(){
        $data = Product::all();
        return $data;
    }
    public function getProductById($id){
        return Product::find($id);
    }
    public function searchForProduct($key){
        return Product::where('name' , 'LIKE' , "%$key%")->get();
    }
    public function getAllTrendingProducts(){
        return Product::where('trending' , '1')->get();
    }
    public function updateProduct($id , Request $request){
        $product = Product::find($id);
        $product->quantity = $request->input('quantity');
        $product->update();
        $product->save();
        return $product;
    }
    public function deleteCategoryById($id){
        $result = Product::where('id' , $id)->delete();
        if($result){
            return ["result" => "product has been deleted"];
        }else{
            return ["result" => "operation failed"];
        }
    }
}
