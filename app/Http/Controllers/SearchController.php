<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function index($value)
    {
        $products = Product::where('active', 1)->where(function($q) use ($value){
            $q->where('article', $value)->orWhere('name', 'LIKE', "%{$value}%");
        })->take(8)->get();

        return view('search', ["value" => $value, "products" => $products]);
    }
}
