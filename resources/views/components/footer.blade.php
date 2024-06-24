<?php
$footerCategory = App\Models\Category::where('active', 1)->orderBy('priority')->get()
?>
<footer class="text-white" style="background-color:#06063685;">
    <div class="col-12">
    <div class="container p-4">
      <section class="">
        <div class="row">
          <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">Каталог</h5>
            <ul class="list-group list-unstyled mb-0 col-count">
              @foreach ($footerCategory as $fc)
                <li>
                    <a href="#!" class="text-white link-underline link-underline-opacity-0">{{$fc->name}}</a>
                </li>
              @endforeach
            </ul>
          </div>

          <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
            <h5 class="text-uppercase">Наши контакты</h5>
            <ul class="list-group list-unstyled mb-0">
                <li class="mb-2">
                <a href="https://yandex.ru/maps/-/CDe868-e" target="_blank" class="text-white link-underline link-underline-opacity-0">
                    <i class="fa-solid fa-location-dot"></i> Москва, Кировоградская ул., 13А, тц. Columbus
                    </a>
                </li>

                <li class="mb-2">
                <a href="tel:+79001111111" class="text-white link-underline link-underline-opacity-0">
                <i class="fa-solid fa-phone"></i> +79001111111
                </a>
                </li>

                <li>
                    <a href="#" class="text-white link-underline link-underline-opacity-0">
                    <i class="fa-solid fa-envelope"></i></i> support@homeshop.ru
                    </a>
                    </li>
            </ul>
          </div>

        </div>
      </section>
    </div>

    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
      © 2024 homeshop.ru - товары для дома
    </div>

    </div>
</footer>
