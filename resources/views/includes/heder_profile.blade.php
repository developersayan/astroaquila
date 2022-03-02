<header class="header_sec after_login_ban">
    <div class="header_botom">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light nav_top">
                <a class="navbar-brand" href="{{route('home')}}"><img src="{{ URL::to('public/frontend/images/logo.png')}}" alt="logo" /></a>
                <div class="after_login_menu">
                    <a href="javascript:;" class="profidrop"><em><img src="{{ URL::to('storage/app/public/profile_picture')}}/{{Auth::user()->profile_img}}" alt=""></em>
                        <span>Hi, {{Auth::user()->first_name}}</span>
                        <b><i class="fa fa-caret-down"></i></b>
                    </a>
                    <div class="profidropdid">
                        <ul>
                            @if(Auth::user()->user_type=='A')
                            <li><a  href="{{route('astrologer.dashboard')}}" @if(Request::segment(2)=="dashboard") class="activ" @endif>{{__('sidebar.dashboard')}}</a></li>
                            <li><a href="{{route('astrologer.profile')}}" @if(Request::segment(2)=="profile"|| Request::segment(2)=="availability"|| Request::segment(2)=="experience" || Request::segment(2)=="experience-edit"|| Request::segment(2)=="education"|| Request::segment(2)=="education-edit") class="activ" @endif>{{__('sidebar.edit_profile')}}</a></li>
                            <li><a href="{{route('astrologer.change.password')}}" @if(Request::segment(2)=="change-password") class="activ" @endif >{{__('sidebar.change_password')}}</a></li>
                            @endif
                            @if(Auth::user()->user_type=='P')
                            <li><a  href="{{route('pundit.dashboard')}}" @if(Request::segment(2)=="dashboard") class="activ" @endif> {{__('sidebar.dashboard')}}</a> </li>
                            <li><a href="{{route('pundit.profile')}}" @if(Request::segment(2)=="profile" || Request::segment(2)=="availability" || Request::segment(2)=="puja") class="activ" @endif>{{__('sidebar.edit_profile')}}</a></li>
                            <li><a href="{{route('pundit.change.password')}}" @if(Request::segment(2)=="change-password") class="activ" @endif >{{__('sidebar.change_password')}}</a></li>
                            @endif
                            <li><a href="{{route('logout')}}">{{__('sidebar.logout')}}</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
