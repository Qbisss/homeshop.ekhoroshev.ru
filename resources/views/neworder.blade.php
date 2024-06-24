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
                    <h1 class="basket-header">Ваш заказ #<strong>{{$id}}</strong></h1>
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <p class="mb-3">Заказ можно посмотреть в личном кабинете</p>
                    @else
                        <p class="mb-3">Запишите номер заказа и следите за его статутом в "заказ"</p>
                    @endif
                    <p>Наш менеджер свяжется с вами в ближайшее время, уточнит по наличию и стоимости доставки.</p>
                </div>
            </div>
        </main>

     <x-footer/>
    </body>

</html>
