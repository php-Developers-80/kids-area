<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
          content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, admin pro admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, material design, material dashboard bootstrap 5 dashboard template">
    <meta name="description" content="Admin Pro is powerful and clean admin dashboard template">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{$settings?$settings->header_logo?get_file($settings->header_logo):asset('admin/img/logo-icon.png'):asset('admin/img/logo-icon.png')}}" />
    <title>@yield('page-title')</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('f7f96b24be1e39493c67', {
            cluster: 'eu'
        });
    </script>
    @include('admin.layouts.assets._css')
    @yield('styles')
    @include('admin.layouts.loader.loaderCss')
    @toastr_css
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body {{--data-theme="{{data_theme_bg()}}"--}}>
<div class="loader-ajax" style="display: none  ; ">
    <div class="lds-grid" >
        <div></div><div></div><div></div><div></div><div></div><div></div>
        <div></div><div></div><div>
        </div>
    </div>
</div>

<!-- -------------------------------------------------------------- -->
<!-- Preloader - style you can find in spinners.css -->
<!-- -------------------------------------------------------------- -->
<div class="preloader">
    <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none"
         xmlns="http://www.w3.org/2000/svg">
        <path
            d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z"
            stroke="#2962FF" stroke-width="2"></path>
        <path
            d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34"
            stroke="#2962FF" stroke-width="2"></path>
        <path id="teabag" fill="#2962FF" fill-rule="evenodd" clip-rule="evenodd"
              d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z">
        </path>
        <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" stroke="#2962FF"></path>
        <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#2962FF" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
</div>
<!-- -------------------------------------------------------------- -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- -------------------------------------------------------------- -->
<div id="main-wrapper" >

    <!-- -------------------------------------------------------------- -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- -------------------------------------------------------------- -->
    @include('admin.layouts.inc._header')
    <!-- -------------------------------------------------------------- -->
    <!-- End Topbar header -->
    <!-- -------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------- -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- -------------------------------------------------------------- -->
   @include('admin.layouts.inc._left_aside')
    <!-- -------------------------------------------------------------- -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- -------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------- -->
    <!-- Page wrapper  -->
    <!-- -------------------------------------------------------------- -->
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles mb-2">
                <div class="col-md-5 col-12 align-self-center">
                    <h3 class="text-themecolor mb-0">@yield('current-page-name')</h3>
                </div>
                <div class="col-md-7 col-12 align-self-center d-none d-md-flex justify-content-end">
                    <ol class="breadcrumb mb-0 p-0 bg-transparent">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">الرئيسية</a></li>
                        @yield('page-links')
                    </ol>
                </div>
            </div>
            <!-- -------------------------------------------------------------- -->
            <!-- Container fluid  -->
            <!-- -------------------------------------------------------------- -->
            @yield('content')
            <!-- -------------------------------------------------------------- -->
            <!-- End Container fluid  -->
            <!-- -------------------------------------------------------------- -->
            <!-- -------------------------------------------------------------- -->
        </div>
        <!-- footer -->
        <!-- -------------------------------------------------------------- -->
        @include('admin.layouts.inc._footer')
        <!-- -------------------------------------------------------------- -->
        <!-- End footer -->
        <!-- -------------------------------------------------------------- -->
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- End Page wrapper  -->
    <!-- -------------------------------------------------------------- -->
</div>
<!-- -------------------------------------------------------------- -->
<!-- End Wrapper -->
<!-- -------------------------------------------------------------- -->
<!-- -------------------------------------------------------------- -->
<!-- customizer Panel -->
<!-- -------------------------------------------------------------- -->
{{--@include('admin.layouts.inc._quick-settings-box')--}}

<div class="modal fade" id="profileEdit"  role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog  modal-fullscreen modal-dialog-centered" role="document">


        <div class="modal-content" style="overflow-y: scroll !important;">

            <div class="modal-body" id="profileEdit-addOrDelete">

            </div>
            <div class="modal-footer text-center d-flex justify-content-center">
                <button id="profileEditSave"  form="EditForm"  type="submit" class="btn btn-success">حفظ </button>

                <button type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">الغاء</button>

            </div>
        </div>
    </div>
</div>
<div id="notes_alert"></div>
<!-- -------------------------------------------------------------- -->
<!-- All Jquery -->
<!-- -------------------------------------------------------------- -->
@include('admin.layouts.assets._js')
@yield('js')

{{-------------------    pusher    ---------------------}}
{{-------------------    pusher    ---------------------}}
{{-------------------    pusher    ---------------------}}
<script>
    var notes_alert = $('#notes_alert').notify({
        removeIcon: '<i class="icon-close"></i>'
    });



</script>

{{-------------------------------------------------}}
{{-------------------------------------------------}}
{{-------------------------------------------------}}

<script>
    $.validate({

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //-------------------- update profile -----------------------------------

    $(document).on('click','.editProfile',function (e) {
        e.preventDefault()
        var id = $(this).attr('id');

        var url = '{{route('profileControl.edit',auth()->user()->id)}}';

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function(){

            },
            success: function(data){
                $('#profileEdit-addOrDelete').html(data.html);
                $('#profileEdit').modal('show')
                $('.dropify').dropify();
                $.validate({
                });

            },
            error: function(data) {
                $('#profileEdit-addOrDelete').html('<h3 class="text-center">لا تملك الصلاحية</h3>')
            }
        });

    });


    $(document).on('submit','form#EditForm',function(e) {
        e.preventDefault();
        var myForm = $("#EditForm")[0]
        var formData = new FormData(myForm)
        var url = $('#EditForm').attr('action');
        $.ajax({
            url:url,
            type: 'POST',
            data: formData,
            beforeSend: function(){
                $('.loader-ajax').show()
            },
            complete: function(){


            },
            success: function (data) {
                $('.loader-ajax').hide()
                $('#profileEdit').modal('hide')
                $(".useImageEdit").attr("src",data.logo);
                $(".nameEdit").html(data.name);


            },
            error: function (data) {
                $('.loader-ajax').hide()
                if (data.status === 500) {
                    $('#profileEdit').modal("hide");

                }
                if (data.status === 422) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                myToast(key, value, 'top-left', '#ff6849', 'error',4000, 2);

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
@toastr_js
@toastr_render
</body>

</html>
