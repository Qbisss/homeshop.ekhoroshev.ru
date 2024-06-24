$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('button[id^="show"]').click(function(e) {

    e.preventDefault();

    var url = window.location.href + $(this).attr('action');

    $.ajax({
      method: "GET",
      url: url,
      data: {
      },
      success: function(data) {
        $('.content').empty();
        $('.content').append(data);
      },
      error: function(er) {
        console.log(er);
      }
    });
});


//////////////////////////
//// CATEGORY
//////////////////////////
$('#content').on( 'click', '#btn-add-category', function( e ) {
    $('.modal-body').empty();
    $('#exampleModalLabel').text('Добавить категорию');
    $('.modal-body').append('<form style="width: 22rem;" data-action="/addcategory" id="addcategory"><div data-mdb-input-init class="form-outline mb-4"><label class="form-label" for="form5Example1">Название</label><input type="text" id="form5Example1" class="form-control no-effect" name="name" /></div><div data-mdb-input-init class="form-outline mb-4"><label class="form-label" for="form5Example2">Приоритет</label><input type="text" id="form5Example2" class="form-control no-effect" name="priority" value="1" /></div></form> <button type="button" id="btnaddcat" class="btn btn-success">Добавить</button>')
});

$('#content').on( 'click', '#btnsavecategory', function( e ) {

    e.preventDefault();

    var url = window.location.href + "/editcategory_process";
    //var data = $('#editcategory').serializeArray();
    //var data = new FormData($('#editcategory'));


    var data = new FormData();


    var form_data = $('#editcategory').serializeArray();

    $.each(form_data, function (key, input) {
        data.append(input.name, input.value);
    });

    var file_data = $('input[name="image"]').prop('files')[0];
    data.append('image', file_data);


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
                $('#modal-body').empty();
                $('#modal-body').append(response.error);

            }else{
                $('#show').trigger('click');
                $('#exampleModal').modal('toggle');
            }

        },
        error: function(er) {
          console.log(er);
        }
    });

});

$('#content').on( 'click', '#btnedit', function( e ) {

    var url = window.location.href + "/editcategory";
    var id = $(this).attr('edit');
    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
         id:id
        },
        success:function(response){

            if(response.error)
            {
                $('#modal-body').empty();
                $('#modal-body').append(response.error);

            }else{
                $('#exampleModalLabel').text('Изменить категорию');
                $('#modal-body').empty();
                $('#modal-body').append(response);
            }

        },
        error: function(er) {
          console.log(er);
        }
    });

});

$('#content').on( 'click', '#btndeletecategory', function( e ) {

    var url = window.location.href + "/deletecategory";
    var id = $('#catid').val();

    console.log(id);
    //$(this).after('<div class="spinner-border spinner-border-sm" role="status"> <span class="visually-hidden"></span></div>').remove();

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
         id:id
        },
        success:function(response){

            if(response.error)
                return;

            $('#exampleModal').modal('toggle');
            $('#show').trigger('click');


        },
        error: function(er) {
          console.log(er);
        }
    });
});

$( '#content' ).on( 'click', '#btnaddcat', function( e ) {
    e.preventDefault();
    var url = window.location.href + $('#addcategory').attr('data-action');
    var data = $('#addcategory').serializeArray();

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
         data:data
        },
        success:function(response){

            if(response.error)
            {
                $('#error').remove();
                $('.btnaddcat').after('<div class="badge bg-danger" id="error">' + response.error + '!</div>')
            }
            else
            {
                $('#show').trigger('click');
                $('#exampleModal').modal('toggle');
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});
////////////////////////////

//////////////////////////
//// PRODUCT
//////////////////////////

$('#content').on( 'click', '#btn-add-product', function( e ) {

    e.preventDefault();
    var url = window.location.href + "/modaladdproduct";

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        processData: false,
        contentType: false,
        data : { },
        success:function(response){

            $('.modal-body').empty();
            $('#exampleModalLabel').text('Добавить товар');
            $('.modal-body').append(response);
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#content').on('change', '#selectCategory', function ( e ) {
    e.preventDefault();
    var url = window.location.href + "/modaladdproperties";
    var optionSelected = $(this);
    var valueSelected  = optionSelected.val();

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data : { id: valueSelected},
        success:function(response){
            $('#properties').empty();
            $('#properties').append(response);
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$( '#content' ).on( 'click', '#btnaddproduct', function( e ) {
    e.preventDefault();
    var url = window.location.href + "/addproduct_process";

    var data = new FormData();


    var form_data = $('#addproduct').serializeArray();

    $.each(form_data, function (key, input) {
        data.append(input.name, input.value);
    });

    var file_data = $('input[name="image"]').prop('files')[0];
    data.append('image', file_data);

    var TotalImages = $('input[name="images"]')[0].files.length;
    data.append('TotalImages', TotalImages);

    var file_data2 = $('input[name="images"]')[0];
    for (var i = 0; i < TotalImages; i++) {
        data.append('images' + i, file_data2.files[i]);
    }

    var properties = $('#properties input').serializeArray();
    $.each(properties, function (key, input) {
        data.append(`properties[${input.name}]`, input.value);
    });

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        processData: false,
        contentType: false,
        data:data,
        success:function(response){

            if(response.error)
            {
                $('#error').remove();
                $('#btnaddproduct').after('<div class="badge bg-danger" id="error">' + response.error + '!</div>')

            }else{
                $('.prod').trigger('click');
                $('#exampleModal').modal('toggle');
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#content').on( 'click', '#btneditproduct', function( e ) {

    var url = window.location.href + "/editproduct";
    var id = $(this).attr('edit');
    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
         id:id
        },
        success:function(response){

            if(response.error)
            {
                $('#modal-body').empty();
                $('#modal-body').append(response.error);

            }else{
                $('#exampleModalLabel').text('Изменить товар');
                $('#modal-body').empty();
                $('#modal-body').append(response);
            }

        },
        error: function(er) {
          console.log(er);
        }
    });

});

$('#content').on( 'click', '#btndeleteproduct', function( e ) {

    var url = window.location.href + "/deleteproduct";
    var id = $('#productID').val();

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
         id:id
        },
        success:function(response){

            if(response.error)
            {
                console.log(response.error);
                return;
            }

            $('#exampleModal').modal('toggle');
            $('.prod').trigger('click');


        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#content').on( 'click', '#btnsaveproduct', function( e ) {

    e.preventDefault();
    var url = window.location.href + "/saveproduct";

    var data = new FormData();


    var form_data = $('#editproduct').serializeArray();

    $.each(form_data, function (key, input) {
        data.append(input.name, input.value);
    });

    var file_data = $('input[name="image"]').prop('files')[0];
    data.append('image', file_data);

    var TotalImages = $('input[name="images"]')[0].files.length;
    data.append('TotalImages', TotalImages);

    var file_data2 = $('input[name="images"]')[0];
    for (var i = 0; i < TotalImages; i++) {
        data.append('images' + i, file_data2.files[i]);
    }

    var properties = $('#properties input').serializeArray();
    $.each(properties, function (key, input) {
        data.append(`properties[${input.name}]`, input.value);
    });

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        processData: false,
        contentType: false,
        data:data,
        success:function(response){

            if(response.error)
            {
                $('#error').remove();
                $('#btndeleteproduct').after('<div class="badge bg-danger" id="error">' + response.error + '!</div>')

            }else{
                $('.prod').trigger('click');
                $('#exampleModal').modal('toggle');
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#content').on( 'click', '#searchproduct', function( e ){
    e.preventDefault();

    var url = window.location.href + '/searchproduct/' + $('#search').val();
    $.ajax({
      method: "GET",
      url: url,
      data: {
      },
      success: function(data) {

        if(data.error)
        {
            $('#search').val(data.error);
            return;
        }

        $('.content').empty();
        $('.content').append(data);
      },
      error: function(er) {
        console.log(er);
      }
    });
});
////////////////////////////

//////////////////////////
//// PROPERTY
//////////////////////////

$('#content').on('click', '#btn-add-property', function( e ){
    e.preventDefault();
    var url = window.location.href + "/modaladdproperty";

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        processData: false,
        contentType: false,
        data : { },
        success:function(response){

            $('.modal-body').empty();
            $('#exampleModalLabel').text('Добавить свойство');
            $('.modal-body').append(response);
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$( '#content' ).on( 'click', '#btnaddprop', function( e ) {
    e.preventDefault();
    var url = window.location.href + $('#addproperty').attr('data-action');
    var data = new FormData();
    var form_data = $('#addproperty').serializeArray();
    $.each(form_data, function (key, input) {
        data.append(input.name, input.value);
    });


    var categories = $('#categories input').serializeArray();
    $.each(categories, function (key, input) {
        data.append(`categories[]`, input.name);
    });

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        processData: false,
        contentType: false,
        data:data,
        success:function(response){

            if(response.error)
            {
                $('#error').remove();
                $('#btnaddprop').after('<div class="badge bg-danger" id="error">' + response.error + '!</div>')
            }
            else
            {
                $('.prop').trigger('click');
                $('#exampleModal').modal('toggle');
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#content').on( 'click', '#btneditproperty', function( e ) {

    var url = window.location.href + "/editproperty";
    var id = $(this).attr('edit');

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
         id:id
        },
        success:function(response){

            if(response.error)
            {
                $('#modal-body').empty();
                $('#modal-body').append(response.error);

            }else{
                $('#exampleModalLabel').text('Изменить свойство');
                $('#modal-body').empty();
                $('#modal-body').append(response);
            }

        },
        error: function(er) {
          console.log(er);
        }
    });

});

$( '#content' ).on( 'click', '#btnsaveproperty', function( e ) {
    e.preventDefault();
    var url = window.location.href + "/saveproperty"

    var data = new FormData();
    var form_data = $('#editproperty').serializeArray();
    $.each(form_data, function (key, input) {
        data.append(input.name, input.value);
    });


    var categories = $('#categories input').serializeArray();
    $.each(categories, function (key, input) {
        data.append(`categories[]`, input.name);
    });

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        processData: false,
        contentType: false,
        data:data,
        success:function(response){

            if(response.error)
            {
                $('#error').remove();
                $('#btnaddprop').after('<div class="badge bg-danger" id="error">' + response.error + '!</div>')
            }
            else
            {
                $('.prop').trigger('click');
                $('#exampleModal').modal('toggle');
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$( '#content' ).on( 'click', '#btndeleteproperty', function( e ) {
    e.preventDefault();
    var url = window.location.href + "/deleteproperty"
    var id = $('#propertyID').val();
    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
            id:id
        },
        success:function(response){
            console.log(response);
            if(response.error)
            {
                $('#error').remove();
                $('#btnaddprop').after('<div class="badge bg-danger" id="error">' + response.error + '!</div>')
            }
            else
            {
                $('.prop').trigger('click');
                $('#exampleModal').modal('toggle');
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#content').on( 'click', '#searchproperty', function( e ){
    e.preventDefault();

    var url = window.location.href + '/searchproperty/' + $('#search').val();
    $.ajax({
      method: "GET",
      url: url,
      data: {
      },
      success: function(data) {

        if(data.error)
        {
            $('#search').val(data.error);
            return;
        }

        $('.content').empty();
        $('.content').append(data);
      },
      error: function(er) {
        console.log(er);
      }
    });
});
////////////////////////////

//////////////////////////
//// BADGE
//////////////////////////

$('#content').on( 'click', '#btn-add-badge', function( e ) {
    $('.modal-body').empty();
    $('#exampleModalLabel').text('Добавить бейджик');
    $('.modal-body').append('<form style="width: 22rem;" data-action="/addbadge" id="addbadge"><div data-mdb-input-init class="form-outline mb-4"><label class="form-label" for="form5Example1">Название</label><input type="text" id="form5Example1" class="form-control no-effect" name="name" /></div><div data-mdb-input-init class="form-outline mb-4"><label for="exampleColorInput" class="form-label">Выберите цвет</label><input type="color" name="color" class="form-control form-control-color" id="exampleColorInput" value="#563d7c" title="Выберите цвет"></div></form><button type="button" id="btnaddbadge" class="btn btn-success">Добавить</button>');
});

$( '#content' ).on( 'click', '#btnaddbadge', function( e ) {
    e.preventDefault();
    var url = window.location.href + $('#addbadge').attr('data-action');
    var data = $('#addbadge').serializeArray();
    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:data,
        success:function(response){
            if(response.error)
            {
                $('#error').remove();
                $('#btnaddbadge').after('<div class="badge bg-danger" id="error">' + response.error + '!</div>')
            }
            else
            {
                $('.bdg').trigger('click');
                $('#exampleModal').modal('toggle');
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#content').on( 'click', '#btneditbadge', function( e ) {

    var url = window.location.href + "/editbadge/" + $(this).attr('edit');

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
                $('#exampleModalLabel').text('Изменить беджик');
                $('#modal-body').empty();
                $('#modal-body').append(response);
            }

        },
        error: function(er) {
          console.log(er);
        }
    });

});

$( '#content' ).on( 'click', '#btndeletebadge', function( e ) {
    e.preventDefault();
    var url = window.location.href + "/deletebadge"
    var id = $('#badgeID').val();
    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:{
            id:id
        },
        success:function(response){
            console.log(response);
            if(response.error)
            {
                $('#error').remove();
                $('#btnaddbadge').after('<div class="badge bg-danger" id="error">' + response.error + '!</div>')
            }
            else
            {
                $('.bdg').trigger('click');
                $('#exampleModal').modal('toggle');
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});

$( '#content' ).on( 'click', '#btnsavebadge', function( e ) {
    e.preventDefault();
    var url = window.location.href + "/savebadge"
    var data = $('#editbadge').serializeArray();

    $.ajax({
        url: url,
        method:"POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data:data,
        success:function(response){

            if(response.error)
            {
                $('#error').remove();
                $('#btnaddbadge').after('<div class="badge bg-danger" id="error">' + response.error + '!</div>')
            }
            else
            {
                $('.bdg').trigger('click');
                $('#exampleModal').modal('toggle');
            }
        },
        error: function(er) {
          console.log(er);
        }
    });
});

////////////////////////////

//////////////////////////
//// ORDER
//////////////////////////

$('#orderstable').on( 'click', '#btneditorder', function( e ) {

    var url = window.location.href + "/editorder/" + $(this).attr('edit');

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
                $('#exampleModalLabel').text('Редактировать заказ');
                $('#modal-body').empty();
                $('#modal-body').append(response);
            }

        },
        error: function(er) {
          console.log(er);
        }
    });

});

$('#modal-body').on('click', '[id^="delorderproduct"]', function(e){

    e.preventDefault();

    var url = window.location.href + "/deletefromorder";
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
                    text: "Товар успешно удален из заказа", // Text that is to be shown in the toast
                    heading: 'Панель', // Optional heading to be shown on the toast
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

                $("#trprod"+id).remove();

                if(response.noorder)
                {
                    $('#exampleModal').modal('toggle');

                    $.toast({
                        text: "В заказе не осталось товаров и он тоже удален", // Text that is to be shown in the toast
                        heading: 'Панель', // Optional heading to be shown on the toast
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

                    setInterval(function() {
                        window.location.reload();
                    }, 2000);

                }
            }

        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#modal-body').on('click', '#btndeleteorder', function(e){
    e.preventDefault();

    var url = window.location.href + "/deleteorder";
    var id = $(this).attr('order');

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

                $('#exampleModal').modal('toggle');

                $.toast({
                    text: "Заказ успешно удален", // Text that is to be shown in the toast
                    heading: 'Панель', // Optional heading to be shown on the toast
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

                setInterval(function() {
                    window.location.reload();
                }, 2000);
            }

        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#modal-body').on('click', '#btnsaveorder', function(e){
    e.preventDefault();

    var url = window.location.href + "/saveorder";
    var id = $(this).attr('order');
    var data = new FormData();
    data.append("id", id);
    var form_data = $('#editorder').serializeArray();

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

            if(!response.error)
            {

                $('#exampleModal').modal('toggle');

                $.toast({
                    text: "Заказ успешно сохранен", // Text that is to be shown in the toast
                    heading: 'Панель', // Optional heading to be shown on the toast
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

                setInterval(function() {
                    window.location.reload();
                }, 2000);
            }

        },
        error: function(er) {
          console.log(er);
        }
    });
});

$('#searchorder').on( 'click', function( e ){
    e.preventDefault();

    var url = window.location.href + '/search/' + $('#search').val();
    $.ajax({
      method: "GET",
      url: url,
      data: {
      },
      success: function(response) {

        if(response.error)
        {
            $('#search').val(response.error);
            return;
        }

        $('#orderstable').empty();
        $('#orderstable').append(response.data);
      },
      error: function(er) {
        console.log(er);
      }
    });
});
////////////////////////////

//////////////////////////
//// USER
//////////////////////////

$('#searchuser').on( 'click', function( e ){
    e.preventDefault();

    var url = window.location.href + '/search/' + $('#search').val();
    $.ajax({
      method: "GET",
      url: url,
      data: {
      },
      success: function(response) {

        if(response.error)
        {
            $('#search').val(response.error);
            return;
        }

        $('#orderstable').empty();
        $('#orderstable').append(response.data);
      },
      error: function(er) {
        console.log(er);
      }
    });
});
////////////////////////////
