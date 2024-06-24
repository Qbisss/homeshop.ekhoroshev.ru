<?php
$newProducts = App\Models\Product::where('active', 1)->orderBy('created_at', 'desc')->get();
$discProducts = App\Models\Product::where('newprice', '!=', 0)->where('active', 1)->inRandomOrder()->get();
?>

<div class="col-sm-12 col-xs-12 col-md-10 items-main" id="items-main">
<div class="row">
  <h1 class="main-headers">Новинки</h1>
  @foreach ($newProducts as $np)
  <x-cart :product="$np"/>
  @endforeach

      <h1 class="main-headers">Скидки</h1>

      @foreach ($discProducts as $dp)
      <x-cart :product="$dp"/>
  @endforeach

</div>

<x-modal/>
