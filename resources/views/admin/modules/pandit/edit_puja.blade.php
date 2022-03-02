@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | @if(@$pujaselect)Edit @else Add @endif Pundit Puja</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
  .edit_action li {
    display: inline-block;
    margin: 0 4px;
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
            <h4 class="pull-left page-title">@if(@$pujaselect)Edit @else Add @endif Puja</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.pandit')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
            </ol>
          </div>
        </div>
         <div class="row">
                        <div class="col-lg-12"> 
                        
                        <div class="astro_bac_list">
                          <ul>
                           <li><a href="{{route('admin.pundit.edit-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                            Basic Info</a></li>

                               <li class="actv"><a href="{{route('admin.pundit.edit-puja-view',['id'=>@$data->id])}}">
                                 <img src="{{ URL::to('public/frontend/images/bacicon5.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/bacicon55.png')}}" class="bacicon2" alt="">
                                Puja</a></li>

                            <li>
                            <a href="{{route('admin.pundit.edit-zipcode-view',['id'=>@$data->id])}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Service Area</a>
                          </li>
                            
                            <li><a href="{{route('admin.pundit.edit-avail',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Availability</a></li>
                          </ul>
                        </div>
                        @include('admin.includes.message')  
                        <div> 
                           
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">@if(@$pujaselect)Edit @else Add @endif Puja</h3> 
                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                        <form role="form" id="addpujaform" method="post" enctype="multipart/form-data" action="@if(@$pujaselect) {{route('admin.pundit.update-puja')}} @else {{route('admin.pundit.add-puja')}} @endif">
                                        	@csrf
                                          <input type="hidden" name="user_id" value="{{@$data->id}}">
                                          <input type="hidden" name="puja_id" value="{{@$pujaselect->id}}">
                                          <div class="form-group">
                                                <label for="FullName">Select Puja</label>
                                              <select class="form-control rm06 basic-select" name="puja" id="pujaList" @if(@$pujaselect) disabled="disabled" @endif>
                                               <option value="" data-price='0'>Select Puja</option>
                                                
                                                @foreach ($pujas as $puja)
                                                 <option value="{{$puja->id}}" data-price='{{(int)$puja->price_starting_from}}' @if(@$pujaselect->puja_id==$puja->id) selected @endif>{{$puja->puja_name}}</option>
                                                 @endforeach
                                              </select>
                                                
                                           </div>
                                           
                                          {{--  <input type="hidden" id='min' value={{@$pujaselect?(int)@$pujaselect->pujas->price_starting_from:0}} readonly>
                                            

                                            <div class="form-group">
                                                <label for="FullName">Puja Price</label>
                                                <input type="text" placeholder="Puja Price" name="price" class="form-control" value="{{@$pujaselect->price}}">
                                                <div class="error" id="price_error"></div>
                                            </div> --}}

                                      <div class="clearfix"></div>
                                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">@if(@$pujaselect)Update @else Save @endif </button>  <a class="btn btn-primary waves-effect waves-light w-md" type="submit" href="{{route('admin.pundit.edit-puja-view',['id'=>@$data->id])}}">Cancel</a></div>
                                        </form>

                                    </div> 
                                </div>
                                <!-- Personal-Information -->
                                  <div class="panel panel-default panel-fill">
                                   
                                    <div class="table-responsive">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th>Puja Name </th>
                                          <th> Homam  Available</th>
                                          <th> No. of Recitals</th>
                                          <th class="rm07"> Action</th>                            
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @if(@$pujalist->isNotEmpty())
                                        @foreach(@$pujalist as $list)
                                        <tr>
                                          <td>{{@$list->pujas->puja_name}}</td>
                                          <td>{{$list->pujas->with_homam=='Y'?'Yes':'No'}}</td>
                                          <td>{{@$list->pujas->no_of_recitals?@$list->pujas->no_of_recitals:'-'}}</td>
                                          <td class="rm07">
                                              <ul class="edit_action">
                                                {{-- <li><a href="{{route('admin.pundit.edit-puja',['id'=>$list->id])}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a></li> --}}
                                                
                                                <li><a href="{{route('admin.pundit.delete-puja',['id'=>$list->id])}}" onclick="return confirm('Do you want to delete this puja ?')"  data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>
                                         {{--  <a href="javascript:void(0);" class="action-dots" id="action{{@$list->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                          <div class="show-actions" style="right: 113px;" id="show-{{@$list->id}}" style="display: none;">
                                              <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                            <ul>
                                              <li><a href="{{route('admin.pundit.edit-puja',['id'=>$list->id])}}">Edit</a></li>
                                             <li><a  href="{{route('admin.pundit.delete-puja',['id'=>$list->id])}}" onclick="return confirm('Do you want to delete this puja ?')">Delete</a></li>
                                            </ul>
                                            </div> --}}
                                          </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr><td>No Data</td></tr>
                                        @endif
                                      </tbody>
                                    </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">
    @foreach (@$pujalist as $list)

    $("#action{{$list->id}}").click(function(){
        $('.show-actions:not(#show-{{$list->id}})').slideUp();
        $("#show-{{$list->id}}").slideToggle();
    });
 @endforeach
</script>
<script>
   $(document).ready(function(){
       $('#pujaList').change(function(event){
            var price = event.target.options[event.target.selectedIndex].dataset.price;
            // price=$(this).data('price');
            console.log(price);
            $('#min').val(price);
        });
        $.validator.addMethod("minprice", function(value, element, min) {
            if(value>=min){
                return true;
            }
            else if(value==''){
                return true;
            }
        }, "Minium price should ");

        $("#addpujaform").validate({
            rules: {
                puja:{
                    required: true,
                },
                price:{
                    required: true,
                    number: true ,
                    min: function(){
                        return parseInt($('#min').val());
                    },
                },
            },
            messages: {
                puja:{
                    required: '{{__('profile.required_puja')}}',
                },
                price:{
                    required: '{{__('profile.required_puja_price')}}',
                    number: '{{__('profile.number_puja_price')}}' ,
                    min: function(){
                        return '{{__('profile.minium_price_should')}}'+$('#min').val();
                    },
                },
            },
        });
    })
</script>


@endsection