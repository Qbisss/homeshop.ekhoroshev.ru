<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use App\Models\ProductProperty;
use App\Models\Badge;

class CategoryController extends Controller
{
    public function index($id, $order = 'priority', $type = 'desc')
    {
        $category = Category::find($id);
        if(!$category)
            return abort(404);

        return view('category', ['category' => $category, 'order' => $order, 'type' => $type]);
    }

    public function mainIndex()
    {
        $catalog = Category::where('active', 1)->orderBy('priority')->get();
        if(!$catalog)
            return abort(404);

        return view('catalog', ['catalog' => $catalog]);
    }

    public function sort_products(Request $request)
    {

        $category = Category::find($request->id);
        if(!$category)
            return abort(404);

        return view('category', ['category' => $category, 'order' => $request->order, 'type' => $request->type]);
    }

    public function load_more(Request $request)
    {
        $mysql = Product::where('active', 1)->where('categoryID', $request->category)->orderBy($request->order, $request->type)->get()->skip($request->loadmore*8);
        $products = $mysql->take(8);
        $data = '';

        $price ='';

        if($product->newprice == 0)
            $price = '<h6 class="mb-3 price">'.$product->price.'.00 руб.</h6>';
        else
            $price = '<h6 class="mb-3 price"><p class="oldprice"'.$product->price.'.00 руб.</p> '.$product->newprice.'.00 руб.</h6>';

        foreach($products as $product)
        {
            $badge = Badge::find($product->badgeID);
            $data .= '
            <div class="col-lg-3 col-md-6 mb-4">

            <div class="card">

                <div class="card-img mt-1">
                <a href="/product/'.$product->id.'"><img src="'.asset($product->image).'"></a>
                <button class="fast">Быстрый просмотр</button>
                </div>

                <div class="card-body align-items-start flex-column">
                <a href="/product/{{$product->id}}" class="card-header">
                <h5 class="mt-auto p-2">'.$product->name.'</h5>
                </a>
                '.$price.'
                </div>

                <div class="card-buttons mb-3">
                <form action="#" class="">
                    <button type="submit" id="addtobasket" product="'.$product->id.'" class="card-button-to-basket">В корзину</button>
                </form>

                </div>

                '.($badge ? '<div class="card-badge" style="background: '.$badge->color.';">'.$badge->name.'</div>' : '').'

            </div>
            </div>
            ';
        }

        if(count($mysql) <= 8)
            return response()->json(['data' => $data, 'removeload' => true]);
        else
            return response()->json(['data' => $data]);
    }

    public function show_fastmodal($id)
    {
        $product = Product::find($id);
        if(!$product)
            return response()->json(['error' => 'Товар не найден']);

        $galary = $product->galary;
        $productProperty = ProductProperty::where('productID', $product->id)->get();

        $images = explode(',', $galary);

        $price = '';

        if($product->newprice == 0)
            $price = '<h5 class="text-center">'.$product->price.'.00 руб.</h5>';
        else
            $price = '<p class="oldprice">'.$product->price.'.00 руб.</p> <h5 class="text-center">'.$product->newprice.'.00 руб.</h5>';



        $i = 0;
        $galaryBtn = '';
        $galaryImage = '';
        foreach($images as $image)
        {
            $galaryBtn .= '<button type="button" '.($i == 0 ? 'class="active"' : '' ).' data-bs-target="#galary" data-bs-slide-to="'.$i.'"></button>';

            $galaryImage .= '
                <div data-bs-interval="100000" class="carousel-item '.($i == 0 ? 'active' : '' ).'">

                    <img id="glass" src="'.asset($image).'" class="d-block" style="width:100%">
                </div>';
            $i++;

        }

        $properties = '';
        foreach($productProperty as $property)
        {
            if(!$property->value)
                    continue;

            $propInfo = Property::find($property->propertyID);
            $properties .= '<tr>
                                <td class="prop_name">'.$propInfo->name.'</td>
                                <td class="prop_value">'.$property->value.'</td>
                            </tr>';
        }


        $data = '
        <div class="row">

        <div class="col-4">
            <div id="galary" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                '.$galaryBtn.'
            </div>

            <div class="carousel-inner">
                '.$galaryImage.'
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#galary" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#galary" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
            </div>
        </div>

        <div class="col-4">
            <div class="properties">

            <table class="prop_table">
            <tbody>

            '.$properties.'
            </tbody>
            </table>

            </div>
        </div>

        <div class="col-4">
            '.$price.'
            <div class="d-grid mb-2">
                <button id="addtobasket" product="'.$product->id.'" class="btn btn-warning" type="button">В корзину</button>
            </div>
            <p>Артикул '.$product->article.'</p>
            <a href="/product/'.$product->id.'""><button type="button" class="btn btn-outline-success"><i class="fa-solid fa-maximize"></i></button></a>
            </div>
        </div>
        ';
        return response()->json(['data' => $data, 'name' => $product->name]);
    }
}
