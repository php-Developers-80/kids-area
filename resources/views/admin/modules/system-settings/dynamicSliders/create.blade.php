@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />

    @include('admin.layouts.loader.loaderCss')

    <style>
        #font_icon {
            font-family: 'FontAwesome', 'sans-serif';
        }
    </style>
@endsection

@section('page-title')
 إضافة قائمة جديدة
@endsection

@section('current-page-name')
    إضافة قائمة جديدة
@endsection

@section('page-links')
    @include('admin.modules.system-settings.routingSettingBasic')

    <li class="breadcrumb-item active">
        <a href="{{route('dynamicSliders.index')}}">  إعدادات القوائم </a>
    </li>
    <li class="breadcrumb-item active">       اضافة قائمة جديدة </li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>

    <section class="add-mainmenu-page my-3 py-4" style="background-color: white;">

        <form action="{{route('dynamicSliders.store')}}" method="post" id="Form">
            @csrf

            {{----------------------------------------}}
            <div class="row">

                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="ar_title"> إسم القائمة بالعربية </label>
                    <input id="ar_title" name="ar_title" type="text" class="form-control" data-validation="required">
                </div>

                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="en_title"> إسم القائمة بالإنجليزية </label>
                    <input id="en_title" name="en_title" type="text" class="form-control" data-validation="required">
                </div>

                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="route_link"> إسم اللينك </label>
                    <select class=" select2" id="route_link" name="route_link" data-validation="required">
                        <option value="">اختر اللينك </option>
                        @foreach($routeLists as $routeRow)
{{--                            @if (\Str::endsWith($routeRow->getName(), ['index','create']) && \Str::contains($routeRow->getPrefix(),'admin'))--}}
{{--                               --}}
{{--                            @endif--}}
                            <option value="{{$routeRow->getName()}}">{{$routeRow->getName()}} </option>
                        @endforeach
                    </select>
                </div>



                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="font_icon"> إختر الأيقون </label>
{{--                    <select class="form-control" id="font_icon" name="font_icon" data-validation="required">--}}
{{--                        <option disabled selected> اختر الأيقون </option>--}}
{{--                        @include('admin.modules.system-settings.dynamicSliders.inc.font_icons')--}}
{{--                    </select>--}}
                    <input class="form-control" id="font_icon" name="font_icon" data-validation="required">
                </div>
                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="permission_id"> إختر الصلاحية </label>
                    <select class="select2" id="permission_id" name="permission_id" {{--data-validation="required"--}}>
                        <option disabled selected> اختر الصلاحية </option>
                        @foreach($permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->ar_name}} </option>
                        @endforeach

                    </select>
                </div>



                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="from"> إرفع صورة </label>
                    <input type="file" class="dropify" name="image">
                </div>

                <div class="col-12 d-flex align-items-center    my-4">
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="is_parent"
                            id="parentId"
                            value="parent"
                            checked
                        />
                        <label class="form-check-label" for="parentId"><h4>رئيسي</h4></label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="is_parent"
                            id="childId"
                            value="child"
                        />
                        <label class="form-check-label" for="childId"><h4>فرعي</h4></label>
                    </div>


                </div>


                <div class="col-lg-4 col-md-6 mb-4" id="parent_slider_menu_section" style="display: none">
                    <label class="label mb-2 " for="parent_id"> إختر القوائم الرئيسية </label>
                    <select class=" select2" id="parent_id" name="parent_id" data-validation="required">
                        <option disabled  selected> اختر القائمة الرئيسية التى يتبعها  </option>
                        @foreach($dynamicSliders as $dynamicSlider)
                            <option  value="{{$dynamicSlider->id}}">
                                {{$dynamicSlider->ar_title }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="col-lg-4 col-md-6 mb-4" id="sub_slider_menu_section" >
                    <label class="label mb-2 " for="child_id"> إختر القوائم الفرعية </label>
                    <select class=" select2" multiple id="child_id" name="child_id[]" >
                        @foreach($subDynamicSliders as $subDynamicSlider)
                            <option  value="{{$subDynamicSlider->id}}">
                                {{$subDynamicSlider->ar_title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-100 pb-3 d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn edit-profile"> حفظ </button>

                </div>
            </div>

            {{----------------------------------------}}
        </form>
    </section>

@endsection

@section('js')
    <script src="{{asset('admin')}}/js/jquery.dataTables.min.js"></script>
{{--    <script src="{{asset('admin')}}/js/dataTables.responsive.min.js"></script>--}}
    <script>

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
                        location.replace('{{route('dynamicSliders.index')}}')

                    }, 2000);


                },
                error: function (data) {
                    $('.loader-ajax').hide()
                    if (data.status === 500) {

                        messages.show("هناك خطأ", {
                            type: 'danger',
                            title: 'خطأ',
                            icon: '<i class="icon-alert-octagon"></i>',
                            delay:2000,
                        });
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

        //=========================================================
        //=========================================================
        //======================= Create Submenu ==================
        //=========================================================

        $(document).on('click','#parentId',function (){
            if ($(this).is(':checked')) {
                $('#parent_slider_menu_section').hide();
                $('#sub_slider_menu_section').show();
            }

            if (!$(this).is(':checked')) {
                $('#parent_slider_menu_section').show();
                $('#sub_slider_menu_section').hide();
            }

        });


        $(document).on('click','#childId',function (){
            if (!$(this).is(':checked')) {
                $('#parent_slider_menu_section').hide();
                $('#sub_slider_menu_section').show();
            }

            if ($(this).is(':checked')) {
                $('#parent_slider_menu_section').show();
                $('#sub_slider_menu_section').hide();
            }

        });



    </script>



@endsection

