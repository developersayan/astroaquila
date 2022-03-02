@extends('layouts.app')

@section('title')
<title>Payment</title>
@endsection

@section('style')
@include('includes.style')
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
                    <div class="main-center-div">@include('includes.message')
                        <form action="{{route('astrologer.call.booking.payment.now',['order_id'=>@$orderDetails->order_id])}}" method="POST" enctype="multipart/form-data" id="payment" >
                             @csrf
                            <div class="login-from-area">
                                <h2>Pay Now</h2>
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
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Astrologer Name:   {{@$orderDetails->astrologer->first_name}} {{@$orderDetails->astrologer->last_name}}</label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            {{-- <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Duration:   {{@$orderDetails->duration}}</label>
                                                </div>
                                            </div> --}}
                                            <div class="clearfix"></div>
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Rate:  @if(@$orderDetails->currency_id==1) RS. @elseif(@$orderDetails->currency_id==2) $ @endif {{@$orderDetails->rate}}</label>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            {{-- <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Total Rate:   @if(@$orderDetails->currency_id==1) RS. @elseif(@$orderDetails->currency_id==2) $ @endif {{@$orderDetails->total_rate}}</label>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Date:   {{ date('d-m-Y H:i',strtotime(@$call_details->call_date_time))}}</label>
                                                </div>
                                            </div>
                                            @if(@$orderDetails->orderPujaNames->name || @$orderDetails->orderPujaNames->relation!="" || @$orderDetails->orderPujaNames->dob!="" ||@$orderDetails->orderPujaNames->janama_nkshatra!=""|| @$orderDetails->orderPujaNames->janam_rashi_lagna!=""|| @$orderDetails->orderPujaNames->gotra!="" || @$orderDetails->orderPujaNames->place_of_residence)
                                            <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Person Information<br><br> @if(@$orderDetails->orderPujaNames->name) <b>Name</b>: {{@$orderDetails->orderPujaNames->name}} @endif <br> @if(@$orderDetails->orderPujaNames->relation!="")  <b>Relation</b>: {{@$orderDetails->orderPujaNames->relation}} <br> @endif @if(@$orderDetails->orderPujaNames->dob!="")  <b>Date Of Birth</b>: {{@$orderDetails->orderPujaNames->dob}} <br> @endif @if(@$orderDetails->orderPujaNames->place_of_residence)  <b>Place Of Residence</b>: {{@$orderDetails->orderPujaNames->place_of_residence}} @endif <br> @if(@$orderDetails->orderPujaNames->janama_nkshatra!="")  <b>Janam Nakshatra</b>: {{@$orderDetails->orderPujaNames->nakshatras->name}} <br> @endif @if(@$orderDetails->orderPujaNames->janam_rashi_lagna!="")  <b>Rashi</b>: {{@$orderDetails->orderPujaNames->rashis->name}} <br> @endif  @if(@$orderDetails->orderPujaNames->gotra!="")  <b>Gotra</b>: {{@$orderDetails->orderPujaNames->gotra}} <br> @endif</label>
                                                </div>
                                            </div>
                                           @endif
                                            
                                        </div>
                                    </div>
                                </div>
                                @if(@$orderDetails->status=='I')
                                <button type="submit" class="login-submit">Pay</button>
                                <!--<button type="submit" class="login-submit">Back</button>-->
                                @endif
                            </div>
                        </form>

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
<script>
    $(document).ready(function(){
        /*$('.login-submit').click(function(){
            window.location.href = '{{ route("astrologer.search.publicProfile" , ["id" => @$orderDetails->astrologer->slug]) }} ';
        });
        $('#payment').submit(function(){
            return false;
        });*/
    });
</script>
@endsection
