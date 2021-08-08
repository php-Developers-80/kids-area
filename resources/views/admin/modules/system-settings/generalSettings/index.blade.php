@extends('admin.layouts.layout')

@section('styles')
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
    الإعدادت العامة
@endsection

@section('current-page-name')
    الإعدادت العامة
@endsection

@section('page-links')

    @include('admin.modules.system-settings.routingSettingBasic')
    <li class="breadcrumb-item active">    الإعدادت العامة </li>
@endsection

@section('content')


    <div id="messages"></div>
    <div id="notes"></div>

    <section class="user-register general-settings my-5">

        <form id="Form" action="{{route('generalSettings.update',setting()->id)}}" method="post" >
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-lg-4 col-sm-6 mb-4">
                    <label class="label mb-2 ">الإسم  </label>
                    <input type="text"  value="{{setting()->ar_title}}" class="form-control" data-validation="required" name="ar_title">
                </div>


                <div class="col-lg-4 col-sm-6 mb-4">
                    <label class="label mb-2 ">العنوان   </label>
                    <input type="text"  value="{{setting()->address1}}" class="form-control" data-validation="required" name="address1">
                </div>



                <div class="col-lg-4 col-sm-6 mb-4">
                    <label class="label mb-2 "> البريد الإلكتروني </label>
                    <input type="email"  name="email1"  value="{{setting()->email1}}" class="form-control" {{--data-validation="required"--}}>
                </div>



                <div class="col-lg-3 col-sm-6 mb-3">
                    <label class="label mb-2 "> رقم الهاتف الاول  (رقم فقط)</label>
                    <input type="text" data-role="tagsinput" name="phone1" value="{{setting()->phone1}}" class="form-control numbersOnly" data-validation="required">
                </div>


                <div class="col-lg-3 col-sm-6 mb-3">
                    <label class="label mb-2 "> رقم الهاتف الثانى (رقم فقط)</label>
                    <input type="text" data-role="tagsinput" name="phone2" value="{{setting()->phone2}}" class="form-control numbersOnly" data-validation="required">
                </div>


                <div class="col-lg-4 col-sm-6 mb-4">
                    <label class="label mb-2 "> اللوجو </label>
                    <input type="file" class="dropify" data-default-file="{{get_file(setting()->header_logo)}}" name="header_logo" />
                </div>


                <div class="col-lg-4 col-sm-6 mb-4">
                    <label class="label mb-2 "> صورة تسجيل الدخول </label>
                    <input type="file" class="dropify" name="login_banner" data-default-file="{{get_file(setting()->login_banner)}}" name="header_logo"/>
                </div>

                <div class="col-12 d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn edit-profile"> حفظ </button>
                </div>


            </div>
        </form>


    </section>


@endsection

@section('js')


    <script>
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
        //=========================================================
        //=========================================================
        //========================Save Data=========================
        //=========================================================
        $(document).on('submit','form#Form',function(e) {
            e.preventDefault();
            var myForm = $("#Form")[0]
            var formData = new FormData(myForm)
            var url = $('#Form').attr('action');
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
                    window.setTimeout(function() {
                        $('.loader-ajax').hide()
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });
                    }, 2000);
                },
                error: function (data) {
                    if (data.status === 500) {
                        $('.loader-ajax').hide()
                        $('#exampleModalCenter').modal("hide");
                        messages.show("تنبيه أنت لا تملك الصلاحية لفعل ذلك", {
                            type: 'danger',
                            title: '',
                            icon: '<i class="icon-alert-octagon"></i>',
                            delay:2000,
                        });
                    }
                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    myToast("تأكد من البيانات", value, 'top-left', '#ff6849', 'error',4000, 2);

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

        //=========================================================
        //=========================================================
        //======================     ajax     =====================
        //=========================================================

        $(document).on('click change','#number_of_account_system_level',function (){
           var number = $('#number_of_account_system_level').val();
           var i = 0;
           var sum = 0;
            for (i = 0; i <= number; i++) {
                sum += i;

            }

        });

    </script>
@endsection
