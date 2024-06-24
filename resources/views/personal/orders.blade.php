<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Личный кабинет | Заказы</title>

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
                    <h1 class="basket-header">Личный кабинет</h1>
                    <div class="col-3">
                        <div class="list-group w-75 pesonal-menu">
                            <a href="/lk/orders" class="list-group-item list-group-item-action">Заказы</a>
                            <a href="#" class="list-group-item list-group-item-action">Мои данные</a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="presonal_main">
                            <table class="table table-hover">
                                <thead>
                              <tr>
                                <th scope="col">Номер</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Дата</th>
                                <th scope="col">Содержимое</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                        <tr>
                                            <td class="align-middle">{{$order->checkid}}</td>
                                            <td class="align-middle">{{$order->status}}</tb>
                                            <td class="align-middle">{{$order->created_at}}</td>
                                            <td class="align-middle"><a href="/myorder/{{$order->checkid}}"><button type="button" class="btn btn-outline-success"><i class="fa-solid fa-eye"></i></button></a></td>
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
