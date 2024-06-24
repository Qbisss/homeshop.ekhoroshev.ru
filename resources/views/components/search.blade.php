<div class="col-10 items-main" id="items-main">
<div class="row mb-5" id="products">
  <h1 class="main-headers">Поиск по запросу {{$value}}</h1>
    @foreach ($products as $product)
    <x-cart :product="$product"/>
    @endforeach

</div>

<x-modal/>
