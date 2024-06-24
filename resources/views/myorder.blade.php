<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Мой заказ</title>

        @vite([
            '/resources/css/main.css',
            '/resources/js/main.js',
            '/resources/css/jquery.toast.min.css',
            '/resources/js/jquery.toast.min.js'
            ])

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
                    <h1 class="basket-header">Мой заказ #{{$order->checkid}}</h1>
                    <p>Статус : <strong>{{$order->status}}</strong></p>
                    <div class="col-12">
                            <div class="presonal_main">
                                <table class="table table-hover">
                                    <thead>
                                  <tr>
                                    <th scope="col">Название товара</th>
                                    <th scope="col">Стоимость</th>
                                    <th scope="col">Количество</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr id="trproduct{{$product->id}}">
                                            <td class="align-middle">{{$product->name}}</td>
                                            <td class="align-middle">{{$product->price}}</tb>
                                            <td class="align-middle">{{$product->amount}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
        </main>

     <x-footer/>
    </body>

</html>
