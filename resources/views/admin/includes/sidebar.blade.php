<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        {{-- <div class="user-details">
            <div class="pull-left">
                @if(auth()->guard('admin')->user()->profile_pic=="")
                <img src="{{ URL::to('public/admin/assets/images/users/avatar-1.jpg')}}" alt="" class="thumb-md img-circle">
                @else
                <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{auth()->guard('admin')->user()->profile_pic}}" alt="" class="thumb-md img-circle">
                @endif

            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{auth()->guard('admin')->user()->name}} <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('admin.manage.profile')}}"><i class="fas fa-user-circle"></i> Profile</a></li>
                        <li><a href="{{route('admin.change.password')}}"><i class="fas fa-cog"></i> Change Password</a></li>
                        <li><a href="{{route('admin.logout')}}"><i class="fas fa-power-off"></i> Logout</a></li>
                    </ul>
                </div>

                <p class="text-muted m-0">Administrator</p>
            </div>
        </div> --}}
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>




                <li><a href="{{route('admin.dashboard')}}" class="waves-effect  @if(Request::segment(2)=="") active @endif @if(Request::segment(2)=="change-password") active @endif  @if(Request::segment(2)=="admin-profile") active @endif"><i class="fas fa-tag ri"></i><span> Dashboard </span></a></li>

                {{-- products --}}


                <li class="dropdown  dropdown_lef @if(request()->segment(2)=="manage-products") open @endif  @if(Request::segment(2)=="product-category"||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-category" || Request::segment(2)=="add-product-category" ||Request::segment(2)=="add-sub-category" ||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-sub-category") open @endif">

                                <a href="#" class=" dropdown-toggle @if(request()->segment(2)=="manage-products") subdrop @endif  @if(Request::segment(2)=="product-category"||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-category" || Request::segment(2)=="add-product-category" ||Request::segment(2)=="add-sub-category" ||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-sub-category") subdrop @endif  @if(request()->segment(2)=="product-sub-menu") back_grey @endif" data-toggle="dropdown" >


                            <i class="icofont-list"></i><span> Products </span>  <span class="added_nicon" onclick='window.location.href="{{route('admin.product.sub.menu')}}"'><i class="fa fa-home" aria-hidden="true"></i></span> <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu sub_menu" @if(request()->segment(2)=="manage-products") style="display: block" @endif  @if(Request::segment(2)=="product-category"||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-category" || Request::segment(2)=="add-product-category" ||Request::segment(2)=="add-sub-category" ||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-sub-category" || request()->segment(2)=="manage-product-faq") style="display: block" @endif>


                                 <li><a href="{{route('admin.product.category.manage')}}" class=" waves-effect
                                @if(Request::segment(2)=="product-category"||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-category" || Request::segment(2)=="add-product-category" ||Request::segment(2)=="add-sub-category" ||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-sub-category" ) active @endif ">
                                <i class="icofont-list"></i><span> Manage Category </span></a></li>

                                <li><a href="{{route('admin.manage.product')}}" class="waves-effect @if(request()->segment(2)=="manage-products" || request()->segment(2)=="manage-product-faq") active @endif"><i class="fa fa-cube ri2"></i><span> Manage Products </span></a></li>

                            </ul>

                            </li>



                            <li class="dropdown  dropdown_lef @if(request()->segment(2)=="manage-horoscope" || request()->segment(2)=="manage-horoscope-category" || request()->segment(2)=="manage-horoscope-title" || request()->segment(2)=="manage-data-bank") open @endif ">

                                <a href="#" class="waves-effect dropdown-toggle @if(request()->segment(2)=="manage-horoscope" || request()->segment(2)=="manage-horoscope-category" || request()->segment(2)=="manage-horoscope-title" || request()->segment(2)=="manage-data-bank") subdrop @endif" data-toggle="dropdown">



                            <i class="fas fa-star"></i><span> Horoscope </span><span class="added_nicon" onclick='window.location.href="{{route('admin.horoscope.sub.menu')}}"'><i class="fa fa-home" aria-hidden="true"></i></span><span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu sub_menu" @if(request()->segment(2)=="manage-horoscope" || request()->segment(2)=="manage-horoscope-category" || request()->segment(2)=="manage-horoscope-title" || request()->segment(2)=="manage-data-bank") style="display: block;" @endif  >


                                 <li><a href="{{route('admin.modules.manage.horoscope.category')}}" class=" waves-effect @if(request()->segment(2)=="manage-horoscope-category") active @endif ">
                                 <i class="fas fa-star"></i><span> Manage Category </span></a></li>

                                 <li><a href="{{route('admin.manage.horoscope.title')}}" class="waves-effect  @if(request()->segment(2)=="manage-horoscope-title") active @endif"><i class="fa fa-header" aria-hidden="true"></i><span> Manage Horoscope Title </span></a></li>

                                <li><a href="{{route('admin.manage.horoscope')}}" class=" waves-effect
                                @if(request()->segment(2)=="manage-horoscope") active @endif ">
                                 <i class="fa fa-h-square" aria-hidden="true"></i><span> Manage Hororscope </span></a></li>

                                 <li><a href="{{route('admin.manage.data.bank')}}" class=" waves-effect
                                @if(request()->segment(2)=="manage-data-bank") active @endif ">
                                 <i class="fa fa-database" aria-hidden="true"></i><span> Aquila Data Bank </span></a></li>





                            </ul>
                            </li>

              <li class="dropdown  dropdown_lef  @if(request()->segment(2)=='manage-gemstones' || Request::segment(2)=='gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='edit-gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='manage-gemstone-price' || request()->segment(2)=="manage-ring-size-system" || request()->segment(2)=="manage-ring-size" || request()->segment(2)=="manage-bracelet-design" || request()->segment(2)=="manage-puja-energization" || request()->segment(2)=="manage-certificate" || request()->segment(2)=="manage-gold-purity" || request()->segment(2)=="manage-ring-pendent-price" || request()->segment(2)=="manage-cirtificate-name"  || request()->segment(2)=="manage-color" || request()->segment(2)=="manage-gemstone-title"|| request()->segment(2)=="manage-ring-pendent-design" ||Request::segment(2)=='manage-gamestone-faq') open @endif">

                                <a href="#" class="waves-effect dropdown-toggle @if(request()->segment(2)=='manage-gemstones' || Request::segment(2)=='gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='edit-gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='manage-gemstones' || Request::segment(2)=='manage-gemstone-price' || request()->segment(2)=="manage-ring-size-system" || request()->segment(2)=="manage-ring-size" || request()->segment(2)=="manage-bracelet-design" || request()->segment(2)=="manage-puja-energization" || request()->segment(2)=="manage-certificate" || request()->segment(2)=="manage-gold-purity" || request()->segment(2)=="manage-ring-pendent-price" || request()->segment(2)=="manage-cirtificate-name"  || request()->segment(2)=="manage-color" || request()->segment(2)=="manage-gemstone-title"|| request()->segment(2)=="manage-ring-pendent-design" ||Request::segment(2)=='manage-gamestone-faq') subdrop @endif  @if(request()->segment(2)=="gemstone-sub-menu") back_grey @endif" data-toggle="dropdown">


                            <i class="fas fa-gem"></i><span> Gemstones </span> <span class="added_nicon" onclick='window.location.href="{{route('admin.gemstone.sub.menu')}}"'><i class="fa fa-home" aria-hidden="true"></i></span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu sub_menu" @if( request()->segment(2)=='manage-gemstones' || Request::segment(2)=='gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='edit-gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='manage-gemstones' || Request::segment(2)=='manage-gemstone-price' || request()->segment(2)=="manage-ring-size-system" || request()->segment(2)=="manage-ring-size" || request()->segment(2)=="manage-bracelet-design" || request()->segment(2)=="manage-puja-energization" || request()->segment(2)=="manage-certificate" || request()->segment(2)=="manage-gold-purity" || request()->segment(2)=="manage-ring-pendent-price" || request()->segment(2)=="manage-cirtificate-name"  || request()->segment(2)=="manage-color" || request()->segment(2)=="manage-gemstone-title" || request()->segment(2)=="manage-ring-pendent-design" ||Request::segment(2)=='manage-gamestone-faq') style="display: block" @endif>


                                 <li><a href="{{route('admin.gemstone.category.manage')}}" class=" waves-effect
                                @if(Request::segment(2)=='gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='edit-gemstone-category' || Request::segment(2)=='add-gemstone-category' || Request::segment(2)=='add-gemstone-category') active @endif">
                                <i class="icofont-list"></i><span> Gemstone Category </span></a></li>
                <li><a href="{{route('admin.manage.gemstone')}}" class=" waves-effect
                                @if(Request::segment(2)=='manage-gemstones' || Request::segment(2)=='manage-gamestone-faq') active @endif">
                                <i class="fas fa-gem"></i><span> Manage Gemstones </span></a></li>
                <li><a href="{{route('admin.manage.gemstone.price')}}" class=" waves-effect
                                @if(Request::segment(2)=='manage-gemstone-price') active @endif">
                                <i class="fas fa-money"></i><span> Manage Gemstone Price </span></a></li>



                                {{-- sayan 20-sept --}}
                                    <li><a href="{{route('admin.manage.ring.system')}}" class="waves-effect  @if(request()->segment(2)=="manage-ring-size-system") active @endif"><i class="fa fa-life-ring" aria-hidden="true"></i><span> Manage Ring Size System </span></a></li>

                                  <li><a href="{{route('admin.manage.ring.size')}}" class="waves-effect  @if(request()->segment(2)=="manage-ring-size") active @endif"><i class="fas fa-ring"></i><span> Manage Ring Size</span></a></li>

                                  <li><a href="{{route('admin.manage.bracelet.design')}}" class="waves-effect  @if(request()->segment(2)=="manage-bracelet-design") active @endif"><i class="far fa-hand-rock"></i><span> Manage Bracelet Design</span></a></li>

                                  <li><a href="{{route('admin.manage.puja-energization')}}" class="waves-effect  @if(request()->segment(2)=="manage-puja-energization" || request()->segment(2)=="manage-puja-faq") active @endif"><i class="fas fa-gopuram"></i><span> Manage Puja Energization</span></a></li>

                                  <li><a href="{{route('admin.manage.cirtificate.name')}}" class="waves-effect  @if(request()->segment(2)=="manage-cirtificate-name") active @endif"><i class="fa fa-book" aria-hidden="true"></i><span> Manage Certificate Name</span></a></li>

                                  <li><a href="{{route('admin.manage.cirtification')}}" class="waves-effect  @if(request()->segment(2)=="manage-certificate") active @endif"><i class="far fa-file"></i><span> Manage Certificate Price</span></a></li>

                                  <li><a href="{{route('admin.manage.gold.purity')}}" class="waves-effect  @if(request()->segment(2)=="manage-gold-purity") active @endif"><i class="fas fa-coins"></i><span> Manage Gold Purity</span></a></li>

                                  <li><a href="{{route('admin.manage.ring-pendent-price')}}" class="waves-effect  @if(request()->segment(2)=="manage-ring-pendent-price") active @endif"><i class="fas fa-money-bill"></i><span> Manage Ring Pendent Price</span></a></li>

                                  <li><a href="{{route('admin.manage.ring.pendent.design')}}" class="waves-effect  @if(request()->segment(2)=="manage-ring-pendent-design") active @endif"><i class="fa fa-file-image-o" aria-hidden="true"></i><span> Manage Ring Pendent Design</span></a></li>


                                  <li><a href="{{route('admin.manage.gemstone.color')}}" class="waves-effect  @if(request()->segment(2)=="manage-color") active @endif"><i class="fa fa-thumb-tack" aria-hidden="true"></i><span> Manage Color </span></a></li>

                                  <li><a href="{{route('admin.manage.gemstone.title')}}" class="waves-effect  @if(request()->segment(2)=="manage-gemstone-title") active @endif"><i class="fa fa-header" aria-hidden="true"></i><span> Manage Gamestone Title </span></a></li>



                            </ul>
                            </li>

              <li class="dropdown dropdown_lef @if(Request::segment(2)=="manage-product-order"||  request()->segment(2)=="manage-puja-order" ||  request()->segment(2)=="manage-horoscope-order") open @endif" >

                                <a href="javascript:void(0)" class="waves-effect dropdown-toggle @if(Request::segment(2)=="manage-product-order" ||  request()->segment(2)=="manage-horoscope-order") subdrop @endif @if(request()->segment(2)=="order-sub-menu") back_grey @endif" data-toggle="dropdown">
<i class="fas fa-receipt"></i><span> Order  </span> <span class="added_nicon" onclick='window.location.href="{{route('admin.order.sub.menu')}}"'><i class="fa fa-home" aria-hidden="true"></i></span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu sub_menu" @if(Request::segment(2)=="manage-product-order" ||  request()->segment(2)=="manage-puja-order" ||  request()->segment(2)=="manage-horoscope-order" ) style="display: block;" @endif>
                                      <li><a href="{{route('admin.manage.product.order')}}" class="waves-effect @if(request()->segment(2)=="manage-product-order") active @endif"><i class="fa fa-cube ri2"></i><span> Manage Product Order</span></a></li>

                                       <li><a href="{{route('admin.manage.puja.order')}}" class="waves-effect @if(request()->segment(2)=="manage-puja-order") active @endif"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span> Manage Puja Order </span></a></li>

                                       <li><a href="{{route('admin.manage.horoscope.order')}}" class="waves-effect @if(request()->segment(2)=="manage-horoscope-order") active @endif"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span> Manage Horoscope Order </span></a></li>

                            </ul>
                            </li>



                        <li class="dropdown dropdown_lef @if(request()->segment(2)=="manage-state" || request()->segment(2)=="manage-zip-code" || request()->segment(2)=="manage-deity" || request()->segment(2)=="manage-purpose" || request()->segment(2)=="manage-planet" || request()->segment(2)=="manage-mantra" || request()->segment(2)=="manage-treatment" || request()->segment(2)=="manage-general-faq"|| request()->segment(2)=="manage-faq-category"|| request()->segment(2)=="manage-search-page-data" || request()->segment(2)=="manage-home-page-bannner" || request()->segment(2)=="home-page-banner-second-slider"|| request()->segment(2)=="manage-expertise"|| request()->segment(2)=="manage-city" || request()->segment(2)=="edit-why-who" | request()->segment(2)=="manage-wiki-category" || request()->segment(2)=="manage-wiki-title" || request()->segment(2)=="manage-aquilia-wiki" || request()->segment(2)=="manage-language" || request()->segment(2)=="manage-reason" || request()->segment(2)=="manage-area") open @endif" >


                                <a href="javascript:void(0)" class="waves-effect dropdown-toggle @if(request()->segment(2)=="manage-state" || request()->segment(2)=="manage-zip-code" || request()->segment(2)=="manage-deity" || request()->segment(2)=="manage-purpose" || request()->segment(2)=="manage-planet" || request()->segment(2)=="manage-mantra" || request()->segment(2)=="manage-treatment" || request()->segment(2)=="manage-general-faq"|| request()->segment(2)=="manage-faq-category"|| request()->segment(2)=="manage-search-page-data" || request()->segment(2)=="manage-home-page-bannner" || request()->segment(2)=="home-page-banner-second-slider"|| request()->segment(2)=="manage-expertise") subdrop @endif @if(request()->segment(2)=="settings-sub-menu" || request()->segment(2)=="manage-city" | request()->segment(2)=="manage-wiki-category" || request()->segment(2)=="manage-wiki-title" || request()->segment(2)=="manage-aquilia-wiki" || request()->segment(2)=="manage-language" || request()->segment(2)=="manage-reason" || request()->segment(2)=="manage-area") back_grey @endif" data-toggle="dropdown" >
                                    <i class="fa fa-cogs" aria-hidden="true"></i><span> Settings  </span> <span class="added_nicon" onclick='window.location.href="{{route('admin.settings.sub.menu')}}"'><i class="fa fa-home" aria-hidden="true"></i></span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu sub_menu" @if(request()->segment(2)=="manage-state" || request()->segment(2)=="manage-zip-code" || request()->segment(2)=="manage-deity" || request()->segment(2)=="manage-purpose" || request()->segment(2)=="manage-planet" || request()->segment(2)=="manage-mantra" || request()->segment(2)=="manage-treatment" || request()->segment(2)=="manage-general-faq" || request()->segment(2)=="manage-faq-category" || request()->segment(2)=="manage-search-page-data" || request()->segment(2)=="manage-home-page-bannner" || request()->segment(2)=="home-page-banner-second-slider" || request()->segment(2)=="manage-expertise" || request()->segment(2)=="manage-city"|| request()->segment(2)=="manage-astro-tips" || request()->segment(2)=="add-astro-tips" || request()->segment(2)=="edit-astro-tips" || request()->segment(2)=="edit-why-who" || request()->segment(2)=="manage-wiki-category" || request()->segment(2)=="manage-wiki-title" || request()->segment(2)=="manage-aquilia-wiki" || request()->segment(2)=="manage-language" || request()->segment(2)=="manage-reason" || request()->segment(2)=="manage-area") style="display: block;" @endif >

                                  <li><a href="{{route('manage.state')}}" class="waves-effect  @if(request()->segment(2)=="manage-state") active @endif"><i class="icofont-location-pin"></i><span> Manage State </span></a></li>

                                  <li><a href="{{route('admin.manage.city')}}" class="waves-effect  @if(request()->segment(2)=="manage-city") active @endif"><i class="icofont-location-pin"></i><span> Manage City </span></a></li>

                                <li><a href="{{route('admin.manage.zip')}}" class="waves-effect  @if(request()->segment(2)=="manage-zip-code") active @endif"><i class="fa fa-map-pin" aria-hidden="true"></i><span> Manage Zipcode </span></a></li>

                                <li><a href="{{route('admin.manage.area')}}" class="waves-effect  @if(request()->segment(2)=="manage-area") active @endif"><i class="fa fa-map-pin" aria-hidden="true"></i><span> Manage Area </span></a></li>

                                <li><a href="{{route('admin.manage.deity')}}" class="waves-effect  @if(request()->segment(2)=="manage-deity") active @endif"><i class="fas fa-ankh"></i><span> Manage Deity </span></a></li>

                                  <li><a href="{{route('admin.manage.purpose')}}" class="waves-effect  @if(request()->segment(2)=="manage-purpose") active @endif"><i class="fab fa-superpowers"></i><span> Manage Purpose </span></a></li>

                  <li><a href="{{route('admin.manage.planet')}}" class="waves-effect  @if(request()->segment(2)=="manage-planet") active @endif"><i class="fas fa-globe"></i><span> Manage Planet </span></a></li>

                  <li><a href="{{route('admin.manage.astro.tips')}}" class="waves-effect  @if(request()->segment(2)=="manage-astro-tips" || request()->segment(2)=="add-astro-tips" || request()->segment(2)=="edit-astro-tips") active @endif"><i class="fa fa-info-circle"></i><span> Astro tips </span></a></li>



                                <li><a href="{{route('admin.manage.mantra')}}" class="waves-effect  @if(request()->segment(2)=="manage-mantra") active @endif"><i class="fas fa-om"></i><span> Manage Mantras </span></a></li>

                                  <li><a href="{{route('admin.manage.treatment')}}" class="waves-effect  @if(request()->segment(2)=="manage-treatment") active @endif"><i class="fa fa-plus-square" aria-hidden="true"></i><span> Manage Treatments </span></a></li>


                                  <li><a href="{{route('admin.manage.faq.category')}}" class="waves-effect  @if(request()->segment(2)=="manage-faq-category") active @endif"><i class="fa fa-empire" aria-hidden="true"></i><span>  Faq Category </span></a></li>

                                  <li><a href="{{route('admin.manage.general.faq')}}" class="waves-effect  @if(request()->segment(2)=="manage-general-faq") active @endif"><i class="fa fa-question" aria-hidden="true"></i><span> General Faq </span></a></li>

                                  <li><a href="{{route('admin.edit.why.who')}}" class="waves-effect  @if(request()->segment(2)=="edit-why-who") active @endif"><i class="fa fa-question-circle" aria-hidden="true"></i><span> Why & who </span></a></li>

                                  <li><a href="{{route('admin.manage.search.page.data')}}" class="waves-effect  @if(request()->segment(2)=="manage-search-page-data") active @endif"><i class="fa fa-pencil" aria-hidden="true"></i><span> Search Content </span></a></li>

                                  <li><a href="{{route('admin.manage.home.page.banner')}}" class="waves-effect  @if(request()->segment(2)=="manage-home-page-bannner") active @endif"><i class="fa fa-snowflake-o" aria-hidden="true"></i><span> Home Page First Slider </span></a></li>

                                  <li><a href="{{route('admin.manage.home.page.banner.second')}}" class="waves-effect  @if(request()->segment(2)=="home-page-banner-second-slider") active @endif"><i class="fa fa-snowflake-o" aria-hidden="true"></i><span> Home Page Second Slider </span></a></li>

                                  <li><a href="{{route('admin.manage.expertise')}}" class="waves-effect  @if(request()->segment(2)=="manage-expertise") active @endif"><i class="fa fa-exchange" aria-hidden="true"></i><span> Manage Expertise</span></a></li>

                                  <li><a href="{{route('admin.manage.language')}}" class="waves-effect  @if(request()->segment(2)=="manage-language") active @endif"><i class="fa fa-language" aria-hidden="true"></i><span> Manage Language</span></a></li>

                                  <li><a href="{{route('admin.manage.reason')}}" class="waves-effect  @if(request()->segment(2)=="manage-reason") active @endif"><i class="fa fa-times" aria-hidden="true"></i><span> Manage Rejection Reason</span></a></li>

                                  <li><a href="{{route('admin.manage.wiki.category')}}" class="waves-effect  @if(request()->segment(2)=="manage-wiki-category") active @endif"><i class="icofont-list"></i><span> Manage Wiki Category</span></a></li>

                                  <li><a href="{{route('admin.manage.wiki.title')}}" class="waves-effect  @if(request()->segment(2)=="manage-wiki-title") active @endif"><i class="fa fa-header" aria-hidden="true"></i><span> Manage Wiki Title</span></a></li>

                                  <li><a href="{{route('admin.manage.aquilia.wiki')}}" class="waves-effect  @if(request()->segment(2)=="manage-aquilia-wiki") active @endif"><i class="fa fa-info-circle"></i><span> Aqualia wiki </span></a></li>



                            </ul>
                            </li>




                            {{-- blogs  --}}

                        <li class="dropdown dropdown_lef @if(request()->segment(2)=="manage-blog-category" || request()->segment(2)=="manage-blog") open @endif" >

                                <a href="javascript:void(0)" class="waves-effect dropdown-toggle @if(request()->segment(2)=="manage-blog-category" || request()->segment(2)=="manage-blog") subdrop @endif  @if(request()->segment(2)=="blog-sub-menu") back_grey @endif" data-toggle="dropdown">
                              <i class="fa fa-th" aria-hidden="true"></i><span> Blogs </span> <span class="added_nicon" onclick='window.location.href="{{route('admin.blog.sub.menu')}}"'><i class="fa fa-home" aria-hidden="true"></i></span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu sub_menu" @if(request()->segment(2)=="manage-blog-category" || request()->segment(2)=="manage-blog") style="display: block;" @endif>
                                      <li><a href="{{route('admin.manage.blog.category')}}" class="waves-effect @if(request()->segment(2)=="manage-blog-category") active @endif"><i class="fas fa-th-large"></i><span> Manage Blog Category </span></a></li>

                               <li><a href="{{route('admin.manage.blog')}}" class="waves-effect @if(request()->segment(2)=="manage-blog") active @endif"><i class="icofont-blogger"></i><span> Manage Blog </span></a></li>

                            </ul>
                            </li>


                             <li class="dropdown dropdown_lef" @if(request()->segment(2)=="manage-customer" ||request()->segment(2)=="manage-astrologer" || request()->segment(2)=="manage-pundit") open @endif>
                                <a href="javascript:void(0)" class="waves-effect dropdown-toggle @if(request()->segment(2)=="manage-customer" ||request()->segment(2)=="manage-astrologer" || request()->segment(2)=="manage-pundit") subdrop @endif @if(request()->segment(2)=="site-user-sub-menu") back_grey @endif" data-toggle="dropdown">
                                   <i class="fa fa-users" aria-hidden="true"></i><span> Site Users  </span> <span class="added_nicon" onclick='window.location.href="{{route('admin.site.user.sub.menu')}}"'><i class="fa fa-home" aria-hidden="true"></i></span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu sub_menu" @if(request()->segment(2)=="manage-customer" ||request()->segment(2)=="manage-astrologer" || request()->segment(2)=="manage-pundit") style="display: block;" @endif>
                                   <li><a href="{{route('admin.manage.customer')}}" class="waves-effect @if(request()->segment(2)=="manage-customer") active @endif"><i class="icofont-users-alt-1"></i><span> Manage Customer </span></a></li>
                                    <li><a href="{{route('admin.manage.astrologer')}}" class="waves-effect @if(request()->segment(2)=="manage-astrologer") active @endif"><i class="icofont-user-suited"></i> <span> Manage Astrologer </span></a></li>
                                    <li><a href="{{route('admin.manage.pandit')}}" class="waves-effect @if(request()->segment(2)=="manage-pundit") active @endif"><i class="icofont-user-alt-7"></i><span> Manage Pundits </span></a></li>
                            </ul>
                            </li>



                             <li class="dropdown dropdown_lef @if(request()->segment(2)=="manage-sellers-sign-up" || request()->segment(2)=="manage-seller") open @endif" >
                                <a href="javascript:void(0)" class="waves-effect dropdown-toggle @if(request()->segment(2)=="manage-sellers-sign-up" || request()->segment(2)=="manage-seller") subdrop @endif @if(request()->segment(2)=="seller-sub-menu") back_grey @endif" data-toggle="dropdown">
                                    <i class="fas fa-address-card"></i><span> Seller  </span> <span class="added_nicon" onclick='window.location.href="{{route('admin.seller.sub.menu')}}"'><i class="fa fa-home" aria-hidden="true"></i></span> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu sub_menu" @if(request()->segment(2)=="manage-sellers-sign-up" || request()->segment(2)=="manage-seller") style="display: block;" @endif>
                                    <li><a href="{{route('admin.manage.seller')}}" class="waves-effect @if(request()->segment(2)=="manage-sellers-sign-up") active @endif"><i class="fa fa-sign-in" aria-hidden="true"></i><span>Seller Sign Up </span></a></li>

                                <li><a href="{{route('admin.manage.selelr-master')}}" class="waves-effect @if(request()->segment(2)=="manage-seller") active @endif"><i class="icofont-users-alt-4"></i><span>Manage Seller </span></a></li>

                            </ul>
                            </li>



                          <li class="dropdown dropdown_lef @if(request()->segment(2)=="manage-puja-category" || request()->segment(2)=="manage-puja" || request()->segment(2)=="manage-puja-faq" ) open @endif">
                                <a href="javascript:void(0)" class="waves-effect dropdown-toggle @if(request()->segment(2)=="manage-puja-category" || request()->segment(2)=="manage-puja" || request()->segment(2)=="manage-puja-faq" || request()->segment(2)=="manage-puja-name") subdrop @endif @if(request()->segment(2)=="puja-sub-menu") back_grey @endif " data-toggle="dropdown">
                                    <i class="fa fa-sun-o" aria-hidden="true"></i><span> Puja </span>  <span class="added_nicon" onclick='window.location.href="{{route('admin.puja.sub.menu')}}"'><i class="fa fa-home" aria-hidden="true"></i></span><span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu sub_menu" @if(request()->segment(2)=="manage-puja-category" || request()->segment(2)=="manage-puja" || request()->segment(2)=="manage-puja-faq" || request()->segment(2)=="manage-puja-name") style="display: block;" @endif>
                                  <li><a href="{{route('admin.manage.puja-category')}}" class="waves-effect @if(request()->segment(2)=="manage-puja-category") active @endif"><i class="fas fa-hanukiah"></i><span> Manage Puja Category </span>  </a></li>

                                  <li><a href="{{route('admin.manage.puja.name')}}" class="waves-effect @if(request()->segment(2)=="manage-puja-name") active @endif"><i class="fas fa-gopuram"></i><span> Manage Puja Name </span></a></li>

                             <li><a href="{{route('admin.manage.puja')}}" class="waves-effect @if(request()->segment(2)=="manage-puja" || request()->segment(2)=="manage-puja-faq") active @endif"><i class="icofont-fire-burn r2"></i><span> Manage Puja </span></a></li>


                            </ul>
                            </li>











               {{--  <li><a href="{{route('admin.product.category.manage')}}" class="waves-effect
                    @if(Request::segment(2)=="product-category"||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-category" || Request::segment(2)=="add-product-category" ||Request::segment(2)=="add-sub-category" ||Request::segment(2)=="add-product-category" ||Request::segment(2)=="edit-product-sub-category" ) active @endif ">
                    <i class="icofont-list"></i><span> Manage Category </span></a></li> --}}
                {{-- <li><a href="{{route('admin.manage.product')}}" class="waves-effect @if(request()->segment(2)=="manage-products") active @endif"><i class="fa fa-cube ri2"></i><span> Manage Products </span></a></li> --}}
                {{-- <li><a href="#" class="waves-effect"><i class="fa fa-cart-plus"></i><span> Manage Orders </span></a></li> --}}
              {{--   <li><a href="{{route('admin.manage.blog.category')}}" class="waves-effect @if(request()->segment(2)=="manage-blog-category") active @endif"><i class="fas fa-th-large"></i><span> Manage Blog Category </span></a></li>

                <li><a href="{{route('admin.manage.blog')}}" class="waves-effect @if(request()->segment(2)=="manage-blog") active @endif"><i class="icofont-blogger"></i><span> Manage Blog </span></a></li> --}}

                {{-- <li><a href="{{route('manage.state')}}" class="waves-effect  @if(request()->segment(2)=="manage-state") active @endif"><i class="icofont-location-pin"></i><span> Manage State </span></a></li>

                 <li><a href="{{route('admin.manage.zip')}}" class="waves-effect  @if(request()->segment(2)=="manage-zip-code") active @endif"><i class="icofont-location-pin"></i><span> Manage Zipcode </span></a></li>

                <li><a href="{{route('admin.manage.deity')}}" class="waves-effect  @if(request()->segment(2)=="manage-deity") active @endif"><i class="fas fa-ankh"></i><span> Manage Deity </span></a></li>

                <li><a href="{{route('admin.manage.purpose')}}" class="waves-effect  @if(request()->segment(2)=="manage-purpose") active @endif"><i class="fab fa-superpowers"></i><span> Manage Purpose </span></a></li> --}}

               {{--  <li><a href="{{route('admin.manage.customer')}}" class="waves-effect @if(request()->segment(2)=="manage-customer") active @endif"><i class="icofont-users-alt-1"></i><span> Manage Customer </span></a></li>
                <li><a href="{{route('admin.manage.astrologer')}}" class="waves-effect @if(request()->segment(2)=="manage-astrologer") active @endif"><i class="icofont-user-suited"></i> <span> Manage Astrologer </span></a></li>
                <li><a href="{{route('admin.manage.pandit')}}" class="waves-effect @if(request()->segment(2)=="manage-pundit") active @endif"><i class="icofont-user-alt-7"></i><span> Manage Pundits </span></a></li> --}}
                {{-- <li><a href="{{route('admin.manage.seller')}}" class="waves-effect @if(request()->segment(2)=="manage-sellers-sign-up") active @endif"><i class="icofont-users-alt-4"></i><span>Seller Sign Up </span></a></li>

                <li><a href="{{route('admin.manage.selelr-master')}}" class="waves-effect @if(request()->segment(2)=="manage-seller") active @endif"><i class="icofont-users-alt-4"></i><span>Manage Seller </span></a></li> --}}


                {{-- <li><a href="{{route('admin.manage.remedy')}}" class="waves-effect @if(request()->segment(2)=="manage-remedies") active @endif"><i class="icofont-files-stack"></i><span> Manage remedies </span></a></li> --}}

                 {{-- <li><a href="{{route('admin.manage.puja-category')}}" class="waves-effect @if(request()->segment(2)=="manage-puja-category") active @endif"><i class="icofont-fire-burn r2"></i><span> Manage Puja Category </span></a></li>

                <li><a href="{{route('admin.manage.puja')}}" class="waves-effect @if(request()->segment(2)=="manage-puja") active @endif"><i class="icofont-fire-burn r2"></i><span> Manage Puja </span></a></li> --}}
                {{-- <li><a href="{{route('admin.manage.commission')}}" class="waves-effect @if(request()->segment(2)=="manage-comission") active @endif"><i class="icofont-money"></i><span> Manage Commission </span></a></li>
                <li><a href="{{route('admin.manage.transaction')}}" class="waves-effect @if(request()->segment(2)=="manage-transaction") active @endif"><i class="icofont-bank-transfer-alt"></i><span> Manage Transaction </span></a></li>
                <li><a href="#" class="waves-effect"><i class="fa fa-money"></i><span> Fund transfer</span></a></li>
                <li><a href="#" class="waves-effect"><i class="fas fa-question-circle ri4"></i><span> Reports </span></a></li> --}}
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
