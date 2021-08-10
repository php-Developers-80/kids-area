<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{$settings?$settings->header_logo?get_file($settings->header_logo):asset('admin/img/logo-icon.png'):asset('admin/img/logo-icon.png')}}" />

    <title>تسجيل الدخول</title>
    @include('admin.layouts.assets._css')
    @yield('styles')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="main-wrapper">
    <!-- -------------------------------------------------------------- -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- -------------------------------------------------------------- -->
    <div class="preloader">
        <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#2962FF" stroke-width="2"></path>
            <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#2962FF" stroke-width="2"></path>
            <path id="teabag" fill="#2962FF" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
            <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#2962FF"></path>
            <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#2962FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- -------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------- -->
    <!-- Login box.scss -->
    <!-- -------------------------------------------------------------- -->
    <div id="messages"></div>
    <div id="notes"></div>
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url("{{$settings?$settings->header_logo?get_file($settings->header_logo):asset('admin/img/auth-bg.jpg'):asset('admin/img/auth-bg.jpg')}}") no-repeat center center;">

        <div class="auth-box p-4 bg-white rounded">
            <div>
                <div class="logo text-center">
                    <span class="db"><img alt="thumbnail" class="rounded-circle" width="80" src="{{$settings?$settings->header_logo?get_file($settings->header_logo):asset('admin/img/logo-icon.png'):asset('admin/img/logo-icon.png')}}"></span>
                    <h5 class="font-weight-medium mb-3">تسجيل الدخول</h5>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        {{-- Form Login --}}
                        <form class="form-horizontal mt-3" action="{{route('admin.login.submit')}}" method="post" id="LoginForm">
                          @csrf
                            <div class="mb-3 row">
                                <div class="col-12">
                                    <input data-validation="required" name="user_name" class="form-control" type="text"  placeholder="اسم المستخدم">
                                </div>

                                <div class="col-12 mt-2" >
                                    <input data-validation="required" name="password" class="form-control" type="password"  placeholder="كلمة المرور">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="col-xs-12">
                                    <button class="btn d-block w-100 btn-info" type="submit"  id="loginButton">
                                        <i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i>
                                        <i id="LoaderId" style="display: none;margin-left: 6px" class="fa fa-circle-o-notch fa-spin"></i>
                                        تسجيل الدخول
                                    </button>
                                </div>
                            </div>
                        </form>
                        {{-- Form --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Login box.scss -->
    <!-- -------------------------------------------------------------- -->
</div>
@include('admin.layouts.assets._js')
@yield('js')
<script>
    $.validate({

    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var notes = $('#notes').notify({
        removeIcon: '<i class="icon-close"></i>'
    });
    /* notes.show("I'm a notification I will quickly alert you as well!", {
         type: 'success',
         title: 'Hello',
         icon: '<i class="icon-sentiment_satisfied"></i>'
     });*/
    var messages = $('#messages').notify({
        type: 'messages',
        removeIcon: '<i class="icon-close"></i>'
    });


    $("form#LoginForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var url = $('#LoginForm').attr('action');
        $.ajax({
            url:url,
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('#loginButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                    ' ></span> <span style="margin-left: 4px;">جارى العمل</span>').attr('disabled', true);

            },
            complete: function(){


            },
            success: function (data) {
                messages.show(" بك مرة أخرى ", {
                    type: 'success',
                    title: 'مرحبا',
                    icon: '<i class="icon-sentiment_satisfied"></i>',
                    delay:2000,
                });

                window.setTimeout(function() {
                    window.location.href=data.router;
                }, 2000);
            },
            error: function (data) {
                if (data.status === 500) {
                    $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> تسجيل الدخول`).attr('disabled', false);
                    messages.show(" فى اسم المستخدم و/أو كلمة المرور", {
                        type: 'danger',
                        title: 'خطأ',
                        icon: '<i class="icon-alert-octagon"></i>',
                        delay:2000,
                    });
                }
                if (data.status === 422) {
                    $('#loginButton').html('{{__('admin.login')}}').attr('disabled', false);
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                notes.show(value, {
                                    type: 'danger',
                                    title: key,
                                    icon: '<i class="icon-alert-triangle"></i>',
                                    delay:2000,
                                });

                            });

                        } else {

                        }
                    });
                }
            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>

</body>

</html>
