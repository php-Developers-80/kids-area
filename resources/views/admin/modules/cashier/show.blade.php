<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> طباعة فاتورة {{$order->id}}</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {

            font-family: 'Almarai', sans-serif;
            /* width: 400px; */

        }

        .w-100 {
            width: 100%;
        }

        .d-flex {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .py-4 {
            padding: 30px 0;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .mb-3 {
            margin-bottom: 10px;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;

        }

        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .container {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }

        .col-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }



        .content {
            background-color: rgb(247, 247, 247);
            padding: 20px;
            width: 600px;
        }


        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: rgb(35, 79, 160);
            color: #dddddd;
        }

        @page {

            margin: 0;  /* this affects the margin in the printer settings */
        }
        @media print {
            th {
                background-color: rgb(4, 66, 102);
                color: rgb(31, 31, 31);
            }

            #printId{
                display: none;
            }
        }
    </style>
</head>

<body >
<div >
    <button id="printId" class="btn btn-success" onclick="">طباعة</button>
</div>
<div class="print">
    <div class="container ">
        <div class="w-100 d-flex py-4">
            <img src="{{get_file(setting()->header_logo)}}" alt="" width="120px" height="120px" >
        </div>
        <div class="w-100 d-flex  mb-3">
            <p> رقم الفاتورة : ({{$order->id}})</p>

        </div>

        <div class="w-100 d-flex  mb-3">
            <p> ولي الأمر : {{$order->customer?$order->customer->name:""}}</p>

        </div>
        <div class="w-100 d-flex  mb-3">
            <p> رقم التليفون :  {{$order->customer?$order->customer->phone:""}}.</p>

        </div>
        <div class="w-100 d-flex  mb-3">


        </div>
        <div class="w-100 d-flex  mb-3">
            <p > اليوم   : {{ nameDays(date('l', strtotime($order->created_at)))}}</p>

            <p style="padding-right: 15px;"> التاريخ    : {{date("Y-m-d",strtotime($order->created_at))}} </p>
        </div>

        <div class="w-100 d-flex">
            <div class="content ">

                <div class="w-100 d-flex py-4">
                    <table>
                        <tr style="background: #918787">
                            <td>إسم الطفل</td>
                            <td>  وقت الدخول </td>
                            <td>المدة</td>
                            <td>وقت الخروج</td>
                        </tr>

                        @foreach($order->orderDetails as $orderDetail)
                            <tr>
                                <td> {{$orderDetail->son?$orderDetail->son->name:""}}</td>
                                <td>{{date("h:i",strtotime($order->started_at)) }}</td>
                                <td>{{$order->ticket?$order->ticket->minutes_count ." دقيقة " :""}}</td>
                                <td>{{date("h:i",strtotime($order->finished_at)) }}</td>
                            </tr>
                        @endforeach

                        <tr style="text-align: center;background: #918787">
                            <td colspan="4">المدفوعات</td>
                        </tr>

                        <tr>
                            <td colspan="2">التذاكر : </td>
                            @php
                                $ticket_price = $order->ticket?$order->ticket->price :0;
                            @endphp
                            <td colspan="2">    ({{count($order->orderDetails)}}) &#x2717; {{ $ticket_price  }}</td>
                        </tr>


                        @if(count($order->add_ons)>0)
                            <tr style="text-align: center;background: #918787">
                                <td colspan="4">الإضافات</td>
                            </tr>

                            @foreach($order->add_ons as $addOn)
                                <tr>
                                    <td colspan="2">{{$addOn->title}} : </td>
                                    <td colspan="2">({{count($order->orderDetails)}}) &#x2717;  {{$addOn->price}}</td>
                                </tr>

                            @endforeach
                        @endif

                        <tr style="text-align: center;background: #918787">
                            <td colspan="4">الإجمالى</td>
                        </tr>

                        <tr>
                            <td colspan="2">الإجمالى قبل الخصم : </td>
                            <td colspan="2">{{$order->original_cost}}</td>
                        </tr>


                        <tr>
                            <td colspan="2">الخصم : </td>
                            <td colspan="2">{{$order->discount_value}}</td>
                        </tr>

                        <tr>
                            <td colspan="2"> الصافى : </td>
                            <td colspan="2">{{$order->total_cost}}</td>
                        </tr>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>
</body>
<script>

    @if(isset(request()->print_now) && request()->print_now == 1)
    window.print()
    @endif
    {{--console.log("{{url()->previous()}}")--}}
    {{--    @if(url()->previous() == url('admin/cashier'))--}}
    {{--    window.print()--}}
    {{--    @endif--}}

</script>
</html>
