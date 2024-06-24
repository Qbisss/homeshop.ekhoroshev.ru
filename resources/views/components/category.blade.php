@php($request = App\Models\Product::where('active', 1)->where('categoryID', $id)->orderBy($order, $type)->get())
@php($products = $request->take(8))
@php($count = $request->count())
<div class="col-10 items-main" id="items-main">
<div class="row mb-5" id="products">
  <h1 class="main-headers">{{$name}}</h1>
    <p id="sorts">
        Цена
        <button id="sort" category="{{$id}}" order="price" OrType="desc" type="button" class="btn btn-light"><i class="fa-solid fa-arrow-up"></i></button>
        <button id="sort" category="{{$id}}" order="price" OrType="asc" type="button" class="btn btn-light" style="margin-right: 20px;"><i class="fa-solid fa-arrow-down"></i></button>

        Название
        <button id="sort" category="{{$id}}" order="name" OrType="desc" type="button" class="btn btn-light"> <i class="fa-solid fa-arrow-up-a-z"></i></button>
        <button id="sort" category="{{$id}}" order="name" OrType="asc" type="button" class="btn btn-light"> <i class="fa-solid fa-arrow-down-a-z"></i></i></button>
    </p>
    @foreach ($products as $product)
         <x-cart :product="$product"/>
    @endforeach

</div>
@if($count > 8)
<div class="d-grid gap-2 col-6 mx-auto">
    <button class="btn btn-primary" type="button" id="loadMore" category="{{$id}}" order="{{$order}}" OrType="{{$type}}">Загрузить еще</button>
  </div>
@endif

<x-modal/>
