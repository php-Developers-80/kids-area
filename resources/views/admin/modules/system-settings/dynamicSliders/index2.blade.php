@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">

    @include('admin.layouts.loader.loaderCss')
    <style>
        .menuGroup {
            margin: 10px;
            padding: 10px;
            border: 1px solid #e4e4e4;
        }

        .menuGroup h2 {
            margin: 0;
            padding: 0px 0px 20px 0px;
        }

        .menuItems {}

        .menuItem {
            margin: 5px;
            padding: 10px;

        }

        .menuPlaceholder {
            width: 100%;
            height: 50px;
            padding: 20px;
            display: block;
            margin: 0 0 15px 0;
            background: #f3f3f3;
            border: 1px dashed #dfdfdf;
        }
    </style>
@endsection

@section('page-title')
    إعدادات القوائم
@endsection

@section('current-page-name')
    إعدادات القوائم
@endsection

@section('page-links')
    @include('admin.modules.system-settings.routingSettingBasic')

    <li class="breadcrumb-item active">      إعدادات القوائم </li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>
    <section class="menu-settings-page  my-3 py-4" style="background-color: white;">

        <!-- basic table -->
        <div class="row">
            <div class="col-12 mb-2">
                <a href="{{route('dynamicSliders.create')}}" class="btn mb-2 btn-success "> أضف <span class="icon-add_circle"></span>  </a>
            </div>
            <div class="col-12">
                @if (count($dynamicSliders)>0)


                    <h2 class="py-2 mb-5 font-weight-bold text-center">يمكنك السحب و الإفلات لإعادة ترتيب القوائم
                    </h2>

                    <form action="{{route('dynamicSliders.reOrderAllDynamicSlidersAction')}}" method="post" id="Form">
                        @csrf

                        <div class="row" id="sortable">

                            <div class="sortMenu">
                                @foreach($dynamicSliders as $row)

                                    <div class="menuGroup" >
                                        <input type="hidden" value="parent-{{$row->id}}" name="order[]">
                                        <div style=" display: flex;align-items: center;">
                                            <h2 style="padding: 0 0 0 20px ;"> {{$row->ar_title}} </h2>
                                            {{--------- buttons --------}}
                                            <a href="{{route('dynamicSliders.edit',$row->id)}}" class="btn-dark-info btn text-white m-1 ">تعديل</a>
                                            <span style="cursor: pointer" class="btn-danger btn text-white m-1 status " id="{{$row->id}}" att_type="{{$row->is_shown == "shown"?"hidden":'shown'}}" >
                                                          {{$row->is_shown == "shown"?"إخفاء":"إظهار"}}
                                                        </span>
                                            {{---------- buttons --------}}
                                        </div>
                                        <div id="{{$row->id}}" class="menuItems">
                                            <div id="{{rand(1111111,9999999)}}" style="opacity: 0" class="menuItem"></div>
                                            @foreach($row->sub_dynamic_slider as $sub_row)
                                                <div id="{{$sub_row->id}}" class="menuItem">
                                                    <input type="hidden" value="sub-{{$sub_row->id}}" name="order[]">
                                                    <div class="border w-100 d-flex align-items-center justify-content-between">
                                                        <h4 class="font-weght-bold mx-3"> {{$sub_row->ar_title}}</h4>
                                                        <div class="btns">
                                                            {{--------- buttons --------}}
                                                            <a href="{{route('dynamicSliders.edit',$sub_row->id)}}" class="btn-dark-info btn text-white m-1 ">تعديل</a>
                                                            <span style="cursor: pointer" class="btn-danger btn text-white m-1 status " id="{{$sub_row->id}}" att_type="{{$sub_row->is_shown == "shown"?"hidden":'shown'}}" >
                                                          {{$sub_row->is_shown == "shown"?"إخفاء":"إظهار"}}
                                                        </span>
                                                            {{---------- buttons --------}}
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class=" mb-2 text-center">
                            <button class="btn mb-2 edit-profile ">حفظ</button>
                        </div>
                    </form>
                @else

                    <div class="alert alert-secondary alert-dismissible bg-secondary text-white border-0 fade show"
                         role="alert">
                        <strong>لا يوحد قوائم  </strong>
                    </div>
                @endif
            </div>
        </div>
        <!-- order table -->
    </section>

@endsection

@section('js')
    <script src="{{asset('admin')}}/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('admin')}}/js/jquery.ui.js"></script>

    {{--    <script src="{{asset('admin')}}/js/dataTables.responsive.min.js"></script>--}}
    <script>

        var messages = $('#messages').notify({
            type: 'messages',
            removeIcon: '<i class="icon-close"></i>'
        });

        //========================================================================
        //========================================================================
        //============================Jquery Sortable=============================
        //========================================================================

        $(document).ready(function() {

            // Sort the parents
            $(".sortMenu").sortable({
                containment: "document",
                items: "> div",
                tolerance: "pointer",
                cursor: "move",
                opacity: 0.7,
                revert: 300,
                delay: 150,
                placeholder: "menuPlaceholder",
                start: function(e, ui) {
                    ui.placeholder.height(ui.helper.outerHeight());
                }
            });

            // Sort the children
            $(".menuItems").sortable({
                items: "> div",
                tolerance: "pointer",
                containment: "document",
                connectWith: '.menuItems'
            });

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
                        $('#exampleModalCenter').modal('hide')
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });
                        $('#basicExample').DataTable().ajax.reload();

                    }, 2000);


                },
                error: function (data) {
                    $('.loader-ajax').hide()
                    if (data.status === 500) {
                        $('#exampleModalCenter').modal("hide");
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


        //========================================================================
        //========================================================================
        //============================Change Status======================================
        //========================================================================
        $(document).on('click', '.status', function () {
            var id = $(this).attr('id');
            var op = $(this);
            swal({
                title: "هل أنت متأكد من ذلك ؟",
                text: "اضغط موافق ....",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "موافق",
                cancelButtonText: "الغاء",
                okButtonText: "موافق",
                closeOnConfirm: false
            }, function () {
                var url = '{{ route("dynamicSliders.changeStatus", ":id") }}'
                url = url.replace(':id', id);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {id: id},
                    success: function (data) {
                        swal.close()
                        if (data == 'hidden'){
                            op.html('إظهار')
                        }
                        if (data != 'hidden'){
                            op.html('إخفاء')
                        }
                        myToast('بنجاح', 'تم الأمر بنجاح', 'top-left', '#ff6849', 'success',4000, 2);
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });
                    },error: function(data) {
                        swal.close()
                        messages.show("لا تملك الصلاحية ", {
                            type: 'danger',
                            title: '',
                            icon: '<i class="icon-error"></i>',
                            delay:2000,
                        });
                    }

                });
            });
        });


    </script>

@endsection

