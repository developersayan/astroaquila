@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Gold Purity</title>
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
                    <h4 class="pull-left page-title">Edit Gold Purity</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.gold.purity')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Edit Gold Purity {{@$data->purity}} </h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.gold.purity.update')}}" method="POST" id="purity" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{@$data->id}}">
                                    <div class="form-group">
                                        <label for="category_name">Gold Purity</label>
                                        <label for="category_name">{{@$data->purity}}</label>
                                        {{-- <input type="text" placeholder="Gold Purity" id="purity" class="form-control" name="name" value="{{@$data->purity}}" disabled> --}}
                                        {{-- <div id="err_category"></div> --}}
                                    </div>
                                    <div class="clearfix"></div>
                                    <b><h3 class="base_range_heading" style="margin-bottom: 12px !important;
    color: #e8a173;"> Ring :-</h3></b>
                                    <div class="form-group">
                                        <label for="category_name">Ring Weight (Carat)</label>
                                        <input type="text" placeholder="Ring Weight Carret"  class="form-control" name="ring_weight_carat" value="{{@$data->ring_weight_carat}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name">Ring Price INR</label>
                                        <input type="text" placeholder="Ring Price INR"  class="form-control" name="ring_price_inr" value="{{@$data->ring_price_inr}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name">Ring Price USD</label>
                                        <input type="text" placeholder="Ring Price USD"  class="form-control" name="ring_price_usd" value="{{@$data->ring_price_usd}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="clearfix"></div>
                                    <b><h3 class="base_range_heading" style="margin-bottom: 12px !important;
    color: #e8a173;"> Pendent :-</h3></b>

                                    <div class="form-group">
                                        <label for="category_name">Pendent Weight (Carat)</label>
                                        <input type="text" placeholder="Pendent Weight Carret"  class="form-control" name="pendent_weight_carat" value="{{@$data->pendent_weight_carat}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="category_name">Pendent Price INR</label>
                                        <input type="text" placeholder="Pendent Price INR"  class="form-control" name="pendent_price_inr" value="{{@$data->pendent_price_inr}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name">Pendent Price USD</label>
                                        <input type="text" placeholder="Pendent Price USD" id="from_usd" class="form-control" name="pendent_price_usd" value="{{@$data->pendent_price_usd}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="form-group">
                                        <label for="category_name">Pendent With Chain Price INR</label>
                                        <input type="text" placeholder="Pendent With Chain Price INR" id="to_usd" class="form-control" name="pendent_chain_price_inr" value="{{@$data->pendent_chain_price_inr}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name">Pendent With Chain Price USD</label>
                                        <input type="text" placeholder="Pendent With Chain Price USD"  class="form-control" name="pendent_chain_price_usd" value="{{@$data->pendent_chain_price_usd}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="clearfix"></div>
                                    <b><h3 class="base_range_heading" style="margin-bottom: 12px !important;
    color: #e8a173;"> Bracelet :-</h3></b>

                                     <div class="form-group">
                                        <label for="category_name">Bracelet Weight (Carat)</label>
                                        <input type="text" placeholder="Bracelet Weight Carret" id="inr" class="form-control" name="bracalet_weight_carat" value="{{@$data->bracalet_weight_carat}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name">Bracelet Price INR</label>
                                        <input type="text" placeholder="Bracelet Price INR"  class="form-control" name="bracelet_price_inr" value="{{@$data->bracelet_price_inr}}">
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name">Bracelet Price USD</label>
                                        <input type="text" placeholder="Bracelet Price USD" id="usd" class="form-control" name="bracelet_price_usd" value="{{@$data->bracelet_price_usd}}">
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
       $("#purity").validate({
            rules: {
                ring_weight_carat: {
                   required:true,
                   number:true,
                   min:1,
               },
                ring_price_inr:{
                required:true,
                number:true,
                min:1,
               },
               ring_price_usd:{
                required:true,
                number:true,
                min:1,
               },
               pendent_weight_carat:{
                required:true,
                number:true,
                min:1,
               },
               pendent_price_inr:{
                required:true,
                number:true,
                min:1,
                
               },
               pendent_price_usd:{
                required:true,
                number:true,
                min:1,
               },
               pendent_chain_price_inr:{
                required:true,
                number:true,
                min:1,
               },
               pendent_chain_price_usd:{
                required:true,
                number:true,
                min:1,
              },
              bracalet_weight_carat:{
                required:true,
                number:true,
                min:1,
              },
              bracelet_price_inr:{
                required:true,
                number:true,
                min:1,
              },
              bracelet_price_usd:{
                required:true,
                number:true,
                min:1,
              },

          },
            
        messages: {
                ring_weight_carat: {
                    required:'Please enter ring weight',
                    number:'Only number allowed',
                    min:'Enter ring weight properly',
            },
            ring_price_inr:{
              required:'please enter ring price in INR',
              number:'Only number allowed',
              min:'Enter ring price properly in INR',
            }, 
            ring_price_usd:{
              required:'please enter ring price in USD',
              number:'Only number allowed',
              min:'Enter ring price properly in USD',
            },
            pendent_weight_carat:{
              required:'Please enter pendent weight',
              number:'Only number allowed',
              min:'Enter pendent weight properly',
            }, 
            pendent_price_inr:{
              required:'please enter pendent price in INR',
              number:'Only number allowed',
              min:'Enter pendent price properly in INR',
            }, 
            pendent_price_usd:{
              required:'please enter pendent price in USD',
              number:'Only number allowed',
              min:'Enter pendent price properly in USD',
            },  
            pendent_chain_price_inr:{
              required:'please enter pendent with chain price in INR',
              number:'Only number allowed',
              min:'Enter pendent with chain price properly in INR',
            }, 
            pendent_chain_price_usd:{
              required:'please enter pendent with chain price in USD',
              number:'Only number allowed',
              min:'Enter pendent with chain price properly in USD',
            },
            bracalet_weight_carat:{
              required:'Please enter bracelet weight',
              number:'Only number allowed',
              min:'Enter pendent weight properly',
            },  
            bracelet_price_usd:{
              required:'please enter bracelet price in USD',
              number:'Only number allowed',
              min:'Enter bracelet price properly in USD',
            },
            bracelet_price_inr:{
              required:'please enter bracelet price in INR',
              number:'Only number allowed',
              min:'Enter bracelet price properly in INR',
            },

        },
      });
    })
</script>
@endsection
