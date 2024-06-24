<?php
$product = App\Models\Product::find($id);
$galary = $product->galary;
$images = explode(',', $galary);
$values = array_values($images);
$firstImage = array_shift($values);
$productProperty = App\Models\ProductProperty::where('productID', $product->id)->get();
$randProducts = App\Models\Product::where('id', '!=', $product->id)->inRandomOrder()->take(4)->get();
?>

<div class="col-10 items-main" id="items-main">
    <div class="row">
  <h1 class="main-headers">{{$product->name}}</h1>
    <div class="col-4">
        <div class="d-flex align-items-center flex-column">
            <div class="mainImg">
                <img class="mb-4" id="mainImage" src="{{asset($firstImage)}}">
            </div>
            <div id="galaryProduct">
                @foreach ($images as $image)
                    @if($firstImage == $image)
                        <a href="#"><img class="activeMain" id="galaryImage" src="{{asset($image)}}"></a>
                    @else
                        <a href="#"><img id="galaryImage" src="{{asset($image)}}"></a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-4">
        <h6>Характеристики</h6>
        <div class="properties">

            <table class="prop_table">
            <tbody>
        <?php
            foreach($productProperty as $property)
            {
                if(!$property->value)
                    continue;

                $propInfo = App\Models\Property::find($property->propertyID);
                echo '<tr>
                        <td class="prop_name">'.$propInfo->name.'</td>
                        <td class="prop_value">'.$property->value.'</td>
                     </tr>';
            }
        ?>
        </tbody>
        </table>

        </div>
    </div>

    <div class="col-4">
        @if($product->newprice == 0)
                <h5 class="text-center">{{$product->price}}.00 руб.</h1>
            @else
                <p class="oldprice">{{$product->price}}.00 руб.</p>
                <h5 class="text-center">{{$product->newprice}}.00 руб.</h1>
            @endif


            <div class="d-grid mb-2">
                <button id="addtobasket" product="{{$product->id}}" class="btn btn-warning" type="button">В корзину</button>
            </div>

            <h6>Артикул {{$product->article}}</h6>
    </div>

    <h4 class="main-headers">Описание</h4>
    <p class="mb-5">{{$product->desc}}</p>

    <h4 class="">Рекомендуем</h4>
    @foreach ($randProducts as $rand)
        <x-cart :product="$rand"/>
    @endforeach
</div>

<x-modal/>
