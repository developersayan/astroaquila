@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Puja</title>
@endsection

@section('style')
@include('admin.includes.style')
{{-- <style type="text/css">
  .select-pure__options{
    height: 135px !important;
  }
</style> --}}
<style type="text/css">
  .panel-default > .panel-heading {
  overflow: visible;
}
</style>
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')
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
            <h4 class="pull-left page-title">Manage Puja</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.puja.add')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Puja</a></li>
              <li class="active"><a href="{{route('admin.puja.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-heading rm02 rm04">
                <form role="form" method="post" action="{{route('admin.manage.puja.search')}}" id="search_form">
                	@csrf
                  <input type="hidden" name="page" value="" id="page">
                  <div class="form-group">
                                                  <label for="FullName">Puja Category</label>
                                                 <select class="form-control rm06 basic-select" name="category_id" id="category_id">
                                                  <option value="">Select Category</option>
                                                  @foreach(@$category as $value)
                                                    <option value="{{@$value->id}}" @if(request('category_id')==@$value->id) selected @endif>{{@$value->name}}</option>
                                                    @endforeach

                                                 </select>
                                                 <div id="error_category"></div>
                                           </div>

                                           <div class="form-group">
                            <label for="search">Select Sub Category</label>
                               <select class="form-control rm06 basic-select" name="sub_category_id" id="sub_category_id">
                                    <option value="">Select Sub Category</option>
                                      @if(@$sub_categories)
                                         @foreach(@$sub_categories as $scategory)
                                                 <option value="{{@$scategory->id}}" @if(request('sub_category_id')==@$scategory->id) selected @endif>{{@$scategory->name}}</option>
                                                 @endforeach
                                                  @else
                                                  {{-- <option value="">No Category Added</option> --}}
                                        @endif
                              </select>
                      </div>

            <div class="form-group">
                    <label for="FullName">Keyword</label>
                    <input type="text" placeholder="Keyword" class="form-control" name="name" value="{{request('name')}}">
                  </div>
                            
						<div class="form-group malti_select ">
                                               <label for="FullName">Select Planet</label>
                                               <select class="chosen-select form-control " multiple data-placeholder="Select Planets" name="planets[]" id="planets_filter">
                                        @foreach($planets as $planet )
                                        <option value="{{ $planet->id }}" {{ @in_array($planet->id, @$request['planets'])?'selected':''}}>{{@$planet->planet_name}}</option>
                                        @endforeach

                                    </select>
                                               {{-- <label id="language-error" class="error" for="language" style="display: none;">{{__('profile.required_language')}}</label> --}}
                                            </div>



                  
                  <div class="clearfix"></div>




                   {{--  <input type="hidden" name="deity" id="deity">
                     <input type="hidden" name="purpose" id="purpose">
                      <input type="hidden" name="rashi" id="rashi">
                      <input type="hidden" name="nakshatra" id="nakshatra">
                      <input type="hidden" name="planets" id="planets"> --}}
                    <div class="form-group malti_select ">
                                               <label for="FullName">Select Deity</label>
                                               <select class="chosen-select form-control " multiple data-placeholder="Select Deity" name="deity[]" id="deity_filter">
                                        @foreach($deity as $deity )
                                        <option value="{{ $deity->id }}" {{ @in_array($deity->id, @$request['deity'])?'selected':''}}>{{@$deity->name}}</option>
                                        @endforeach

                                    </select>
                                            </div>

                                          {{-- <div class="clearfix"></div> --}}
                                           <div class="form-group malti_select ">
                                               <label for="FullName">Select Purpose</label>
                                              <select class="chosen-select form-control " multiple data-placeholder="Select Purpose" name="purpose[]" id="purpose">
                                        @foreach($purpose as $value )
                                        <option value="{{ $value->id }}" {{ @in_array($value->id, @$request['purpose'])?'selected':''}}>{{@$value->name}}</option>
                                        @endforeach

                                    </select>
                                            </div>

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

                                            <div class="clearfix"></div>






                  <div class="form-group">
                    <label for=""> Price Range</label>
                    <div class="slider_rnge">
                            <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                              <div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 100%;"></div>
                              <span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%;"></span> <span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 100%;"></span> </div> <span class="range-text">
                                      <input type="text" class="price_numb" readonly id="amount" name="amount">
                                                <input type="hidden" class="price_numb" readonly id="amount1" name="amount1">
                                                <input type="hidden" class="price_numb" readonly id="amount2" name="amount2">
                                     </span> </div>
                                     <div class="clearfix"></div>
                  </div>

                   <div class="form-group">
                                                  <label for="FullName">Type Of Puja</label>
                                                 <select class="form-control rm06 basic-select" name="type" id="type">
                                                  <option value="">Select Type Of Puja</option>
                                                   <option value="BOTH" @if(request('type')=="BOTH") selected @endif>Both</option>
                                                  <option value="ONLINE" @if(request('type')=="ONLINE") selected @endif>Online</option>
                                                  <option value="OFFLINE" @if(request('type')=="OFFLINE") selected @endif>Offline</option>
                                                 
                                                 </select>
                                                 <div id="error_category"></div>
                                           </div>
                                           {{-- <div class="clearfix"></div> --}}

                                           <div class="form-group">
                                                  <label for="FullName">Availability</label>
                                                 <select class="form-control rm06 basic-select" name="avail" id="avail">
                                                  <option value="">Select</option>
                                                   <option value="Y" @if(request('avail')=="Y") selected @endif>Yes</option>
                                                  <option value="N" @if(request('avail')=="N") selected @endif>No</option>
                                                  
                                                 
                                                 </select>
                                                 <div id="error_category"></div>
                                           </div>

                                           <div class="form-group">
                                                  <label for="FullName">Puja Name</label>
                                                 <select class="form-control rm06 basic-select" name="puja_id" id="puja_id">
                                                  <option value="">Select</option>
                                                   @foreach(@$puja_name as $value)
                                                    <option value="{{@$value->id}}" @if(request('puja_id')==@$value->id) selected @endif>{{@$value->name}}</option>
                                                    @endforeach
                                                  
                                                 
                                                 </select>
                                                 <div id="error_category"></div>
                                           </div>
                                           <div class="clearfix"></div>
                  <div class="rm05">
                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Search</button>
                  </div>
                </form>
                <div class="clearfix"></div>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  	@include('admin.includes.message')
                    <h4 class="count_heading">Total Number Of Pujas : {{@$puja_count}}</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Puja Id</th>
                            <th>Puja Name</th>
                            <th>Puja Title</th>
                            <th>Puja Category</th>
                            <th>Puja Sub Category</th>
                            <th> Image</th>
                            <th>Price/Discount </th>
                            <th>Show At Home</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$pujas->isNotEmpty())
                        @foreach(@$pujas as $key=> $puja)
                          <tr>
                            <td>{{@$puja->puja_code}}</td>
                            <td>@if(@$puja->puja_id!=""){{@$puja->pujaName->name}} @else -- @endif</td>
                            <td>
                              @if(strlen(@$puja->puja_name) >60)
                                {!! substr(@$puja->puja_name, 0, 60 ) . '...' !!}
                              @else
                              {{@$puja->puja_name}}
                              @endif
                            </td>
                            <td>{{@$puja->category->name}}</td>
                            <td>@if(@$puja->puja_sub_category!=""){{@$puja->subcategory->name}}@else -- @endif</td>
                            <td>@if(@$puja->puja_image!="")<img src="{{ URL::to('storage/app/public/puja_image')}}/{{@$puja->puja_image}}" class="widthimg80"> @else No Image @endif</td>
                            <td>
                              INR {{round(@$puja->price_inr,2)}}
                              @if(@$puja->discount_inr>0)
                              / {{@$puja->discount_inr}}%

                              @endif
                              <br>
                               USD {{round(@$puja->price_usd,2)}}
                              @if(@$puja->discount_usd>0)
                              / {{@$puja->discount_usd}}%

                              @endif
                            </td>
                            <td>@if(@$puja->show_at_home=='Y')Yes @else No @endif</td>
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{$puja->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                             <div class="show-actions" id="show-{{$puja->id}}" style="display: none;">
                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                    <li><a href="{{route('admin.manage.puja.edit',['id'=>@$puja->id])}}">Edit </a></li>
                                    @if(@$puja->show_at_home=='Y')
                                    <li><a href="{{route('admin.manage.puja-show-at-home',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to remove this puja at home ?')">Remove From Home </a></li>
                                    @else
                                    <li><a href="{{route('admin.manage.puja-show-at-home',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to show this puja at home ?')">Show At Home </a></li>
                                    @endif
                                    <li><a href="{{route('admin.manage.puja.delete',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to delete this puja?')">Delete</a></li>
                                    <li><a href="{{route('admin.manage.faq.puja',['id'=>@$puja->id])}}" >Faq</a></li>
                                </ul>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                      	@else
                      	<tr><td>No Data</td></tr>

                      	@endif

                        </tbody>
                      </table>
                    </div>


                    <ul class="pagination rtg">
                      {{@$pujas->links()}}
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
  <!-- ============================================================== -->
  <!-- End Right content here -->
@endsection
@section('script')
@include('admin.includes.script')
  <script>
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
  	 var value1 = '{{request('amount1')}}';
        var value2 = '{{request('amount2')}}';
        if(value1==''){
            value1=0;
        }
        if(value2==''){
            value2 = '{{@$max_price?@$max_price:1000}}';
        }
    $("#slider-range").slider({
    range: true,
    min: 0,
    max: '{{@$max_price?@$max_price:1000}}',
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

 <script>
    $(document).ready(function(){

 @foreach (@$pujas as $puja)

    $("#action{{$puja->id}}").click(function(){
        $('.show-actions:not(#show-{{$puja->id}})').slideUp();
        $("#show-{{$puja->id}}").slideToggle();
    });
 @endforeach
});
</script>
<script type="text/javascript">
 
        var resetAutocomplete = function() {
            autocomplete.reset();
        };

</script>

  <script type="text/javascript">
  $(document).ready(function(){
    $('#category_id').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('admin.manange.puja.get.sub-cat')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#sub_category_id').html(data.sub_cat);
          
        }
      })
    })
  })
</script>
@endsection
