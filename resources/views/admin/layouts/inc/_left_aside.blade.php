<aside class="left-sidebar" >
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item user-profile">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                       aria-expanded="false">
                        <img src="{{auth()->user()->logo?get_file(auth()->user()->logo):asset('admin/img/users/1.jpg')}}" class="useImageEdit" alt="user">
                        <span class="hide-menu nameEdit">{{auth()->user()->name}}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item">
                            <a href="javascript:void(0)" class="sidebar-link p-0 editProfile">
                                <i class="mdi mdi-adjust"></i>
                                <span class="hide-menu">عرض الحساب </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{route('admin.logout')}}" class="sidebar-link p-0">
                                <i class="mdi mdi-adjust"></i>
                                <span class="hide-menu"> تسجيل الخروج </span>
                            </a>
                        </li>
                    </ul>
                </li>
               {{-- <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">القائمة الرئيسية</span>
                </li>--}}


                @foreach(dynamic_sliders() as $slider)
                    <li style="{{$slider->is_shown == "hidden" || !checkAdminHavePermission($slider->permission_name) ?"display:none;":""}}"  class="sidebar-item">
                        <a class="sidebar-link  waves-effect waves-dark" href="{{$slider->sub_dynamic_slider->count()>0?route('routingBasics.show',$slider->id):route($slider->route_link)}}"
                           aria-expanded="false">
                            <i class="{{$slider->font_icon}}"></i>
                            <span class="hide-menu">{{$slider->ar_title}}</span></span>
                        </a>
                    </li>
                @endforeach


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
