@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Puja Energization</title>
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
                    <h4 class="pull-left page-title">Add Puja Energization</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.puja-energization')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Puja Energization</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.puja-energization.add')}}" method="POST" id="ringForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                                <label for="FullName">Puja Name</label>
                                               <select class="form-control rm06 basic-select" name="name" id="name">
                                                  <option value="">Select Puja</option>
                                                  @foreach(@$pujas as $value)
                                                  <option value="{{@$value->id}}">{{@$value->puja}}</option>
                                                  @endforeach
                                               </select>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <label for="category_name">Price INR</label>
                                        <input type="text" placeholder="Price INR" id="inr" class="form-control" name="price_inr">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name">Price USD</label>
                                        <input type="text" placeholder="Price USD" id="usd" class="form-control" name="price_usd">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>
                                    <div class="clearfix"></div>
                                    
                                    <b><h3 class="base_range_heading"> Base Price Range</h3></b>
                                    <p class="note_energization">(Note: Energization options will show up in front end based on the Base Price of Gemstone.)</p>

                                    <div class="clearfix"></div>

                                    <div class="form-group">
                                        <label for="category_name">Base Price INR From</label>
                                        <input type="text" placeholder="Base Price INR From" id="from_inr" class="form-control" name="from_inr">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="category_name">Base Price INR To</label>
                                        <input type="text" placeholder="Base Price INR To" id="to_inr" class="form-control" name="to_inr">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <label for="category_name">Base Price USD From</label>
                                        <input type="text" placeholder="Base Price USD From" id="from_usd" class="form-control" name="from_usd">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name">Base Price USD To</label>
                                        <input type="text" placeholder="Base Price USD To" id="to_usd" class="form-control" name="to_usd">
                                        {{-- <div id="err_category"></div> --}}
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
       $("#ringForm").validate({
         rules: {
              name: {
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
               from_inr:{
                required:true,
                number:true,
                
                
               },
               to_inr:{
                required:true,
                number:true,
                min:1,
                
               },

               from_usd:{
                required:true,
                number:true,
                
               },
               to_usd:{
                required:true,
                number:true,
                min:1,
                
               },
          },
            
        messages: {
                name: {
                    required:'Please select puja energization name',
                    // remote:'Puja Energization name already exits',
            },
            price_inr:{
              required:'please enter price in INR',
              number:'Only number allowed',
              min:'Enter price properly in INR',
            }, 
            price_usd:{
              required:'please enter price in USD',
              number:'Only number allowed',
              min:'Enter price properly in USD',
            }, 
            from_inr:{
              required:'please enter base price INR from',
              number:'Only number allowed',
              min:'Enter price properly in USD',
            }, 
            to_inr:{
              required:'please enter base price INR to',
              number:'Only number allowed',
              min:'Enter price properly in USD',
            }, 
            from_usd:{
              required:'please enter base price USD from',
              number:'Only number allowed',
              min:'Enter price properly in USD',
            },  
            to_usd:{
              required:'please enter base price USD to',
              number:'Only number allowed',
              min:'Enter price properly in USD',
            },  

        },
        submitHandler: function(form){
          var from_inr = $('#from_inr').val();
          var to_inr = $('#to_inr').val();
          var from_usd = $('#from_usd').val();
          var to_usd = $('#to_usd').val();
          var name = $('#name').val();
          
           $.ajax({
                   url:"{{route('admin.manage.puja-energization.check-price')}}",
                   method:"GET",
                   data:{'from_inr':from_inr,'to_inr':to_inr,'from_usd':from_usd,'to_usd':to_usd,'name':name},
                   success: function(res) {
                   console.log(res);
                   if (res=="greater_inr") {
                    alert('Base price from INR should not be greater than or equal to base price to INR');
                     return false;
                    }
                    if (res=="greater_usd") {
                    alert('Base price from USD should not be greater than or equal to base price to USD');
                     return false;
                    }
                   if (res=="inr_exit") {
                    alert('Base INR price range already exits for this puja');
                     return false;
                    }
                    else if (res=="usd_exit") {
                      alert('Base USD price range already exits for this puja');
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
@endsection
