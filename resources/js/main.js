let loadmore = 1;

$('#loadMore').on('click',function(e){
    e.preventDefault();
    var category = $(this).attr('category');
    var order = $(this).attr('order');
    var type = $(this).attr('OrType');
    var url = `/category/loadmore/${category}/${loadmore}/${order}/${type}`;

    $.ajax({
        url: url,
        method:"GET",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
        },
        success:function(response){
            if(response.removeload)
                $('#loadMore').remove();

            $('#products').append(response.data);
            loadmore++;
        },
        error: function(er) {
          console.log(er);
        }
    });
});


$('#sorts').on('click', '#sort' ,function(e){
    e.preventDefault();
    var id = $(this).attr('category');
    var order = $(this).attr('order');
    var type = $(this).attr('OrType');
    var url = `/category/sort/${id}/${order}/${type}`;

    window.location.href = url;
});

$('#items-main').on('click', '#fast', function(e){
    var id = $(this).attr('product');
    var url = `/category/modal/${id}`;

    $.ajax({
        url: url,
        method:"GET",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
        },
        success:function(response){

            if(response.error)
            {
                $('#modal-body').empty();
                $('#modal-body').append(response.error);

            }else{
                $('#fastModalLabel').text(response.name);
                $('#modal-body').empty();
                $('#modal-body').append(response.data);
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#galaryProduct').on('click', '#galaryImage', function(e){
    e.preventDefault();
    var img = $(this).attr('src');
    $('.activeMain').removeClass('activeMain');
    $(this).addClass('activeMain');
    $('#mainImage').attr('src', img);
});

$('#items-main').on('click', "#addtobasket", function(e) { addToBasket(e, $(this))} );
$('#modal-content').on('click', "#addtobasket", function(e) { addToBasket(e, $(this))} );

function addToBasket(e, btn)
{
    e.preventDefault();
    var url = "/addtobasket";
    var id = btn.attr('product');

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
            id:id
        },
        success:function(response){

            if(!response.error)
            {
                $.toast({
                    text: "Товар добавлен", // Text that is to be shown in the toast
                    heading: 'Корзина', // Optional heading to be shown on the toast
                    icon: 'success', // Type of toast icon
                    showHideTransition: 'fade', // fade, slide or plain
                    allowToastClose: true, // Boolean value true or false
                    hideAfter: 2000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
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

                $("#basketcount").text(response.count);
            }

        },
        error: function(er) {
          console.log(er);
        }
    });


}

$('input[id^="basketAmount"]').on('change', function(e){
    var id = $(this).attr('product');
    var amount = $(this).val();

    var url = `/basket/productamount/${id}/${amount}`;

    $.ajax({
        url: url,
        method:"GET",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
        },
        success:function(response){

            if(!response.error)
            {
                $("#price"+id).text(response.price+".00 руб");
                $("#basketsum").text("Общая сумма : "+response.sum+".00 руб");
            }

        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('a[id^="delproduct"]').on('click', function(e){

    e.preventDefault();

    var url = "/deletefrombasket";
    var id = $(this).attr('product');

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
            id:id
        },
        success:function(response){

            if(!response.error)
            {
                $.toast({
                    text: "Товар убран", // Text that is to be shown in the toast
                    heading: 'Корзина', // Optional heading to be shown on the toast
                    icon: 'success', // Type of toast icon
                    showHideTransition: 'fade', // fade, slide or plain
                    allowToastClose: true, // Boolean value true or false
                    hideAfter: 2000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
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

                $("#trproduct"+id).remove();
                $("#basketcount").text(response.count);
                $("#basketsum").text("Общая сумма : "+response.sum+".00 руб");

                if(response.reload)
                {
                    window.location.reload();
                }
            }

        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#pickup').on('click', function(e) {
   $('#orderForm').empty();
   $('#orderForm').append('<form id="formDelivery"> <p class="mb-3"> При самовывозе товар бранируется на срок не более 2 дней!</p><div class="mb-3"><label for="FullName" class="form-label">Фамилия Имя Отчество</label><input type="text" class="form-control" id="FullName" name="fullName"><div id="FullName" class="form-text">ФИО через пробел</div></div><div class="mb-3"><label for="FullName" class="form-label">Номер телефона</label><input type="text" class="form-control bfh-phone" id="Phone" name="phone" data-format="+7 (ddd) ddd-dd-dd"><div id="FullName" class="form-text"></div></div> <input type="hidden" name="delivery" value="Самовывоз"> <input type="hidden" name="address" value=" Москва, Кировоградская ул., 13А, тц. Columbus">  <button type="submit" id="btn-delivery" class="btn btn-primary">Заказать</button></form>');
});

$('#deliverybtn').on('click', function(e){
    $('#orderForm').empty();
    $('#orderForm').append('<form id="formDelivery"><p class="mb-3">После оформелния заказа с вами свяжется наш оператор и скажет цену доставки, после Вам будем выставлен счет на оплату</p><div class="mb-3"><label for="fullName" class="form-label">Фамилия Имя Отчество</label><input type="text" class="form-control" id="fullName" name="fullName"><div id="fullName" class="form-text">ФИО через пробел</div></div><select class="form-select mb-3" name="delivery"><option value="no" selected>Выберите способ доставки</option><option value="Сдэк">Сдэк</option><option value="Почта России">Почта России</option><option value="Яндекс доставка">Яндекс доставка</option></select><div class="mb-3"><label for="address" class="form-label">Адрес доставки</label><input type="text" class="form-control" id="address" name="address"><div id="addressS" class="form-text">Город, улица, дом, квартира или адрес пункта выдачи</div></div><div class="mb-3"><label for="phone" class="form-label">Номер телефона</label><input type="text" class="form-control bfh-phone mb-3" id="phone" name="phone" data-format="+1 (ddd) ddd-dddd"> </div> <button type="submit" id="btn-delivery" class="btn btn-primary">Заказать</button></form>');
});

$('#btnSearch').on('click', function(e){
    var value = $("#search").val();
    var url = `/search/${value}`;
    if(value)
        window.location.href = url;

});

$('#orderForm').on('click', "#btn-delivery", function(e) {
    e.preventDefault();

    var url = window.location.href + "/add_order";
    var data = new FormData();
    var form_data = $('#formDelivery').serializeArray();

    $.each(form_data, function (key, input) {
        data.append(input.name, input.value);
    });


    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:data,
        processData: false,
        contentType: false,
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


            console.log(response.redirect_url);

            if(response.redirect_url)
                window.location.href = response.redirect_url;
        },
        error: function(er) {
          console.log(er);
        }
    });
});

function footerToBottom() {
    var browserHeight = $(window).height(),
         footerOuterHeight = $('footer').outerHeight(true),
         mainHeightMarginPaddingBorder = $('main').outerHeight(true) - $('main').height() + 3;
         $('main').css({
              'min-height': browserHeight - footerOuterHeight - mainHeightMarginPaddingBorder,
         });
    };
    footerToBottom();
    $(window).resize(function () {
    footerToBottom();
});

document.addEventListener("DOMContentLoaded", function(event) {
    var location = localStorage.getItem('curPage');
    var scrollpos = localStorage.getItem('scrollpos');
    if (scrollpos && location == window.location.pathname) window.scrollTo(0, scrollpos);
    else if(window.location.pathname.includes("product") || window.location.pathname.includes("category"))
    {
        document.getElementById("items-main").scrollIntoView();
    }
});

window.onbeforeunload = function(e) {
    localStorage.setItem('scrollpos', window.scrollY);
    localStorage.setItem('curPage', window.location.pathname);
};
