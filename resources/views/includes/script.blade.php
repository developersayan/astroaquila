<!-- Bootstrap core JavaScript -->
<script src="{{ URL::to('public/frontend/js/jquerymin.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/bootstrap.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/select2.full.js') }}"></script>
<script src="{{ URL::to('public/frontend/js/select2.js') }}"></script>
<script src="{{ URL::to('public/frontend/js/carouselscript.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/owl.carousel.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/jquery.fancybox.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/jquery.fancybox.pack.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/jquery.fancybox-media.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/custom.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/bundle.min.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/custom-file-input.js')}}"></script>
<script src="{{ URL::to('public/frontend/js/chosen.jquery.js')}}" type="text/javascript"></script>
<script src="{{ URL::to('public/frontend/js/chosen.jquery2.js')}}" type="text/javascript"></script>
<script src="{{ URL::to('public/frontend/js/init.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@if(Auth::check())
<script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-app.js"></script>

<!-- stackoverflow solution -->
<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.5/firebase-messaging.js"></script>

<script src="{{ asset('public/frontend/js/firebase.js') }}"></script>
@endif
@include('includes.extrescript')
{{-- <script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script> --}}
<script>
    $(document).ready(function() {
        console.log($(window).width());
		$(".user_llk").click(function() {
			$(".show01").slideToggle();
            if($(window).width() <= 990){
                if($('#navbarSupportedContent').is(":visible")){
                    console.log('2')
                    $('#navbarSupportedButton').trigger('click');
                }
            }
		});
	});
</script>
<script>
    $(".mobile_filter").click(function() {
		$(".left-profle").slideToggle();
	});
</script>
<script>
    $(document).on('click', function () {
        var $target = $(event.target);
        if (!$target.closest('.shopcutBx').length && !$target.closest('.shopcut').length && $('.shopcutBx').is(":visible")) {

        }});

</script>

<script>
    $(".mobile_filter_as").click(function () {
        $(".dashboard_left_inr").slideToggle();
    });
    $(".profidrop").click(function(){
        $(".profidropdid").slideToggle();
    });
</script>
<script>
    $(document).on('click', function () {
        var $target = $(event.target);
        if (!$target.closest('.profidropdid').length && !$target.closest('.profidrop').length && $('.profidropdid').is(":visible")) {
            $('.profidropdid').slideUp();
        }
        $('#lang_change').change(function(){
            console.log($(this).val())
            var lancode = $(this).val();
            if(lancode==1){
                window.location.href = '{{route("lang",["id"=>1])}} ';
            }else{
                window.location.href = '{{route("lang",["id"=>2])}} ';
            }
        })
        $('#currency_change').change(function(){
            console.log($(this).val())
            var currencycode = $(this).val();

            if(currencycode==2){
                window.location.href = '{{route("currency",["id"=>2])}} ';
            }
            else if(currencycode==3){
                window.location.href = '{{route("currency",["id"=>3])}} ';
            }
            else if(currencycode==4){
                window.location.href = '{{route("currency",["id"=>4])}} ';
            }else if(currencycode==5){
                window.location.href = '{{route("currency",["id"=>5])}} ';
            }

        })
    });
</script>

{{-- <script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script> --}}
<script>
 $(document).on('click', function () {
  var $target = $(event.target);
  if (!$target.closest('.shopcutBx').length && !$target.closest('.shopcut').length && $('.shopcutBx').is(":visible")) {
    $('.shopcutBx').slideUp();
  }});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.login_show').click(function(){
            $("#login-modal-show").modal("show");
        });
        $('.goog-te-menu2-item').on('change',function(event){
            var lan = $('.goog-te-menu2-item').val();
            alert('sayan');
        });
       });

</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


    <script type="text/javascript">
        function googleTranslateElementInit() {
             new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'ar,bn,zh-CN,cs,nl,en,fi,fr,de,el,gu,hi,it,ja,kn,ko,ml,mr,ne,pa,pt,ro,ru,sd,es,ta,th,te,tr,ur', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
            function changeGoogleStyles() {
                if($('.goog-te-menu-frame').contents().find('.goog-te-menu2').length) {
                    $('.goog-te-menu-frame').contents().find('.goog-te-menu2').css({
                        'max-width':'100%',
                        'overflow-x':'auto',
                        'box-sizing':'border-box',
                        'height':'auto'
                    });
                } else {
                    setTimeout(changeGoogleStyles, 50);
                }
            }
            changeGoogleStyles();
        }
    </script>





@if(Auth::check())
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
@if(@$call_history->call_status=='I')
	@if(!Route::is('chat.with.astrologer'))
		@if(@$chat_audio_over=='Y')
<script>
var promise = document.querySelector('#chataudio').play();
if (promise !== undefined) {
	  promise.then(_ => {
		console.log('playing');
		//document.querySelector('#chataudio').pause();
	  }).catch(error => {
		console.log('No playing');
		//document.querySelector('#chataudio').play();
	  });
	}
unmutemp3.addEventListener('click', function() {
	console.log($("#chataudio").prop('muted'));
	if( $("#chataudio").prop('muted') ) {
		  $("#chataudio").prop('muted', false);
		 // $(this).html('<i class="fa fa-volume-up"></i>');
	} else {
	  $("#chataudio").prop('muted', true);
	  //$(this).html('<i class="fa fa-volume-off"></i>');
	}
  });
  $(document).ready(function(){
	$('#unmutemp3').click();	
  });
  setTimeout(function(){
	  document.getElementById("unmutemp3").click();
		$.ajax({
			url: '{{ route("chat.sound.off") }}',
			type: 'POST',
			dataType: 'JSON',
			data: {
				message_master_id:{{@$call_history->id}},
				_token: '{{ csrf_token() }}'
			}
		}).done(result => {
			console.log(result);
			if(result.code == 200){
				console.log(result);
			}
		});
	 },15000)
</script>
@endif
<script>
$(document).ready(function(){
$('#astrologerChatModal').modal('show'); //display something
//...

// if you don't want to lose the reference to previous backdrop
$('#astrologerChatModal').modal('hide');
$('#astrologerChatModal').data('bs.modal',null); // this clears the BS modal data
//...

// now works as you would expect
$('#astrologerChatModal').modal({backdrop:'static', keyboard:false});
$(".chat-bodys").scrollTop($('.chat-bodys').prop("scrollHeight"));
});
</script>
@endif
@if(@$call_history->chat_started == 1)
    @if(@$call_history->is_per_minute=='N')
        <script>
        var countDownDate = {{1000*strtotime($call_end_time)}};
        // Update the count down every 1 second
        var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("time").innerHTML = minutes + " : " + seconds ;

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            $('.close-chat1').click();
        }
        }, 1000);
        </script>
        @else
        <script>
        var lowwalletbalance=0;
        var countDownDate = {{1000*strtotime($call_history->call_start_time)}};
        // Update the count down every 1 second
        var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = now - countDownDate;


        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        if(hours >= 1)
        {
            document.getElementById("time").innerHTML = hours+" : "+minutes + " : " + seconds ;
        }
        else
        {
            document.getElementById("time").innerHTML = minutes + " : " + seconds ;
        }
        if(seconds == 59)
        {
            if(lowwalletbalance==1)
            {
                $('.close-chat1').click();
            }
            else
            {
                $.ajax({
                    url: '{{ route("deduct.wallet") }}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        message_master_id:{{@$call_history->id}},
                        _token: '{{ csrf_token() }}'
                    }
                }).done(result => {
                    console.log(result);
                    if(result.status == 'failure'){
                        lowwalletbalance=1;
                    }
                });
            }
        }

        }, 1000);
        </script>
        @endif
    @endif
@endif
<script>
  {{-- Pusher Scripts Start --}}
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
	
	console.log(socketId);
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
	@if(Auth::check())
	channel.bind('receive-event', function(data) {
		newmsg = data.message;
		console.log("receive event triggered:");
		console.log(data);
		var file1='';
		var filepath1='';
		var session_id={{auth()->user()->id}};
		var call_his=data.is_per_minute;
		var chat_started=data.chat_started;
		@if(@$call_history->chat_started==1)
			var timer_flag=1;
		@else
			var timer_flag=0;
		@endif
		
		
		if(timer_flag!=1)
		{
			if(data.chat_started==1 && data.chat_count1>=1 && data.chat_count2>=1){
				console.log('timer received');
                    if(call_his == 'N'){
                        //var countDownDate = (Date.parse(result.result.call_end_time+' GMT'));
                       // var countDownDate = data.call_end_time+(19*1000);
                        var countDownDate = data.call_end_time;
                        // Update the count down every 1 second
                        var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();

                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;

                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"
                        document.getElementById("time").innerHTML = minutes + " : " + seconds ;

                        // If the count down is finished, write some text
                        if (distance < 0) {
                            clearInterval(x);
                            $('.close-chat1').click();
                        }
                        }, 1000);
                    }else{
                        var lowwalletbalance=0;
                        //var countDownDate = (Date.parse(result.result.call_start_time+' GMT'));
                        //var countDownDate = data.call_start_time-(19*1000);
                        var countDownDate = data.call_start_time;
                        var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();

                        // Find the distance between now and the count down date
                        var distance = now - countDownDate;


                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"
                        if(hours >= 1)
                        {
                            document.getElementById("time").innerHTML = hours+" : "+minutes + " : " + seconds ;
                        }
                        else
                        {
                            document.getElementById("time").innerHTML = minutes + " : " + seconds ;
                        }
                        if(seconds == 59)
                        {
                            if(lowwalletbalance==1)
                            {
                                $('.close-chat1').click();
                            }
                            else
                            {
                                $.ajax({
                                    url: '{{ route("deduct.wallet") }}',
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data: {
                                        message_master_id:data.booking_id,
                                        _token: '{{ csrf_token() }}'
                                    }
                                }).done(result => {
                                    console.log(result);
                                    if(result.status == 'failure'){
                                        lowwalletbalance=1;
                                    }
                                });
                            }
                        }

                        }, 1000);
                    }
                    //timer_flag = 1;
                }
	}
		if(data.file!='')
		{
			filepath1='{{asset("storage/app/public/astrologer_chat_image/")}}';
			file1='<a href="'+filepath1+data.file+'" class="msg-link-color" target=_blank download><i class="fa fa-paperclip"></i>'+data.file+'</a>';
		}
		if(newmsg)
		{
			var html='<div class="media w-100 mb-3 sender-div"><img src="'+data.image+'" alt="" width="32" class="rounded-circle"><div class="media-body ml-3"><h5>'+data.from+'</h5><div class="bg-light rounded py-2 px-3 mb-1">	<p class="text-small mb-0 text-muted">'+newmsg+' '+file1+'</p>	</div><p class="small">'+data.created_at+'</p></div></div>';
		}
		else
		{
			var html='<div class="media w-100 mb-3 sender-div"><img src="'+data.image+'" alt="" width="32" class="rounded-circle"><div class="media-body ml-3"><h5>'+data.from+'</h5><div class="bg-light rounded py-2 px-3 mb-1">	<p class="text-small mb-0 text-muted">'+file1+'</p>	</div><p class="small">'+data.created_at+'</p></div></div>';
		}

		$('.chat-bodys-'+data.pusher_message_master_id).append(html);
		$(".chat-bodys").scrollTop($('.chat-bodys').prop("scrollHeight"));
		@if(!Route::is('chat.with.astrologer'))
		if(data.to_id==session_id && !$('#astrologerChatModal').is(":visible"))
		{
            location.reload();
		}
		@endif
	});
	@endif
		channel.bind('close-event', function(data) {
            var id = data.message_master_id;
            location.reload();
        });
		
	@if(@$call_history)

	var message_master_id={{@$call_history->id}};
    var chat_id={{@$call_history->id}};
    var name = "{{@Auth::user()->first_name}}";
    var my_id = parseInt("{{@Auth::user()->id}}");
    var user_type = "{{@Auth::user()->user_type}}";
    var call_his = "{{@$call_history->is_per_minute}}";
    var user_arr=msgmaster_arr=[];
    var keyup = 0;
	@if(@$chat_count1==1 && @$chat_count1==2)
		var timer_flag = 1;
	@else
		var timer_flag = 0;
	@endif
    function sendMsg(chat_id){
        var replymsg = "";
        var err = 0;
        var filecnt = 0;
        if($('.chat-msg-'+chat_id).val()!="")
            replymsg = $.trim($('.chat-msg-'+chat_id).val());
        var files = $('.file-'+chat_id).prop('files');
        if(Object.keys(files).length>0){
            $('.typing-text-'+chat_id).text("uploading...");
            $('.typing-text-chats-'+chat_id).text("uploading...");
            //$('.chat-bodys-'+chat_id).css("height", "228px");
        }
        data = new FormData();
        data.append('_token', "{{ csrf_token() }}");
        data.append('booking_id',chat_id);
        data.append('message',replymsg);
        data.append('socket_id',socketId);
        data.append('timer_flag',timer_flag);
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
				data.append('file', file);
            } else {
                alert("This file cannot be uploaded.");
                err = 1;
            }
        });
        $('.file-append').empty();
        $('.file-append-chats').empty();
        if(err == 0){
            filecnt = Object.keys(files).length;
        }
        if (replymsg || filecnt>0) {
			$('.chat-msg-'+chat_id).val("");
			$('.file-'+chat_id).val('');
            $('.file-name-'+chat_id).html('');
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
                //$('.chat-bodys-'+id).css("height", "242px");
				@if(@$call_history->chat_started!=1)
                if(result.result.chat_started==1 && result.result.chat_count1>=1 && result.result.chat_count2>=1){
					console.log('timer sent');
                    if(call_his == 'N'){
                        //var countDownDate = (Date.parse(result.result.call_end_time+' GMT'));
                        //var countDownDate = result.result.call_end_time+(19*1000);
                        var countDownDate = result.result.call_end_time;
                        // Update the count down every 1 second
                        var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();

                        // Find the distance between now and the count down date
                        var distance = countDownDate - now;

                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"
                        document.getElementById("time").innerHTML = minutes + " : " + seconds ;

                        // If the count down is finished, write some text
                        if (distance < 0) {
                            clearInterval(x);
                            $('.close-chat1').click();
                        }
                        }, 1000);
                    }else{
                        var lowwalletbalance=0;
                        //var countDownDate = (Date.parse(result.result.call_start_time+' GMT'));
                        // var countDownDate = result.result.call_start_time-(19*1000);
                        var countDownDate = result.result.call_start_time;
                        var x = setInterval(function() {

                        // Get today's date and time
                        var now = new Date().getTime();

                        // Find the distance between now and the count down date
                        var distance = now - countDownDate;


                        // Time calculations for days, hours, minutes and seconds
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Display the result in the element with id="demo"
                        if(hours >= 1)
                        {
                            document.getElementById("time").innerHTML = hours+" : "+minutes + " : " + seconds ;
                        }
                        else
                        {
                            document.getElementById("time").innerHTML = minutes + " : " + seconds ;
                        }
                        if(seconds == 59)
                        {
                            if(lowwalletbalance==1)
                            {
                                $('.close-chat1').click();
                            }
                            else
                            {
                                $.ajax({
                                    url: '{{ route("deduct.wallet") }}',
                                    type: 'POST',
                                    dataType: 'JSON',
                                    data: {
                                        message_master_id:{{@$call_history->id}},
                                        _token: '{{ csrf_token() }}'
                                    }
                                }).done(result => {
                                    console.log(result);
                                    if(result.status == 'failure'){
                                        lowwalletbalance=1;
                                    }
                                });
                            }
                        }

                        }, 1000);
                    }
                    timer_flag = 1;
                }
				@endif
				var file1='';
				var filepath1='';
				if(result.result.file!='')
				{
					console.log(result);
					filepath1='{{asset("storage/app/public/astrologer_chat_image/")}}';
					file1='<a href="'+filepath1+result.result.file+'" class="msg-link-color" target=_blank download><i class="fa fa-paperclip"></i>'+result.result.file+'</a>';
				}
				if(replymsg)
				{
					var html='<div class="media w-100 ml-auto mb-3 reciever-div"><div class="media-body mr-1"><div class="bg-styled rounded py-2 px-3 mb-1"><p class="text-small mb-0">'+replymsg+' '+file1+'</p> </div><div class="w-100"></div><p class="small">'+result.result.created_at+'</p></div> <img src="'+result.result.profile_image+'" alt="" width="30" class="rounded-circle"></div>';
				}
				else
				{
					var html='<div class="media w-100 ml-auto mb-3 reciever-div"><div class="media-body mr-1"><div class="bg-styled rounded py-2 px-3 mb-1"><p class="text-small mb-0">'+file1+'</p> </div><div class="w-100"></div><p class="small">'+result.result.created_at+'</p></div> <img src="'+result.result.profile_image+'" alt="" width="30" class="rounded-circle"></div>';
				}
				$('.chat-bodys-'+chat_id).append(html);
				$(".chat-bodys").scrollTop($('.chat-bodys').prop("scrollHeight"));
			});
		}
		else {
            alert('Please type some message or insert file.');
        }
        console.log(timer_flag)
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
		$('.close-chat').click(function(){
			if(confirm('Are you sure you want to close the chat? Once closed, you will not be able to send any more messages.'))
			{
				$('.close-chat1').click();
			}
		});
		$("body").delegate(".close-chat1", "click", function(e){
				$('.typing-text-chats').text("");
				$('.chat_form-'+chat_id).remove();
				$('.time-'+chat_id).remove();
				$('.timer_all-'+chat_id).html('Chat has ended');
					$.ajax({
						url: '{{ route("close.chat.message") }}',
						type: 'POST',
						dataType: 'JSON',
						data: {
							id:chat_id,
							_token: '{{ csrf_token() }}',
						}
					})
					.done(result => {
						if(result.status == 'success'){
							console.log("Chat Closed");


						}
					});

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
			$('.typing-text-chats').text("typing...");
		} else if(data.typing == 'end') {
			$('.typing-text-'+data.message_master_id).text("");
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
			if($(".rm_emoji_area").is(':visible'))
			{
				$(".rm_emoji_area").slideUp("slow");
			}
        });
		@endif
</script>
{{-- Pusher Scripts End --}}
@endif
