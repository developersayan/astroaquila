@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Product </title>
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
            <h4 class="pull-left page-title">Manage Product</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.add-product-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
              <li class="active"><a href="{{route('admin.product.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <div class="clearfix"></div>
            <div class="panel panel-default">

              <div class="panel-heading rm02 rm04">

                <form role="form" method="post" action="{{route('admin.manage.product.search')}}" id="search_form">
                  @csrf
                   <input type="hidden" name="page" value="" id="page">
                  <div class="form-group">
                            <label for="search">Select Category</label>
                               <select class="form-control rm06 basic-select" name="category" id="category">
                                    <option value="">Select Category</option>
                                      @if(@$product_categories->isNotEmpty())
                                         @foreach(@$product_categories as $category)
                                                 <option value="{{@$category->id}}" @if(request('category')==@$category->id) selected @endif>{{@$category->name}}</option>
                                                 @endforeach
                                                  @else
                                                  <option value="">No Category Added</option>
                                        @endif
                              </select>
                      </div>
					  <div class="form-group">
                            <label for="search">Select Sub Category</label>
                               <select class="form-control rm06 basic-select" name="sub_category" id="sub_category">
                                    <option value="">Select Sub Category</option>
                                      @if(@$sub_categories)
                                         @foreach(@$sub_categories as $scategory)
                                                 <option value="{{@$scategory->id}}" @if(request('sub_category')==@$scategory->id) selected @endif>{{@$scategory->name}}</option>
                                                 @endforeach
                                                  @else
                                                  <option value="">No Category Added</option>
                                        @endif
                              </select>
                      </div>
					  

                  <div class="form-group">
                    <label for="FullName">keyword</label>
                    <input type="text" placeholder="keyword" class="form-control" name="keyword" value="{{request('keyword')}}">
                  </div>

                  <div class="form-group malti_select ">
                                               <label for="FullName">Select Planet</label>
                                               <select class="chosen-select form-control " multiple data-placeholder="Select Planets" name="planets[]" id="planets_filter">
                                        @foreach($planets as $planet )
                                        <option value="{{ $planet->id }}" {{ @in_array($planet->id, @$request['planets'])?'selected':''}}>{{@$planet->planet_name}}</option>
                                        @endforeach

                                    </select>
                                            </div>


                  

                   <div class="form-group malti_select ">
                                               <label for="FullName">Select Deity</label>
                                               <select class="chosen-select form-control " multiple data-placeholder="Select Deity" name="deity[]" id="deity_filter">
                                        @foreach($deity as $value )
                                        <option value="{{ $value->id }}" {{ @in_array($value->id, @$request['deity'])?'selected':''}}>{{@$value->name}}</option>
                                        @endforeach

                                    </select>
                        </div>

                                          {{-- <div class="clearfix"></div> --}}
                                           

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


                  <div class="form-group">
                    <label for="FullName">Purpose</label>
                   <select class="form-control rm06 basic-select" name="purpose">
                      <option value="">Select Purpose</option>
                        @foreach(@$purpose as $value)
                        <option  value="{{@$value->id}}" @if(request('purpose')==@$value->id) selected @endif>{{@$value->name}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="clearfix"></div>

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
                                     <div class="clearfix"></div>
                  </div>




                  <div class="form-group">
                    <label for="FullName">Status</label>
                   <select class="form-control rm06 basic-select" name="status">
                   		<option value="">Select Status</option>
                        <option value="A" @if(request('status')=='A') selected @endif>Active</option>
                        <option value="I" @if(request('status')=='I') selected @endif>Inactive</option>
                    </select>
                  </div>


                  <div class="form-group">
                    <label for="FullName">Seller</label>
                   <select class="form-control rm06 basic-select" name="seller">
                      <option value="">Select Seller</option>
                      @foreach(@$sellers as $seller)
                      <option value="{{@$seller->id}}" @if(request('seller')==@$seller->id) selected @endif>{{@$seller->seller_name}}</option>
                      @endforeach

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

                  <div class="clearfix"></div>

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
                    <h4 class="count_heading">Total Number Of Products : {{@$product_count}}</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Product Id</th>
                            <th>Title</th>
                            <th> Category</th>
                            <th>Sub Category</th>
                            <th> Image </th>
                            <th>Price/Discount </th>
                            <th>Seller Name</th>
                            <th>Availability</th>
                            <th>Status</th>
                            <th>Show At Home</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$products->isNotEmpty())
                        @foreach(@$products as $product)
                          <tr>
                            <td>{{@$product->product_code}}</td>
                            <td>
                              @if(strlen(@$product->product_name) >60)
                                {!! substr(@$product->product_name, 0, 60 ) . '...' !!}
                              @else
                              {{@$product->product_name}}
                              @endif
                            </td>
                            <td>{{@$product->productscat->name}}</td>
                            <td>@if(@$product->sub_category_id!=""){{@$product->products_subcat->name}}@else ---- @endif</td>
                            <td>
                            @if(@$product->productdefault!="")
                                  <img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$product->productdefault->image}}" style="width:65px;height: 68px">
                            @else
                                    No Image
                             @endif
                           </td>
                            {{-- <td>{{@$product->product_weight}}g.m.</td> --}}
                            <td>
                              INR {{round(@$product->price_inr,2)}}
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
                              <td>{{@$product->seller->seller_name}}</td>
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
                                    <li><a href="{{route('admin.manage.edit-product',['id'=>@$product->id])}}">Edit</a></li>
                                    <li><a href="{{route('admin.manage.product.delete',['id'=>@$product->id])}}"
                                    	onclick="return confirm('Do you want to delete this product?')">Delete</a></li>
                                      <li><a href="{{route('admin.manage.faq.product',['id'=>@$product->id])}}"
                                      >Faq</a></li>
                                    <li><a href="{{route('admin.manage.product.status',['id'=>@$product->id])}}"
                                    	onclick="return confirm('Do you want to change status for this product?')">
                                  @if(@$product->status=="A")
		                            	Inactive
		                            	@elseif(@$product->status=="I")
		                            	Active
		                            	@endif
                                    </a></li>
                                  @if(@$product->is_show=="N")
                                  <li><a href="{{route('admin.manage.product.show-at-home',['id'=>@$product->id])}}"
                                      onclick="return confirm('Do you want to show this product at home ?')">Show At Home</a></li>
                                  @else
                                  <li><a href="{{route('admin.manage.product.show-at-home',['id'=>@$product->id])}}"
                                      onclick="return confirm('Do you want to remove this product from home?')">Remove From Home</a></li>
                                 @endif
                                </ul>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                          @else
                          <tr><td>No Products</td></tr>
                          @endif
                        </tbody>
                      </table>
                    </div>


                    <ul class="pagination rtg">
                      {{@$products->links()}}
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

  $(document).ready(function(){
    $('#category').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      // $('#sub_category_id').html('<option value=''>Select Sub Categorys</option>');
      $.ajax({
        url:'{{route('admin.manage.get.sub-category')}}',
        type:'GET',
        data:{category:id},
        success:function(data){
          console.log(data);
          if (data.subcategories=="<option value=''>Select Sub Category</option>") {
            $('#sub_category').html(data.subcategories);
            // $('#sub_category_id').prop('required',false);

          }else{
            $('#sub_category').html(data.subcategories);
            // $('#sub_category_id').prop('required',true);
         }
        }
      })
    })
  })
</script>
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
                $("#amount").val("INR " + ui.values[0] + " - INR " + ui.values[1]);
                $("#amount1").val(ui.values[0]);
                $("#amount2").val(ui.values[1]);
            }
        });
        $("#amount").val("INR " + $("#slider-range").slider("values", 0) + " - INR " + $("#slider-range").slider("values", 1));
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
    // var lang = '';// $('.open-lan').children('li').children('a').data('id');
    // //alert(lang);
    // if(lang == 'english') {
    //   $('#paste-lan').html('<img src="images/english-flag1.png" alt="">')
    //   $('.open-lan').css('display', 'none');
    // } else {
    //   if(lang == 'arabic') {
    //     $('#paste-lan').html('src="images/arabic-flag1.png"')
    //     $('.open-lan').css('display', 'none');
    //   } else {
    //     $('.open-lan').css('display', 'none');
    //   }
    // }
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
  @foreach (@$products as $product)

    $("#action{{$product->id}}").click(function(){
        $('.show-actions:not(#show-{{$product->id}})').slideUp();
        $("#show-{{$product->id}}").slideToggle();
    });
 @endforeach
 </script>


@endsection
