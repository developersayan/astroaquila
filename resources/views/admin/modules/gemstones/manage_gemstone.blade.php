@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Gemstones </title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
	#exits_title{
		display: none;
		color: red;
	}
  .custom_angle.angle {
    right: 32px;
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
            <h4 class="pull-left page-title">Manage Gemstones</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.add-gemstone-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
              <li class="active"><a href="{{route('admin.gemstone.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <div class="clearfix"></div>
            <div class="panel panel-default">

              <div class="panel-heading rm02 rm04">

                <form role="form" method="post" action="{{route('admin.manage.gemstone.search')}}" id="search_form">
                  @csrf
                  <input type="hidden" name="page" value="" id="page">

                  <div class="form-group">
                            <label for="search">Select Title</label>
                               <select class="form-control rm06 basic-select" name="title" id="title">
                                    <option value="">Select Title</option>
                                      @if(@$title->isNotEmpty())
                                         @foreach(@$title as $value)
                                                 <option value="{{@$value->id}}" @if(request('title')==@$value->id) selected @endif>{{@$value->title}}</option>
                                                 @endforeach
                                                  @else
                                                  <option value="">No Category Added</option>
                                        @endif
                              </select>
                      </div>

                  <div class="form-group">
                            <label for="search">Select Category</label>
                               <select class="form-control rm06 basic-select" name="category" id="category">
                                    <option value="">Select Category</option>
                                      @if(@$gemstone_categories->isNotEmpty())
                                         @foreach(@$gemstone_categories as $category)
                                                 <option value="{{@$category->id}}" @if(request('category')==@$category->id) selected @endif>{{@$category->category_name}}</option>
                                                 @endforeach
                                                  @else
                                                  <option value="">No Category Added</option>
                                        @endif
                              </select>
                      </div>
					  <div class="form-group malti_select ">
                                               <label for="FullName">Select Planet</label>
                                               <select class="chosen-select form-control " multiple data-placeholder="Select Planets" name="planets[]" id="planets_filter">
                                        @foreach($planets as $planet )
                                        <option value="{{ $planet->id }}" {{ @in_array($planet->id, @$request['planets'])?'selected':''}}>{{@$planet->planet_name}}</option>
                                        @endforeach

                                    </select>
                                            </div>


                    {{--  <input type="hidden" name="deity" id="deity">
                     <input type="hidden" name="rashi" id="rashi">
                      <input type="hidden" name="nakshatra" id="nakshatra">
                      <input type="hidden" name="planets" id="planets">
                       <input type="hidden" name="color" id="color"> --}}
                   <div class="form-group malti_select ">
                                               <label for="FullName">Select Deity</label>
                                               <select class="chosen-select form-control " multiple data-placeholder="Select Deity" name="deity[]" id="deity_filter">
                                        @foreach($deity as $value )
                                        <option value="{{ $value->id }}" {{ @in_array($value->id, @$request['deity'])?'selected':''}}>{{@$value->name}}</option>
                                        @endforeach

                                    </select>
                                            </div>

                                          <div class="clearfix"></div>
                                           

                                            <div class="form-group malti_select ">
                                               <label for="FullName">Select Rashi</label>
                                               <select class="chosen-select form-control " multiple data-placeholder="Select Rashi" name="rashi[]" id="rashi_filter">
                                        @foreach($rashi as $rashi )
                                        <option value="{{ $rashi->id }}" {{ @in_array($rashi->id, @$request['rashi'])?'selected':''}}>{{@$rashi->name}}</option>
                                        @endforeach

                                    </select>
                                            </div>

                                            <div class="form-group malti_select ">
                                               <label for="FullName">Select Nakshatra</label>
                                               <select class="chosen-select form-control " multiple data-placeholder="Select Nakshatra" name="nakshatra[]" id="nakshatra_filter">
                                        @foreach($nakshatras as $nakshatra )
                                        <option value="{{ $nakshatra->id }}" {{ @in_array($nakshatra->id, @$request['nakshatra'])?'selected':''}}>{{@$nakshatra->name}}</option>
                                        @endforeach

                                    </select>
                                            </div>

                                            <div class="form-group malti_select ">
                                               <label for="FullName">Select Color</label>
                                               <select class="chosen-select  form-control " multiple data-placeholder="Select Color" name="color[]" id="color_filter">
                                        @foreach($color as $value )
                                        <option value="{{ $value->id }}" {{ @in_array($value->id, @$request['color'])?'selected':''}}>{{@$value->color}}</option>
                                        @endforeach

                                    </select>
                                            </div>
					  {{-- <div class="form-group">
                            <label for="search">Select Rashi</label>
                               <select class="form-control rm06" name="rashi" id="rashi">
                                    <option value="">Select Rashi</option>
                                      @if(@$rashis)
                                         @foreach(@$rashis as $val)
                                                 <option value="{{@$val->id}}" @if(request('rashi')==@$val->id) selected @endif>{{@$val->name}}</option>
                                                 @endforeach
                                                  @else
                                                  <option value="">No Rashi Added</option>
                                        @endif
                              </select>
                      </div> --}}

                  <div class="form-group">
                    <label for="FullName">keyword</label>
                    <input type="text" placeholder="keyword" class="form-control" name="keyword" value="{{request('keyword')}}">
                  </div>
                  {{-- <div class="clearfix"></div> --}}
                  <div class="clearfix"></div>

                  <div class="clearfix"></div>
                  <div class="form-group">
                    <label for="FullName">Weight</label>
                    <input type="text" placeholder="Weight" class="form-control" name="weight" value="{{request('weight')}}" maxlength="4">
                  </div>


				  {{-- 
				  
				  
				  <div class="form-group">
                            <label for="search">Select Stone Type</label>
                               <select class="form-control rm06" name="stone_type" id="stone_type">
										<option value="">Select Stone Type</option>
										<option value="P" @if(request('stone_type')=='P') selected @endif>Precious</option>
										<option value="SP" @if (request('stone_type') == 'SP') selected @endif>Semi Precious</option>
										<option value="UR" @if (request('stone_type') == 'UR') selected @endif>Up Rattan</option>
										<option value="G" @if (request('stone_type') == 'G') selected @endif>Genetral</option>
                              </select>
                      </div> --}}


                <div class="form-group">
                            <label for="search">Select Shape</label>
                               <select class="form-control rm06 basic-select" name="shape" id="shape">
                                  <option value="">Select Shape</option>
                                  @foreach(@$shape as $value)
                                  <option value="{{@$value->id}}"  @if(request('shape')==@$value->id) selected @endif>{{@$value->shapes}}</option>
                                  @endforeach
                      
                              </select>
                      </div>

                      <div class="form-group">
                            <label for="search">Select Cuts</label>
                               <select class="form-control rm06 basic-select" name="cut" id="cut">
                                  <option value="">Select Cuts</option>
                                  @foreach(@$cut as $value)
                                  <option value="{{@$value->id}}" @if(request('cut')==@$value->id) selected @endif>{{@$value->cuts}}</option>
                                  @endforeach
                      
                              </select>
                      </div> 



                       {{-- <div class="form-group">
                            <label for="search">Select Color</label>
                               <select class="form-control rm06 basic-select" name="color" id="color">
                                  <option value="">Select Color</option>
                                  @foreach(@$color as $value)
                                  <option value="{{@$value->id}}" @if(request('color')==@$value->id) selected @endif>{{@$value->color}}</option>
                                  @endforeach
                      
                              </select>
                      </div>   --}}   
                      {{-- <div class="clearfix"></div>  --}}

                  

                  <div class="form-group">
                    <label for=""> Price Range</label>
                     <div class="slider_rnge">
                                            <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                                <div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 100%;"></div>
                                                <span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%;"></span>
                                                <span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all"
                                                    style="left: 100%;"></span>
                                            </div> <span class="range-text">
                                                <input type="text" class="price_numb" readonly id="amount" name="amount">
                                                <input type="hidden" class="price_numb"  id="amount1" name="amount1">
                                                <input type="hidden" class="price_numb"  id="amount2" name="amount2">
                                            </span>
                                        </div>
                                     {{-- <div class="clearfix"></div> --}}
                  </div>

                  <div class="clearfix"></div>



                  

                  <div class="form-group">
                    <label for="FullName">Status</label>
                   <select class="form-control rm06 basic-select" name="status">
                   		<option value="">Select Status</option>
                        <option value="A" @if(request('status')=='A') selected @endif>Active</option>
                        <option value="I" @if(request('status')=='I') selected @endif>Inactive</option>
                    </select>
                  </div>                  

                  <div class="form-group">
                    <label for="FullName">Availability</label>
                   <select class="form-control rm06 basic-select" name="avail">
                      <option value="">Select Availability</option>
                      <option value="Y" @if(request('avail')=='Y') selected @endif>Yes</option>
                      <option value="N" @if(request('avail')=='N') selected @endif>No</option>
                    </select>
                  </div>
                  {{-- <div class="clearfix"></div> --}}

                  <div class="form-group">
                    <label for="FullName">Lab Certified</label>
                   <select class="form-control rm06basic-select" name="lab">
                      <option value="">Select</option>
                      <option value="Y" @if(request('lab')=='Y') selected @endif>Yes</option>
                      <option value="N" @if(request('lab')=='N') selected @endif>No</option>
                    </select>
                  </div>
				  {{-- <div class="clearfix"></div> --}}
				  
				  
				  
				  <div class="form-group">
                    <label for="FullName">COD Available?</label>
                   <select class="form-control rm06 basic-select" name="is_cod_available">
                      <option value="">Select</option>
                      <option value="Y" @if(request('is_cod_available')=='Y') selected @endif>Yes</option>
                      <option value="N" @if(request('is_cod_available')=='N') selected @endif>No</option>
                    </select>
                  </div>

                  <div class="clearfix"></div>

                  <div class="form-group">
                    <label for="FullName">Treatment</label>
                   <select class="form-control rm06 basic-select" name="treatment">
                      <option value="">Select</option>
                      @foreach(@$treatment as $value)
                      <option value="{{@$value->slug}}" @if(request('treatment')==@$value->slug) selected @endif>{{@$value->name}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="FullName">Discount</label>
                   <select class="form-control rm06 basic-select" name="discount">
                      <option value="">Select</option>
                      <option value="20" @if(request('discount')==20) selected @endif>Upto 20%</option>
                      <option value="35" @if(request('discount')==35) selected @endif>Upto 35%</option>
                      <option value="50" @if(request('discount')==50) selected @endif>Upto 50%</option>
                    </select>
                  </div>

                  <div class="clearfix"></div>
                  <div class="rm05 marl0">
                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Search</button>
                  </div>
                </form>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  	@include('admin.includes.message')
                    <h4 class="count_heading">Total Number Of Gemstones : {{@$gemstone_count}}</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Gemstone Id</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Image </th>
                            <th>Price/Discount </th>
                            <th>Stone Type</th>
                            <th>Availability</th>
                            <th>Status</th>
                            <th>Show At Home</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$gemstones->isNotEmpty())
                        @foreach(@$gemstones as $product)
                          <tr>
                            <td>{{@$product->product_code}}</td>
                            <td>
							@if(@$product->title->title)
							@if(strlen(@$product->title->title) >60)
                               {!! substr(@$product->title->title, 0, 60 ) . '...' !!}
                               @else
                               {{@$product->title->title}}
                              @endif
							  @else
                             @if(@$product->product_name!="") 
                              @if(strlen(@$product->product_name) >60)
                                {!! substr(@$product->product_name, 0, 60 ) . '...' !!}
                              @else
                              {{@$product->product_name}}
                              @endif
                              @endif
                              @endif
                            </td>
                            <td>{{@$product->gemcategory->category_name}}</td>
                            <td>
                            @if(@$product->productdefault!="")
                                  <img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$product->productdefault->image}}" style="width:65px;height: 68px">
                            @else
                                    No Image
                             @endif
                           </td>
                            {{-- <td>{{@$product->product_weight}}g.m.</td> --}}
                            <td>
                              Rs. {{round(@$product->price_inr,2)}}
                              @if(@$product->discount_inr>0)
                              / {{@$product->discount_inr}}%
                             {{--  @php
                              $old_price = $product->price_inr;
                              $discount_value = ($old_price / 100) * @$product->discount_inr;
                              $new_price = $old_price - $discount_value;
                              @endphp --}}
                              {{-- /₹{{round(@$new_price,2)}} --}}
                              @endif
                              <br>
                               USD {{round(@$product->price_usd,2)}}
                              @if(@$product->discount_usd>0)
                              / {{@$product->discount_usd}}%
                             {{--  @php
                              $old_price = $product->price_usd;
                              $discount_value = ($old_price / 100) * @$product->discount_usd;
                              $new_price = $old_price - $discount_value;
                              @endphp
                              /${{round(@$new_price,2)}} --}}
                              @endif





                              </td>
                              <td>@if(@$product->stone_type=='P') Precious @elseif(@$product->stone_type=='SP') Semi precious @elseif(@$product->stone_type=='UR') Up Rattan @elseif(@$product->stone_type=='G') General @endif</td>
                              <td>
                                @if(@$product->availability=="Y")
                                Yes
                                @else
                                No
                                @endif
                              </td>

                            <td class="@if($product->status=='A') green @elseif($product->status=='I') cancel @endif">
                            	@if(@$product->status=="A")
                            	Active
                            	@elseif(@$product->status=="I")
                            	Inactive
                            	@endif
                            </td>

                            <td class="@if($product->is_show=='Y') green @elseif($product->status=='N') cancel @endif">
                              @if(@$product->is_show=="Y")
                              Yes
                              @elseif(@$product->is_show=="N")
                              No
                              @endif
                            </td>
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{$product->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$product->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                    <li><a href="{{route('admin.manage.edit-gemstone',['id'=>@$product->id])}}">Edit</a></li>
                                    <li><a href="{{route('admin.manage.gemstone.delete',['id'=>@$product->id])}}"
                                    	onclick="return confirm('Do you want to delete this gemstone?')">Delete</a></li>
                                      <li><a href="{{route('admin.manage.faq.gamestone',['id'=>@$product->id])}}"
                                      >Faq</a></li>
                                    <li><a href="{{route('admin.manage.gemstone.status',['id'=>@$product->id])}}"
                                    	onclick="return confirm('Do you want to change status for this gemstone?')">
                                  @if(@$product->status=="A")
		                            	Inactive
		                            	@elseif(@$product->status=="I")
		                            	Active
		                            	@endif
                                    </a></li>
                                  @if(@$product->is_show=="N")
                                  <li><a href="{{route('admin.manage.gemstone.show-at-home',['id'=>@$product->id])}}"
                                      onclick="return confirm('Do you want to show this gemstone at home ?')">Show At Home</a></li>
                                  @else
                                  <li><a href="{{route('admin.manage.gemstone.show-at-home',['id'=>@$product->id])}}"
                                      onclick="return confirm('Do you want to remove this gemstone from home?')">Remove From Home</a></li>
                                 @endif
								 <li><a href="{{route('admin.manage.add-gemstone-price',['id'=>@$product->id])}}">Manage Price</a></li>
                                </ul>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                          @else
                          <tr><td>No Gemstones added</td></tr>
                          @endif
                        </tbody>
                      </table>
                    </div>


                    <ul class="pagination rtg">
                      {{@$gemstones->links()}}
                    </ul>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End row -->

      </div>
      <!-- container -->

    </div>
    <!-- content -->

    @include('admin.includes.footer')
  </div>
 @endsection

@section('script')
@include('admin.includes.script')
<script>
  $(document).ready(function(){
        var value1 = '{{@$request['amount1']}}';
        var value2 = '{{@$request['amount2']}}';
        if(value1==''){
            value1=0;
        }else{
          value1 = '{{@$request['amount1']}}';
        }
        if(value2==''){
            value2 = '{{@$max_price?@$max_price:10000}}';
        }else{
          value2 = '{{@$request['amount2']}}';
        }
        console.log(value2,value1);
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: '{{@$max_price?@$max_price:10000}}',
            values: [value1, value2],
            slide: function(event, ui) {
                $("#amount").val("Rs " + ui.values[0] + " - Rs " + ui.values[1]);
                $("#amount1").val(ui.values[0]);
                $("#amount2").val(ui.values[1]);
            }
        });
        $("#amount").val("Rs " + $("#slider-range").slider("values", 0) + " - Rs " + $("#slider-range").slider("values", 1));
        $("#amount1").val($("#slider-range").slider("values", 0));
        $("#amount2").val($("#slider-range").slider("values", 1));




  /* Menu Start */
  $('#sm').mouseover(function() {
    $(this).show();
  });
  $('#sm').mouseout(function() {
    $(this).hide();
  });
  $('#m1').mouseover(function() {
    $('.all_menu').show();
    $('#sm').show();
  });
  var column = 4
  var wWidth = $(window).width()
  if(wWidth >= 767 && wWidth <= 991) {
    column = 3
  } else if(wWidth >= 575 && wWidth < 767) {
    column = 2
  }

  $('#m1, #m2 ').mouseleave(function() {
    $('#sm').hide();
    $('#sm1, #sm2').hide();
  });
  /* Menu Start */
  $('#paste-lan').click(function() {
    $('.open-lan').toggle();
  });
  $('.open-lan').find('a').click(function() {
    var lang = $(this).data("id");
    if(lang == 'english') {
      $('#paste-lan').html('<img src="images/english-flag1.png" alt="">');
    } else {
      $('#paste-lan').html('<img src="images/arabic-flag1.png" alt="">');
    }
    $('.open-lan').hide();
  });
});
  </script>
<script type="text/javascript">
    $(".rtg li a").click(function(){
      
      
      var url = $(this).attr('href');
      
      

      var vars = [], hash;
      var hashes = url.slice(window.location.href.indexOf('?') + 1).split('&');
      for(var i = 0; i < hashes.length; i++)
      {
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
      }
      // console.log(hash[1]);
      $('#page').val(hash[1]);
      $("#search_form").submit();
      return false;
    });
  @foreach (@$gemstones as $product)
    $("#action{{$product->id}}").click(function(){
        $('.show-actions:not(#show-{{$product->id}})').slideUp();
        $("#show-{{$product->id}}").slideToggle();
    });
 @endforeach

 </script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
 <script>
    $(document).ready(function(){
       $("#search_form").validate({
            rules: {
                weight: {
                   number:true,
           },

          },
            
        messages: {
              weight:{ 
              number:'Weight must be a number', 
            },
        },

        });
    })
</script>


@endsection
