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
    <!-- Start row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="me-3 align-self-center"><img src="img/income-w.png" alt="Income" />
                        </div>
                        <div class="align-self-center">
                            <h6 class="text-white mt-2 mb-0">كل المبيعات</h6>
                            <h2 class="mt-0 text-white">953,000</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="me-3 align-self-center"><img src="img/expense-w.png" alt="Income" />
                        </div>
                        <div class="align-self-center">
                            <h6 class="text-white mt-2 mb-0">مبيعات الفروع</h6>
                            <h2 class="mt-0 text-white">236,000</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="me-3 align-self-center"><img src="img/assets-w.png" alt="Income" />
                        </div>
                        <div class="align-self-center">
                            <h6 class="text-white mt-2 mb-0">الفروع</h6>
                            <h2 class="mt-0 text-white">3</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-danger">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="me-3 align-self-center"><img src="img/staff-w.png" alt="Income" />
                        </div>
                        <div class="align-self-center">
                            <h6 class="text-white mt-2 mb-0">الموظفون</h6>
                            <h2 class="mt-0 text-white">749</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->
    <!-- Start row -->
    <div class="row">
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-md-flex">
                        <div>
                            <h3 class="card-title mb-1"><span
                                    class="lstick d-inline-block align-middle"></span> مخطط المبيعات </h3>
                        </div>
                        <div class="ms-auto">
                            <select class="form-select">
                                <option selected="">يناير 2021</option>
                                <option value="1">فبراير 2021</option>
                                <option value="2">مارس 2021</option>
                                <option value="3">ابريل 2021</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-info stats-bar">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="p-3 active">
                                <h6 class="text-white"> كل المبيعات</h6>
                                <h3 class="text-white mb-0">$10,345</h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="p-3">
                                <h6 class="text-white">هذا الشهر</h6>
                                <h3 class="text-white mb-0">$7,589</h3>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="p-3">
                                <h6 class="text-white">هذا الاسبوع</h6>
                                <h3 class="text-white mb-0">$1,476</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-4">
                    <div id="Sales-Overview" class="position-relative" style="height:340px;"></div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="card w-100">
                <img class="card-img-top blog-img3" src="img/img1.jpg" alt="Card image cap">
                <div class="card-body">
                    <h3 class="font-weight-normal">Business development of rules 2021</h3>
                    <span class="badge bg-info rounded-pill">Technology</span>
                    <p class="mb-0 mt-3">Titudin venenatis ipsum aciat. Vestibu ullamer quam. nenatis ipsum
                        ac feugiat. Ibulum ullamcorper.aciat. Vestibu ullamer quam. nenatis</p>
                    <div class="d-flex mt-2">
                        <button class="btn ps-0 btn-link ">Read more</button>
                        <div class="ms-auto align-self-center">
                            <a href="javascript:void(0)" class="link me-2"><i class="fa fa-heart-o"></i></a>
                            <a href="javascript:void(0)" class="link me-2"><i
                                    class="fa fa-share-alt"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- -------------------------------------------------------------- -->
        <!-- visit charts-->
        <!-- -------------------------------------------------------------- -->
        <div class="col-lg-6 col-md-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title"><span class="lstick d-inline-block align-middle"></span>الموظفون</h4>
                    <div id="Visit-Separation" style="height:270px; width:100%;"
                         class="d-flex justify-content-center align-items-center"></div>
                    <table class="table v-middle fs-3 mb-0 mt-4">
                        <tr>
                            <td>هاتف</td>
                            <td class="text-end font-weight-medium">38.5%</td>
                        </tr>
                        <tr>
                            <td>تابلت</td>
                            <td class="text-end font-weight-medium">30.8%</td>
                        </tr>
                        <tr>
                            <td>شاشة كاشير</td>
                            <td class="text-end font-weight-medium">7.7%</td>
                        </tr>
                        <tr>
                            <td>أخرى</td>
                            <td class="text-end font-weight-medium">23.1%</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->
    <!-- Start row -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="stats">
                            <h1 class="text-white">9062+</h1>
                            <h6 class="text-white">Subscribe</h6>
                            <button class="btn btn-rounded btn-outline btn-light m-t-10 fs-3">Check
                                list</button>
                        </div>
                        <div class="stats-icon text-end ms-auto"><i
                                class="fa fa-envelope display-5 op-3 text-dark"></i></div>
                    </div>
                </div>
            </div>
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="stats">
                            <h1 class="text-white">6509+</h1>
                            <h6 class="text-white">Facebook Likes</h6>
                            <button class="btn btn-rounded btn-outline btn-light m-t-10 fs-3">Check
                                list</button>
                        </div>
                        <div class="stats-icon text-end ms-auto"><i
                                class="fab fa-facebook-f display-5 op-3 text-dark"></i></div>
                    </div>
                </div>
            </div>
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="stats">
                            <h1 class="text-white">3257+</h1>
                            <h6 class="text-white">Twitter Followers</h6>
                            <button class="btn btn-rounded btn-outline btn-light m-t-10 fs-3">Check
                                list</button>
                        </div>
                        <div class="stats-icon text-end ms-auto"><i
                                class="fab fa-twitter display-5 op-3 text-dark"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex">
                        <h4 class="card-title"><span
                                class="lstick d-inline-block align-middle"></span> مخطط المبيعات</h4>
                        <ul class="list-inline mb-0 ms-auto">
                            <li class="list-inline-item">
                                <h6 class="text-success"><i class="fa fa-circle font-10 me-2 "></i>الشهر الحالي
                                </h6>
                            </li>
                            <li class="list-inline-item">
                                <h6 class="text-info"><i class="fa fa-circle font-10 me-2"></i>الشهر السابق
                                </h6>
                            </li>
                        </ul>
                    </div>
                    <div class="text-center mt-3">
                        <div class="btn-group " role="group" aria-label="Basic example">
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary shadow-sm fs-2 me-0">PAGEVIEWS</button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary shadow-sm fs-2">REFERRALS</button>
                        </div>
                    </div>
                    <div id="Website-Visit" class="position-relative mt-3"
                         style="height:350px; width:100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->
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
