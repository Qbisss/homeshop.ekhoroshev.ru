@php ($badge = App\Models\Badge::find($product->badgeID))
<div class="col-lg-3 col-md-6 mb-4">
    <div class="card">
        <div class="card-img mt-1">
        <a href="/product/{{$product->id}}"><img src="{{asset($product->image)}}"></a>
        <button class="fast" id="fast" product="{{$product->id}}" data-bs-toggle="modal" data-bs-target="#fastModal">Быстрый просмотр</button>
        </div>

        <div class="card-body align-items-start flex-column">
        <a href="/product/{{$product->id}}" class="card-header">
            <h5 class="mt-auto p-2">{{$product->name}}</h5>
        </a>
        @if($product->newprice == 0)
            <h6 class="mb-3 price">{{$product->price}}.00 руб.</h6>
        @else
        <h6 class="mb-2 price"><p class="oldprice">{{$product->price}}.00 руб.</p>{{$product->newprice}}.00 руб.</h6>
        @endif
        </div>

        <div class="card-buttons mb-3">
        <button type="button" id="addtobasket" product="{{$product->id}}" class="card-button-to-basket">В корзину</button>
        </div>
        @if($badge)
        <div class="card-badge" style="background: {{$badge->color}};">{{$badge->name}}</div>
        @endif
    </div>
</div>
