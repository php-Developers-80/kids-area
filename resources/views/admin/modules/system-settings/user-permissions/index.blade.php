@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
     صلاحيات المستخدمين
@endsection

@section('current-page-name')
    صلاحيات المستخدمين
@endsection

@section('page-links')
    @include('admin.modules.system-settings.routingSettingBasic')
    <li class="breadcrumb-item active">     صلاحيات المستخدمين </li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>

    <section class="brands-page my-5">

        <!-- basic table -->
        <div class="row">
            <div class="col-12 mb-2">
                <a href="{{route('userPermissions.create')}}" class="btn mb-2 btn-success "> أضف <span class="icon-add_circle"></span>  </a>

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
                                    <th>الصورة </th>
                                    <th>اسم الأدمن </th>
                                    <th>الوظيفة فى النظام </th>
                                    <th>الهاتف</th>
                                    <th>حالة النشاط </th>
                                    <th>التفعيل </th>
                                    <th>عدد الصلاحيات التى يمتلكها</th>
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
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

            <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
            <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">


                <div class="modal-content">

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
    {{--    <script src="{{asset('admin')}}/js/dataTables.responsive.min.js"></script>--}}
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
            "ajax": "{{route('userPermissions.index')}}",

            "columns": [
                {"data": "delete_all", orderable: false, searchable: false},
                {"data": "logo",   orderable: false,searchable: true},
                {"data": "name",   orderable: false,searchable: true},
                {"data": "user_type",   orderable: false,searchable: true},
                {"data": "phone",   orderable: false,searchable: true},
                {"data": "is_active",   orderable: false,searchable: true},
                {"data": "is_block",   orderable: false,searchable: true},
                {"data": "permissions_count", orderable: false, searchable: false},
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
                var url = '{{ route("userPermissions.destroy", ":id") }}';
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
                        url: '{{route('userPermissions.delete.bulk')}}',
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

    </script>
@endsection

