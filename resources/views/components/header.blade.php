<?php
$cookie = Illuminate\Support\Facades\Cookie::get('basket');
$basketCount = 0;
if($cookie)
{
    $basket = stripslashes($cookie);
    $basket = json_decode($basket, true);
    $basketCount = count($basket);
}
?>

<header>
<div class="col-12 header-first-info">
    <a href="https://yandex.ru/maps/-/CDe868-e" target="_blank" class="header-adress">
    <i class="fa-solid fa-location-dot"></i> Москва, Кировоградская ул., 13А, тц. Columbus
    </a>

    <a href="tel:+79001111111" class="header-phone">
    <i class="fa-solid fa-phone"></i>
     +79001111111<br>
     <i class="fa-solid fa-check"></i>
     с 10:00 до 20:00
    </a>
</div>

<div class="col-10 header-main-info">
    <div class="container">
        <div class="row">
        <div class="col-10 col-md-4">
            <h1><a href="/" class="header-name">Домашний</a></h1>
        </div>

        <div class="d-md-none col-xs-2 col-sm-2">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                  <button class="navbar-toggler mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav header-menu-small">
                      <li class="nav-item ">
                        <li><a href="/catalog">Каталог</a></li>
                      </li>
                      <li class="nav-item">
                        <li><a href="/contact">Контакты</a></li>
                      </li>
                      <li class="nav-item">
                        <li><a href="/checkorder">Заказ</a></li>
                      </li>
                    </ul>
                  </div>
                </div>
              </nav>
        </div>

        <div class="col-12 col-md-4 searchWrapper">
            <ul>
                <li>
                    <input type="text" class="w-100 search-input" name="product" id="search" placeholder="Назвиние или артикул товара">
                    <div class="list">

                    </div>

                    <a href="#" id="btnSearch"><i class="fa-solid fa-magnifying-glass"></i></a>
                </li>
            </ul>
        </div>

        <div class="d-none d-md-block col-4 header-user-menu">
        <ul>

                <li><a href="/basket"><i class="fa-solid fa-cart-arrow-down">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-dar" id="basketcount">{{$basketCount}}</span>
                </i></a></li>
                <li><a href="/lk">
                @if(\Illuminate\Support\Facades\Auth::check())
                <i class="fa-regular fa-user no-spacing"> Личный кабинет</i></a></li>
                @else
                <i class="fa-regular fa-user no-spacing"> Авторизация</i></a></li>
                @endif
            </ul>
        </div>
        <div class="d-none d-md-block col-12 header-menu">
            <ul>
                <li><a href="/catalog">Каталог</a></li>
                <li><a href="/contact">Контакты</a></li>
                <li><a href="/checkorder">Заказ</a></li>
            </ul>
        </div>
        </div>
    </div>
</div>

<div class="col-12">


</div>
</header>
