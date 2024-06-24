<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Домашний интернет магазин | Админка</title>

        @vite([
            "/resources/css/main.css",
            "/resources/css/admin.css"
        ])

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/97d69fa06e.js" crossorigin="anonymous"></script>

     </head>
    <body>
        <main>
              <section class="vh-100" style="background-color: #588be98a;">
                <form method="POST" action="{{route("admin.login_process")}}">
                    @csrf
                <div class="container py-5 h-100">
                  <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                      <div class="card shadow-10-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                          <h3 class="mb-5">Админ Панель</h3>

                          <div class="form-outline mb-4">
                            <input type="login" id="typeEmailX-2" class="form-control form-control-lg" name="login"/>
                            <label class="form-label" for="typeEmailX-2">Логин</label>
                          </div>

                          <div class="form-outline mb-4">
                            <input type="password" id="typePasswordX-2" class="form-control form-control-lg" name="password" />
                            <label class="form-label" for="typePasswordX-2">Пароль</label>
                          </div>

                          <button class="btn btn-primary btn-lg btn-block" type="submit">Войти</button>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </form>
              </section>
        </main>
    </body>


</html>

