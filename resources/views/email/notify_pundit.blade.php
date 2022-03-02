<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Order Details</title>
    <style>
      .tabs_tt{
      max-width:650px; margin:0 auto;
      }
      .tabs_header{
      width:100%; display:block; padding:20px 0; background:#000; text-align:center; margin-bottom:10px;
      }
      .name_ttag{
      float:left; padding:0 10px; color:#000; font-family:Arial, Helvetica, sans-serif;}
      .order_d_block{
      width:96.5%; float:left; border:1px solid #ddd; padding:10px; margin-bottom:10px;
      }
      .order_d_block h3{
      font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;
      }
      .heading{
      font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;
      }
      .order_d_block ul{
      margin:0;
      padding:0;
      }
      .order_d_block ul li{
      list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px
      }
      .half_ddiv{
      width:45.2%; float:left; border:1px solid #ddd; padding:10px;
      }
      .half_ddiv ul{
      margin:0;
      padding:0;}
      .half_ddiv ul li{
      list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px;}
      .table_res{
      max-width:100%;
      overflow:auto;
      }
      .table_res table{
      margin:15px 0 0;
      padding:0;
      width:100%;
      float:left;
      }
      .table_res table th{
      padding:10px 4px; background:#000; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;
      }
      .table_res table td{
      padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;
      }
      .margL20{
      margin-left:15px;
      }
      @media(max-width:590px) {
      .half_ddiv{
      width:100% !important;
      }
      .margL20{
      margin-left:0 !important;
      }
      }
      .color_pallete{
      width: 27px;
      height: 25px;
      border: 1px solid #000;
      display: inline-block;
      margin: 1px 5px 5px 0;
      float: left;
      }
    </style>
  </head>
  <body style="margin:0; padding:0;">
    <div class="tabs_tt" style="max-width:650px; margin:0 auto;">
    <div class="tabs_header" style=" width: 100%; display: block; padding: 30px 0 0px 0;  background: #fff; text-align: center; margin-bottom: 0;">
      <img src="{{asset('public/frontend/images/logo.png')}}" width="150px" />
      {{-- <div
            style="/*width:620px;*/background:#F9F9F9; /*padding: 0px 10px;*/ border:1px solid #d9d8d8; border-bottom: none;height: 100px; margin: -9px 0px -13px 0px;">
            <div
                style="float: none; text-align: center; margin-top: 20px; background:url('{{ URL::to('#') }}') repeat center center">
                <img src="{{asset('public/frontend/images/logo.png')}}" width="135" alt="">
            </div>
        </div> --}}
    </div>
    <div class="name_ttag" style="float:left; padding:0 10px; color:#000; font-family:Arial, Helvetica, sans-serif;">
      <h1 style="margin: 15px 0 10px 0;">
        <p style="font-weight:600; margin: 0px;"><u><b>Admin Assigned You An Puja Order</b></u></p>
      </h1>
      <!-- <h2><p style="font-weight:600;">Your Order:  has been </p></h2> -->
      <h2 style="margin:0 0 10px 0;">Customer Name: {{@$data['name']}} {{@$data['last_name']}}</h2>
    </div>
    <div class="order_d_block" style="width:96.5%; float:left; border:1px solid #ddd; padding:10px; margin-bottom:10px;">
      <h3 style="font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;">Order Details</h3>
      <ul style="margin:0; padding:0; width: 45%; float: left;">
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Order Number :{{@$data['order_id']}}</strong></li>
		<li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Puja Code :{{@$data['puja_code']}}</strong></li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Puja Date :{{@$data['date']}}</strong></li>
       <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Puja Type :{{@$data['puja_type']}}</strong></li>

      </ul>

      <ul style="margin:0; padding:0; width: 45%; float: right;">
        {{-- <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong> Subtotal: {{ number_format(getCurrencyPrice(@$data['sub_total']),2, '.', '') }}
          {{ getCurrency1() }}</strong>
        </li>
        @if(@$data['shipping_price'] != "NA")
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
          <strong>
            Shipping charges :
            {{ number_format(getCurrencyPrice(@$data['shipping_price']), 2, '.', '') }}
            <!-- $data['shipping_price'] -->
            <!-- {{ number_format($data['order']->shipping_price, 2, '.', '') }} -->
            {{ getCurrency1() }}
          </strong>
        </li>
        @endif
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Product discount:
          {{ number_format(getCurrencyPrice(@$data['total_discount']), 2, '.', '') }}
          {{ getCurrency1() }}</strong>
        </li>

        @if(@$data['order']->coupon_code)
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Coupon discount:
          {{ number_format(getCurrencyPrice(@$data['order']->coupon_discount), 2, '.', '') }} {{ getCurrency1() }} ({{ @$data['order']->coupon_code }})
          </strong>
        </li>
        @endif --}}
     <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Puja Price  : {{$data['neworderDetails']->currencyDetails->currency_code}} {{@$data['subtotal']}} </strong>
        </li>    
		<li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>With Homam  : @if(@$data['is_homam']=='Y') Yes @else No @endif</strong>
        </li>
		@if(@$data['is_homam']=='Y')
		<li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Homam Amount  : {{$data['neworderDetails']->currencyDetails->currency_code}} {{@$data['homam_price']}} </strong>
        </li>
		@endif

    <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>With CD Recording Of Puja  : @if(@$data['is_cd']=='Y') Yes @else No @endif</strong>
        </li>
    @if(@$data['is_cd']=='Y')
    <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>CD Recording Amount  : {{$data['neworderDetails']->currencyDetails->currency_code}} {{@$data['cd_price']}} </strong>
        </li>
    @endif


    <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>With Live Streaming Of Puja  : @if(@$data['is_live_streaming']=='Y') Yes @else No @endif</strong>
        </li>
    @if(@$data['is_cd']=='Y')
    <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Live Streaming Amount  : {{$data['neworderDetails']->currencyDetails->currency_code}} {{@$data['live_streaming_price']}} </strong>
        </li>
    @endif

        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>With Prasad Of Puja  : @if(@$data['is_prasad']=='Y') Yes @else No @endif</strong>
        </li>
    @if(@$data['is_prasad']=='Y')
    <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Prasad Amount  : {{$data['neworderDetails']->currencyDetails->currency_code}} {{@$data['prasad_price']}} </strong>
        </li>
    @endif

    @if(@$data['dakshina']!=0)
    <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Dakshina  : {{$data['neworderDetails']->currencyDetails->currency_code}} {{@$data['dakshina']}} </strong>
        </li>

    @endif
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Order Total  : {{$data['neworderDetails']->currencyDetails->currency_code}} {{@$data['order_total']}} </strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Payment Status  : @if(@$data['payment_status']=='I') Initiated @elseif(@$data['payment_status']=='P') Paid @elseif(@$data['payment_status']=="F") Failed @endif </strong>
        </li>
      </ul>
    </div>
    
    @if(@$data['puja_type']=='OFFLINE')
    <div class="half_ddiv" style="width:96.5%; float:left; border:1px solid #ddd; padding:10px; margin-bottom:10px; margin-right: 17px;">
      <h3 class="heading" style="font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;">Puja Address Details</h3>
      <ul style="margin:0; padding:0;">
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">{{ @$data['data']->shipping_fname }} {{ @$data['data']->shipping_lname }}</li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Address:{{ @$data['puja_address']}}</strong>
        </li>

        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Zipcode:{{ @$data['zip_code']}}</strong>
        </li>

        @if(@$data['landmark']!="") 
         <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Landmark:{{ @$data['landmark']}}</strong>
        </li>
        @endif

        @if(@$data['house_no']!="") 
         <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>House/Flat No :{{ @$data['house_no']}}</strong>
        </li>
        @endif
       
      </ul>
    </div>
    @endif
    

    <div class="half_ddiv" style="width:96.5%; float:left; border:1px solid #ddd; padding:10px; margin-bottom:10px;">
      <h3 class="heading" style="font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;">Puja Details</h3>
      <ul style="margin:0; padding:0;">
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">{{ @$data['data']->billing_fname }} {{ @$data['data']->billing_lname }}</li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Puja Name:{{ @$data['puja_name']}}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Puja Details:{{substr(@$data['puja_details'],40) }} ...</strong>
        </li>
        
      </ul>
    </div>
    {{-- @endif --}}
    <div style="clear:both">
      <div class="table_res" style="max-width:100%; overflow:auto;">
        <h3 class="heading" style="font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;">Persons Name For Puja</h3>
        <table cellpadding="0" cellspacing="0" style="margin:15px 0 0; padding:0; width:100%; float:left;">
          <tr>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Name</th>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Dob</th>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Janma Nakshatra</th>

            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Janma Rashi</th>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Gotra</th>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Place Of Resident</th>
          </tr>
          @foreach(@$data['customers'] as $value)
          <tr>

             <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>{{ $value->name }}</p>
            </td>

            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>
                @if(@$value->dob!="")
                {{ $value->dob }}
                @else
                --
                @endif
              </p>
            </td>

            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>@if(@$value->janama_nkshatra!="")
                                                            {{@$value->nakshatras->name}}
                                                            @else
                                                            --
                                                            @endif</p>
            </td>

            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>@if(@$value->janam_rashi_lagna!="")
                                                            {{@$value->rashis->name}}
                                                            @else
                                                            --
                                                            @endif</p>
            </td>

            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>@if(@$value->gotra!="")
                                                            {{@$value->gotra}}
                                                            @else
                                                            --
                                                            @endif</p>
            </td>

             <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>  @if(@$value->place_of_residence !="")
                                                            {{@$value->place_of_residence}}
                                                            @else
                                                            --
                                                            @endif</p>
            </td>
            
            
          </tr>
          @endforeach
        </table>
      </div>
	  @if(@$data['mantraDetails'])
	  <div style="clear:both">
	  <div class="table_res" style="max-width:100%; overflow:auto;">
        <h3 class="heading" style="font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;">Additional Mantra Details</h3>
        <table cellpadding="0" cellspacing="0" style="margin:15px 0 0; padding:0; width:100%; float:left;">
          <tr>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Mantra</th>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">No Of Recitals</th>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Price</th>
          </tr>
          @foreach(@$data['mantraDetails'] as $mantra)
          <tr>

             <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>{{ $mantra->mantra->mantra }}</p>
            </td>

            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>{{ $mantra->no_of_recital }}</p>
            </td>

            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>{{$data['neworderDetails']->currencyDetails->currency_code}} {{@$mantra->price}}</p>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
	  @endif
      <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 20px 0px 10px 0px;">Thank you,</p>
      <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team Astroaquila</p>
    </div>
  </body>
</html>
