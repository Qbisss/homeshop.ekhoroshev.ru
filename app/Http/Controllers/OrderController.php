<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProducts;

class OrderController extends Controller
{
    public function add_order(Request $request)
    {

        $cookie = Cookie::get('basket');
        if(!$cookie)
            return response()->json(['error' => "Корзина пустая"]);

        if(empty($request->delivery) || $request->delivery == "no")
            return response()->json(['error' => "Не выбран способ доставки"]);

        if(empty($request->fullName))
            return response()->json(['error' => "ФИО не заполнено"]);

        if(empty($request->phone))
            return response()->json(['error' => "Телефон не заполнен"]);

        if(empty($request->address))
            return response()->json(['error' => "Не заполнен адресс доставки"]);

        $order = new Order;
        $order->name = $request->fullName;
        $order->phone = $request->phone;
        $order->delivery = $request->delivery;
        $order->address = $request->address;
        $order->status = "Обрабатывается";
        if(Auth::check())
            $order->userid = Auth::id();

        $order->checkid = mt_rand(100000000, 999999999);
        $order->save();


        $basket = stripslashes($cookie);
        $basket = json_decode($basket, true);
        $itemIdList = array_column($basket, 'itemID');
        $products = Product::WhereIn('id', $itemIdList)->get();

        $sum = 0;
        foreach ($products as $product) {

            if(!$product || $product->active == 0)
                continue;

            $amount = $basket[$product->id]["itemCount"];
            $price = $product->newprice > 0 ? $product->newprice : $product->price;


            $orderProducts = new OrderProducts;
            $orderProducts->orderid = $order->id;
            $orderProducts->name =$product->name;
            $orderProducts->price = $price;
            $orderProducts->amount = $amount;

            $orderProducts->save();

        }

        Cookie::queue(Cookie::forget('basket'));
        $url = '/neworder/'.$order->checkid;
        return response()->json(["redirect_url" => $url]);
    }

    public function show_order($id)
    {
        $order = Order::where('checkid', $id)->first();
        if(!$order)
            return response()->json(['error' => "Заказ не найден"]);

        $products = OrderProducts::where('orderid', $order->id)->get();

        if(!$products)
            return response()->json(['error' => "Ошибка в заказе"]);

        return view('myorder', ['order' => $order, 'products' => $products]);
    }

    public function show_neworder($id)
    {
        return view('neworder', ['id' => $id]);
    }
}
