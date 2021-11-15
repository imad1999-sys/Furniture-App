<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request , $id)
    {
        $product_id = $request->input('product_id');
        $product_check = Product::where('id', $product_id);
        if ($product_check) {
            if (Cart::where('product_id', $product_id)->exists()) {
                return ['result' =>  " Already added to cart"];
            } else {
                $cart = new Cart();
                $cart->product_id = $product_id;
                $cart->quantity = $request->input('quantity');
                $cart->user_id = $id;
                $cart->save();
                return ['result' => "Added to cart successfully"];
            }
        } else {
            return ['result' => "error in adding to cart"];
        }
    }

    public function getAllProductsFromCart()
    {
        $data = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->get(['products.*', 'carts.*']);
        return ["data" => $data];
    }

    public function getProductByIdFromCart($id)
    {
        $data = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->where('carts.product_id', $id)
            ->get(['products.*', 'carts.quantity']);
        return $data;
    }

    public function deleteProductFromCart($id)
    {
        $result = Cart::where('id', $id)->delete();
        if ($result) {
            return ["result" => "product has been deleted"];
        } else {
            return ["result" => "operation failed"];
        }
    }

    public function updateProductInCartById($id , Request $request)
    {
            $cart = Cart::find($id);
            $cart->quantity = $request->input('quantity');
            $cart->update();
            $cart->save();
            return ["result" => "the product has been updated successfully"];
    }
    public function checkoutCart(){
        $cartItems = Cart::all();
        return $cartItems;
    }
}
