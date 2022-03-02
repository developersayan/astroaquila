@extends('layouts.app')

@section('title')
<title>Payment</title>
@endsection

@section('style')
@include('includes.style')
<style type="text/css">
    .error{
        color: red !important;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection



@section('body')

<section class="pad-114">
    <div class="login-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="main-center-div back_white">@include('includes.message')
                        <form action="{{route('pundit.puja.booking.payment',['order_id'=>@$orderDetails->order_id])}}" method="POST" enctype="multipart/form-data" id="payment">
                            @csrf
                            <div class="login-from-area">
                                <h2>Puja Payment</h2>
                                {{-- <p>{{__('auth.sign_up_customer_content')}}</p> --}}
                                <div class="birth-details">
                                    <h3>Order ID :- {{@$orderDetails->order_id}} </h3>
                                    <div>
                                        <div class="row">
                                            {{-- <div class="col-md-6 position-relative">
                                                <input type="text" id="datepicker" class="login-type log-date" placeholder="{{__('auth.date_of_birth_placeholder')}}" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                                <span class="over_llp"><img src="{{ URL::to('public/frontend/images/cal.png')}}" alt=""></span>
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <input type="text" class="login-type" placeholder="{{__('auth.time_of_birth_placeholder')}}" name="time_of_birth" value="{{ old('time_of_birth') }}">
                                                <span class="over_llp"><img src="{{ URL::to('public/frontend/images/clock.png')}}" alt=""></span>
                                            </div> --}}
                                            <div class="clearfix"></div>
                                            {{-- <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Pundit Name:   {{@$orderDetails->pundit->first_name}} {{@$orderDetails->pundit->last_name}}</label>
                                                </div>
                                            </div> --}}
                                            <div class="clearfix"></div>
                                            @if(@$orderDetails->pujas->puja_id!="")
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Puja Name:   {{@$orderDetails->pujas->pujaName->name}}</label>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Puja Tile:   {{@$orderDetails->pujas->puja_name}}</label>
                                                </div>
                                            </div>
                                            @if(@$orderDetails->pujas->puja_code!="")
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Puja Code:   {{@$orderDetails->pujas->puja_code}}</label>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Puja Type:   @if(@$orderDetails->puja_type=='ONLINE') {{__('search.online')}}  @elseif(@$orderDetails->puja_type=='OFFLINE') {{__('profile.offline')}} @endif</label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
											<div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Date:   {{ date('d-m-Y',strtotime(@$orderDetails->date))}}</label>
                                                </div>
                                            </div>
											<div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Base Price:  {{@$orderDetails->currencyDetails->currency_symbol}} {{@$orderDetails->subtotal}}</label>
                                                </div>
                                            </div>
											@if(@$orderDetails->is_homam=='Y')
											<div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Homam Price:  {{@$orderDetails->currencyDetails->currency_symbol}} {{@$orderDetails->homam_price}}</label>
                                                </div>
                                            </div>
											@endif


                                            @if(@$orderDetails->is_cd=='Y')
                                            <div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>CD of recording of Puja Price:  {{@$orderDetails->currencyDetails->currency_symbol}} {{@$orderDetails->cd_price}}</label>
                                                </div>
                                            </div>
                                            @endif

                                            @if(@$orderDetails->is_live_streaming=='Y')
                                            <div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Live streaming of Puja Price:  {{@$orderDetails->currencyDetails->currency_symbol}} {{@$orderDetails->live_streaming_price}}</label>
                                                </div>
                                            </div>
                                            @endif


                                            @if(@$orderDetails->is_prasad=='Y')
                                            <div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Prasad of Puja Price:  {{@$orderDetails->currencyDetails->currency_symbol}} {{@$orderDetails->prasad_price}}</label>
                                                </div>
                                            </div>
                                            @endif

                                            @if(@$orderDetails->dakshina!=0)
                                            <div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Dakshina:  {{@$orderDetails->currencyDetails->currency_symbol}} {{@$orderDetails->dakshina}}</label>
                                                </div>
                                            </div>
                                            @endif


                                            @if(@$orderDetails->is_prasad=='Y' && @$orderDetails->delivery_of_prasad=="Y")
                                            <div class="col-md-12" style="text-align: left">
                                            <div class="form_box_area">
                                            <label>Delivery Of Prasad Available: Yes </label>
                                            </div>
                                            </div>
                                            @endif

                                            @if(@$orderDetails->is_prasad=='Y' && @$orderDetails->delivery_of_prasad=="N")
                                             <div class="col-md-12" style="text-align: left">    
                                            <div class="form_box_area">
                                            <label>Delivery Of Prasad Available: Not Available </label>
                                            </div>
                                        </div>
                                            @endif

                                            

                                            @if(@$orderDetails->is_prasad=='Y' && @$orderDetails->delivery_of_prasad=="Y")
                                            
                                            @if(@session()->get('currency')==1 && @$orderDetails->pujas->delivery_days_india!="")
                                            <div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Tentative date of delivery of prasad: <?php $days = @$orderDetails->pujas->delivery_days_india+1  ?>
                                                Before {{date('F j, Y', strtotime(date('Y-m-d'). ' + '.$days.' days'))}}</label>
                                                </div>
                                            </div>
                                           

                                            @else
                                            
                                            @if(@$orderDetails->pujas->delivery_days_outside_india!="")
                                            <div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Tentative date of delivery of prasad: <?php $days = @$orderDetails->pujas->delivery_days_outside_india+1  ?>
                                                Before {{date('F j, Y', strtotime(date('Y-m-d'). ' + '.$days.' days'))}}</label>
                                                </div>
                                            </div>
                                            @endif


                                            @endif
                                            @endif
                                            
                                            
                                            <div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Refundable:  @if(@$orderDetails->pujas->refundable=="Y")Yes @else No @endif</label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            @if(@$orderDetails->pujas->refundable=="Y")
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Refundable Status:  @if(@$orderDetails->pujas->refundable_status=="E")Exchange Only @elseif(@$orderDetails->pujas->refundable_status=="'FR") Fully Refundable @elseif(@$orderDetails->pujas->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif</label>
                                                </div>
                                            </div>
                                            @endif


                                            
											@if(@$orderDetails->mantraDetails->isNotEmpty())
											<div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Additional Mantras:</label>
													<div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Mantra</th>
                                                        <th>No Of Recitals</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(@$orderDetails->mantraDetails->isNotEmpty())
                                                    @foreach(@$orderDetails->mantraDetails as $mantra)
                                                    <tr>
                                                        <td>{{@$mantra->mantra->mantra}}</td>

                                                        <td>
                                                            {{@$mantra->no_of_recital}}
                                                        </td>

                                                        <td>
														{{@$orderDetails->currencyDetails->currency_symbol}} {{@$mantra->price}}
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
											@endif
											<div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Total Rate:  {{@$orderDetails->currencyDetails->currency_symbol}} {{@$orderDetails->total_rate}}</label>
                                                </div>
                                            </div>
                                            @if(@$orderDetails->payment_status=='P')
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Payment Status: Paid</label>
                                                </div>
                                            </div>

                                             
                                            @endif
                                            @if(@$orderDetails->payment_status=='F')
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Payment Status: Failed</label>
                                                </div>
                                            </div>
                                            @endif
                                            @if(@$orderDetails->status=='N')
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Booking Status: New</label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                   <label style="border: 2px solid #fbbc93;padding:5px;">For more information on Return/Exchange/Refund refer to our Return/Exchange/Refund policy.</label>
                                                </div>
                                            </div>

                                             <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                   <label style="border: 2px solid #fbbc93;padding:5px;">We do not give any kind of Assurance/ Guarantee / Warranty related to the Astrological impact against the item purchased/service booked/taken/paid. The same is based on one's own related devotion and belief system and. For further information, please refer to our Assurance/ Guarantee / Warranty policy.</label>
                                                </div>
                                            </div>

                                </div>
                                @if(@$orderDetails->status=='I')
                                <div class="col-md-12" style="text-align: left">
                                <div class="availability_check">
                                        <input id="agree_check" type="checkbox"  value="agree" name="agree_check" >
                                        <label for="agree_check">I agree <a href="{{route('terms.condition')}}" target="_blank">terms & condition</a> and <a href="{{route('privacy.policy')}}" target="_blank">Privacy Policy </a></label>
                                        <div id="error_check" style="color: red !important;"></div>
                                    </div>
                                </div>
                                @endif
                                @if(@$orderDetails->status=='I')
                                <button type="submit" class="login-submit mt-2">Pay</button>
                                @endif
                            </div>
                        </form>
                        @if(@$orderDetails->payment_status=='P')
                                    <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area"><a href="{{route('customer.puja.history')}}" ><button class="login-submit">
                                                    Go To Order Page
                                                </button></a>
                                                </div>
                                            </div>
                                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection



@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
{{-- @include('includes.toaster') --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
       $("#payment").validate({
            rules: {
               
           agree_check:{
            required:true,
           },

          },
            
        messages: {
            agree_check:{
             required:'Please accept terms and condtions before pay',
           },

        },
         submitHandler:function(form){
                $('#error_check').html('');
                if($('#agree_check').prop("checked") == false)
                {
                    $('#error_check').append('<p class="error">Please accept the terms and condition before pay</p>')
                }else{

                    // $('#error_check').html('');
                    form.submit();                
                }
            },  

        });
    })
</script>
@endsection
