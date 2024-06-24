<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

use App\Models\Product;

class BasketController extends Controller
{
    public function index()
    {
        $cookie = Cookie::get('basket');
        $haveProducts = false;

        if($cookie)
        {
            $basket = stripslashes($cookie);
            $basket = json_decode($basket, true);
            $itemIdList = array_column($basket, 'itemID');
            $products = Product::WhereIn('id', $itemIdList)->get();

            $sum = 0;
            foreach ($products as $product) {
                if(!$product || $product->active == 0)
                {
                    unset($basket[$product->id]);
                    if(count($basket) <= 0)
                    {
                        Cookie::queue(Cookie::forget('basket'));
                        $haveProducts = false;
                        return view('basket', ['haveProducts' => $haveProducts]);
                    }

                    $item = json_encode($basket);
                    Cookie::queue(Cookie::make('basket', $item, 2628000));
                    continue;
                }

                $amount = $basket[$product->id]["itemCount"];
                $sum += $product->newprice > 0 ? $product->newprice * $amount : $product->price * $amount;
                $haveProducts = true;
            }

            return view('basket', ['products' => $products, 'basket' => $basket, 'sum' => $sum, 'haveProducts' => $haveProducts]);
        }

        return view('basket', ['haveProducts' => $haveProducts]);
    }

    public function productamount(Request $request)
    {
        $id = $request->id;
        $amount = $request->amount;

        $product = Product::find($id);
        if(!$product)
            return response()->json(['error' => "Товар не найден"]);

        $cookie = Cookie::get('basket');
        if(!$cookie)
            return response()->json(['error' => "Корзина пуста"]);

        $basket = stripslashes($cookie);
        $basket = json_decode($basket, true);
        $itemIdList = array_column($basket, 'itemID');

        if(!in_array($id, $itemIdList))
            return response()->json(['error' => "Товар в корзине не найден"]);



        $basket[$id]["itemCount"] = $amount;
        $item = json_encode($basket);
        Cookie::queue(Cookie::make('basket', $item, 2628000));

        $price = $product->newprice > 0 ? $product->newprice * $amount : $product->price * $amount;

        $products = Product::WhereIn('id', $itemIdList)->get();

        $sum = 0;
        foreach ($products as $pr) {
            $amount = $basket[$pr->id]["itemCount"];
            $sum += $pr->newprice > 0 ? $pr->newprice * $amount : $pr->price * $amount;
        }

        return response()->json(['price' => $price, 'sum' => $sum]);
    }

    public function deletefrombasket(Request $request)
    {
        $id = $request->id;

        $cookie = Cookie::get('basket');
        if(!$cookie)
            return response()->json(['error' => "Корзина пуста"]);

        $basket = stripslashes($cookie);
        $basket = json_decode($basket, true);
        $itemIdList = array_column($basket, 'itemID');

        if(!in_array($id, $itemIdList))
            return response()->json(['error' => "Товар в корзине не найден"]);

        unset($basket[$id]);
        if(count($basket) <= 0)
        {
            Cookie::queue(Cookie::forget('basket'));
            return response()->json(['reload' => "Товара нет в корзине", 'count' => 0]);
        }
        $item = json_encode($basket);
        Cookie::queue(Cookie::make('basket', $item, 2628000));

        $itemIdList = array_column($basket, 'itemID');
        $products = Product::WhereIn('id', $itemIdList)->get();

        $sum = 0;
        foreach ($products as $product) {
            $amount = $basket[$product->id]["itemCount"];
            $sum += $product->newprice > 0 ? $product->newprice * $amount : $product->price * $amount;
        }


        return response()->json(['count' => count($basket), 'sum' => $sum]);
    }

    public function addtobasket(Request $request)
    {
        $id = $request->id;

        $product = Product::find($id);

        if(!$product)
            return response()->json(['error' => 'Продукт не найден']);


        if(Cookie::get('basket'))
        {
            $cookie = stripslashes(Cookie::get('basket'));
            $basket = json_decode($cookie, true);
            $itemIdList = array_column($basket, 'itemID');


            if(in_array($id, $itemIdList))
            {
                foreach ($basket as $key => $value)
                {
                    if($basket[$key]["itemID"] == $id)
                    {
                        $basket[$key]["itemCount"] ++;
                        $item = json_encode($basket);
                        Cookie::queue(Cookie::make('basket', $item, 2628000));

                        return response()->json(['count' => count($basket)]);
                    }
                }
            }
            else
            {
                $itemArr = array(
                    'itemID' => $id,
                    'itemCount' => 1
                  );

                $basket[$id] = $itemArr;
                $item = json_encode($basket);
                Cookie::queue(Cookie::make('basket', $item, 2628000));
                return response()->json(['count' => count($basket)]);

            }
        }
        else
        {
            $basket = array();

            $itemArr = array(
                'itemID' => $id,
                'itemCount' => 1
              );

            $basket[$id] = $itemArr;
            $item = json_encode($basket);
            Cookie::queue(Cookie::make('basket', $item, 2628000));
            return response()->json(['count' => count($basket)]);

        }
    }
}
