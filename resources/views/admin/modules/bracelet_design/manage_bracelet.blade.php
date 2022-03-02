@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Bracelet Design</title>
@endsection

@section('style')
@include('admin.includes.style')
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
            <h4 class="pull-left page-title">Manage Bracelet Design</h4>
           <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.bracelet.design.add-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add </a></li>
                        <li class="active"><a href="{{route('admin.gemstone.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                    </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading rm02 rm04">
                <form role="form" action="{{route('admin.manage.bracelet.design.search')}}" method="post" id="search_form">
                 @csrf
                 <div class="form-group">
                                                  <label for="FullName">Select Metal</label>
                                                 <select class="form-control rm06 basic-select" name="metal" id="metal">
                                                  <option value="">Select Metal</option>
                                                  
                                                   <option value="G" @if(request('metal')=='G') selected @endif>Gold</option>
                                                   <option value="P" @if(request('metal')=='P') selected @endif>Panchdhatu</option>
                                                   <option value="S" @if(request('metal')=='S') selected @endif>Silver</option>
                                                   
                                                 </select>
                                                 <div id="error_metal"></div>
                                    </div>
                  <div class="form-group">
                    <label for="FullName">Design Name</label>
                    <input type="text" placeholder="Design Name" class="form-control" name="keyword" value="{{request('keyword')}}">
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
                  <div class="rm05">
                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Search</button>
                  </div>
                </form>
              </div>
              <div class="panel-body">
                <div class="row">
                	@include('admin.includes.message')
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Design Name</th>
                            <th>Image</th>
                            <th>Price INR</th>
                            <th>Price USD</th>
                            <th>Metal</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$design->isNotEmpty())
                        @foreach(@$design as $value)
                          <tr>
                            <td>{{@$value->design_name}}</td>
                            <td>@if(@$value->design_picture!="")<img src="{{ URL::to('storage/app/public/bracelet_design')}}/{{@$value->design_picture}}" class="widthimg80"> @else No Image @endif</td>
                            <td>{{@$value->price_inr}} INR</td>
                            <td>{{@$value->price_usd}} USD</td>
                            <td>@if(@$value->metal_type=="G")Gold @elseif(@$value->metal_type=="S") Silver @else Panchdhatu @endif</td>
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{@$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                               <div class="show-actions" id="show-{{@$value->id}}" style="display: none;">
                                 <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                    <li><a href="{{route('admin.manage.bracelet.design.edit',['id'=>@$value->id])}}">Edit</a></li>
                                    <li><a href="{{route('admin.manage.bracelet.design.delete',['id'=>@$value->id])}}"  onclick="return confirm('Do you want to delete this ?')">Delete</a></li>
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
                      {{@$design->links()}}
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
	  @foreach (@$design as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
</script>

<script>
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
@endsection