@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Transaction</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
  #error{
    color: red;
    display: none;
  }
  #form_error{
      color: red;
    display: none;
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
            <h4 class="pull-left page-title">Manage Transaction </h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading rm02 rm04">
                <form role="form" class="search_filter" method="post" action="{{route('admin.manage.transaction.search')}}">
                  @csrf
                  <div class="form-group">
                    <label for="FullName">From</label>
                    <input type="date" placeholder="From" class="form-control from_date" value="{{request('from_date')}}"
name="from_date">
<span id="form_error">Please select from date.</span>
                  </div>
                  <div class="form-group">
                    <label for="">To</label>
                    <input type="date" placeholder="To" class="form-control to_date" value="{{request('to_date')}}"
name="to_date">
<span id="error">To date must be from start date.</span>
                  </div>
                  <div class="form-group">
                    <label for="">Order Id</label>
                    <input type="text" placeholder="Order Id" class="form-control" name="keyword" value="{{request('keyword')}}">
                  </div>
                  
                  <div class="rm05">
                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Search</button>
                  </div>
                </form>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Order Id</th>
                            <th>Customer name</th>
                            <th>Astrologer Name/Pundits Name</th>
                            <th>Date</th>
                            <th>Net Amount</th>                            
                            <th>Commission</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$transactions->isNotEmpty()) 
                        @foreach(@$transactions as $transaction)
                          <tr>
                            <td>{{@$transaction->order_id}}</td>
                            <td>{{@$transaction->customer->first_name}} {{@$transaction->customer->last_name}}</td>
                            <td>{{@$transaction->astrologer->first_name}} {{@$transaction->astrologer->first_name}}</td>
                            <td>{{date('d/m/Y', strtotime(@$transaction->date))}}</td>
                            <td>₹{{@$transaction->total_rate}}</td>
                            <td>₹{{@$transaction->commission}}</td>
                          </tr>
                          @endforeach
                          @else
                          <tr><td>No Data</td></tr>
                        @endif
                          
                          
                        </tbody>
                      </table>
                    </div>
                    
                    
                    <ul class="pagination">
                       {{@$transactions->appends(request()->except(['page', '_token']))->links()}}
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

    $('.search_filter').on('submit', function() {
      var to = $('.to_date').val();
     

      if (to!="") {
      var from = $('.from_date').val();
      if ($('.from_date').val()=="") {
        $("#form_error").show();
        // setTimeout(function() { $("#form_date").hide();},2000);
        return false;
      }
      if(Date.parse(from) > Date.parse(to)){
          $("#error").show();
          // setTimeout(function() { $("#error").hide(); },10000);
          return false;
        }
      }

    });


</script>
@endsection