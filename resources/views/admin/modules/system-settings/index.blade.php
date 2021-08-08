@extends('admin.layouts.layout')

@section('styles')

@endsection

@section('page-title')
  إعدادات النظام
@endsection

@section('current-page-name')
    إعدادات النظام
@endsection

@section('page-links')
    <li class="breadcrumb-item active">      إعدادات النظام</li>
@endsection

@section('content')

    <section class="settings-category my-5">

        <div class="row">
            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('generalSettings.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fad fa-sliders-v"></i>
                            </div>

                            <h3>
                                الإعدادات العامة
                            </h3>
                        </div>
                    </div>
                </a>

            </div>



            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('users.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fad fa-user "></i>
                            </div>

                            <h3>
                                المستخدمين
                            </h3>
                        </div>
                    </div>
                </a>

            </div>


            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('userPermissions.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fad fa-ballot-check"></i>
                            </div>

                            <h3>
                                صلاحيات المستخدمين
                            </h3>
                        </div>
                    </div>
                </a>

            </div>





            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('dynamicSliders.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fad fa-bars"></i>                                        </div>

                            <h3>
                                التحكم في القوائم
                            </h3>
                        </div>
                    </div>
                </a>

            </div>




            <div class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route('logActivities.index')}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="fad fa-users"></i>
                            </div>

                            <h3>
                                أنشطة المستخدمين
                            </h3>
                        </div>
                    </div>
                </a>

            </div>




        </div>

    </section>
@endsection

@section('js')
    <script>

    </script>
@endsection
