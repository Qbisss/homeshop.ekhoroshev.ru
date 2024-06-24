<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Контакты</title>

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
                    <h1 class="basket-header">Контакты</h1>
                    <div class="col-md-6 col-sm-12">
                    <div class="w-100 mb-5" style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/org/columbus/1189573038/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Columbus</a><a href="https://yandex.ru/maps/213/moscow/category/shopping_mall/184108083/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Торговый центр в Москве</a><a href="https://yandex.ru/maps/213/moscow/category/entertainment_center/184106372/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:28px;">Развлекательный центр в Москве</a><iframe src="https://yandex.ru/map-widget/v1/?indoorLevel=1&ll=37.605966%2C55.612330&mode=search&oid=1189573038&ol=biz&tab=inside&z=16.73" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-5">
                        <ul class="list-group list-unstyled mb-0">
                            <li class="mb-2">
                            <a href="https://yandex.ru/maps/-/CDe868-e" target="_blank" class="text-dark link-underline link-underline-opacity-0">
                                <i class="fa-solid fa-location-dot"></i> Москва, Кировоградская ул., 13А, тц. Columbus
                                </a>
                            </li>

                            <li class="mb-2">
                            <a href="tel:+79001111111" class="text-dark link-underline link-underline-opacity-0">
                            <i class="fa-solid fa-phone"></i> +79001111111
                            </a>
                            </li>

                            <li>
                                <a href="#" class="text-dark link-underline link-underline-opacity-0">
                                <i class="fa-solid fa-envelope"></i></i> support@homeshop.ru
                                </a>
                                </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>

     <x-footer/>
    </body>

</html>
