@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Hororscope</title>
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
            <h4 class="pull-left page-title">Manage Hororscope</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.horoscope.add-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Horoscope</a></li>
              <li class="active"><a href="{{route('admin.horoscope.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-heading rm02 rm04">
                <form role="form" method="post" action="{{route('admin.manage.horoscope')}}" id="search_form">
                	@csrf
                  <input type="hidden" name="page" value="" id="page">
                  <div class="form-group">
                                                  <label for="FullName">Horoscope Category</label>
                                                 <select class="form-control rm06 basic-select" name="category_id" id="category_id">
                                                  <option value="">Select Category</option>
                                                  @foreach(@$category as $value)
                                                    <option value="{{@$value->id}}" @if(request('category_id')==@$value->id) selected @endif>{{@$value->name}}</option>
                                                    @endforeach

                                                 </select>
                                                 <div id="error_category"></div>
                                           </div>


                                           <div class="form-group">
                                                  <label for="FullName">Horoscope Title</label>
                                                 <select class="form-control rm06 basic-select" name="title_id" id="title_id">
                                                  <option value="">Select Title</option>
                                                  @foreach(@$title as $value)
                                                    <option value="{{@$value->id}}" @if(request('title_id')==@$value->id) selected @endif>{{@$value->title}}</option>
                                                    @endforeach

                                                 </select>
                                                 <div id="error_category"></div>
                                           </div>


                                      <div class="form-group">
                                              <label for="FullName">Keyword</label>
                                              <input type="text" placeholder="Keyword" class="form-control" name="keyword" value="{{request('keyword')}}">
                                      </div>

                                      <div class="form-group malti_select ">
                                               <label for="FullName">Select Expertise</label>
                                               <select class="chosen-select form-control " multiple data-placeholder="Select Expertise" name="expertise[]" id="nakshatra_filter">
                                                @foreach($expertise as $value )
                                                <option value="{{ $value->id }}" {{ @in_array($value->id, request('expertise'))?'selected':''}}>{{@$value->expertise_name}}</option>
                                                @endforeach
                                                </select>
                                       </div>
                            
						

                                         






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
                                                  <label for="FullName">Status</label>
                                                 <select class="form-control rm06 basic-select" name="status" id="status">
                                                  <option value="">Select</option>
                                                   <option value="A" @if(request('status')=="A") selected @endif>Active</option>
                                                  <option value="I" @if(request('status')=="I") selected @endif>Inactive</option>
                                                  
                                                 
                                                 </select>
                                                 <div id="error_category"></div>
                                           </div>

                                           {{-- <div class="clearfix"></div>  --}}


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
                    <h4 class="count_heading">Total Number Of Horoscope : {{@$horoscope_count}}</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Code</th>
                            <th>Horoscope Name</th>
                            <th>Horoscope Title</th>
                            <th>Horoscope Category</th>
                            <th>Price/Discount </th>
                            <th>Image</th>
                            <th>Status</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$data->isNotEmpty())
                        @foreach(@$data as $key=> $value)
                          <tr>
                            <td>{{@$value->code}}</td>
                            <td>{{@$value->name}}</td>
                            <td>@if(@$value->title_id){{@$value->titleName->title}} @else -- @endif</td>
                            <td>{{@$value->category->name}}</td>
                            <td>
                              INR {{round(@$value->price_inr,2)}}
                              @if(@$value->discount_inr>0)
                              / {{@$value->discount_inr}}%

                              @endif
                              <br>
                               USD {{round(@$value->price_usd,2)}}
                              @if(@$value->discount_usd>0)
                              / {{@$value->discount_usd}}%

                              @endif
                            </td>
                            
                            <td>@if(@$value->image!="")<img src="{{ URL::to('storage/app/public/horoscope_image')}}/{{@$value->image}}" class="widthimg80"> @else No Image @endif</td>
                            <td>@if(@$value->status=="A") Active @else Inactive @endif</td>
                            
                           
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                             <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                    <li><a href="{{route('admin.manage.horoscope.edit-view',['id'=>@$value->id])}}">Edit </a></li>
                                    
                                    <li><a href="{{route('admin.manage.horoscope.status.change',['id'=>@$value->id])}}" onclick="return confirm('Do you want to change the status of this horoscope ?')">@if(@$value->status=="A") Inactive @else Active @endif </a></li>

                                    <li><a href="{{route('admin.manage.horoscope.status.delete',['id'=>@$value->id])}}" onclick="return confirm('Do you want to delete this horoscope?')">Delete</a></li>
                                    
                                    <li><a href="{{route('admin.manage.horoscope.faq',['id'=>@$value->id])}}" >Faq</a></li>
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
                      {{@$data->links()}}
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

 @foreach (@$data as $puja)

    $("#action{{$puja->id}}").click(function(){
        $('.show-actions:not(#show-{{$puja->id}})').slideUp();
        $("#show-{{$puja->id}}").slideToggle();
    });
 @endforeach
});
</script>

@endsection
