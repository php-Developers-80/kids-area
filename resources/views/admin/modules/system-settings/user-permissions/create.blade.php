@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    @include('admin.layouts.loader.loaderCss')

@endsection

@section('page-title')
 إضافة صلاحيات للمستخدمين
@endsection

@section('current-page-name')
    إضافة صلاحيات للمستخدمين
@endsection

@section('page-links')
    @include('admin.modules.system-settings.routingSettingBasic')
    <li class="breadcrumb-item active">
        <a href="{{route('userPermissions.index')}}">  صلاحيات المستخدمين </a>
    </li>
    <li class="breadcrumb-item active">       إضافة صلاحيات للمستخدمين </li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>

    <section class="items-add-page my-3 py-4" style="background-color: white;">
        @if (count($parent_permissions)>0)


        <form action="{{route('userPermissions.store')}}" method="post" id="Form">
            @csrf

            <div class="row">

                {{-------------------------------  ا ختر المستخدم ------------------------------}}
                <h3 class="text-center mb-5" style="font-weight: 700;">إختر المستخدم </h3>

                <div class="col-lg-4 col-md-6  mb-4">
                    <label class="label mb-2 " for="user_id"> إختر المستخدم  </label>
                    <select class=" select2" id="user_id" name="user_id" data-validation="required">
                        <option disabled selected> إختر المستخدم </option>
                        @foreach($users as $user)
                          <option value="{{$user->id}}">
                              {{$user->name}}
                          </option>
                        @endforeach
                    </select>
                </div>

                {{-------------------------------  اختر الصلاحيات  ------------------------------}}
                <h3 class="text-center my-4" style="font-weight: 700;">الصلاحيات</h3>

                {{--------------------- foreach parent permissions -------------------------}}
                @foreach($parent_permissions as $index=>$parent_permission )
                <div class="row mt-4">

                    <div class="col-12 mb-4 " style="direction: ltr;">

                        <div class="mb-4">
                            <span style="cursor: pointer;margin-right: 20px "   class="btn  btn-danger parent_class" att-type="{{$parent_permission->id}}"  > اختيار كل صلاحيات  {{$parent_permission->ar_name}} </span>

                            <input type="checkbox" id="md_checkbox_all-{{$parent_permission->id}}" name="permissions[]" value="{{$parent_permission->id}}"
                                   class="material-inputs filled-in chk-col-light-blue permission_class parent_class_{{$parent_permission->id}}"  />
                            <label for="md_checkbox_all-{{$parent_permission->id}}" style="font-weight: 700;" >{{$parent_permission->ar_name}} </label>
                            -
                            {{++$index}}
                        </div>

                        {{---------------------  child permissions -------------------------}}
                        @php
                            $permissions = \Spatie\Permission\Models\Permission::where('parent_id',$parent_permission->id)
                            ->orderBy('type_order','asc')
                            ->get();
                        @endphp

                        @if (count($permissions)>0)


                            @foreach($permissions as $permission )

                                <div class="row mt-4 border py-2 row permissions-row d-flex align-items-center justify-content-end">

                                    <div class="col-12 mb-4 " style="direction: ltr;">

                                        <div class="mb-4">
                                            <span style="cursor: pointer ;margin-right: 20px"   class="btn  btn-danger child_class" att-type="{{$permission->id}}" style="margin-right: 20px" > اختيار كل صلاحيات  {{$permission->ar_name}}  </span>

                                            <input type="checkbox" id="md_checkbox_all-{{$permission->id}}" name="permissions[]" value="{{$permission->id}}"
                                                   class="material-inputs filled-in chk-col-light-blue permission_class parent_class_{{$parent_permission->id}} child_class_{{$permission->id}}"  />
                                            <label for="md_checkbox_all-{{$permission->id}}" style="font-weight: 700;" >{{$permission->ar_name}} </label>
                                        </div>
                                        {{--------------------- sub_child permissions -------------------------}}
                                        @php
                                            $sub_permissions = \Spatie\Permission\Models\Permission::where('parent_id',$permission->id)
                                            ->orderBy('type_order','desc')
                                            ->get();
                                        @endphp
                                        @if (count($sub_permissions)>0)

                                            <div class="border py-2 row permissions-row d-flex align-items-center justify-content-end">
                                                {{--------------------Single permission----------------------}}
                                                @foreach($sub_permissions as $sub_permission)
                                                    <div class="my-2  col-lg-3 col-md-4 col-sm-6 ">
                                                        <input type="checkbox" id="md_checkbox_all-{{$sub_permission->id}}" name="permissions[]" value="{{$sub_permission->id}}"
                                                               class="material-inputs filled-in chk-col-light-blue permission_class parent_class_{{$parent_permission->id}} child_class_{{$permission->id}} sub_child"
                                                               attr-parent="{{$parent_permission->id}}"
                                                               attr-child="{{$permission->id}}"  />
                                                        <label  for="md_checkbox_all-{{$sub_permission->id}}" >{{$sub_permission->ar_name}}</label>
                                                    </div>
                                                @endforeach
                                                {{--------------------Single permission----------------------}}
                                            </div>
                                        @endif

                                    </div>

                                </div>
                            @endforeach

                            {{-----------------End For Foreach ----------------}}
                        @endif
                    </div>

                </div>
                @endforeach
                {{------------------------------------------------------------------------------}}
                <div class="w-100 pb-3 d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn edit-profile"> حفظ </button>

                </div>
            </div>
        </form>
        @else
            <div class="alert alert-secondary alert-dismissible bg-secondary text-white border-0 fade show"
                 role="alert">
                <strong>لا يوحد صلاحيات حاليا لإضافتها للمستخدمين  </strong>
            </div>
        @endif
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
                        location.replace('{{route('userPermissions.index')}}')

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


    </script>


    <script>
        $(document).on('click', '.parent_class', function () {
            var op = $(this)
            var parent_id = op.attr('att-type');

            var class_name = '.parent_class_'+parent_id;
            var class_name_check = class_name+':checked';
            var check=true;
            $(class_name_check).each(function () {
                check=false;
            });
            $(class_name).prop('checked', check);
        });


        $(document).on('click', '.child_class', function () {
            var op = $(this)
            var child_id = op.attr('att-type');

            var class_name = '.child_class_'+child_id;
            var class_name_check = class_name+':checked';
            var check=true;
            $(class_name_check).each(function () {
                check=false;
            });
            $(class_name).prop('checked', check);
        });

        $(document).on('click', '.sub_child', function () {
            var op = $(this)
            var parent_id_from_sub_child = op.attr('attr-parent');
            var shild_id_from_sub_child = op.attr('attr-child');
            if ( op.is(":checked")){
                $('#md_checkbox_all-'+parent_id_from_sub_child).prop('checked', true);
                $('#md_checkbox_all-'+shild_id_from_sub_child).prop('checked', true);
            }
        });

        $(document).ready(function () {
            $('form').submit( function() {
                if ($('input.permission_class:checked').length < 1) {
                    myToast('اختر على الأقل صلاحية واحدة', 'تنبيه', 'buttom-left', '#ff6849', 'error', 3500, 6);
                    return false;
                }
            });

        });
    </script>
@endsection

