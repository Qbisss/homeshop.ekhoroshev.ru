<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Личный кабинет | Авторизация</title>

        @vite(["/resources/css/main.css", '/resources/js/main.js', '/resources/css/jquery.toast.min.css', '/resources/js/jquery.toast.min.js'])

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/97d69fa06e.js" crossorigin="anonymous"></script>

     </head>
    <body>
     <x-header/>

        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 mt-5 mb-5">
                        <div class="col-12 mb-3">
                        <h3 class="header-c text-center">Регистрация</h6>
                            <form class="form-class" action="/register_process" method="post">
                            @csrf
                                <div class="mb-3 in-c">
                                    <label for="email" class="form-label">
                                        Email: @if($errors->has('email')) {{$errors->first('email')}} @endif
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="mb-3 in-c">
                                    <label for="name" class="form-label">
                                        Телефон: @if($errors->has('phone')) {{$errors->first('phone')}} @endif
                                    </label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                    <div id="name" class="form-text">Формат 8XXXXXXXXXX (Пример 89645849522)</div>
                                </div>
                                <div class="mb-3 in-c">
                                    <label for="password" class="form-label">
                                        Пароль: @if($errors->has('password')) {{$errors->first('password')}} @endif
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password">
                                 </div>

                                 <div class="mb-3 in-c">
                                    <label for="password2" class="form-label">
                                        Повторить пароль: @if($errors->has('password2')) {{$errors->first('password2')}} @endif
                                    </label>
                                    <input type="password" class="form-control" id="password2" name="password2">
                                 </div>

                                <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-primary btn-c">Регистрация</button>
                          </div>

                            </form>
                            </div>
                            <div class="col-12 in-cc">
                            Есть аккаунт? <a href="/lk">Авторизация</a>
                            </div>

                        </div>
                </div>
            </div>
        </main>

     <x-footer/>
    </body>
</html>
