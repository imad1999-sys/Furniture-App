<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Favorites;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function addToFavorites(Request $request)
    {
        $fav = new Favorites();
        $fav->product_id = $request->input('product_id');
        $product_check = Product::where('id', $fav->product_id);
        if ($product_check) {
            if (Favorites::where('product_id', $fav->product_id)->exists()) {
                return ['result' =>  " Already added to favorites"];
            } else {
                $fav->save();
                return ["result" => "product has been added to favorites successfully"];
            }
        }
    }

    public function fetchAllProductsFromFavorites()
    {
        $data = Favorites::join('products', 'products.id', '=', 'favorites.product_id')
            ->get(['products.name', 'products.image', 'products.quantity', 'products.small_description', 'products.selling_price', 'favorites.id']);
        return ["data" => $data];
    }

    public function deleteProductFromFavorites($id)
    {
        $result = Favorites::where('id', $id)->delete();
        if ($result) {
            return ["result" => "product has been deleted"];
        } else {
            return ["result" => "operation failed"];
        }
    }
}
