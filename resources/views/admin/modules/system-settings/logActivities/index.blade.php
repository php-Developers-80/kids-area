@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">

    @include('admin.layouts.loader.loaderCss')
@endsection

@section('page-title')
  أنشطة المستخدمين
@endsection

@section('current-page-name')
    أنشطة المستخدمين
@endsection

@section('page-links')
    @include('admin.modules.system-settings.routingSettingBasic')
    <li class="breadcrumb-item active">    أنشطة المستخدمين </li>
@endsection

@section('content')

    <section class="items-add-page my-3 py-4" style="background-color: white;">


        <!-- basic table -->
        <div class="row">

            <div class="col-12">
                <button class="btn mb-2 btn-info" id="searchButton">
                <i class="fad fa-filter"></i>
                    بحث
                </button>

                <div class="card">

                    <div class="card-body">


                        <div class="table-responsive">
                            <table id="basicExample" class="table  table-bordered">

                                <thead>
                                <tr>
                                    <th>وقت الإضافة</th>
                                    <th>رقم العملية</th>
                                    <th>اسم المستخدم </th>
                                    <th>الحالة الحالية</th>
                                    <th>العملية</th>
                                    <th>موضوع العملية</th>


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

                        <form action="{{route('logActivities.filter')}}" id="Form" method="post" >
                            @csrf
                            <div class="row mt-2 mb-2 p-3 text-center">
                                <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
                                    ابحث بالمستخدم - التاريخ
                                </button>
                            </div>

                            <div class="row d-flex justify-content-center">

                                <div class="col-lg-4 col-md-6  mb-4">
                                    <label class="label mb-2 "> من </label>
                                    <input type="date" name="from_date" class="form-control" >
                                </div>

                                <div class="col-lg-4 col-md-6  mb-4">
                                    <label class="label mb-2 "> إلى </label>
                                    <input type="date" name="to_date" class="form-control">
                                </div>



                                <div class="col-lg-4 col-md-6  mb-4">
                                    <label class="label mb-2 " for="">إسم المستخدم </label>
                                    <select class="form-control" id="user_id" name="user_id" >
                                        <option value="" selected>اختر المستخدم</option>
                                       @foreach($users as $user)
                                           <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer text-center d-flex justify-content-center">
                        <button id="save"  form="Form"  type="submit" class="btn btn-success">ابحث </button>
                        <button id="clearFrom"   type="button" class="btn btn-dark">مسح الفلاتر </button>
                        <button type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">الغاء</button>

                    </div>
                </div>
            </div>
        </div>


    </section>

@endsection

@section('js')
    <script src="{{asset('admin')}}/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('admin')}}/js/dataTables.responsive.min.js"></script>
    <script>

        var messages = $('#messages').notify({
            type: 'messages',
            removeIcon: '<i class="icon-close"></i>'
        });

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
            'iDisplayLength': 50,
            "ajax": "{{route('logActivities.index')}}",

            "columns": [
                {"data": "created_at", searchable: true},
                {"data": "id",   orderable: true,searchable: true},
                {"data": "user_name",   orderable: true,searchable: true},
                {"data": "user_status",   orderable: true,searchable: true},
                {"data": "description",   orderable: true,searchable: true},
                {"data": "subject",   orderable: true,searchable: true},
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
        //============================Filter======================================
        //========================================================================

        $(document).on('click', '#searchButton', function () {
           $('#exampleModalCenter').modal('show')
        });

        $(document).on('click','#clearFrom',function (e) {
            $('#Form')[0].reset();
        });

        $(document).on('submit','form#Form',function(e) {
            e.preventDefault();
            var data_fr=$('#Form').serialize()
            $('#exampleModalCenter').modal('hide');
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
                'iDisplayLength': 50,
                'serverMethod': 'post',
                'ajax': {
                    dataType: 'json',
                    'url':"{{route('logActivities.filter')}}",
                    'data': {
                        'from_date':$('#from_date').val(),
                        'to_date':$('#to_date').val(),
                        'user_id':$('#user_id').val(),
                        'csrf-token':"{{ csrf_token() }}",
                    }
                },
                "columns": [
                    {"data": "created_at", searchable: true},
                    {"data": "id",   orderable: true,searchable: true},
                    {"data": "user_name",   orderable: true,searchable: true},
                    {"data": "user_status",   orderable: true,searchable: true},
                    {"data": "description",   orderable: true,searchable: true},
                    {"data": "subject",   orderable: true,searchable: true},
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

        });


    </script>
@endsection
