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
    </div>
    <div class="name_ttag" style="float:left; padding:0 10px; color:#000; font-family:Arial, Helvetica, sans-serif;">
      <h1 style="margin: 15px 0 10px 0;">
        <p style="font-weight:600; margin: 0px;"><u><b>Order Cancelled</b></u></p>
      </h1>
      <!-- <h2><p style="font-weight:600;">Your Order:  has been </p></h2> -->
      <h2 style="margin:0 0 10px 0;">Buyer Name: {{@$data['data']->customer->first_name}} {{@$data['data']->customer->last_name}}</h2>
    </div>
    <div class="order_d_block" style="width:96.5%; float:left; border:1px solid #ddd; padding:10px; margin-bottom:10px;">
      <h3 style="font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;">Order Details</h3>
      <ul style="margin:0; padding:0; width: 45%; float: left;">
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Order Number :{{@$data['data']->order_id}}</strong></li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Order Date :{{ date('jS M Y',strtotime(@$data['data']->date)) }}</strong></li>
        @if(@$data['data']->payment_type=='COD')
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Payment Method : Cash On Delivery</strong></li>
        @elseif(@$data['data']->payment_type=='O')
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Payment Method : Online</strong></li>
        @elseif(@$data['data']->payment_type=='W')
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Payment Method : Wallet</strong></li>
        @endif


        @if(@$data['data']->status == 'I')
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Status : Incomplete</strong></li>
        @elseif($data['data']->status == 'N')
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Status : New</strong></li>
        @elseif($data['data']->status == 'C')
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px;   margin-bottom:5px; margin-left: 0px;"><strong>Status : Complete</strong></li>
        @elseif($data['data']->status == 'CA')
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px;   margin-bottom:5px; margin-left: 0px;"><strong>Status : Cancel</strong></li>
        @elseif($data['data']->status == 'IP')
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px;   margin-bottom:5px; margin-left: 0px;"><strong>Status : In Progress</strong></li>
        @elseif($data['data']->status == 'D')
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px;   margin-bottom:5px; margin-left: 0px;"><strong>Status : Delivered</strong></li>
        @endif
      </ul>

      <ul style="margin:0; padding:0; width: 45%; float: right;">
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Order Total  : {{@$data['data']->currencyDetails->currency_code}} {{@$data['data']->total_rate}} </strong>
        </li>
      </ul>
    </div>
    <div class="half_ddiv" style="width:45.2%; float:left; border:1px solid #ddd; padding:10px; margin-bottom:10px; margin-right: 17px;">
      <h3 class="heading" style="font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;">Shipping Details</h3>
      <ul style="margin:0; padding:0;">
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">{{ @$data['data']->shipping_fname }} {{ @$data['data']->shipping_lname }}</li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>City:{{ @$data['data']->shipping_city }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Zip Code:{{ @$data['data']->shipping_pin_code }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Land Mark:{{ @$data['data']->shipping_landmark }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Street:{{ @$data['data']->shipping_street }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Country:{{ @$data['data']->country->name }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>State:{{ @$data['data']->state->name }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Address:{{ @$data['data']->shipping_address }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Email: {{ @$data['data']->shipping_email }}</strong></li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Phone: {{ @$data['data']->shipping_phone }}</strong></li>
      </ul>
    </div>
    <div class="half_ddiv" style="width:45.2%; float:left; border:1px solid #ddd; padding:10px; margin-bottom:10px;">
      <h3 class="heading" style="font-family:Arial, Helvetica, sans-serif; font-size:19px; font-weight:normal; margin:0 0 5px; padding:0;">Billing Details</h3>
      <ul style="margin:0; padding:0;">
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">{{ @$data['data']->billing_fname }} {{ @$data['data']->billing_lname }}</li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>City:{{ @$data['data']->billing_city }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Zip Code:{{ @$data['data']->billing_pin_code }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Land Mark:{{ @$data['data']->billing_landmark }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Street:{{ @$data['data']->billing_street }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Country:{{ @$data['data']->billingCountry->name }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>State:{{ @$data['data']->billingState->name }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;">
            <strong>Address:{{ @$data['data']->billing_address }}</strong>
        </li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Email: {{ @$data['data']->billing_email }}</strong></li>
        <li style="list-style:none; font-family:Arial, Helvetica, sans-serif; font-size:13px; margin-bottom:5px; margin-left: 0px;"><strong>Phone: {{ @$data['data']->billing_phone }}</strong></li>
      </ul>
    </div>
    {{-- @endif --}}
    <div style="clear:both">
      <div class="table_res" style="max-width:100%; overflow:auto;">
        <table cellpadding="0" cellspacing="0" style="margin:15px 0 0; padding:0; width:100%; float:left;">
          <tr>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Product</th>
			<th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Product Code</th>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Product Quantity</th>
            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">Unit price</th>

            <th style="padding:10px 4px; background:#2486e1; color:#fff; font-family:Arial, Helvetica, sans-serif; font-size:12px; text-align:center; text-transform:uppercase;">TOTAL PRICE</th>
          </tr>
          @foreach(@$data['data']->orderDetails as $value)
          <tr>
            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              @if(@$value->product->productdefault->image)
				  @if($value->product_type=='GS')
					  <span class="tabel-image" style="width: 100%"><img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$value->product->productdefault->image}}" alt="" style="width: 80px; float: left;"></span>
					@else
						<span class="tabel-image" style="width: 100%"><img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$value->product->productdefault->image}}" alt="" style="width: 80px; float: left;"></span>
					@endif              
              @else
              <span class="tabel-image"><img src="{{ asset('public/frontend/images/default_product.png') }}" alt="" style="width: 80px; float: left;"></span>
              @endif
              <br>
              <p style="margin: 5px 0; float: left; text-align: left;">{{@$value->product->product_name}} @if($value->product_type=='GS' && @$value->jewellery_type && @$value->metal_type) With @if(@$value->metal_type=='G') Gold @elseif(@$value->jewellery_type=='S') Silver @elseif(@$value->jewellery_type=='P') Panchdhatu @endif  @if(@$value->jewellery_type=='R') Ring @elseif(@$value->jewellery_type=='P') Pendant @elseif(@$value->jewellery_type=='B') Bracelet @endif @endif</p>

            </td>
			<td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>{{ $value->product->product_code }}</p>
            </td>
            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>{{ $value->quantity }}</p>
            </td>
            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>{{@$data['data']->currencyDetails->currency_code}} {{@$value->price}}</p>
            </td>
            <td style="padding:7px 4px; color:#323232; font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; border-bottom:1px solid #ddd;"  >
              <p>{{@$data['data']->currencyDetails->currency_code}} {{@$value->total_price}}</p>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
      <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 20px 0px 10px 0px;">Thank you,</p>
      <p style="font-family:Arial; font-size:14px; font-weight:500; color:#363839;margin: 0px 0px 10px 0px;">Team Astroaquila</p>
    </div>
  </body>
</html>
