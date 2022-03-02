@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Landing Page</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
    .mini-stat-info span {
    color: #ffffff;
    display: block;
    font-size: 13px;
    font-weight: 700;
    margin-top: 17px;
}
</style>
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')
<!-- Left Sidebar End -->



<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb pull-right">
                       {{--  <li><a href="#">Astroaquila</a></li> --}}
                    </ol>
                </div>
            </div>

            <!-- Start Widget -->
            <div class="row">
                @if(request()->segment(2)=="product-sub-menu")
                <a href="{{route('admin.product.category.manage')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-list"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Category</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.manage.product')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-cube ri2"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Products</span>
                        </div>
                    </div>
                </div>
                </a>
                @endif

                @if(request()->segment(2)=="horoscope-sub-menu")
                <a href="{{route('admin.modules.manage.horoscope.category')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-star"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Category</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.manage.horoscope.title')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-header" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Horoscope Title</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.manage.horoscope')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-h-square" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Hororscope</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.data.bank')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-database" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Aquila Data Bank</span>
                        </div>
                    </div>
                </div>
                </a>
                @endif


                @if(request()->segment(2)=="gemstone-sub-menu")
                <a href="{{route('admin.gemstone.category.manage')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-list"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Gemstone Category</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.manage.gemstone')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-gem"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Gemstones</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.gemstone.price')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"> <i class="fas fa-money"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Gemstone Price</span>
                        </div>
                    </div>
                </div>
                </a>

                 <a href="{{route('admin.manage.ring.system')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-life-ring" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Ring Size System </span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.ring.size')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-life-ring" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Ring Size</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.bracelet.design')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="far fa-hand-rock"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark"> Manage Bracelet Design</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.puja-energization')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-gopuram"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark"> Manage Puja Energization</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.cirtificate.name')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-book" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark"> Manage Certificate Name</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.cirtification')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="far fa-file"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark"> Manage Certificate Price</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.gold.purity')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-coins"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark"> Manage Gold Purity</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.ring-pendent-price')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-money-bill"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark"> Manage Ring Pendent Price</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.ring.pendent.design')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-file-image-o" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Ring Pendent Design</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.gemstone.color')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-thumb-tack" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Color</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.gemstone.title')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-thumb-tack" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Gamestone Title </span>
                        </div>
                    </div>
                </div>
                </a>

            @endif



            @if(request()->segment(2)=="order-sub-menu")
                <a href="{{route('admin.manage.product.order')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-cube ri2"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Product Order</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.manage.puja.order')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Puja Order</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.horoscope.order')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Horoscope Order</span>
                        </div>
                    </div>
                </div>
                </a>
         @endif





         @if(request()->segment(2)=="settings-sub-menu")

                <a href="{{route('manage.state')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-location-pin"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage State</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.city')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-location-pin"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage City</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.zip')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-map-pin" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Zipcode</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.deity')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-ankh"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Deity</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.purpose')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fab fa-superpowers"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Purpose</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.planet')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-globe"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Planet</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.mantra')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-om"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Mantras</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.treatment')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-plus-square" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Treatments</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.faq.category')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-empire" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Faq Category</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.general.faq')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-question" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">General Faq</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.search.page.data')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Search Content</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.home.page.banner')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-snowflake-o" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Home Page First Slider</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.home.page.banner.second')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-snowflake-o" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Home Page Second Slider</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.expertise')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-exchange" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Expertise</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.edit.why.who')}}">
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-info"><i class="fa fa-question-circle"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">Why & who</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{route('admin.manage.astro.tips')}}">
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-info"><i class="fa fa-info-circle"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">Astro tips</span>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{route('admin.manage.language')}}">
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-info"><i class="fa fa-language" aria-hidden="true"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">Manage Language</span>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{route('admin.manage.reason')}}">
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-info"><i class="fa fa-times" aria-hidden="true"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">Manage Rejection Reason</span>
                            </div>
                        </div>
                    </div>
                </a>


                <a href="{{route('admin.manage.aquilia.wiki')}}">
                    <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="mini-stat clearfix bx-shadow bg-white">
                            <span class="mini-stat-icon bg-info"><i class="fa fa-info-circle"></i></span>
                            <div class="mini-stat-info text-right text-dark">
                                <span class="counter text-dark">Aqualia wiki</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="{{route('admin.manage.wiki.category')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-list"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Wiki Category</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.wiki.title')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-header" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Wiki Title</span>
                        </div>
                    </div>
                </div>
                </a>

         @endif


         @if(request()->segment(2)=="blog-sub-menu")
                <a href="{{route('admin.manage.blog.category')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-th-large"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Blog Category</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.manage.blog')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-blogger"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Blog</span>
                        </div>
                    </div>
                </div>
                </a>
           @endif


           @if(request()->segment(2)=="site-user-sub-menu")
                <a href="{{route('admin.manage.customer')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-users-alt-1"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Customer</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.manage.astrologer')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-user-suited"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Astrologer</span>
                        </div>
                    </div>
                </div>
                </a>


                <a href="{{route('admin.manage.pandit')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-user-alt-7"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Pundits</span>
                        </div>
                    </div>
                </div>
                </a>
           @endif




            @if(request()->segment(2)=="seller-sub-menu")
                <a href="{{route('admin.manage.seller')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-sign-in" aria-hidden="true"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Seller Sign Up</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.manage.selelr-master')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-users-alt-4"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Seller</span>
                        </div>
                    </div>
                </div>
                </a>



           @endif




            @if(request()->segment(2)=="puja-sub-menu")
                <a href="{{route('admin.manage.puja-category')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-hanukiah"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Puja Category</span>
                        </div>
                    </div>
                </div>
                </a>
                <a href="{{route('admin.manage.puja.name')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fas fa-gopuram"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Puja Name</span>
                        </div>
                    </div>
                </div>
                </a>

                <a href="{{route('admin.manage.puja')}}">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="icofont-fire-burn r2"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">Manage Puja</span>
                        </div>
                    </div>
                </div>
                </a>



           @endif


            </div>
            <!-- end row -->







        </div> <!-- container -->

    </div> <!-- content -->

    <footer class="footer text-right">
        Copyright &copy; 2021 Astroaquila.com All rights reserved.
    </footer>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

@section('script')
@include('admin.includes.script')
@endsection
