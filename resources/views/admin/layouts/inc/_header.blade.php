<header class="topbar" >
    <nav class="navbar top-navbar navbar-expand-md navbar-dark" >
        <div class="navbar-header" >
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="fad fa-bars"></i></a>
            <!-- -------------------------------------------------------------- -->
            <!-- Logo -->
            <!-- -------------------------------------------------------------- -->
            <a class="navbar-brand" href="#">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img style="border-radius: 6px;margin-left: 6px;" src="{{setting()->header_logo?get_file(setting()->header_logo):asset('admin/img/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img style=" border-radius: 6px;margin-left: 6px;" src="{{setting()->header_logo?get_file(setting()->header_logo):asset('admin/img/logo-light-icon.png')}}" alt="homepage" class="light-logo" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
              {{--  <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{asset('admin')}}/img/logo-text.png" alt="homepage" class="dark-logo" />
                    <!-- Light Logo text -->
                            <img src="{{asset('admin')}}/img/logo-light-text.png" class="light-logo" alt="homepage" />
                        </span>--}}
            </a>
            <!-- -------------------------------------------------------------- -->
            <!-- End Logo -->
            <!-- -------------------------------------------------------------- -->
            <!-- -------------------------------------------------------------- -->
            <!-- Toggle which is visible on mobile only -->
            <!-- -------------------------------------------------------------- -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
               data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
               aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fad fa-ellipsis-h"></i></a>
        </div>
        <!-- -------------------------------------------------------------- -->
        <!-- End Logo -->
        <!-- -------------------------------------------------------------- -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- -------------------------------------------------------------- -->
            <!-- toggle and nav items -->
            <!-- -------------------------------------------------------------- -->
            <ul class="navbar-nav me-auto">
                <!-- This is  -->
                <li class="nav-item"> <a
                        class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark"
                        href="javascript:void(0)"><i class="fad fa-bars"></i></a> </li>
            </ul>
            <!-- -------------------------------------------------------------- -->
            <!-- Right side toggle and nav items -->
            <!-- -------------------------------------------------------------- -->
            <ul class="navbar-nav justify-content-end">
                <!-- -------------------------------------------------------------- -->
                <!-- Profile -->
                <!-- -------------------------------------------------------------- -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuButton" data-toggle="dropdown" >
                        <img src="{{auth()->user()->logo?get_file(auth()->user()->logo):asset('admin/img/users/1.jpg')}}" alt="user" width="30" class="profile-pic rounded-circle useImageEdit" />
                    </a>

                    <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY" aria-labelledby="dropdownMenuButton">
                        <div class="d-flex no-block align-items-center p-3 bg-primary text-white mb-2">
                            <div class="">
                                <img src="{{auth()->user()->logo?get_file(auth()->user()->logo):asset('admin/img/users/1.jpg')}}" alt="user" class="rounded-circle useImageEdit"
                                               width="60">
                            </div>
                            <div class="ms-2">
                                <h4 class="mb-0 text-white nameEdit">{{auth()->user()->name}}</h4>

                            </div>
                        </div>

                        <!-- <a class="dropdown-item" href="#"><i data-feather="mail"
                                class="feather-sm text-success me-1 ms-1"></i>
                            Inbox</a> -->

                        <a class="dropdown-item" href="{{route('admin.logout')}}"><i data-feather="log-out"
                                                                                      class="feather-sm text-danger me-1 ms-1"></i> خروج </a>
                        <div class="dropdown-divider"></div>
                        <div class="pl-4 p-2">
                            <a href="#" class="btn d-block w-100 btn-primary rounded-pill editProfile">عرض بيانات الحساب</a>
                        </div>
                    </div>
                </li>

                <!-- -------------------------------------------------------------- -->
                <!-- Profile -->
                <!-- -------------------------------------------------------------- -->


            </ul>
        </div>
    </nav>
</header>
