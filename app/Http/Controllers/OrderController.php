<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder($id , Request $request){
        $order = new Order();
        $order->user_id = $id;
        $order->first_name = $request->input('first_name');
        $order->last_name = $request->input('last_name');
        $order->first_address = $request->input('first_address');
        $order->second_address = $request->input('second_address');
        $order->city = $request->input('city');
        $order->state = $request->input('state');
        $order->country = $request->input('country');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');
        $order->pincode = $request->input('pincode');
        $order->tracking_no = 'furniture'.rand(0 , 1000);
        $total = 0;
        $cartTotal = Cart::where('user_id' , $id)->get();
        foreach ($cartTotal as $item){
            $prod = Product::where('id' , $item->product_id)->first();
            $total += $prod->selling_price * $item->quantity;
        }
        $order->total_price = $total;
        $order->save();

        $cartItems = Cart::where('user_id' , $id)->get();
        foreach ($cartItems as $item){
            $prod = Product::where('id' , $item->product_id)->first();
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $prod->selling_price,
            ]);
        }
        $cartItems = Cart::all();
        Cart::destroy($cartItems);
        return $order;
    }
    public function viewOrder(){
        return Order::join('order_items' , 'order_items.order_id' , '=' , 'orders.id')
            ->join('products' , 'products.id' , '=' , 'order_items.product_id')
            ->get(['orders.*' , 'order_items.*' , 'products.*']);
    }
    public function allOrders(){
        return Order::all();
    }
}
