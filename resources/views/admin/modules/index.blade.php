@extends('admin.layouts.layout')

@section('styles')

@endsection

@section('page-title')
    {{$parentRoute->ar_title}}
@endsection

@section('current-page-name')
    {{$parentRoute->ar_title}}
@endsection

@section('page-links')

    <li class="breadcrumb-item active">     {{$parentRoute->ar_title}}</li>

@endsection

@section('content')
    <section class="settings-category my-5">

        <div class="row">
            @foreach($sunRoutings as $single)
            {{---------------------------------}}

            <div style="{{($single->is_shown == "hidden" || !checkAdminHavePermission($single->permission_name) || $single->route_link == "accountsSetting.index" )?"display:none;":""}}" class="col-lg-4 col-sm-6 mb-4">
                <a href="{{route($single->route_link)}}">
                    <div class="content  d-flex align-items-center justify-content-center">
                        <div class="text-i">
                            <div class="w-100 mb-3 d-flex align-items-center justify-content-center">
                                <i class="{{$single->font_icon}}"></i>
                            </div>

                            <h3>
                                {{$single->ar_title}}
                            </h3>
                        </div>
                    </div>
                </a>

            </div>

            {{---------------------------------}}
            @endforeach

        </div>

    </section>
@endsection

@section('js')

@endsection
