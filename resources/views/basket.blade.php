<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Корзина</title>

        @vite([
            '/resources/css/main.css',
            '/resources/js/main.js',
            '/resources/css/jquery.toast.min.css',
            '/resources/js/jquery.toast.min.js',
            '/resources/js/bootstrap-formhelpers.min.js',
            '/resources/css/bootstrap-formhelpers.min.css'])

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/97d69fa06e.js" crossorigin="anonymous"></script>

     </head>
    <body>
     <x-header/>

        <main>
            <div class="container-fluid">
                <div class="row">
                    <h1 class="basket-header">Корзина</h1>
                    @if(!$haveProducts)
                    <div class="nobasket">
                        <i class="fa-solid fa-cart-shopping w-100 text-center fs-1"></i>
                        <h5 class="text-center w-100">Ваша корзина пуста</h5>
                        <p class="text-center w-100">Перейдите в <a href="/catalog">каталог</a>, что бы добавить товары</p>
                    </div>
                    @else
                    <div class="table-basket">
                    <table class="table basket">
                        <thead>
                          <tr>
                            <th scope="col"></th>
                            <th scope="col">Товар</th>
                            <th scope="col">Цена</th>
                            <th scope="col">Количество</th>
                            <th scope="col">Итого</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            @if(!$product || $product->active == 0)
                                @continue
                            @endif
                            <tr id="trproduct{{$product->id}}">
                                <th><a href="/product/{{$product->id}}"><img class="basket-img" src="{{asset($product->image)}}"></a></th>
                                <td class="align-middle">{{$product->name}} <a href="#" id="delproduct" product={{$product->id}}><i class="fa-solid fa-delete-left delproduct"></i></a></td>
                                <td class="align-middle">{{$product->newprice > 0 ? $product->newprice : $product->price}}.00 руб</tb>
                                <td class="align-middle"><input type="number" class="form-control basket-number" id="basketAmount" product="{{$product->id}}" value="{{$basket[$product->id]['itemCount']}}"></td>
                                <td class="align-middle" id="price{{$product->id}}">{{$product->newprice > 0 ? $product->newprice * $basket[$product->id]['itemCount'] :  $product->price * $basket[$product->id]['itemCount']}}.00 руб</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>

                    <div class="col-6 mb-5" id="delivery">
                        <h5>Заполните данные</h5>
                        <form class="mb-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="pickup" value="option1">
                            <label class="form-check-label" for="pickup">Самовывоз</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="deliverybtn" value="option2">
                            <label class="form-check-label" for="delivery">Доставка</label>
                          </div>
                        </form>
                        <div id="orderForm">

                        </div>
                    </div>
                    <div class="col-6">
                        <h4 id="basketsum">
                            Общая сумма : {{$sum}}.00 руб
                        </h4>
                    </div>
                    @endif

                </div>
            </div>
        </main>

     <x-footer/>
    </body>

</html>
