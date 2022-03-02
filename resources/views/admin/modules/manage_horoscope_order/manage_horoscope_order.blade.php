@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Horoscope Order </title>
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
.add_puja_link{
  cursor: pointer;
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
            <h4 class="pull-left page-title">Manage Horoscope Order</h4>
            <ol class="breadcrumb pull-right">
              {{-- <li class="active"><a href="{{route('admin.manage.add-product-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li> --}}
              <li class="active"><a href="{{route('admin.order.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <div class="clearfix"></div>
            <div class="panel panel-default">
              
              <div class="panel-heading rm02 rm04">

                <form role="form" method="post" action="{{route('admin.manage.horoscope.order')}}" class="search_filter" id="search_form">
                  @csrf
                 
                  <input type="hidden" name="page" value="" id="page">
                  <div class="form-group">
                    <label for="FullName">keyword</label>
                    <input type="text" placeholder="keyword" class="form-control" name="keyword" value="{{request('keyword')}}">
                  </div>


                  <div class="form-group">
                    <label for="FullName">From</label>
                   <input type="text" name="from_date" value="{{request('from_date')}}" id="datepicker" placeholder="{{__('profile.from_placeholder')}}" class="position-relative from_date">

                  </div>
                  <div class="form-group">
                    <label for="">To</label>
                   <input type="text" name="to_date" value="{{request('to_date')}}" id="datepicker1" placeholder="{{__('profile.to_placeholder')}}" class="position-relative to_date">

                  </div>

                 

                  <div class="form-group">
                    <label for="FullName">Order No</label>
                    <input type="text" placeholder="Order no" class="form-control" name="order_id" value="{{request('order_id')}}">
                  </div>
                   <div class="clearfix"></div>
                  <div class="form-group">
                    <label for="FullName">Horoscope</label>
                   <select class="form-control rm06 basic-select" name="horoscope">
                      <option value="">Select Horoscope</option>
                      @foreach(@$horoscope as $value)
                      <option value="{{@$value->id}}" @if(request('horoscope')==@$value->id) selected @endif>{{@$value->name}}</option>
                      @endforeach
                                                    
                    </select>
                  </div>

                  {{-- <div class="form-group">
                        <label for="FullName">Status</label>
                        <select class="form-control rm06 basic-select" name="status">
                            <option value="">Select Status</option>
                            <option value="CA" @if(request('status')=='CA') selected @endif>Cancel</option>
                            <option value="N" @if(request('status')=='N') selected @endif>New</option>
                        </select>
                  </div> --}}

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
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Order Id</th>
                            <th>Person Name</th>
                            <th>Horoscope Name</th>
                            <th>Order Date</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            {{-- <th>Gender</th> --}}
                            <th>Total Price</th>
                            <th>Status</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$order->isNotEmpty())
                        @foreach(@$order as $value)
                          <tr>
                            <td><a href="{{route('admin.manage.horoscope.order.view',['id'=>@$value->id])}}">{{@$value->order_id}}</a></td>
                            <td>{{@$value->name}}</td>
                            <td>{{@$value->horoscope->name}}</td>
                            <td>{{date('d/m/Y',strtotime(@$value->date))}}</td>
                            <td>{{@$value->email}}</td>
                            <td>{{@$value->phone_no}}</td>
                            {{-- <td>@if(@$value->gender=="M")Male @elseif(@$value->gender=="F") Female @else Others @endif</td> --}}
                            <td> {{@$value->currencyDetails->currency_code}} {{@$value->total_rate}}</td>
                            <td>
                              @if(@$value->status=="I")
                              Initiated
                              @elseif(@$value->status=="N")
                              New
                              @elseif(@$value->status=="C")
                              Completed
                              @elseif(@$value->status=="CA")
                              Canceled
                              @elseif(@$value->status=="IP")
                              Inprocess
                              @elseif(@$value->status=="A")
                              Accepted
                              @endif
                            </td>
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                    <li><a href="{{route('admin.manage.horoscope.order.view',['id'=>@$value->id])}}"
                                    	>View</a></li>
                                      {{-- @if(@$value->status=="N")
                                      <li><a href="{{route('admin.manage.horoscope.order.cancel',['id'=>@$value->id])}}" onclick="return confirm('Do you want to Cancel this order?')"
                                      >Cancel</a></li>
                                      @endif --}}
                                 </ul>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                          @else
                          <tr><td>No Order Found</td></tr>
                          @endif 
                        </tbody>
                      </table>
                    </div>
                    
                    
                    <ul class="pagination rtg">
                      {{@$order->links()}}
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
  @foreach (@$order as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
 </script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>




<script>
    $( function() {
        $( "#datepicker" ).datepicker();
        $( "#datepicker1" ).datepicker();
    });
      $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/dd/yy',
        onClose: function (selectedDate, inst) {
            console.log(selectedDate, Date.parse(selectedDate));
            let minDate = new Date(selectedDate);
            minDate.setDate(minDate.getDate());
            var selectedDate = $('#datepicker').datepicker('getDate');
            selectedDate.setDate(selectedDate.getDate()+1);
            $("#datepicker1").datepicker("option", "minDate", selectedDate);
            $('#datepicker1').datepicker('show');
        }
    });
    $("#datepicker1").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/dd/yy',
        onClose: function (selectedDate, inst) {
            var selectedDate = $('#datepicker1').datepicker('getDate');
            if(selectedDate==''|| selectedDate==null || selectedDate==undefined){
            }else{
                selectedDate.setDate(selectedDate.getDate()-1);
                $("#datepicker").datepicker("option", "maxDate", selectedDate);
            }
        }
    });
</script>
<script type="text/javascript">

$(document).ready(function(){
        $(".search_filter").validate({
            rules: {
                to_date:{
                    required: function(){
                        var from_date = $('#datepicker').val();
                        if(from_date !=''){
                            return true
                        }else{
                            return false
                        }
                    },
                },
                from_date:{
                    required:function(){
                        var to_date = $('#datepicker1').val();
                        if(to_date !=''){
                            return true
                        }else{
                            return false
                        }
                    },
                },
            },
            messages: {
                to_date:{
                    required: 'To Date Enter',
                },
                from_date:{
                    required: 'From Date Enter',
                },
            },
        });
    });


</script>


@endsection