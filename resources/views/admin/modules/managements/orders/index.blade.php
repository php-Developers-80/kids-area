@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="{{asset('admin/css/select2.css')}}" rel="stylesheet">
    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
    الطلبات
@endsection

@section('current-page-name')
    الطلبات
@endsection

@section('page-links')
    @include('admin.modules.managements.routingManagment')
    <li class="breadcrumb-item active">     كل الطلبات </li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>
    <section class="brands-page my-5">

        <!-- basic table -->
        <div class="row">
            <div class="col-12 mb-2">
                <button id="showDaily" class="btn btn-success pull-left"> عرض طلبات اليوم  <span class="icon-clear_all"></span>  </button>
                <button id="showAll" class="btn btn-primary pull-left"> عرض الكل  <span class="icon-clear_all"></span>  </button>
                <button id="search" class="btn btn-warning pull-left"> البحث <span class="icon-search"></span>  </button>
                <button id="bulk_delete" class="btn btn-danger pull-left"> حذف الكل <span class="icon-delete"></span>  </button>
            </div>
            <div class="col-12">
                <div class="card">

                    <div class="card-body">


                        <div class="table-responsive" style="overflow-y: scroll">
                            <table id="basicExample" class="table  table-bordered" >

                                <thead>
                                <tr>
                                    <th>
                                        <input id="checkAll" type='checkbox' class='check-all' data-tablesaw-checkall>
                                    </th>
                                    <th>رقم الفاتورة </th>
                                    <th>اسم ولى الأمر </th>
                                    <th>رقم الهاتف </th>
                                    <th>الصافى </th>
                                    <th>المدة </th>
                                    <th>وقت الدخول </th>
                                    <th>وقت الخروج </th>
                                    <th>الأبناء </th>
                                    <th>اسم الكاشير </th>
                                    <th>وقت الإضافة</th>
                                    <th>التحكم</th>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot align="right">
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- order table -->






        <div class="modal fade" id="search_form" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

            <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
            <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">


                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">  البحث </h5>

                    </div>
                    <div class="modal-body" id="form-for-addOrDelete">
                        <form id="Form1" action="{{route('orders.filter')}}" method="post">
                            @csrf
                            <div class="row ">

                                <div class="col-md-4">
                                    <label for="from">من تاريخ /</label>
                                    <input type="date" id="from" name="from"  class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="to">إلى تاريخ /</label>
                                    <input type="date" id="to" name="to"  class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label for="code">كود الفاتورة /</label>
                                    <input type="text" id="id" name="id"  class="form-control">
                                </div>



                            </div>

                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <label for="customer_id">اختر ولى الأمر /</label>
                                    <select class="form-control" name="customer_id" id="customer_id" >
                                        <option selected value="0" >اختر ولى الأمر </option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}} - {{$customer->phone}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="user_id">اختر الكاشير /</label>
                                    <select class="form-control" name="user_id" id="user_id" >
                                        <option selected value="0" >اختر الكاشير</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3" >
                                    <label for="from_money">من القيمة /</label>
                                    <input type="text" id="from_money" name="from_money"  class="form-control numbersOnly">
                                </div>
                                <div class="col-md-3"  >
                                    <label for="to_money">إلى القيمة /</label>
                                    <input type="text" id="to_money" name="to_money"  class="form-control numbersOnly">
                                </div>


                            </div>

                            <div class="row align-items-center justify-content-center mt-2 form-group">


                            </div>

                        </form>

                    </div>
                    <div class="modal-footer text-center d-flex justify-content-center">
                        <span id="clearFrom"  class="btn btn-warning pull-left" style="margin: 5px"> مسح  <span class="icon-delete"></span>  </span>
                        <button type="submit" form="Form1" class="btn btn-success pull-left "> بحث <span class="icon-search"></span>  </button>

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
            'iDisplayLength': 100,
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // converting to interger to find total
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // computing column Total of the complete result
                var monTotal = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                $( api.column( 0).footer() ).html('الإجمالى');
                $( api.column( 4 ).footer() ).html(monTotal);
            },
            "ajax": "{{route('orders.index')}}",
            "columns": [
                {"data": "delete_all", orderable: false, searchable: false},
                {"data": "id",   orderable: true,searchable: true},
                {"data": "name",   orderable: true,searchable: true},
                {"data": "phone",   orderable: true,searchable: true},
                {"data": "total_cost",   orderable: true,searchable: true},
                {"data": "ticket_time",   orderable: true,searchable: true},
                {"data": "started_at",   orderable: true,searchable: true},
                {"data": "finished_at",   orderable: true,searchable: true},
                {"data": "sons_names",   orderable: true,searchable: true},
                {"data": "creator",   orderable: true,searchable: true},
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
                var url = '{{ route("orders.destroy", ":id") }}';
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
                        url: '{{route('orders.delete.bulk')}}',
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


        //---------------------- model of search -------------------------------------

        $(document).on('click','#search',function (e) {
            e.preventDefault()
            $('#search_form').modal('show')
        });

        $(document).on('click','#clearFrom',function (e) {
            $('#Form1')[0].reset();
        });

        $(document).on('submit','form#Form1',function(e) {
            e.preventDefault();
            var data_fr=$('#Form1').serializeArray();
            var values = {};
            $.each(data_fr, function (i, field) {
                values[field.name] = field.value;
            });
            var getValue = function (valueName) {
                return values[valueName];
            };

            $('#search_form').modal('hide');
            if ($.fn.DataTable.isDataTable('#basicExample')) {
                $('#basicExample').dataTable().fnClearTable();
                $('#basicExample').dataTable().fnDestroy();
            }
            $("#basicExample").DataTable({
                dom: 'Bfrtip',
                responsive: 1,
                "processing": true,
                "lengthChange": true,
                "serverSide": true,
                "ordering": true,
                "searching": true,
                'iDisplayLength': 100,
                'serverMethod': 'post',
                'ajax': {
                    dataType: 'json',
                    'url':"{{route('orders.filter')}}",
                    'data': {
                        'from':getValue('from'),
                        'to':getValue('to'),
                        'code':getValue('id'),
                        'user_id':getValue('user_id'),
                        'from_money':getValue('from_money'),
                        'to_money':getValue('to_money'),
                        'customer_id':getValue('customer_id'),
                        'csrf-token':"{{ csrf_token() }}",
                    }
                },  "columns": [

                    {"data": "delete_all", orderable: false, searchable: false},
                    {"data": "id",   orderable: true,searchable: true},
                    {"data": "name",   orderable: true,searchable: true},
                    {"data": "phone",   orderable: true,searchable: true},
                    {"data": "total_cost",   orderable: true,searchable: true},
                    {"data": "ticket_time",   orderable: true,searchable: true},
                    {"data": "started_at",   orderable: true,searchable: true},
                    {"data": "finished_at",   orderable: true,searchable: true},
                    {"data": "sons_names",   orderable: true,searchable: true},
                    {"data": "creator",   orderable: true,searchable: true},
                    {"data": "created_at", searchable: true},
                    {"data": "actions", orderable: false, searchable: false}
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // converting to interger to find total
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // computing column Total of the complete result
                    var monTotal = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    $( api.column( 0).footer() ).html('الإجمالى');
                    $( api.column( 4 ).footer() ).html(monTotal);
                },

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

        });




        $(document).on('click','#showAll',function (e) {
            e.preventDefault()
            if ($.fn.DataTable.isDataTable('#basicExample')) {
                $('#basicExample').dataTable().fnClearTable();
                $('#basicExample').dataTable().fnDestroy();
            }

            $("#basicExample").DataTable({
                dom: 'Bfrtip',
                responsive: 1,
                "processing": true,
                "lengthChange": true,
                "serverSide": true,
                "ordering": true,
                "searching": true,
                'iDisplayLength': 100,
                "ajax": "{{route('orders.index')}}",
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // converting to interger to find total
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // computing column Total of the complete result
                    var monTotal = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    $( api.column( 0).footer() ).html('الإجمالى');
                    $( api.column( 4 ).footer() ).html(monTotal);
                },
                "columns": [
                    {"data": "delete_all", orderable: false, searchable: false},
                    {"data": "id",   orderable: true,searchable: true},
                    {"data": "name",   orderable: true,searchable: true},
                    {"data": "phone",   orderable: true,searchable: true},
                    {"data": "total_cost",   orderable: true,searchable: true},
                    {"data": "ticket_time",   orderable: true,searchable: true},
                    {"data": "started_at",   orderable: true,searchable: true},
                    {"data": "finished_at",   orderable: true,searchable: true},
                    {"data": "sons_names",   orderable: true,searchable: true},
                    {"data": "creator",   orderable: true,searchable: true},
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
        })
        $(document).on('click','#showDaily',function (e) {
            e.preventDefault()
            if ($.fn.DataTable.isDataTable('#basicExample')) {
                $('#basicExample').dataTable().fnClearTable();
                $('#basicExample').dataTable().fnDestroy();
            }

            $("#basicExample").DataTable({
                dom: 'Bfrtip',
                responsive: 1,
                "processing": true,
                "lengthChange": true,
                "serverSide": true,
                "ordering": true,
                "searching": true,
                'iDisplayLength': 100,
                "ajax": "{{route('orders.index')}}?date={{date("Y-m-d")}}",
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // converting to interger to find total
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // computing column Total of the complete result
                    var monTotal = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    $( api.column( 0).footer() ).html('الإجمالى');
                    $( api.column( 4 ).footer() ).html(monTotal);
                },
                "columns": [
                    {"data": "delete_all", orderable: false, searchable: false},
                    {"data": "id",   orderable: true,searchable: true},
                    {"data": "name",   orderable: true,searchable: true},
                    {"data": "phone",   orderable: true,searchable: true},
                    {"data": "total_cost",   orderable: true,searchable: true},
                    {"data": "ticket_time",   orderable: true,searchable: true},
                    {"data": "started_at",   orderable: true,searchable: true},
                    {"data": "finished_at",   orderable: true,searchable: true},
                    {"data": "sons_names",   orderable: true,searchable: true},
                    {"data": "creator",   orderable: true,searchable: true},
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
        })


    </script>
@endsection
