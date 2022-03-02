@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Ring Pendent Price</title>
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
                    <h4 class="pull-left page-title">Manage Ring Pendent Price</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.ring-pendent-price.add-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add </a></li>
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
                            <form role="form" action="{{route('admin.manage.ring-pendent-price')}}" method="post" id="search_form">
                             @csrf
                             <input type="hidden" name="page" value="" id="page">
                            <div class="form-group ">
                                                <label for="FullName">Type</label>
                                               <select class="form-control rm06 basic-select" name="type_id" id="type_id">
                                                  <option value="">Select Type</option>
                                                  <option value="P" @if(request('type_id')=="P") selected @endif>Pendent</option>
                                                  <option value="R" @if(request('type_id')=="R") selected @endif>Ring</option>
                                                  
                                               </select>
                                       </div>

                                   <div class="form-group ">
                                                <label for="FullName">Metal Type</label>
                                               <select class="form-control rm06 basic-select" name="metal_type_id" id="metal_type_id">
                                                  <option value="">Select Metal Type</option>
                                                  <option value="P" @if(request('metal_type_id')=="P") selected @endif>Panchdhatu</option>
                                                  <option value="S" @if(request('metal_type_id')=="S") selected @endif>Silver</option>
                                                  
                                               </select>
                                       </div>  
                                <div class="form-group">
                                    <label for="FullName">Weight</label>
                                    <input type="text" id="FullName" class="form-control" value="{{request('weight')}}" name="weight" placeholder="Weight">
                                </div> 
                                <div class="rm05" style="margin-top: 25px;">
                                    <button class="btn btn-primary waves-effect waves-light w-md"
                                        type="submit">Search</button>
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
                                                    <th>Type</th>
                                                    <th>Metal Type</th>
                                                    <th>Price INR</th>
                                                    <th>Price USD</th>
                                                    <th>Price INR (Pendent With Chain)</th>
                                                    <th>Price USD (Pendent With Chain)</th>
                                                    <th>Weight (gm)</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$rings->isNotEmpty())
                                                @foreach (@$rings as $value)
                                                <tr>
                                                    <td>@if(@$value->type=="R")Ring @else Pendent @endif</td>
                                                    <td>@if(@$value->metal_type=="S")Silver @else Panchdhatu @endif</td>
                                                    <td>
                                                        {{@$value->price_inr}} INR
                                                    </td>
                                                    <td>
                                                        {{@$value->price_usd}} USD
                                                    </td>

                                                    <td>
                                                        @if(@$value->type=="P") {{@$value->with_chain_price_inr}} INR @else -- @endif
                                                    </td>

                                                    <td>
                                                        @if(@$value->type=="P") {{@$value->with_chain_price_usd}} USD @else -- @endif
                                                    </td>

                                                    <td>@if(@$value->weight!=""){{@$value->weight}} @else -- @endif</td>

                                                    

                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>                                                                
                                                                <li><a href="{{route('admin.manage.ring-pendent-price.edit',['id'=>@$value->id])}}">Edit</a></li>
                                                                <li><a href="{{route('admin.manage.ring-pendent-price.delete',['id'=>@$value->id])}}" onclick="return confirm('Do you want to delete this data ?')">Delete</a></li>
																
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr><td colspan="4"><center> No Data </center></td></tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <ul class="pagination rtg">
                                        {{@$rings->links()}}
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
<!-- ============================================================== -->

@endsection

@section('script')
@include('admin.includes.script')

<script>
    $(document).ready(function(){
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
  @foreach (@$rings as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
});
</script>
@endsection
