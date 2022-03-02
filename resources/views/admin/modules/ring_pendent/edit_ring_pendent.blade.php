@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Ring Pendent Price</title>
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
                    <h4 class="pull-left page-title">Edit Ring Pendent Price</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.ring-pendent-price')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                     @include('admin.includes.message')  
                    <div>
                        <!-- Personal-Information -->
                        <div class="panel panel-default panel-fill">
                            <div class="panel-heading">
                                <h3 class="panel-title">Edit Ring Pendent Price</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.ring-pendent-price.update')}}" method="POST" id="purity" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{@$data->id}}">
                                    
                                    <div class="row">
                                        <div class="col-lg-4">
                                       <div class="form-group rm03">
                                                <label for="FullName">Type</label>
                                               <select class="form-control rm06 basic-select" name="type_id" id="type_id">
                                                  <option value="">Select Type</option>
                                                  <option value="P" @if(@$data->type=="P") selected @endif>Pendent</option>
                                                  <option value="R" @if(@$data->type=="R") selected @endif>Ring</option>
                                                  
                                               </select>
                                       </div>
                                   </div>
                                    

                                   <div class="col-lg-4">
                                         <div class="form-group rm03">
                                                <label for="FullName">Metal Type</label>
                                                <select class="form-control rm06 basic-select" name="metal_type_id" id="metal_type_id">
                                                  <option value="">Select Metal Type</option>
                                                  <option value="P" @if(@$data->metal_type=="P") selected @endif>Panchdhatu</option>
                                                  <option value="S" @if(@$data->metal_type=="S") selected @endif>Silver</option>
                                                  
                                               </select>
                                       </div>
                                   </div>
                                       <div class="col-lg-4">
                                     <div class="form-group rm03">
                                        <label for="category_name">Weight (gm)</label>
                                        <input type="text" placeholder="Weight"  class="form-control" name="weight" id="weight" value="{{@$data->weight}}">
                                    </div>
                                </div>
                                   </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <label for="category_name">Price INR</label>
                                        <input type="text" placeholder="Price INR"  class="form-control" name="price_inr" value="{{@$data->price_inr}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name"> Price USD</label>
                                        <input type="text" placeholder="Price USD"  class="form-control" name="price_usd" value="{{@$data->price_usd}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="pendent_price" @if(@$data->type=="R") style="display: none;" @endif>
                                    <div class="form-group">
                                        <label for="category_name">Price INR (With Chain)</label>
                                        <input type="text" placeholder="Price INR (With Chain)"  class="form-control" name="with_chain_price_inr" value="{{@$data->with_chain_price_inr}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="category_name">Price USD (With Chain)</label>
                                        <input type="text" placeholder="Price USD (With Chain)"  class="form-control" name="with_chain_price_usd" value="{{@$data->with_chain_price_usd}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>
                                  </div>

                                    
                                    
                                <div class="clearfix"></div>
                                    <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                                </form>

                            </div>
                        </div>
                        <!-- Personal-Information -->
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
       $("#purity").validate({
            rules: {
               type_id:{
                    required:true,
                },
                metal_type_id:{
                    required:true,
                }, 
                 weight:{
                required:true,
               },
                price_inr:{
                required:true,
                number:true,
                min:1,
               },
               price_usd:{
                required:true,
                number:true,
                min:1,
               },
               
               with_chain_price_inr:{
                required:true,
                number:true,
                min:1,
                
               },
               with_chain_price_usd:{
                required:true,
                number:true,
                min:1,
               },
        },
            
        messages: {
             type_id:{
                required:'Please select type',
            },
            metal_type_id:{
                required:'Please select metal type',
            },
            weight:{
                required:'Please enter the weight',
            }, 
            price_inr:{
              required:'please enter price in INR',
              number:'Only number allowed',
              min:'Enter  price properly in INR',
            }, 
            price_usd:{
              required:'please enter price in USD',
              number:'Only number allowed',
              min:'Enter price properly in USD',
            },
            
            with_chain_price_inr:{
              required:'please enter pendent with chain price in INR',
              number:'Only number allowed',
              min:'Enter pendent with chain price properly in INR',
            }, 
            with_chain_price_usd:{
              required:'please enter pendent with chain price in USD',
              number:'Only number allowed',
              min:'Enter pendent with chain price properly in USD',
            },  
            

        },
        submitHandler: function(form){
            var type = $('#type_id').val();
            var metal_type = $('#metal_type_id').val();
            var weight  = $('#weight').val();
            var id = '{{@$data->id}}';
            $.ajax({
                      url:"{{route('admin.manage.ring-pendent-price.check')}}",
                      method:"GET",
                      data:{'type':type,'metal_type':metal_type,'weight':weight,'id':id},
                      success: function(res) {
                      console.log(res);  
                      // return false;
                      if (res=="found") {
                        alert('Weight already exists in this criteria');
                        return false; 
                     }else{
                        form.submit();
                     }
                   }
          });
        }
      });
    })
</script>
<script type="text/javascript">
    $('#type_id').on('change',function(e){
        var type = $('#type_id').val();
        if (type=="P") {
            $('.pendent_price').css('display','block');
        }else{
             $('.pendent_price').css('display','none');
        }
    })
</script>
@endsection
