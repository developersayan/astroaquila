<script src="https://cloud.apizee.com/apiRTC/apiRTC-latest.min.js"></script>
@if(@Auth::guard('web')->user())
<button onclick="playAudio()" type="button" id="playAudioBtn" style="display: none">Play Audio</button>
<script type="text/javascript">
	var player;
	$(document).ready(function() {
	player = new Audio("{{ url('public/video_call_ringtone.mp3') }}" );
	player.loop = true;
	player.muted = true;

	console.log(player);
	})
	function playAudio() {
	player.play();
	}
	function pauseAudio() {
	player.pause();
	}
</script>
<script>
    $(function(){
		var timer=0, minutes=0, seconds=0;
		var yTime = xTime = 0;
		var chatFlag = 0;
		var timeOutVar;
		var domian = options = api = "";
		domain = 'phpwebdevelopmentservices.com';
		var myTimeInterval ="";
		var session = null,
		imClient = null,
		my_id = {{ @Auth::guard('web')->user()->id }},
		webRTCClient = null,
		dataClient = null;

		session = apiRTC.init({
			apiKey : "47716e958466549153f429fed4b9fd80",
			apiCCId : my_id,
			onReady : sessionReadyHandler,
			senderNickname: '{{  @Auth::guard("web")->user()->name  }}'
		});

		//
		function sessionReadyHandler(e) {
		    apiRTC.addEventListener("receiveIMMessage", receiveIMMessageHandler);
		    apiRTC.addEventListener("receiveData", receiveData);
		    imClient = apiCC.session.createIMClient();
		    dataClient = apiCC.session.createDataClient();
		}


		// for videocall.....
		var userAnswer=0;
		$('.videoCallStart').click(function(){
			swal({
				title: "Video call",
				text: "Do you want to start a video call ?",
				icon: "info",
				buttons: ['Cancle', 'OK'],
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					startCall($(this).data('token'));
					localStorage.setItem('token',$(this).data('token'));
					localStorage.setItem('userId',$(this).data('id'));
					localStorage.setItem('permin',$(this).data('permin'));
					localStorage.setItem('maxTime', $(this).data('dur'));
					localStorage.setItem('userType', 'P');
					localStorage.setItem('userName',$(this).data('name'));
					userAnswer = checkUserOnline($(this).data('id'), localStorage.getItem('token'),localStorage.getItem('permin'));
					$('.parent_loader').show();
					timeOut();
				} else {
				  	return false;
				}
			});
		});


		function checkUserOnline(id,token,permin){
		    var obj = {
				message: "You have a new video call request from {{ @Auth::guard('web')->user()->name }}",
				chatToken:localStorage.getItem('token'),
				duration:localStorage.getItem('maxTime'),
				permin:localStorage.getItem('permin'),
				code:100
		    };
		    imClient.sendMessage(id, obj);
		}

		function isRequestAccsepted(id, choice){
		    // Y for yes
		    if(choice=='Y'){
		      	var obj = {
			        message: "The video call request is accepted",
			        code:101
		      	};
		      	imClient.sendMessage(id, obj);
		    }
		    // N for No
		    if(choice=='N'){
		        var obj = {
		          message: "It looks like the user is currently busy.",
		          code:102
		        };
		      	imClient.sendMessage(id, obj);
		    }
		}

		function receiveIMMessageHandler(e) {
		    // for video call accseptence...
		    if(e.detail.message.code==100){
		    	// ring remote site
		    	playAudio();
                localStorage.setItem('userCallRequest',0);
		      	swal({
		            title: "New video call request",
		            text: e.detail.message.message,
		            icon: "info",
		            buttons: true,
		            dangerMode: true,
		        })
		        .then((willDelete) => {
                    if(localStorage.getItem('userCallRequest')==0){
		            if (willDelete) {
                        localStorage.setItem('userCallRequest',1);
						localStorage.setItem('userChatId',e.detail.senderId);
						localStorage.setItem('userChatToken',e.detail.message.chatToken);
						localStorage.setItem('token',e.detail.message.chatToken);
						localStorage.setItem('maxTime',e.detail.message.duration);
						localStorage.setItem('permin',e.detail.message.permin);
						localStorage.setItem('videoStart',1);
						localStorage.setItem('startTime',timer);
						localStorage.setItem('userType', 'C');
						isRequestAccsepted(e.detail.senderId, 'Y');
						startvideoCall(e.detail.message.chatToken);
						
		            } else {
		              	isRequestAccsepted(e.detail.senderId, 'N');
		              	pauseAudio();
		            }
                    } else{
                        pauseAudio();
                    }
		        });
		    }
		    if(e.detail.message.code==101){
				$('.parent_loader').hide();
				clearTimeout(timeOutVar);
				swal('The video call request was accepted',{ icon: "success"});
				localStorage.setItem('startTime',timer);
				localStorage.setItem('userChatId', e.detail.senderId);
				startvideoCall(localStorage.getItem('token'));
		    }
		    if(e.detail.message.code==102){
				$('.parent_loader').hide();
				swal('User Cannot accept the call.',{ icon: "info"});
				clearTimeout(timeOutVar);
		    }

		    if(e.detail.message.code==108){
				localStorage.removeItem('videoStart');
				localStorage.removeItem('userChatToken');
				localStorage.removeItem('userChatId');
				localStorage.removeItem('userId');
				localStorage.removeItem('token');
				swal('The video conference ended.',{ icon: "info"});
		    }
		    if(e.detail.message.code==404){
		      	swal.close();
		    }
		    if(e.detail.message.code==500){
				swal(e.detail.message.message,{ icon: "info"});
				window.localStorage.removeItem('videoStart');
				window.localStorage.removeItem('userChatToken');
				window.localStorage.removeItem('startTime');
				window.localStorage.removeItem('maxTime');
				window.localStorage.removeItem('userChatId');
				window.localStorage.removeItem('userId');
				window.localStorage.removeItem('token');
				// window.localStorage.removeItem('userCallRequest');
				clearInterval(myTimeInterval);
		    }

		    if(e.detail.message.code==2008){
		      swal(e.detail.message.message,{ icon: "info"});
		    }
		}

		function timeOut(){
		    timeOutVar = setTimeout(function(){
				var obj = {
					message: "Minimize chat request",
					code:404
				};
				imClient.sendMessage(localStorage.getItem('userId'), obj);
				localStorage.removeItem('userId');
				localStorage.removeItem('token');
				$('.parent_loader').hide();
				swal("The user is currently unavailable to answer this call",{icon:"info"});
		    }, 30000);
		}

		function receiveData(e) {
		    console.log(e);
		}

		function startvideoCall(token){
	       	location.href="{{route('my.video')}}";
		}

		$('.videoClose').click(function(){
	        localStorage.removeItem('token');
	        var obj = {
				message:"The video conference ended.",
				code:108
	        }
	        imClient.sendMessage(localStorage.getItem('userChatId'), obj);
	        localStorage.removeItem('videoStart');
	        localStorage.removeItem('userChatToken');
	        localStorage.removeItem('userChatId');
	        localStorage.removeItem('userId');
	        localStorage.removeItem('token');
	         localStorage.removeItem('permin');
		});

	  	function eraseAll(){
		    var obj = {
				message:"The video conference ended.",
				code:108
		    }
		    imClient.sendMessage(localStorage.getItem('userChatId'), obj);
		    localStorage.removeItem('token');
		    localStorage.removeItem('videoStart');
		    localStorage.removeItem('userChatToken');
		    localStorage.removeItem('userChatId');
		    localStorage.removeItem('userId');
		    localStorage.removeItem('token');
		    localStorage.removeItem('permin');
	  	}

		function incomingMessageListener(obj)
		{
			if(chatFlag==0){
				api.executeCommand('toggleChat');
				chatFlag=1;
			}
			toastr.success('You have a new message from '+obj.nick);
		}

		function outgoingMessageListener(object)
		{
			if(chatFlag==1){
				chatFlag=0;
			}
			toastr.success('Message sent successfully');
		}

	 	function videoCloseFun(){
			updateVideoStatus(localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token'));
			swal('The video conference ended.',{icon:"info"});

			var obj = {
				message:"Your video call is being disconnected.",
				code:500
			};
			imClient.sendMessage(localStorage.getItem('userChatId'), obj);
			imClient.sendMessage(localStorage.getItem('userId'), obj);
			window.localStorage.removeItem('videoStart');
			window.localStorage.removeItem('userChatToken');
			window.localStorage.removeItem('startTime');
			window.localStorage.removeItem('maxTime');
			window.localStorage.removeItem('userChatId');
			window.localStorage.removeItem('userId');
			window.localStorage.removeItem('token');
			localStorage.removeItem('permin');
			clearInterval(myTimeInterval);
		 }
		 // This method is used to update video call status
        function startCall(token){
			if(token!=null || token!=""){
                var reqData = {
                    'jsonrpc' : '2.0',
                    '_token' : '{{csrf_token()}}',
                    'params' : {
                        'token' : token,
                    }
                };
                $.ajax({
                    url: "{{ route('video.call.start') }}",
                    method: 'post',
                    dataType: 'json',
                    data: reqData,
                    success: function(response){
                        // console.log(response);
                        // if(response.result.call_complete==1){
                        //     activeRoom.disconnect();
                        // }
                    }, error: function(error) {
                        toastr.info('Video Call Error');
                    }
                });
            }
        }
	});

</script>
@endif
