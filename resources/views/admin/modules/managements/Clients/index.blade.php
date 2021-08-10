@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="{{asset('admin/css/select2.css')}}" rel="stylesheet">
   @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
  العملاء
@endsection

@section('current-page-name')
    العملاء
@endsection

@section('page-links')
    @include('admin.modules.managements.routingManagment')
    <li class="breadcrumb-item active">     كل العملاء </li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>
    <section class="brands-page my-5">

        <!-- basic table -->
        <div class="row">
            <div class="col-12 mb-2">
                <button id="addButton" class="btn mb-2 btn-success "> أضف <span class="icon-add_circle"></span>  </button>
                <button id="bulk_delete" class="btn mb-2 btn-danger"> حذف الكل <span class="icon-delete"></span>  </button>
            </div>
            <div class="col-12">
                <div class="card">

                    <div class="card-body">


                        <div class="table-responsive">
                            <table id="basicExample" class="table  table-bordered">

                                <thead>
                                <tr>
                                    <th>
                                        <input id="checkAll" type='checkbox' class='check-all' data-tablesaw-checkall>
                                    </th>
                                    <th>الإسم </th>
                                    <th>رقم الهاتف</th>
                                    <th>وقت الإضافة</th>
                                    <th>التحكم</th>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- order table -->



        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

            <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
            <div class="modal-dialog  modal-fullscreen modal-dialog-centered" role="document">


                <div class="modal-content" style="overflow-y: scroll !important;">

                    <div class="modal-body" id="form-for-addOrDelete">

                    </div>
                    <div class="modal-footer text-center d-flex justify-content-center">
                        <button id="save"  form="Form"  type="submit" class="btn btn-success">حفظ </button>

                        <button type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">الغاء</button>

                    </div>
                </div>
            </div>
        </div>


    </section>

@endsection

@section('js')
    <script src="{{asset('admin')}}/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('admin/js/select2.js')}}"></script>
    <script src="{{asset('admin/backEndFiles/repeater/jquery.repeater.min.js')}}"></script>

    <script>

        var messages = $('#messages').notify({
            type: 'messages',
            removeIcon: '<i class="icon-close"></i>'
        });

        $("#basicExample").DataTable({
            dom: 'Bfrtip',
            responsive: 1,
            "processing": true,
            "lengthChange": true,
            "serverSide": true,
            "ordering": true,
            "searching": true,
            'iDisplayLength': 20,
            "ajax": "{{route('customers.index')}}",
            "columns": [
                {"data": "delete_all", orderable: false, searchable: false},
                {"data": "name",   orderable: true,searchable: true},
                {"data": "phone",   orderable: true,searchable: true},
                {"data": "created_at", searchable: true},
                {"data": "actions", orderable: false, searchable: false}
            ],
            "language": {
                "sProcessing":   "{{trans('admin.sProcessing')}}",
                "sLengthMenu":   "{{trans('admin.sLengthMenu')}}",
                "sZeroRecords":  "{{trans('admin.sZeroRecords')}}",
                "sInfo":         "{{trans('admin.sInfo')}}",
                "sInfoEmpty":    "{{trans('admin.sInfoEmpty')}}",
                "sInfoFiltered": "{{trans('admin.sInfoFiltered')}}",
                "sInfoPostFix":  "",
                "sSearch":       "{{trans('admin.sSearch')}}:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "{{trans('admin.sFirst')}}",
                    "sPrevious": "{{trans('admin.sPrevious')}}",
                    "sNext":     "{{trans('admin.sNext')}}",
                    "sLast":     "{{trans('admin.sLast')}}"
                }
            },
            order: [
                [2, "desc"]
            ],
        })


        //========================================================================
        //========================================================================
        //=======================Add , edit model=================================
        //========================================================================
        $(document).on('click','#addButton',function (e) {
            e.preventDefault()
            var url = '{{route('customers.create')}}';
            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function(){
                    $('.loader-ajax').show()
                },
                success: function(data){
                    window.setTimeout(function() {
                        $('.loader-ajax').hide()

                        $('#form-for-addOrDelete').html(data.html);
                        $('#exampleModalCenter').modal('show')
                        $('.dropify').dropify();
                         $('select').select2();
                        $.validate({
                        });
                    }, 2000);
                },
                error: function(jqXHR,error, errorThrown) {
                    $('.loader-ajax').hide()
                    if(jqXHR.status&&jqXHR.status==500){
                        $('#exampleModalCenter').modal("hide");
                        $('#form-for-addOrDelete').html('<h3 class="text-center">لا تملك الصلاحية</h3>')
                        //save
                        messages.show("لا تملك هذه الصلاحية..", {
                            type: 'danger',
                            title: '',
                            icon: '<i class="icon-error"></i>',
                            delay:2000,
                        });
                    }


                }
            });
        });

        $(document).on('click','.editButton',function (e) {
            e.preventDefault()
            var id = $(this).attr('id');

            var url = '{{route('customers.edit',":id")}}';
            url = url.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                beforeSend: function(){

                    $('.loader-ajax').show()
                },
                success: function(data){
                    window.setTimeout(function() {

                        $('#form-for-addOrDelete').html(data.html);
                        $('.loader-ajax').hide()
                        $('#exampleModalCenter').modal('show')
                        $('.dropify').dropify();
                        $('.linear-background').hide()
                        $('select').select2();
                        $.validate({
                        });
                    }, 2000);
                },
                error: function(data) {
                    $('.loader-ajax').hide()
                    $('#form-for-addOrDelete').html('<h3 class="text-center">لا تملك الصلاحية</h3>')
                    messages.show("لا تملك هذه الصلاحية..", {
                        type: 'danger',
                        title: '',
                        icon: '<i class="icon-error"></i>',
                        delay:2000,
                    });
                }
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
                       // $('#exampleModalCenter').modal("hide");
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
        //============================Delete======================================
        //========================================================================
        //delete one row
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('id');
            swal({
                title: "هل أنت متأكد من الحذف؟",
                text: "لا يمكنك التراجع بعد ذلك؟",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "موافق",
                cancelButtonText: "الغاء",
                okButtonText: "موافق",
                closeOnConfirm: false
            }, function () {
                var url = '{{ route("customers.destroy", ":id") }}';
                url = url.replace(':id', id);
                console.log(url);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {id: id},
                    success: function (data) {
                        swal.close()
                        myToast('بنجاح', 'تم الأمر بنجاح', 'top-left', '#ff6849', 'success',4000, 2);
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });
                        $('#basicExample').DataTable().ajax.reload();
                    },error: function(data) {
                        swal.close()
                        messages.show("لا تملك الصلاحية للحذف", {
                            type: 'danger',
                            title: '',
                            icon: '<i class="icon-error"></i>',
                            delay:2000,
                        });
                    }

                });
            });
        });
        //delete multi rows
        $(document).on('click', '#checkAll', function () {
            var check=true;
            $('.delete-all:checked').each(function () {
                check=false;
            });

            $('.delete-all').prop('checked', check);
        });

        $(document).on('click', '#bulk_delete', function () {
            var id = [];
            $('.delete-all:checked').each(function () {
                id.push($(this).attr('id'));
            });
            if (id.length > 0) {
                swal({
                    title: "هل انت متاكد انك تريد حذف هذه البيانات؟",
                    text: "لن يمكنك استعادة هذه البيانات بعد الحذف.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "حذف البيانات",
                    cancelButtonText: "الغاء",
                    okButtonText: "موافق",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        url: '{{route('customers.delete.bulk')}}',
                        type: 'DELETE',
                        data: {id: id},
                        success: function (data) {
                         $('#checkAll').prop('checked',false);
                            swal.close()
                            messages.show("تمت العملية بنجاح..", {
                                type: 'success',
                                title: '',
                                icon: '<i class="jq-icon-success"></i>',
                                delay:2000,
                            });
                            $('#basicExample').DataTable().ajax.reload();
                            if (data.error.length > 0) {
                                myToast('لم تتم العملية', data.error, 'buttom-left', '#ff6849', 'error', 3500, 6);
                            } else {
                                myToast('عملية ناجحة', data.success, 'buttom-left', '#ff6849', 'success', 3500, 6);
                            }
                        },error: function(data) {
                            swal.close()
                            messages.show("لا تملك الصلاحية للحذف", {
                                type: 'warning',
                                title: '',
                                icon: '<i class="icon-error"></i>',
                                delay:2000,
                            });
                        }
                    });
                });
            } else {
                swal({
                    title: "لم تتم العملية",
                    text: "برجاء تحديد  المراد حذفه اولا.",
                    type: "error",
                    confirmButtonText: "موافق"
                });
            }
        });

        //-------------- repeater --------------------
        var room = 1;

        function education_fields() {

            room++;
            var objTo = document.getElementById('education_fields')
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "mb-3 removeclass" + room);
            divtest.setAttribute("id", "removeclass" + room);
            var rdiv = 'removeclass' + room;
            divtest.innerHTML = `
 <div class="row">
        <div class="col-sm-10">
            <div class="mb-3">
                <input data-validation="required" type="text" class="form-control"  name="son_name[]" placeholder="الإسم">
            </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
<button class="btn btn-danger removeDiv" type="button" attr-value="${room}">
<i class="fa fa-minus"></i>
</button>
</div>
        </div>
    </div>`;
            $('select').select2();

            $.validate({
            });
            objTo.appendChild(divtest)
        }

        $(document).on('click','.removeDiv',function (e){
            e.preventDefault()
            var room = $(this).attr('attr-value')
            console.log(room);
            var classDiv=".removeclass"+room
            $(this).closest(classDiv).remove();

        })

        $(document).on('click','#AddAccounts',function (e){
            e.preventDefault()
            var op =$(this)
            var op_status = op.attr('attr-value')
            if (op_status == "hidden"){
                $('.accountDiv').show()
                op.attr('attr-value','shown')
               op.html(`أسماء الأولاد
                <i  class="fad fa-minus-circle" >
                </i>`)
                $('#is_there_bank_account').val('yes')
            }else{
                $('.accountDiv').hide()
                op.attr('attr-value','hidden')
                op.html(`  أسماء الأولاد
                <i  class="fad fa-plus" >
                </i>`)
                $('#is_there_bank_account').val('no')
            }
        })

    </script>
@endsection
