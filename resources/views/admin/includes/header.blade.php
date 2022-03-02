<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="{{route('admin.dashboard')}}" class="logo"><img src="{{ URL::to('public/admin/assets/images/Logo-1.png')}}" alt=""></a>
        </div>
    </div>
    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left">
                        <i class="fa fa-bars"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>
                <!--<form class="navbar-form pull-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control search-bar" placeholder="Type here for search...">
                                </div>
                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                            </form>-->

                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true">
                             @if(auth()->guard('admin')->user()->profile_pic=="")
                <img src="{{ URL::to('public/admin/assets/images/users/avatar-1.jpg')}}" alt="" class="img-circle">
                @else
                <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{auth()->guard('admin')->user()->profile_pic}}" alt="" class=" img-circle">
                @endif
                            </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('admin.manage.profile')}}"><i class="fas fa-user-circle"></i> Profile</a></li>
                            <li><a href="{{route('admin.change.password')}}"><i class="fas fa-cog"></i> Change Password</a></li>
                            <li><a href="{{route('admin.logout')}}"><i class="fas fa-power-off"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
