@extends('layouts.app')

@section('title')
<title>Chat</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection

@section('body')
@php
$emoji_array=["๐", "๐", "๐", "๐", "๐", "๐", "๐", "๐คฃ","๐", "๐", "๐", "๐", "๐", "๐", "๐", "๐ฅฐ", "๐", "๐", "๐", "๐", "๐", "๐", "๐", "๐", "๐คช", "๐คจ", "๐ง", "๐ค", "๐", "๐คฉ", "๐ฅณ", "๐", "๐", "๐", "๐", "๐", "๐", "๐", "โน๏ธ", "๐ฃ", "๐", "๐ซ",
        "๐ฉ", "๐ฅบ", "๐ข", "๐ญ", "๐ค", "๐ ", "๐ก", "๐คฌ", "๐คฏ", "๐ณ", "๐ฅต", "๐ฅถ", "๐ฑ", "๐จ", "๐ฐ", "๐ฅ", "๐", "๐ค", "๐ค", "๐คญ", "๐คซ", "๐คฅ", "๐ถ", "๐", "๐", "๐ฌ", "๐", "๐ฏ", "๐ฆ", "๐ง", "๐ฎ", "๐ฒ", "๐ฅฑ", "๐ด", "๐คค", "๐ช", "๐ต", "๐ค", "๐ฅด", "๐คข", "๐คฎ", "๐คง", "๐ท", "๐ค", "๐ค",
        "๐ค", "๐ค ", "๐", "๐ฟ", "๐น", "๐บ", "๐คก", "๐ฉ", "๐ป", "๐", "โ ๏ธ", "๐ฝ", "๐พ", "๐ค", "๐", "๐บ", "๐ธ", "๐น", "๐ป", "๐ผ", "๐ฝ", "๐", "๐ฟ", "๐พ", "๐", "๐ค", "๐", "โ", "๐", "๐", "๐ค", "โ๏ธ", "๐ค", "๐ค", "๐ค", "๐ค", "๐", "๐", "๐", "๐", "๐", "โ๏ธ", "๐", "๐", "โ", "๐", "๐ค",
        "๐ค", "๐", "๐", "๐", "๐คฒ", "๐ค", "๐",   "โ๏ธ", "๐", "๐คณ", "๐ช", "๐ฆพ", "๐ฆต", "๐ฆฟ", "๐ฆถ", "๐ฃ", "๐", "๐ฆป", "๐", "๐ง ", "๐ฆท", "๐ฆด", "๐", "๐", "๐", "๐", "๐", "๐ฉธ", "๐ถ", "๐ง", "๐ง", "๐ฆ", "๐ฉ", "๐ง", "๐จ", "๐ฉโ๐ฆฑ", "๐จโ๐ฆฑ", "๐ฉโ๐ฆฐ", "๐จโ๐ฆฐ", "๐ฑโโ๏ธ", "๐ฑ", "๐ฑโโ๏ธ", "๐ฉโ๐ฆณ", "๐จโ๐ฆณ", "๐ฉโ๐ฆฒ", "๐จโ๐ฆฒ",
        "๐ง", "๐ต", "๐ง", "๐ด", "๐ฒ", "๐ณโโ๏ธ", "๐ณ", "๐ณโโ๏ธ", "๐ง", "๐ฎโโ๏ธ", "๐ฎ", "๐ฎโโ๏ธ", "๐ทโโ๏ธ", "๐ท", "๐ทโโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐ต๏ธโโ๏ธ", "๐ต๏ธ", "๐ต๏ธโโ๏ธ", "๐ฉโโ๏ธ", "๐จโโ๏ธ", "๐ฉโ๐พ", "๐จโ๐พ", "๐ฉโ๐ณ", "๐จโ๐ณ", "๐ฉโ๐", "๐งโ๐", "๐จโ๐", "๐ฉโ๐ค", "๐จโ๐ค", "๐ฉโ๐ซ", "๐จโ๐ซ", "๐ฉโ๐ญ", "๐จโ๐ญ", "๐ฉโ๐ป", "๐ป",
        "๐จโ๐ป", "๐ฉโ๐ผ", "๐จโ๐ผ", "๐ฉโ๐ง", "๐งโ๐ง", "๐จโ๐ง", "๐ฉโ๐ฌ", "๐งโ๐ฌ", "๐จโ๐ฌ", "๐ฉโ๐จ", "๐งโ๐จ", "๐จโ๐จ", "๐ฉโ๐", "๐จโ๐", "๐ฉโโ๏ธ", "๐งโโ๏ธ", "๐จโโ๏ธ", "๐ฉโ๐", "๐จโ๐", "๐ฉโโ๏ธ", "๐จโโ๏ธ", "๐ฐ", "๐คต", "๐ธ", "๐คด", "๐ฆธโโ๏ธ", "๐ฆธ", "๐ฆธโโ๏ธ", "๐ฆนโโ๏ธ", "๐ฆน", "๐ฆนโโ๏ธ", "๐คถ", "๐", "๐งโโ๏ธ",
        "๐ง", "๐งโโ๏ธ", "๐งโโ๏ธ", "๐ง", "๐งโโ๏ธ", "๐งโโ๏ธ", "๐ง", "๐งโโ๏ธ", "๐งโโ๏ธ", "๐ง", "๐งโโ๏ธ", "๐งโโ๏ธ", "๐ง", "๐งโโ๏ธ", "๐งโโ๏ธ", "๐ง", "๐งโโ๏ธ", "๐งโโ๏ธ", "๐ง", "๐งโโ๏ธ", "๐ผ", "๐คฐ", "๐คฑ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐งโโ๏ธ", "๐ง", "๐งโโ๏ธ", "๐คฆโโ๏ธ", "๐คฆ",
        "๐คฆโโ๏ธ", "๐คทโโ๏ธ", "๐คท", "๐คทโโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐งโโ๏ธ", "๐ง", "๐งโโ๏ธ", "๐", "๐คณ", "๐", "๐บ", "๐ฏโโ๏ธ", "๐ฏ", "๐ฏโโ๏ธ", "๐ด", "๐ฉโ๐ฆฝ", "๐จโ๐ฆฝ", "๐ฉโ๐ฆผ", "๐จโ๐ฆผ", "๐ถโโ๏ธ", "๐ถ", "๐ถโโ๏ธ", "๐ฉโ๐ฆฏ", "๐จโ๐ฆฏ", "๐งโโ๏ธ", "๐ง", "๐งโโ๏ธ", "๐โโ๏ธ", "๐", "๐โโ๏ธ", "๐งโโ๏ธ", "๐ง",
        "๐งโโ๏ธ", "๐ญ", "๐งโ๐คโ๐ง", "๐ฌ", "๐ซ", "๐ฉโโค๏ธโ๐ฉ", "๐", "๐จโโค๏ธโ๐จ", "๐ฉโโค๏ธโ๐จ", "๐ฉโโค๏ธโ๐โ๐ฉ", "๐", "๐จโโค๏ธโ๐โ๐จ", "๐ฉโโค๏ธโ๐โ๐จ", "๐ช", "๐จโ๐ฉโ๐ฆ", "๐จโ๐ฉโ๐ง", "๐จโ๐ฉโ๐งโ๐ฆ", "๐จโ๐ฉโ๐ฆโ๐ฆ", "๐จโ๐ฉโ๐งโ๐ง", "๐จโ๐จโ๐ฆ", "๐จโ๐จโ๐ง", "๐จโ๐จโ๐งโ๐ฆ", "๐จโ๐จโ๐ฆโ๐ฆ", "๐จโ๐จโ๐งโ๐ง", "๐ฉโ๐ฉโ๐ฆ", "๐ฉโ๐ฉโ๐ง", "๐ฉโ๐ฉโ๐งโ๐ฆ", "๐ฉโ๐ฉโ๐ฆโ๐ฆ", "๐ฉโ๐ฉโ๐งโ๐ง", "๐จโ๐ฆ", "๐จโ๐ฆโ๐ฆ", "๐จโ๐ง", "๐จโ๐งโ๐ฆ", "๐จโ๐งโ๐ง", "๐ฉโ๐ฆ", "๐ฉโ๐ฆโ๐ฆ", "๐ฉโ๐ง", "๐ฉโ๐งโ๐ฆ", "๐ฉโ๐งโ๐ง", "๐ฃ", "๐ค", "๐ฅ",
    "๐งณ", "๐", "โ๏ธ", "๐งต", "๐งถ", "๐", "๐ถ", "๐ฅฝ", "๐ฅผ", "๐ฆบ", "๐", "๐", "๐", "๐งฃ", "๐งค", "๐งฅ", "๐งฆ", "๐", "๐", "๐ฅป", "๐ฉฑ", "๐ฉฒ", "๐ฉณ", "๐", "๐", "๐", "๐", "๐", "๐", "๐", "๐", "๐ฅพ", "๐ฅฟ", "๐ ", "๐ก", "๐ฉฐ", "๐ข", "๐", "๐", "๐ฉ", "๐", "๐งข", "๐", "๐", "๐ผ"
    ];

@endphp
<section class="pad-114">
    <div class="dashboard-customer">
        <div class="container">
            <div class="row">
                @include('includes.profile_sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="cus-dashboard-right">
                            <h2>chat</h2> </div>
                            <div class="cus-rightbody p-0">
                    <div class="main-center-div back_white new-chat-boxs">
					<div class="main-chat-box main-chat-box-{{@$call_history->id}}">
                                <div class="chat-heads">
                                    <div class="chat-title chat_timer">
                                        <span><b class="username-{{@$call_history->id}}">@if(auth()->user()->id==@$call_history->user_id) {{@$call_history->orderDetails['astrologer']->first_name." ".@$call_history->orderDetails['astrologer']->last_name}} @else {{@$call_history->orderDetails['customer']->first_name." ".@$call_history->orderDetails['customer']->last_name}} @endif</b></span>
                                        @if(@$call_history->call_status=='C') <div class="timer_all">Chat has ended</div> @else
										    <div class="timer_all timer_all-{{@$call_history->id}}">
                                                <i class="fa fa-clock-o"></i>
                                                <span id="time" class="time-{{@$call_history->id}}">
                                                    @if(@$call_history->is_per_minute == 'N')
                                                       {{@$call_history->call_duration}}:00
                                                    @else
                                                        0:0
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
										@if(@$call_history->orderDetails['orderPujaNames'])
											<div class="clearfix"></div>
											<span>Person details: </span>
											<span>@if(@$call_history->orderDetails['orderPujaNames']->name) <br><b>Name:</b> {{@$call_history->orderDetails['orderPujaNames']->name}} @endif @if(@$call_history->orderDetails['orderPujaNames']->dob) <br><b>Date Of Birth:</b> {{date('jS F Y',strtotime(@$call_history->orderDetails['orderPujaNames']->dob))}} @endif @if(@$call_history->orderDetails['orderPujaNames']->janam_rashi_lagna) <br><b>Janam rashi:</b> {{@$call_history->orderDetails['orderPujaNames']->rashis->name}} @endif  @if(@$call_history->orderDetails['orderPujaNames']->gotra) <br><b>Gotra:</b> {{@$call_history->orderDetails['orderPujaNames']->gotra}} @endif @if(@$call_history->orderDetails['orderPujaNames']->janama_nkshatra) <br><b>Janam Nakshatra:</b> {{@$call_history->orderDetails['orderPujaNames']->nakshatras->name}} @endif @if(@$call_history->orderDetails['orderPujaNames']->place_of_residence) <br><b>Residence:</b> {{@$call_history->orderDetails['orderPujaNames']->place_of_residence}} @endif @if(@$call_history->orderDetails['orderPujaNames']->relation) <br><b>Relation:</b> {{@$call_history->orderDetails['orderPujaNames']->relation}} @endif</span>
										@endif
										@if(@$call_history->orderDetails->expertise) <span><br><b>Expertise:</b> {{@$call_history->orderDetails->expertise_name->expertise_name}}</span> @endif
										@if(@$call_history->orderDetails->measurement) <span><br><b>Measurment:</b> {{@$call_history->orderDetails->measurement}}</span> @endif
										@if(@$call_history->orderDetails->astro_attachment) <span><br><b>Astro attachment:</b> {{@$call_history->orderDetails->astro_attachment}}<a href="{{url('storage/app/public/astro_attachment/'.@$call_history->orderDetails->astro_attachment)}}" download> <i class="fa fa-download"></i> </a></span> @endif
										@if(@$call_history->orderDetails->order_description) <span><br><b>Description:</b> {{@$call_history->orderDetails->order_description}}</span> @endif
                                    </div>
									
                                    <div class="chat-action-des" data-id="{{@$call_history->id}}">
                                        <!--<a href="javascript:;" class="minimise-chat-box" data-id="{{@$call_history->id}}"><i aria-hidden="true" class="fa fa-minus"></i></a>
                                        <a href="javascript:;" class="chat-action" data-id="{{@$call_history->id}}"><i aria-hidden="true" class="fa fa-times"></i></a>-->
                                    </div>
                                </div>
                                <div class="chat-bodys chat-bodys-{{@$call_history->id}}">
								@if($chat_history->isNotEmpty())
								@foreach($chat_history as $chat)
								@if($chat->sent_by==auth()->user()->id)
                                        <div class="media w-100 ml-auto mb-3 reciever-div">
                                                        <div class="media-body mr-1">
                                                            <div class="bg-styled rounded py-2 px-3 mb-1">
                                                                <p class="text-small mb-0" style="word-break: break-word;">{{@$chat->message}}@if(@$chat->file)<a href="{{asset('storage/app/public/astrologer_chat_image/'.@$chat->file)}}" class="msg-link-color" target=_blank download><i class="fa fa-paperclip"></i>{{@$chat->file}}</a>@endif</p>
                                                            </div>
                                                            <div class="w-100"></div>
                                                            <p class="small">{{getDateTimeDiff($chat->created_at,date('Y-m-d H:i:s'))}}</p>
                                                        </div>
                                                    <img src="{{auth()->user()->profile_img ? url('storage/app/public/profile_picture/'.'/'.auth()->user()->profile_img) : url('public/frontend/images/blank.png')}}" alt="" width="30" class="rounded-circle">
                                        </div>
                                @else
                                        <div class="media w-100 mb-3 sender-div">@if($chat->sent_by==@$chat->user_id) <img src="{{@$call_history->orderDetails['customer']->profile_img ? url('storage/app/public/profile_picture/'.'/'.@$call_history->orderDetails['customer']->profile_img) : url('public/frontend/images/blank.png')}}" alt="" width="32" class="rounded-circle"> @else <img src="{{@$call_history->orderDetails['astrologer']->profile_img ? url('storage/app/public/profile_picture/'.'/'.@$call_history->orderDetails['astrologer']->profile_img) : url('public/frontend/images/blank.png')}}" alt="" width="32" class="rounded-circle">  @endif
                                                    <div class="media-body ml-3">
                                                        <h5>@if($chat->sent_by==@$chat->user_id) {{@$call_history->orderDetails['customer']->first_name." ".@$call_history->orderDetails['customer']->last_name}} @else  {{@$call_history->orderDetails['astrologer']->first_name." ".@$call_history->orderDetails['astrologer']->last_name}} @endif</h5>
                                                        <div class="bg-light rounded py-2 px-3 mb-1">
                                                            <p class="text-small mb-0 text-muted" style="word-break: break-word;">{{@$chat->message}} @if(@$chat->file)<a href="{{asset('storage/app/public/astrologer_chat_image/'.@$chat->file)}}" class="msg-link-color" target=_blank download><i class="fa fa-paperclip"></i>{{@$chat->file}}</a>@endif</p>
                                                        </div>

                                                        <p class="small">{{getDateTimeDiff($chat->created_at,date('Y-m-d H:i:s'))}}</p>
                                                    </div>
                                                </div>
                                    @endif
									@endforeach
									@endif
								</div>
                                @if(@$call_history->call_status!='C')
                                <form class="frm_msg chat_form-{{@$call_history->id}}" onsubmit="return sendMsg({{@$call_history->id}})" data-id="{{@$call_history->id}}">

                                    <div class="chat-fots">
                                        <div class="text-tops">
                                        <div class="typing-text typing-text-{{@$call_history->id}}"></div>
                                        <div class="file-append file-append-{{@$call_history->id}}"></div>
                                        </div>
                                        <div class="texarea-rea">
                                        <textarea class="type-msgs chat-msg-{{@$call_history->id}}" data-id="{{@$call_history->id}}" placeholder="Type your message.."></textarea>
                                         <a href="javascript:void(0);" class="rm_emoji" data-id="{{@$call_history->id}}">๐</a>

                                         <div class="rm_emoji_area rm_emoji_area-{{@$call_history->id}}" style="display:none;"><ul>@for($k = 0; $k < count($emoji_array); $k++) <li class="emoticon">{{$emoji_array[$k]}}</li> @endfor</ul></div>
                                         </div>
                                        <div class="upload_box">
                                            <input type="file" id="file-{{@$call_history->id}}" data-id="{{@$call_history->id}}" class="file-upload-chat file-{{@$call_history->id}}">
                                            <label for="file-{{@$call_history->id}}" class="btn-2"> Attach File </label>
                                        </div>

                                        <p class="file-name-foots file-name-{{@$call_history->id}}"></p>
                                        <a href="javascript:void(0);" class="chat-send" data-id="{{@$call_history->id}}"><i class="fa fa-paper-plane">  </i> Reply</a>

                                        <a href="javascript:void(0);" class="close_btns close-chat"> End Chat</a>
                                        <a href="javascript:void(0);" class="close_btns close-chat1" style="display:none"> End Chat</a>
                                    </div>
                                </form>
								@endif
                            </div>
                    </div>
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
<script>
$(document).ready(function(){
	$(".chat-bodys").scrollTop($('.chat-bodys').prop("scrollHeight"));
});
</script>
   <script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
@endsection
