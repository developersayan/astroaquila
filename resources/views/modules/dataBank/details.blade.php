@extends('layouts.app')

@section('title')
<meta name="title" content="{{@$data->name}}">

<meta property="og:title" content="Puja | {{@$data->name }}">

@if(@$data->image)
<meta property="og:image" content="{{ URL::to('storage/app/public/dataBank')}}/{{$data->image}}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/videos2.jpg')}}" alt="">
@endif
<title>Details of {{@$data->name}}</title>
@endsection

@section('style')
@include('includes.style')
<style>
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
.spectrum--light .spectrum-ActionButton--quiet {
    background-color: transparent;
    border-color: transparent;
    color: #4b4b4b;
    display: none;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
    .error {
        color: red;
        text-align: left !important;
    }
    .pac-container {
        z-index: 1060 !important;
    }
    .form_box_area {
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .form_box_area input[type] {
        height: 38px;
    }
    .form_box_area select {
        height: 38px;
    }
    .form_box_area label {
        font: 400 14px/20px 'Roboto', sans-serif;
        margin-bottom: 4px;
    }
    .owl-nav{
        display: block !important;
    }
    .owl-prev {
        position: absolute;
        top: 154px;
        width: 13px;
        height: 29px;
        background-size: 100%;
        font-size: 0 !important;
        left: -15px;
        background: url(../public/frontend/images/stonleft.png)no-repeat;
    }
    .owl-next {
        position: absolute;
        top: 154px;
        width: 13px;
        height: 29px;
        background-size: 100%;
        font-size: 0 !important;
        right: -15px;
        background: url(../public/frontend/images/stonright.png)no-repeat;
    }
    .error{
        color: red !important;
    }

</style>
@endsection

@section('header')
@include('includes.header')
@endsection


@section('body')
<?php
 $custom = (new \App\Helpers\CustomHelper)->currencyConversion();
?>
<section class="pad-114 data_ban">
    <div class="banner-inner">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="inner-headings">
              <h3>Details of {{@$data->name}}</h3>
              <div class="shareBx">
                <span><i class="fa fa-share-square-o" aria-hidden="true"></i>Share:</span>
                
                              <div class="clearfix"></div>
                              
                <ul style="min-width: 160px">
                  <div class="sharethis-inline-share-buttons"></div>
                </ul>   
              </div> 
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<div class="details_sec puja_det_pg new-all-details">
    <div class="container">
        <div class="details_iner">
            <div class="details_left">
                <div class="astro_details noflex back_white">
                    <div class="astroflex">
                    <div class="ast_det_left">
                        <div class="media">
                            <em>@if(@$data->image) <img src="{{ URL::to('storage/app/public/dataBank')}}/{{$data->image}}" alt=""> @else <img src="{{ URL::to('public/frontend/images/videos2.jpg')}}" alt=""> @endif</em>
                            <div class="media-body">
                                <h4>{{@$data->name}}</h4>
                                <p>Profession: {{@$data->professionName->name}}</p>
                                <p>Famous For: {{@$data->famousName->name}}</p>
                                <p>{{@$data->countrylist->name}},{{@$data->statelist->name}},{{@$data->citylist->name}}</p>
                                <p>DOB : {{ date('F j, Y', strtotime(@$data->dob))}}</p>
                                <p>Place Of Birth : {{$data->place_of_birth}}</p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="shareBx" >
                        <span><i class="fa fa-share-square-o" aria-hidden="true"></i>{{__('search.share')}}:</span>

                     {{--    <ul style="min-width: 160px">
                            <div class="sharethis-inline-share-buttons"></div>
                        </ul> --}}


                    </div>
                    </div>
                    
                </div>

                @if(@$data->description)
                <div class="about_astro back_white">         
                <h2>Description</h2>           
                    <div class="edu_quli">

                        <div class="edu_quliitem">
               
                                <p>{!!@$data->description!!}</p>
                               
                              </div>
                            </div>
                          </div>
              @endif

                 @if(@$data->file_upload)
                <div class="about_astro back_white">                    
                    <div class="edu_quli">
                        <div class="edu_quliitem">
               
                                <div id="adobe-dc-view" style="height: 800px; width: 100%;"></div>
                               
                              </div>
                            </div>
                          </div>
              @endif  
				
				
				
                
            </div>

            <div class="ast_det_right bac">
                <div class="ast_det_right_inr">
                    @if(@$similar->isNotEmpty())
                        <div class="astro-dash-form new-astropuja">
                            <div class="row similer-puja">
                                <div  style="display: block; width:100%;">
                                    @foreach ($similar as $value)
                                    <div class="item">
                                        <div class="gem-stone-item back_white">
                                            <a href="{{route('aquila.data.bank.details',['id'=>@$value->slug])}}"><span>@if(@$value->image) <img src="{{ URL::to('storage/app/public/dataBank')}}/{{$value->image}}" > @else <img src="{{ URL::to('public/frontend/images/videos2.jpg')}}" alt=""> @endif</span></a>
                                            <div class="gem-stone-text">
                                               <h6><a href="{{route('aquila.data.bank.details',['id'=>@$value->slug])}} " target="_blank">{{@$value->name}}</a></h6>
                                                <p>Profession: {{@$value->professionName->name}}</p>
                                                <p>Famous For: {{@$value->famousName->name}}</p>
                                                <p>{{@$value->countrylist->name}},{{@$value->statelist->name}},{{@$value->citylist->name}}</p>
                                                <p>DOB : {{ date('F j, Y', strtotime(@$value->dob))}}</p>
                                                <p>Place Of Birth : {{$value->place_of_birth}}</p>
                                                    {{-- <span style="height: auto; border: 0px; text-align:left"> --}}
                                        <a href="{{route('aquila.data.bank.details',['id'=>@$value->slug])}}" class="pag_btn"  style="    height: 34px;
    line-height: 34px;">View More</a>
                                    {{-- </span>
 --}}                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                
                            </div>
                            
                            
                            </div>
                            @endif
                        </div>
                    
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

   

<script type="text/javascript">
// $('body').on('focus', '.datepicker_puja', function(){

//      var currentDate = new Date();
//      // $(this).datepicker
//     // $(this).datepicker();
//         $(this).datepicker({
//          changeMonth: true,
//          changeYear:true,
//         });

// });
//$(".datepicker_puja").prop('readonly', false);

</script>
  
<script>
    $('.moreless-button').click(function() {

        if ($('.moreless-button').text() == "{{__('search.read_more')}} +") {
            $('.aboutRemaove').hide();
            $('.moretext').show();
            $(this).text("{{__('search.read_less')}} -")
        } else {
            $('.aboutRemaove').show();
            $('.moretext').hide();
            $(this).text("{{__('search.read_more')}} +")
        }
        // $('.moretext').slideToggle();

    });
</script>
<script type="text/javascript">
    $('.moreless-button1').click(function() {
  $('.moretext1').slideToggle();
  if ($('.moreless-button1').text() == "{{__('search.view_all')}} +") {
    $(this).text("{{__('search.view_less')}} -")
  } else {
    $(this).text("{{__('search.view_all')}} +")
  }
});
</script>
<script type="text/javascript">
    $('.moreless-button2').click(function() {
  $('.moretext2').slideToggle();
  if ($('.moreless-button2').text() == "{{__('search.read_more')}} +") {
    $(this).text("{{__('search.read_less')}} -")
  } else {
    $(this).text("{{__('search.read_more')}} +")
  }
});
</script>

<script type="text/javascript">
    $('.moreless-button3').click(function() {
  $('.moretext3').slideToggle();
  if ($('.moreless-button3').text() == "{{__('search.read_more')}} +") {
    $(this).text("{{__('search.read_less')}} -")
  } else {
    $(this).text("{{__('search.read_more')}}e +")
  }
});
</script>


<script type="text/javascript">
    $('.moreless-button4').click(function() {
  $('.moretext4').slideToggle();
  if ($('.moreless-button4').text() == "{{__('search.read_more')}} +") {
    $(this).text("{{__('search.read_less')}} -")
  } else {
    $(this).text("{{__('search.read_more')}} +")
  }
});
</script>


<script type="text/javascript">
    $('.moreless-button5').click(function() {
  $('.moretext5').slideToggle();
  if ($('.moreless-button5').text() == "Show More Reviews +") {
    $(this).text("Show Less Reviews -")
  } else {
    $(this).text("Show More Reviews +")
  }
});
</script>
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>

@if(@$data->file_upload)
<script src="https://documentcloud.adobe.com/view-sdk/main.js"></script>
<script type="text/javascript">
  document.addEventListener("adobe_dc_view_sdk.ready", function(){ 
    var adobeDCView = new AdobeDC.View({clientId: "{{env('ADOBE_CLIENT_ID')}}", divId: "adobe-dc-view"});
    adobeDCView.previewFile({
      content:{location: {url: "{{URL::to('storage/app/public/data_bank_attachment/'.$data->file_upload)}}"}},
      metaData:{fileName: "{{$data->file_upload}}"}
    }, {embedMode: "SIZED_CONTAINER", showDownloadPDF: false, showPrintPDF: false});
  });
</script>
@endif

@endsection

