<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Заказ</title>

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
                    <h1 class="basket-header">Просмотр вашего заказа</h1>
                    <p>Введите номер вашего заказа для его просмотра</p>
                    <div class="col-6">
                    <form action="">
                    <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-lg">#</span>
                        <input type="text" id="orderid" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                    </div>

                        <button type="submit" id='checkorder' class="btn btn-primary mb-3">Проверить</button>
                    </form>
                    </div>
                </div>
            </div>
        </main>

     <x-footer/>
    </body>
        <script>
            $('#checkorder').on('click', function(e){
                e.preventDefault();
                var id = $('#orderid').val();

                var url = `/myorder/${id}`;

                $.ajax({
                    url: url,
                    method:"GET",
                    data:{
                    },
                    success:function(response){

                        if(response.error)
                            {
                                $.toast({
                                    text: response.error, // Text that is to be shown in the toast
                                    heading: 'Ошибка', // Optional heading to be shown on the toast
                                    icon: 'error', // Type of toast icon
                                    showHideTransition: 'fade', // fade, slide or plain
                                    allowToastClose: true, // Boolean value true or false
                                    hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                    stack: 3, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                                    position: 'top-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values



                                    textAlign: 'left',  // Text alignment i.e. left, right or center
                                    loader: true,  // Whether to show loader or not. True by default
                                    loaderBg: '#9EC600',  // Background color of the toast loader
                                    beforeShow: function () {}, // will be triggered before the toast is shown
                                    afterShown: function () {}, // will be triggered after the toat has been shown
                                    beforeHide: function () {}, // will be triggered before the toast gets hidden
                                    afterHidden: function () {}  // will be triggered after the toast has been hidden
                                });
                                return;
                            }

                            window.location.href = url;

                    },
                    error: function(er) {
                    console.log(er);
                    }
                });
            });
        </script>
</html>
