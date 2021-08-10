@extends('admin.layouts.layout')
@section('styles')
    <link rel="stylesheet" href="https:////code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />

    <style>
        select {
            font-family: 'FontAwesome', 'sans-serif';
        }
    </style>
@endsection

@section('page-title')
    الصفحة الرئيسية
@endsection

@section('current-page-name')
الرئيسية
@endsection

@section('page-links')

@endsection

@section('content')

    @if (auth()->user()->user_type == 'cashier')
        <div class="row">
            <h3 class="text-center">أهلا بك يا {{auth()->user()->name}}</h3>
        </div>
        <div class="row text-center " style="margin-top: 50px">
           <a href="{{route('cashier.index')}}">
               <i class="fad fa-cart-plus " style="font-size: 200px; ">

               </i>
           </a>
        </div>
    @else
        <!-- Start row -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-info">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="me-3 align-self-center"><img src="{{asset('admin')}}/img/income-w.png" alt="Income" />
                            </div>
                            <div class="align-self-center">
                                <h6 class="text-white mt-2 mb-0">كل المبيعات</h6>
                                <h2 class="mt-0 text-white">{{$all_cost}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-success">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="me-3 align-self-center"><img src="{{asset('admin')}}/img/expense-w.png" alt="Income" />
                            </div>
                            <div class="align-self-center">
                                <h6 class="text-white mt-2 mb-0">مبيعات الشهر</h6>
                                <h2 class="mt-0 text-white">{{$month_cost}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="me-3 align-self-center"><img src="{{asset('admin')}}/img/assets-w.png" alt="Income" />
                            </div>
                            <div class="align-self-center">
                                <h6 class="text-white mt-2 mb-0">مبيعات الأسبوع</h6>
                                <h2 class="mt-0 text-white">{{$week_cost}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-danger">
                    <div class="card-body">
                        <div class="d-flex no-block">
                            <div class="me-3 align-self-center"><img src="{{asset('admin')}}/img/staff-w.png" alt="Income" />
                            </div>
                            <div class="align-self-center">
                                <h6 class="text-white mt-2 mb-0">مبيعات اليوم</h6>
                                <h2 class="mt-0 text-white">{{$daily_cost}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->
    @endif


@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
        } );
    </script>
@endsection
