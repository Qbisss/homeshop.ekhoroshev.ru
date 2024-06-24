<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::find($id);
        if(!$product)
            return abort(404);

        $product->views += 1;
        $product->save();

        return view('product', ['product' => $product]);
    }
}
