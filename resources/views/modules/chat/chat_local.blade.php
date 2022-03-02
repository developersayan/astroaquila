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
$emoji_array=["😀", "😃", "😄", "😁", "😆", "😅", "😂", "🤣","😊", "😇", "🙂", "🙃", "😉", "😌", "😍", "🥰", "😘", "😗", "😙", "😚", "😋", "😛", "😝", "😜", "🤪", "🤨", "🧐", "🤓", "😎", "🤩", "🥳", "😏", "😒", "😞", "😔", "😟", "😕", "🙁", "☹️", "😣", "😖", "😫",
        "😩", "🥺", "😢", "😭", "😤", "😠", "😡", "🤬", "🤯", "😳", "🥵", "🥶", "😱", "😨", "😰", "😥", "😓", "🤗", "🤔", "🤭", "🤫", "🤥", "😶", "😐", "😑", "😬", "🙄", "😯", "😦", "😧", "😮", "😲", "🥱", "😴", "🤤", "😪", "😵", "🤐", "🥴", "🤢", "🤮", "🤧", "😷", "🤒", "🤕",
        "🤑", "🤠", "😈", "👿", "👹", "👺", "🤡", "💩", "👻", "💀", "☠️", "👽", "👾", "🤖", "🎃", "😺", "😸", "😹", "😻", "😼", "😽", "🙀", "😿", "😾", "👋", "🤚", "🖐", "✋", "🖖", "👌", "🤏", "✌️", "🤞", "🤟", "🤘", "🤙", "👈", "👉", "👆", "🖕", "👇", "☝️", "👍", "👎", "✊", "👊", "🤛",
        "🤜", "👏", "🙌", "👐", "🤲", "🤝", "🙏",   "✍️", "💅", "🤳", "💪", "🦾", "🦵", "🦿", "🦶", "👣", "👂", "🦻", "👃", "🧠", "🦷", "🦴", "👀", "👁", "👅", "👄", "💋", "🩸", "👶", "👧", "🧒", "👦", "👩", "🧑", "👨", "👩‍🦱", "👨‍🦱", "👩‍🦰", "👨‍🦰", "👱‍♀️", "👱", "👱‍♂️", "👩‍🦳", "👨‍🦳", "👩‍🦲", "👨‍🦲",
        "🧔", "👵", "🧓", "👴", "👲", "👳‍♀️", "👳", "👳‍♂️", "🧕", "👮‍♀️", "👮", "👮‍♂️", "👷‍♀️", "👷", "👷‍♂️", "💂‍♀️", "💂", "💂‍♂️", "🕵️‍♀️", "🕵️", "🕵️‍♂️", "👩‍⚕️", "👨‍⚕️", "👩‍🌾", "👨‍🌾", "👩‍🍳", "👨‍🍳", "👩‍🎓", "🧑‍🎓", "👨‍🎓", "👩‍🎤", "👨‍🎤", "👩‍🏫", "👨‍🏫", "👩‍🏭", "👨‍🏭", "👩‍💻", "💻",
        "👨‍💻", "👩‍💼", "👨‍💼", "👩‍🔧", "🧑‍🔧", "👨‍🔧", "👩‍🔬", "🧑‍🔬", "👨‍🔬", "👩‍🎨", "🧑‍🎨", "👨‍🎨", "👩‍🚒", "👨‍🚒", "👩‍✈️", "🧑‍✈️", "👨‍✈️", "👩‍🚀", "👨‍🚀", "👩‍⚖️", "👨‍⚖️", "👰", "🤵", "👸", "🤴", "🦸‍♀️", "🦸", "🦸‍♂️", "🦹‍♀️", "🦹", "🦹‍♂️", "🤶", "🎅", "🧙‍♀️",
        "🧙", "🧙‍♂️", "🧝‍♀️", "🧝", "🧝‍♂️", "🧛‍♀️", "🧛", "🧛‍♂️", "🧟‍♀️", "🧟", "🧟‍♂️", "🧞‍♀️", "🧞", "🧞‍♂️", "🧜‍♀️", "🧜", "🧜‍♂️", "🧚‍♀️", "🧚", "🧚‍♂️", "👼", "🤰", "🤱", "🙇‍♀️", "🙇", "🙇‍♂️", "💁‍♀️", "💁", "💁‍♂️", "🙅‍♀️", "🙅", "🙅‍♂️", "🙆‍♀️", "🙆", "🙆‍♂️", "🙋‍♀️", "🙋", "🙋‍♂️", "🧏‍♀️", "🧏", "🧏‍♂️", "🤦‍♀️", "🤦",
        "🤦‍♂️", "🤷‍♀️", "🤷", "🤷‍♂️", "🙎‍♀️", "🙎", "🙎‍♂️", "🙍‍♀️", "🙍", "🙍‍♂️", "💇‍♀️", "💇", "💇‍♂️", "💆‍♀️", "💆", "💆‍♂️", "🧖‍♀️", "🧖", "🧖‍♂️", "💅", "🤳", "💃", "🕺", "👯‍♀️", "👯", "👯‍♂️", "🕴", "👩‍🦽", "👨‍🦽", "👩‍🦼", "👨‍🦼", "🚶‍♀️", "🚶", "🚶‍♂️", "👩‍🦯", "👨‍🦯", "🧎‍♀️", "🧎", "🧎‍♂️", "🏃‍♀️", "🏃", "🏃‍♂️", "🧍‍♀️", "🧍",
        "🧍‍♂️", "👭", "🧑‍🤝‍🧑", "👬", "👫", "👩‍❤️‍👩", "💑", "👨‍❤️‍👨", "👩‍❤️‍👨", "👩‍❤️‍💋‍👩", "💏", "👨‍❤️‍💋‍👨", "👩‍❤️‍💋‍👨", "👪", "👨‍👩‍👦", "👨‍👩‍👧", "👨‍👩‍👧‍👦", "👨‍👩‍👦‍👦", "👨‍👩‍👧‍👧", "👨‍👨‍👦", "👨‍👨‍👧", "👨‍👨‍👧‍👦", "👨‍👨‍👦‍👦", "👨‍👨‍👧‍👧", "👩‍👩‍👦", "👩‍👩‍👧", "👩‍👩‍👧‍👦", "👩‍👩‍👦‍👦", "👩‍👩‍👧‍👧", "👨‍👦", "👨‍👦‍👦", "👨‍👧", "👨‍👧‍👦", "👨‍👧‍👧", "👩‍👦", "👩‍👦‍👦", "👩‍👧", "👩‍👧‍👦", "👩‍👧‍👧", "🗣", "👤", "👥",
    "🧳", "🌂", "☂️", "🧵", "🧶", "👓", "🕶", "🥽", "🥼", "🦺", "👔", "👕", "👖", "🧣", "🧤", "🧥", "🧦", "👗", "👘", "🥻", "🩱", "🩲", "🩳", "👙", "👚", "👛", "👜", "👝", "🎒", "👞", "👟", "🥾", "🥿", "👠", "👡", "🩰", "👢", "👑", "👒", "🎩", "🎓", "🧢", "💄", "💍", "💼"
    ];
	
@endphp
<section class="pad-114">
    <div class="dashboard-customer">
        <div class="container">
            <div class="row">
                @include('includes.profile_sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="main-center-div back_white">
					<div class="main-chat-box main-chat-box-{{@$call_history->id}}">
                                <div class="chat-heads">
                                    <div class="chat-title">
                                        <span><b class="username-{{@$call_history->id}}">@if(auth()->user()->id==@$call_history->user_id) {{@$call_history->orderDetails['astrologer']->first_name." ".@$call_history->orderDetails['astrologer']->last_name}} @else {{@$call_history->orderDetails['customer']->first_name." ".@$call_history->orderDetails['customer']->last_name}} @endif</b></span>
                                    </div>
                                    <div class="chat-action-des" data-id="{{@$call_history->id}}">
                                        <a href="javascript:;" class="minimise-chat-box" data-id="{{@$call_history->id}}"><i aria-hidden="true" class="fa fa-minus"></i></a>
                                        <a href="javascript:;" class="chat-action" data-id="{{@$call_history->id}}"><i aria-hidden="true" class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                <div class="chat-bodys chat-bodys-{{@$call_history->id}}">
								@if($chat_history->isNotEmpty())
								@foreach($chat_history as $chat)
								@if($chat->sent_by==auth()->user()->id)
                                        <div class="media w-100 ml-auto mb-3 reciever-div">
                                                        <div class="media-body mr-3">
                                                            <div class="bg-styled rounded py-2 px-3 mb-1">
                                                                <p class="text-small mb-0">{{@$chat->message}}@if(@$chat->file)<a href="{{asset('storage/app/public/astrologer_chat_image/'.@$chat->file)}}" class="msg-link-color" target=_blank download>{{@$chat->file}}</a>@endif</p>
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
                                                            <p class="text-small mb-0 text-muted">{{@$chat->message}} @if(@$chat->file)<a href="{{asset('storage/app/public/astrologer_chat_image/'.@$chat->file)}}" class="msg-link-color" target=_blank download>{{@$chat->file}}</a>@endif</p>
                                                        </div>
                                                        <br>
                                                        <p class="small">{{getDateTimeDiff($chat->created_at,date('Y-m-d H:i:s'))}}</p>
                                                    </div>
                                                </div>
                                    @endif
									@endforeach
									@endif
								</div>
                                <div class="file-append file-append-{{@$call_history->id}}"></div>
                                <div class="typing-text typing-text-{{@$call_history->id}}"></div>
                                <form class="frm_msg" onsubmit="return sendMsg({{@$call_history->id}})" data-id="{{@$call_history->id}}">
                                    <div class="rm_emoji_area rm_emoji_area-{{@$call_history->id}}" style="display:none;"><ul>@for($k = 0; $k < count($emoji_array); $k++) <li class="emoticon">{{$emoji_array[$k]}}</li> @endfor</ul></div>
                                    <div class="chat-fots">
                                        <textarea class="type-msgs chat-msg-{{@$call_history->id}}" data-id="{{@$call_history->id}}" placeholder="Type your message.."></textarea>
                                        <div class="upload_box">
                                            <input type="file" id="file-{{@$call_history->id}}" data-id="{{@$call_history->id}}" class="file-upload-chat file-{{@$call_history->id}}">
                                            <label for="file-{{@$call_history->id}}" class="btn-2"></label>
                                        </div>
                                        <a href="javascript:void(0);" class="rm_emoji" data-id="{{@$call_history->id}}">🙂</a>
                                        <p class="file-name-foots file-name-{{@$call_history->id}}"></p>
                                        <a href="javascript:void(0);" class="chat-send" data-id="{{@$call_history->id}}"><i class="fa fa-paper-plane"></i></a>
                                    </div>
                                </form>
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
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  {{-- Pusher Scripts Start --}}
<script>
    var message_master_id={{@$call_history->id}};
    var name = "{{@Auth::user()->first_name}}";
    var my_id = parseInt("{{@Auth::user()->id}}");
    var user_arr=msgmaster_arr=[];
    var keyup = 0;
    
	
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: '{{env('PUSHER_APP_CLUSTER')}}'
    });

    var socketId = null;
    pusher.connection.bind('connected', function() {
        socketId = pusher.connection.socket_id;
    });
    var channel = pusher.subscribe('astroaquila');
    
    //Typing
    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 3000;  //time in ms (3 seconds)

    function nl2br (str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
    function sendMsg(id){
        var replymsg = "";
        var err = 0;
        var filecnt = 0;
        if($('.chat-msg-'+id).val()!="")
            replymsg = $.trim($('.chat-msg-'+id).val());
        var files = $('.file-'+id).prop('files');
        if(Object.keys(files).length>0){
            $('.typing-text-'+id).text("uploading...");
            $('.typing-text-chats-'+id).text("uploading...");
        }
        data = new FormData();
        data.append('_token', "{{ csrf_token() }}");
        data.append('booking_id',id);
        data.append('message',replymsg);
        data.append('socket_id',socketId);
        console.log(data);
        console.log("SEND MSG 1");
        var err = 0;
        var filecnt = 0;
        console.log("Stopped typing");
        startStopTypingAJAX('end');
        keyup = 0;
        $.each(files, function(k,file){
            var fileExt = file.name.split('.').pop();
			console.log(fileExt);
            if(fileExt == "doc" || fileExt == "docx" || fileExt == "jpg" || fileExt == "png" || fileExt == "gif" || fileExt == "pdf" || fileExt == "PDF" || fileExt == "DOC" || fileExt == "DOCX" || fileExt == "JPG" || fileExt == "PNG") {
                alert("This file cannot be uploaded.");
                err = 1;
            } else {
                data.append('file', file);
            }
        });
        $('.file-append').empty();
        $('.file-append-chats').empty();
        if(err == 0){
            filecnt = Object.keys(files).length;
        }
		alert(filecnt);
        if (replymsg || filecnt>0) {
			$('.chat-msg-'+id).val("");
			$('.file-'+id).val('');
            $('.file-name-'+id).html('');
            $.ajax({
                url: '{{ route("send.chat.message") }}',
                type: 'POST',
                dataType: 'JSON',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
            })
            .done(result => {
                $('.typing-text').text("");
                $('.typing-text-chats').text("");
				console.log(result);
				var file='';
				var filepath='';
				if(result.result.file!='')
				{
					filepath='{{asset("storage/app/public/astrologer_chat_image/")}}';
					file='<a href="'+filepath+result.result.file+'" class="msg-link-color" target=_blank download>'+result.result.file+'</a>';
				}
				var html='<div class="media w-100 ml-auto mb-3 reciever-div"><div class="media-body mr-3"><div class="bg-styled rounded py-2 px-3 mb-1"><p class="text-small mb-0">'+replymsg+' '+file+'</p> </div><div class="w-100"></div><p class="small">'+result.result.created_at+'</p></div> <img src="'+result.result.image+'" alt="" width="30" class="rounded-circle"></div>';
				$('.chat-bodys-'+id).append(html);
			});
		}
		else {
            alert('Please type some message or insert file.');
        }
	}
	$("body").delegate(".chat-send", "click", function(e) {
		sendMsg($(this).data('id'));
		$(this).val("");
	});
	function startStopTypingAJAX(typing) {
        $.ajax({
            url: '{{ route("typing.ajax") }}',
            type: 'POST',
            dataType: 'JSON',
            data: {
                message_master_id:message_master_id,
                from: name,
                typing: typing,
                _token: '{{ csrf_token() }}',
                socket_id: socketId,
            }
        });
    }
	$("body").delegate(".type-msgs", "keyup", function(e) {
            // Enter was pressed without shift key
            e.preventDefault();
            if(keyup == 0)
                keyup = 1;
            $('.message_master_id').val($(this).data('id'));
            if(e.key == 'Enter' && e.ctrlKey) {
                test=$(this).val()+"\r\n";
                $(this).val(test);
                e.preventDefault();
            } else if(e.key == 'Enter') {
                // console.log($(this).data('id'));
                e.preventDefault();
                sendMsg($(this).data('id'));
                $(this).val("");
            }
            if(keyup == 1){
                // fire typing event
                startStopTypingAJAX('start');
                keyup = 2;
            }
            clearTimeout(typingTimer);
            if ($(this).val()) {
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            }
        });
		//user is "finished typing," do something
    function doneTyping () {
        console.log("Stopped typing");
        startStopTypingAJAX('end');
        keyup = 0;
    }
	channel.bind('start-end-typing', function(data) {
		if(data.typing == 'start'){
			$('.typing-text-'+data.message_master_id).text("typing...");
			//$('.chat-bodys-'+data.message_master_id).css("height", "228px");
			$('.typing-text-chats').text("typing...");
		} else if(data.typing == 'end') {
			$('.typing-text-'+data.message_master_id).text("");
			//$('.chat-bodys-'+data.message_master_id).css("height", "242px");
			$('.typing-text-chats').text("");
		}            
    });
	$("body").delegate(".rm_emoji", "click", function(e) {
            e.preventDefault();
            $(".rm_emoji_area").slideToggle("slow");
		});

        $("body").delegate(".emoticon", "click", function() {
            var emoticon = $(this).text();
            textvalue = $('.type-msgs').val();
            $('.type-msgs').val(textvalue + emoticon);
        });
		channel.bind('receive-event', function(data) {            
            newmsg = data.message;
            /*console.log("receive event triggered:");
            console.log(data);*/
			var file='';
			var filepath='';
			if(data.file!='')
			{
				filepath='{{asset("storage/app/public/astrologer_chat_image/")}}';
				file='<a href="'+filepath+data.file+'" class="msg-link-color" target=_blank download>'+data.file+'</a>';
			}
			var html='<div class="media w-100 mb-3 sender-div"><img src="'+data.image+'" alt="" width="32" class="rounded-circle"><div class="media-body ml-3"><h5>'+data.from+'</h5><div class="bg-light rounded py-2 px-3 mb-1">	<p class="text-small mb-0 text-muted">'+newmsg+' '+file+'</p>	</div><br><p class="small">'+data.created_at+'</p></div></div>';
			$('.chat-bodys-'+data.pusher_message_master_id).append(html);
			
        });
</script>
{{-- Pusher Scripts End --}}
   <script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
@endsection
