@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">

    @include('admin.layouts.loader.loaderCss')
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
                <a href="{{route('dynamicSliders.reOrderAllDynamicSliders')}}" class="btn mb-2 btn-danger "> اعادة ترتيب جميع القوائم الرئيسية و الفرعية <span class="icon-add_circle"></span>  </a>
            </div>
            <div class="col-12">
                <h2 class="py-2 mb-5 font-weight-bold text-center">يمكنك السحب و الإفلات لإعادة ترتيب القوائم الرئيسية
                </h2>

                <form action="{{route('dynamicSliders.changeOrder')}}" method="post" id="Form">
                    @csrf
                    <div class="row" id="sortable">

                        {{-----------------------------------------}}
                        @foreach($dynamicSliders as $row)

                        <div class="col-md-12   mb-4 ui-state-default d-flex align-items-center ">
                            <div class="border w-100 d-flex align-items-center justify-content-between">
                                {{----- input hiden -----}}
                                <input type="hidden" value="{{$row->id}}" name="order[]">
                                {{---------title-----------}}
                                <h4 class="font-weght-bold mx-3">
                                    {{$row->ar_title}}
                                    - عدد القوائم الفرعية : {{count($row->sub_dynamic_slider)}}
                                </h4>
                                <div class="btns">
                                    {{--------- buttons --------}}
                                    <a href="{{route('dynamicSliders.edit',$row->id)}}" class="btn-dark-info btn text-white m-1 ">تعديل</a>
                                    <span style="cursor: pointer" class="btn-danger btn text-white m-1 status " id="{{$row->id}}" att_type="{{$row->is_shown == "shown"?"hidden":'shown'}}" >
                                        {{$row->is_shown == "shown"?"إخفاء":"إظهار"}}</span>
                                    {{---------- buttons --------}}
                                </div>

                            </div>

                        </div>
                        @endforeach
                        {{-----------------------------------------}}

                    </div>

                    <div class=" mb-2 text-center">
                        <button class="btn mb-2 edit-profile ">حفظ</button>
                    </div>
                </form>

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
        $(function () {
            $("#sortable").sortable();
            $("#sortable").disableSelection();
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

