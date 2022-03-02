@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Gemstone Price </title>
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
            <h4 class="pull-left page-title">Manage Gemstone Price</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.add-gemstone-price')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add</a></li>
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

                <form role="form" method="post" action="{{route('admin.manage.gemstone.price')}}" id="search_form">
                  @csrf
                   <input type="hidden" name="page" value="" id="page">
                  <div class="form-group">
                            <label for="search">Select Gemstone</label>
                               <select class="form-control rm06 basic-select" name="gemstone_id" id="gemstone_id">
                                    <option value="">Select Gemstone</option>
                                      @if(@$gemstones->isNotEmpty())
                                         @foreach(@$gemstones as $gems)
                                                 <option value="{{@$gems->id}}" @if(request('gemstone_id')==@$gems->id) selected @endif>@if(@$gems->product_name!=""){{@$gems->product_name}} ({{@$gems->product_code}}) @else {{@$gems->title->title}} ({{@$gems->product_code}}) @endif </option>
                                                 @endforeach
                                                  @else
                                                  <option value="">No Category Added</option>
                                        @endif
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
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Gemstone Code</th>
                            <th>Gemstone Title</th>
                            <th>Weight (Carat)</th>
                            <th>Base Price (INR)</th>
                            <th>Base Price (USD)</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$gemstone_price->isNotEmpty())
                        @foreach(@$gemstone_price as $product)
                          <tr>
						  <td>{{@$product->gemstoneDetails->product_code}}</td>
                            <td>@if(@$product->gemstoneDetails->product_name!=""){{@$product->gemstoneDetails->product_name}} @else {{@$product->gemstoneDetails->title->title}} @endif</td>
                            <td>{{@$product->gemstoneDetails->product_weight}}</td>
                            <td>{{@$product->gemstoneDetails->price_inr}}</td>
                            <td>{{@$product->gemstoneDetails->price_usd}}</td>
                            
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{$product->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$product->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                    <li><a href="{{route('admin.manage.add-gemstone-price',['id'=>@$product->product_id])}}">Edit</a></li>
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
                      {{@$gemstone_price->links()}}
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
  @foreach (@$gemstone_price as $product)
    $("#action{{$product->id}}").click(function(){
        $('.show-actions:not(#show-{{$product->id}})').slideUp();
        $("#show-{{$product->id}}").slideToggle();
    });
 @endforeach
 </script>
@endsection
