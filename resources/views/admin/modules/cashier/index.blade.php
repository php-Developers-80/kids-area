@extends('admin.layouts.layout')

@section('styles')
    <link href="{{asset('admin')}}/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="{{asset('admin/css/select2.css')}}" rel="stylesheet">
    @include('admin.layouts.loader.loaderCss')
    <style>

        @media print {
            body.modal-open {
                visibility: hidden;
            }

            body.modal-open .modal .modal-header,
            body.modal-open .modal .modal-body {
                visibility: visible; /* make visible modal body and header */
            }
            .noprint {
                visibility: hidden;
            }
        }
    </style>

@endsection

@section('page-title')
الكاشير
@endsection

@section('current-page-name')
    الكاشير
@endsection

@section('page-links')

    <li class="breadcrumb-item active">
        الكاشير
    </li>
@endsection

@section('content')

    <div id="messages"></div>
    <div id="notes"></div>

    <section class="brands-page my-5">
        <div class="row mb-3">
            <div class="col-4"><span id="showDailyOrders" class="btn btn-danger"> <i class="far fa-eye"></i>   عرض طلبات اليوم  </span></div>
            <div class="col-8"></div>
        </div>
        <!-- basic table -->
        <div class="row">
            <form action="{{route('cashier.store')}}" method="post" id="Form">
                @csrf

                <div class="row">


                    {{-----------------Part 1 ----------------}}

                    <div class="col-6" style="border-left: 1px solid #eccece;">
                        <div class="row">
                            <input type="hidden" value="exist_user" name="type_of_client" id="type_of_client">
                            <div class="col-lg-8 col-md-8  mb-3" id="clients_div">
                                <select class=" select2" id="client_id" name="client_id">
                                    <option value=""  selected>  ابحث عن ولى الأمر بالإسم أو الهاتف </option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">   {{$customer->name}} -  {{$customer-> phone}}   </option>
                                    @endforeach
                                </select>
                            </div>

                            {{--     button to display button         --}}
                            <div class="col-lg-4 col-md-4  mb-3" >

                                <div>
                                    <span  id="new_client"  class="btn btn-success" style="padding: 8px 8px!important;">  أضف عميل  <i class="fad fa-user-plus"></i></span>
                                </div>

                            </div>

                            <div class="col-lg-12 col-md-12  mb-3" id="oldCliectDivDisplay">


                            </div>

                            <div class="col-lg-12 col-md-12  mb-3" id="newCliectDivDisplay">


                            </div>


                        </div>
                    </div>

                    {{----------------------------------------}}
                    <div class="col-6 ">

                        <div class="col-12 mb-3">
                            <select class=" select2" id="ticket_id" name="ticket_id" data-validation="required">
                                <option value=""  selected>  اختر المدة  </option>
                                @foreach($tickets as $ticket)
                                    <option att_price="{{$ticket->price}}"  value="{{$ticket->id}}">   {{$ticket->price . "  ج.م  "}} -  {{$ticket->minutes_count . "  دقيقة  "}}   </option>
                                @endforeach
                            </select>
                        </div>
                        {{-------------------   items    -----------------}}

                        <div class="row" id="items_display" style="">
                            @include('admin.modules.cashier.parts.add-ons')
                        </div>

                        {{------------------------------------------------}}

                    </div>
                </div>


                {{--         -----------------          --}}

                {{--         rate and discount on total          --}}

                <div class="row mt-2 mb-2 p-3 text-center">
                    <div class="col-12">
                        <span id=""  class="btn btn-light-info">
                                 عرض الصافى


                            <i  class="fad fa-money-bill-alt" id="icon-add">
                            </i>
                        </span>
                    </div>
                </div>


                <div class="row">

                    <div class="col-lg-3 col-md-6  mb-3">
                        <label class="label mb-2 " for="original_cost"> الإجمالى </label>
                        <input type="text" readonly id="original_cost" name="original_cost" value="0" class="form-control " data-validation="required">
                    </div>

                    <div  class="col-lg-3 col-md-6  mb-3">
                        <label class="label mb-2 " for="discount_rate"> نسبة الخصم </label>
                        <input type="text"   id="discount_rate" name="discount_rate" value="0" class="form-control numbersOnly not_increase_about_100" data-validation="required">
                    </div>

                    <div  class="col-lg-3 col-md-6  mb-3">
                        <label class="label mb-2 " for="discount_value"> قيمة الخصم </label>
                        <input readonly type="text"  id="discount_value" name="discount_value" value="0" class="form-control " data-validation="required">
                    </div>


                    <div  class="col-lg-3 col-md-6  mb-3">
                        <label class="label mb-2 " for="bill_total_cost"> الصافى </label>
                        <input type="text" readonly id="bill_total_cost" name="total_cost" value="0" class="form-control " data-validation="required">
                    </div>

                </div>
                {{--         rate and discount on total          --}}

                <div class="col-12 d-flex align-items-center justify-content-center">
                    <button style="margin-right: 5px" type="submit" id="saveAndPrintForm"  class="btn edit-profile"> حفظ و طباعة </button>
                </div>

            </form>

        </div>
        <!-- order table -->


        <div class="modal fade" id="search_form" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

            <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
            <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">


                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title  badge-success" id="myExtraLargeModalLabel">  طلبات اليوم </h5>

                    </div>
                    <div class="modal-body" id="form-for-addOrDelete">

                        <div class="table-responsive">
                            <table id="basicExample" class="table  table-bordered">

                                <thead>
                                <tr>
                                    <th>
                                        <input id="checkAll" type='checkbox' class='check-all' data-tablesaw-checkall>
                                    </th>
                                    <th>رقم الفاتورة </th>
                                    <th>اسم ولى الأمر </th>
                                    <th>رقم الهاتف </th>
                                    <th>الصافى </th>
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
                    <div class="modal-footer text-center d-flex justify-content-center">

                        <button type="button" class="btn btn-light-danger text-danger font-weight-medium waves-effect text-start" data-bs-dismiss="modal">الغاء</button>

                    </div>
                </div>
            </div>
        </div>


    </section>

    @include('admin.modules.cashier.parts.audioPart')
@endsection

@section('js')
    <script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/backEndFiles/repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('admin/js/select2.js')}}"></script>

    <script src="{{asset('admin/babel/babel.min.js')}}"></script>
    <script src="{{asset('admin/axios/axios.min.js')}}"></script>


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
                        $('#exampleModalCenter').modal('hide')
                        messages.show("تمت العملية بنجاح..", {
                            type: 'success',
                            title: '',
                            icon: '<i class="jq-icon-success"></i>',
                            delay:2000,
                        });

                        window.open(data, '_blank');

                        location.reload();


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

        //-------------- exists Client  --------------------

        $(document).on('change','#client_id',function (e){
            e.preventDefault()
            var ob = $(this);
            var id = ob.val()
            if(ob.val() == '' || ob.val() == null){

            }else{
                $("#type_of_client").val('exist_user')
                $("#oldCliectDivDisplay").html('')
                $("#newCliectDivDisplay").html('')
                $('.loader-ajax').show()

                axios.get('{{route('selectExistClient')}}', {
                    params: {
                        id: id,
                    }
                }).then(function (response) {
                    console.log(response);
                    $('#oldCliectDivDisplay').html(response.data.html)
                    sum()
                }).catch(function (error) {
                        console.log(error);
                }).then(function () {
                        $('.loader-ajax').hide()
                        // always executed
                });
            }
        })

        var room = 10000;
        $(document).on('click','#addChild',function (e){

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
                <input data-validation="required" type="text" class="form-control SonToSum"  name="son_name[]" placeholder="الإسم">
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
            console.log(divtest)
            $("#oldCliectDivDisplay").append(divtest)

            sum()

        })



        //-------------- New Client  --------------------

        $(document).on('click','#new_client',function (e) {
            e.preventDefault()

            $('.loader-ajax').show()
            $("#type_of_client").val('new_user')
            $("#oldCliectDivDisplay").html('')
            $("#newCliectDivDisplay").html('')
            axios.get('{{route('selectNewClient')}}', {
                params: {
                    id: 1,
                }
            }).then(function (response) {
                console.log(response);
                $('#newCliectDivDisplay').html(response.data.html)

                sum()
            }).catch(function (error) {
                console.log(error);
            }).then(function () {
                $('.loader-ajax').hide()
                // always executed
            });

        })

        var room2 = 1;
        $(document).on('click','.addingHere',function (e) {

            //-------------- repeater --------------------

            room2++;
            var objTo = document.getElementById('education_fields')
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "mb-3 removeclass" + room2);
            divtest.setAttribute("id", "removeclass" + room2);
            var rdiv = 'removeclass' + room2;
            divtest.innerHTML = `
 <div class="row">
        <div class="col-sm-10">
            <div class="mb-3">
                <input data-validation="required" type="text" class="form-control SonToSum"  name="son_name[]" placeholder="الإسم">
            </div>
        </div>

        <div class="col-sm-2">
          <div class="form-group">
<button class="btn btn-danger removeDiv" type="button" attr-value="${room2}">
<i class="fa fa-minus"></i>
</button>
</div>
        </div>
    </div>`;

            $("#newCliectDivDisplay").append(divtest)
            sum()
        })


        //-------------- Delete Child  --------------------

        $(document).on('click','.removeDiv',function (e){
            e.preventDefault()
            var room = $(this).attr('attr-value')
            console.log(room);
            var classDiv=".removeclass"+room
            $(this).closest(classDiv).remove();
            sum()
        })

        //-------------- cal the sum  --------------------

        function sum()
        {
            //ticket value
            var ticket_val = 0
            if($("#ticket_id").val() == '' || $("#ticket_id").val() == null){
                ticket_val = 0;
            }else{

                ticket_val =   parseFloat($('#ticket_id option:selected').attr("att_price"));
            }

            //add ons value
           var add_ons_value = 0;
            $('input[class="add_ons"]:checked').each(function() {
                add_ons_value = add_ons_value + parseFloat($(this).attr('att_price'));
            });

            var count_of_SonToSum = document.querySelectorAll('#Form .SonToSum').length> 0?document.querySelectorAll('#Form .SonToSum').length:1;
            console.log(count_of_SonToSum)
            //original cost
            var original_cost = parseFloat(ticket_val +  add_ons_value) * count_of_SonToSum
            $("#original_cost").val(original_cost)


            var discount_rate  =   parseFloat($("#discount_rate").val())
            var discount_value  =   parseFloat(discount_rate * original_cost /100)

            $("#discount_value").val(discount_value)
            $("#bill_total_cost").val(original_cost - discount_value )

        }

        $(document).on('keyup','#discount_rate',function (){
            sum()
        })

        $(document).on('change','.add_ons,#ticket_id',function (){
            sum()
        })


        $(document).on('change click keyup','.not_increase_about_100',function (e){
            if ($(this).val() > 100){
                $(this).val('100');
            }

            sum()

        });
    </script>

    <script>
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
            "ajax": "{{route('cashier.index')}}",
            "columns": [
                {"data": "delete_all", orderable: false, searchable: false},
                {"data": "id",   orderable: true,searchable: true},
                {"data": "name",   orderable: true,searchable: true},
                {"data": "phone",   orderable: true,searchable: true},
                {"data": "total_cost",   orderable: true,searchable: true},
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

        $(document).on('click','#showDailyOrders',function (e) {
            e.preventDefault()
            $('#search_form').modal('show')
        });


    </script>


@endsection
