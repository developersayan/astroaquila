@extends('layouts.app')

@section('style')
@include('includes.style')
<style type="text/css" media="screen">
    .fade:not(.show) {
        opacity: 1 !important;
    }
    </style>
@endsection

@section('title')
<title>Astroaquila | Video Call</title>
@endsection
@section('header')
@include('includes.header')
<style type="text/css">
    .featured_text p {
    min-height: 60px;

}
.details{
    width: 21%;
}
.timer{
    max-width: 1200px;
    margin: 0 auto;
    position: absolute;
    top: 50px;
    left: 6px;
    color: white;
}
#time_error{
    color: red;
}
.timer_error{
    max-width: 1200px;
    margin: 0 auto;
    position: absolute;
    top: 50px;
    left: 6px;
    color: red;
}
.timer_one{
    max-width: 1200px;
    margin: 0 auto;
    position: absolute;
    top: 50px;
    left: 6px;
    color: white;
}
.remaing_duration{
        max-width: 1200px;
    margin: 0 auto;
    position: absolute;
    top: 50px;
    left: 6px;
    color: white;
}
.count_down_timer{
    max-width: 1200px;
    margin: 0 auto;
    position: absolute;
    top: 50px;
    left: 6px;
    color: white;
    margin-top: 45px;
}
.name_person{
    max-width: 1200px;
    margin: 0 auto;
    position: absolute;
    top: 50px;
    left: 6px;
    color: white;
    margin-top: 45px;
}
.details{
    max-width: 1200px;
    margin: 0 auto;
    position: absolute;
    top: 80px;
    left: 6px;
    color: white;
    margin-top: 45px;
    width: 21%;
    padding-left: 6px;
}
}
</style>
@endsection


@section('body')

<section class="bkng-hstrybdy contt pad-114">
    <div class="bokcntnt-bdy add_for_video1">
        <div class="container mobile_width">
            <div class="row" style="float: left; width: 100%;">
                {{-- <h1 class="video_hhd">Video Call</h1> --}}
                <div class="fulscrn " id="fulvido">
                    <div id="remote-media" class="full_bg"></div>
                    <div class="mutevdo">
                        <div class="mutxt">
                            <p id="remote-audio-mute" style="display: none"><i class="fa fa-microphone-slash"
                                    aria-hidden="true"></i>Audio muted</p>
                            <p id="remote-video-mute" style="display: none"><i
                                    class="fas fa-video-slash"></i> video muted </p>
                            <span id="connecting">connecting ...</span>
                        </div>
                    </div>
                    <div id="controls">
                        <div id="preview">
                            <div class="vdomutetxt">
                                <div class="twobtn">
                                    <span id="local-audio-mute" style="display: none"><i class="fa fa-microphone-slash"
                                            aria-hidden="true"></i></span>
                                    <span id="local-video-mute" style="display: none"><i
                                            class="fas fa-video-slash"></i></span>
                                </div>
                            </div>
                            <div style="display: none" id="local-media"></div>
                            <button id="button-preview">Preview my camera </button>
                        </div>
                    </div>


                    <div class="name_person"><span id="name__pbox" style="color: white"></span></div>

                    <div class="timer"><span id="time"></span></div>
                    <div class="timer_error"><span id="time_error"></span></div>

                    <div class="remaing_duration" style="display: none;"><span id="time_remaining" style="color: white"></span></div>

                    <div class="count_down_timer" style="display: none;"><span id="count_timer" style="color: white"></span></div>

                    <div class="timer_one" style="display: none;"><span id="time_one" style="color: white"></span></div>

                    <div class="details" style="display: none;">
                        {{-- <p class='order_ajax_details'><span> Name:</span> Sayan Ghosh</p>
                        <p class='order_ajax_details'><span> Name:</span> Sayan Ghosh</p>
                        <p class='order_ajax_details'><span> Name:</span> Sayan Ghosh</p><p class='order_ajax_details'><span> Name:</span> Sayan Ghosh</p>
                        <p class='order_ajax_details'><span> Name:</span> <a download class="download_video"> Download</a></p> --}}
                    </div>

                    <input type="hidden" id="total_duration" value="0">
                    <input type="hidden" id="start_time">
                    {{-- <input type="text" id="sayan"> --}}
                    <input type="hidden" id="done" value="0">
                    <input type="hidden" name="timer_one_value" id="timer_one_value" value="0">
                    <div class="all_video_btn">
                        <button title="Mute audio" data-toggle="tooltip" id="audio-mute"
                            class="add_for_video2 icon_rm_001"><i class="fa fa-microphone"
                                aria-hidden="true"></i></button>
                        <button title="Unmute audio" data-toggle="tooltip" id="audio-unmute"
                            class="add_for_video2 icon_rm_001 icon_rm_003" style="display: none"><i
                                class="fa fa-microphone-slash" aria-hidden="true"></i></button>

                        <button id="button-leave" class="add_for_video2"><i class="fa fa-phone"
                                aria-hidden="true"></i></button>

                        <button title="Mute video" data-toggle="tooltip" id="video-mute"
                            class="add_for_video2 icon_rm_002"><i class="fas fa-video"></i></button>
                        <button title="Unmute video" data-toggle="tooltip" id="video-unmute"
                            class="add_for_video2 icon_rm_002 icon_rm_003" style="display: none"><i
                                class="fas fa-video-slash"></i></button>

                        <button title="Full screen" data-toggle="tooltip" title="Full screen" data-toggle="tooltip"
                            id="video-full" class="add_for_video2 icon_rm_002"><i class="fas fa-compress"></i></button>
                        <button title="Exit full screen" data-toggle="tooltip" id="video-small"
                            class="add_for_video2 icon_rm_002 icon_rm_003" style="display: none"><i
                                class="fas fa-compress"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>



@endsection



{{-- @section('footer')
@include('includes.footer')
@endsection --}}

@section('script')
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="//media.twiliocdn.com/sdk/js/video/releases/2.0.0-beta15/twilio-video.min.js"></script>
<script>
    var userType = localStorage.getItem('userType');
    var permin = localStorage.getItem('permin');
    if (userType=='P') {
        id=localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token');
        $.ajax({
                      url:"{{route('my.video.get.details')}}",
                      method:"GET",
                      data:{id:id},
                      success: function(res) {
                        $('.details').show();
                        $('.details').html(res.details);
                    }
               });

    }else{
        id=localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token');
        $.ajax({
                  url:"{{route('my.video.get.details')}}",
                  method:"GET",
                  data:{id:id},
                  success: function(res) {
                    $('.details').show();
                    $('.details').html(res.details);
                }
               });
    }

</script>
<script src="{{URL::to('public/frontend/js/twilio-quickstart.js') }}"></script>
{{-- @include('includes.scripte') --}}
@include('includes.toaster')
<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    var myTimeInterval = '';
        var videoMute = false;
        var audioMute = false;
        var increment=1;
        $(document).ready(function() {
            // if refresh after start the video call
            if(localStorage.getItem('startTime')){
                // start video call
                roomName = localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token');
                var reqData = {
                    roomName: roomName
                };
                $.getJSON(tokenUrl, reqData, function(data) {
                    identity = data.identity;

                    var connectOptions = {
                        name: roomName,
                        logLevel: 'debug',
                        _useTwilioConnection: true
                    };

                    if (previewTracks) {
                        connectOptions.tracks = previewTracks;
                    }

                    // Join the Room with the token from the server and the
                    // LocalParticipant's Tracks.
                    Video.connect(data.token, connectOptions).then(roomJoined, function(error) {
                    });

                    // Bind button to leave Room.
                    document.getElementById('button-leave').onclick = function() {
                        activeRoom.disconnect();
                    };
                });
            } else {
                toastr.error('Some error happen!');
                window.location.reload(history.back());
                // location.href="{{route('gemstone.search')}}";
            }
        });


        // This method is used to start timer
        function start_timer() {



            if(window.localStorage.getItem('maxTime')==10000){

                id=localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token');
                $('#time_error').hide();
                $('#time').hide();
                $('.timer_one').show();
                $('#time_one').html('Call Time : 0 minute');
                if (userType=='C') {
                    time_get = '{{date('Y-m-d h:i:s')}}'
                    $('#start_time').val(time_get);
                 $.ajax({
                      url:"{{route('my.video.call.start.time.update.call')}}",
                      method:"GET",
                      data:{'time':$('#start_time').val(),'id':id},
                      success: function(res) {

                    }
               });
            }

            }else{
                $('#time_error').hide();
                $('#time').hide();
                if (userType=='P') {
                    var duration = window.localStorage.getItem('maxTime');
                    // alert(duration);
                    $('.remaing_duration').show();
                    $('.count_down_timer').show();
                    var m = Math.floor(duration % 3600 / 60);
                    var s = Math.floor(duration % 3600 % 60);
                    $('#time_remaining').text('Remaining Call duration :'+m + "m :" + s +"s");
                    var fiveMinutes = 60 * 0,
                    display = $('#count_timer');
                    startTimerSender(fiveMinutes, display);
                    return false;
                }else{
                    id=localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token');
                    var duration = window.localStorage.getItem('maxTime');
                    // alert(duration);
                    $('.remaing_duration').show();
                    $('.count_down_timer').show();
                    var m = Math.floor(duration % 3600 / 60);
                    var s = Math.floor(duration % 3600 % 60);
                    $('#time_remaining').text('Remaining Call duration :'+m + "m :" + s +"s");
                    time_get = '{{date('Y-m-d h:i:s')}}'
                    $('#start_time').val(time_get);
                    var fiveMinutes = 60 * 0,
                    display = $('#count_timer');
                    startTimerCustomer(fiveMinutes, display);

                     

                    $.ajax({
                      url:"{{route('my.video.call.start.time.update.call')}}",
                      method:"GET",
                      data:{'time':$('#start_time').val(),'id':id},
                      success: function(res) {
                        // alert(res);
                      setTimeout(function () {
                        CallComplete();
                      },duration*1000);
                      
                    }
                   });
                    return false;
                 }
            }
            // console.log(parseInt((window.localStorage.getItem('maxTime'))/60, 10));
           //  if ((window.localStorage.getItem('maxTime')/60) <4) {
            
           //  $('#time_error').html( parseInt((window.localStorage.getItem('maxTime'))/60, 10)+' minute lefts');
            
       
           //  }else{
            
           //  $('#time').html( parseInt((window.localStorage.getItem('maxTime'))/60, 10)+' minute lefts');
            
           // }
           
            
            // update video_status
            // updateVideoInitiated(localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token'));
            if(window.localStorage.getItem('maxTime')==10000){
                if(window.localStorage.getItem('startTime')){
                    timer = parseInt(window.localStorage.getItem('startTime'));
                    window.localStorage.setItem('startTime', timer);
                }
                else{
                    timer = 0;
                    window.localStorage.setItem('startTime', timer);
                }

                myTimeInterval = setInterval(function () {
                    if(window.localStorage.getItem('maxTime')==10000){
                        minutes = parseInt(timer / 60, 10);
                        seconds = parseInt(timer % 60, 10);
                        numberminutes = parseInt(timer / (60 * increment), 10);
                        minutes = minutes < 10 ? "0" + minutes : minutes;
                        seconds = seconds < 10 ? "0" + seconds : seconds;
                        // $('#time').html( parseInt((window.localStorage.getItem('maxTime')/60-numberminutes))+' minute left');
                        timer++;
                        window.localStorage.setItem('startTime', timer);

                        if(numberminutes>0){
                            updateCallTime(localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token'),window.localStorage.getItem('startTime'),userType);
                            
                            if((window.localStorage.getItem('maxTime')/60-increment)>=0){
                                if((window.localStorage.getItem('maxTime')/60-increment)>=4){
                                $('#time').html( parseInt((window.localStorage.getItem('maxTime')/60-increment))+' minute left');
                                }else{
                                   $('#time').html('');
                                   $('#time_error').html( parseInt((window.localStorage.getItem('maxTime')/60-increment))+' minute left '); 
                                } 
                            }
                         
                            increment++;
                        }
                        if(parseInt(window.localStorage.getItem('maxTime'))-parseInt(window.localStorage.getItem('startTime')) == 600){
                            toastr.info('@lang('message.video_call_message')');
                        }
                        if(parseInt(window.localStorage.getItem('startTime')) == parseInt(window.localStorage.getItem('maxTime'))){
                            // updateVideoStatus(localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token'));

                        }
                    }
                    else{
                        // call videoCloseFunCustomer for stop timer and remove localstorage
                        if(userType == 'C') {
                            videoCloseFunCustomer();
                            swal('Video call Over',{icon:"info"});
                        }

                        // call videoCloseFunProfessional for stop timer and remove localstorage
                        if(userType == 'P') {
                            videoCloseFunProfessional();
                            swal('Video call Over',{icon:"info"});
                        }
                        window.localStorage.removeItem('videoStart');
                        window.localStorage.removeItem('userChatToken');
                        window.localStorage.removeItem('startTime');
                        window.localStorage.removeItem('maxTime');
                        window.localStorage.removeItem('userChatId');
                        window.localStorage.removeItem('userId');
                        window.localStorage.removeItem('token');
                        window.localStorage.removeItem('permin');
                        clearInterval(myTimeInterval);
                    }
                }, 1000);
            } else {
                // call videoCloseFunCustomer for stop timer and remove localstorage
                if(userType == 'C') {
                    videoCloseFunCustomer();
                    swal('Video call Over',{icon:"info"});
                }

                // call videoCloseFunProfessional for stop timer and remove localstorage
                if(userType == 'P') {
                    videoCloseFunProfessional();
                    swal('Video call Over',{icon:"info"});
                }
                window.localStorage.removeItem('videoStart');
                window.localStorage.removeItem('userChatToken');
                window.localStorage.removeItem('startTime');
                window.localStorage.removeItem('maxTime');
                window.localStorage.removeItem('userChatId');
                window.localStorage.removeItem('userId');
                window.localStorage.removeItem('token');
                window.localStorage.removeItem('permin');
                clearInterval(myTimeInterval);
            }
        }

        function videoCloseFunCustomer(id=''){
            id=localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token');
            clearInterval(myTimeInterval);
            window.localStorage.removeItem('videoStart');
            window.localStorage.removeItem('userChatToken');
            window.localStorage.removeItem('startTime');
            window.localStorage.removeItem('maxTime');
            window.localStorage.removeItem('userChatId');
            window.localStorage.removeItem('userId');
            window.localStorage.removeItem('token');
            window.localStorage.removeItem('permin');
            // location.replace(document.referrer);
            location.href="{{route('user.video.call.redirect')}}/"+id;
        }




        function videoCloseFunProfessional(id='') {
            id=localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token');
            clearInterval(myTimeInterval);
            window.localStorage.removeItem('videoStart');
            window.localStorage.removeItem('userChatToken');
            window.localStorage.removeItem('startTime');
            window.localStorage.removeItem('maxTime');
            window.localStorage.removeItem('userChatId');
            window.localStorage.removeItem('userId');
            window.localStorage.removeItem('token');
            // location.replace(document.referrer);
            location.href="{{route('user.video.call.redirect')}}/"+id;
        }


        function CallComplete(id=''){
            id=localStorage.getItem('userChatToken') ? localStorage.getItem('userChatToken'): localStorage.getItem('token');
            clearInterval(myTimeInterval);
            window.localStorage.removeItem('videoStart');
            window.localStorage.removeItem('userChatToken');
            window.localStorage.removeItem('startTime');
            window.localStorage.removeItem('maxTime');
            window.localStorage.removeItem('userChatId');
            window.localStorage.removeItem('userId');
            window.localStorage.removeItem('token');
            window.localStorage.removeItem('permin');
            // location.replace(document.referrer);
            location.href="{{route('my.video.call.complete')}}/"+id;
        }
// This method is used to update video call status
        function updateCallTime(token,callTime,userType){
            if(token!=null || token!=""){
                $('#time_one').html('');
                if (userType=="P") {
                    var time = $('#timer_one_value').val();
                    var update_time = +time+1;
                    $('#timer_one_value').val(update_time);
                    $('#time_one').html('Call Time :'+update_time+'minute');
                }

                if (userType=="C") {
                    var time = $('#timer_one_value').val();
                    var update_time = +time+1;
                    $('#timer_one_value').val(update_time);
                    $('#time_one').html('Call Time :'+update_time+'minute');
                }
                
                var reqData = {
                    'jsonrpc' : '2.0',
                    '_token' : '{{csrf_token()}}',
                    'params' : {
                        'token' : token,
                        'completed_call':callTime,
                        'user_type':userType
                    }
                };
                $.ajax({
                    url: "{{ route('update.call.time') }}",
                    method: 'post',
                    dataType: 'json',
                    data: reqData,
                    success: function(response){
                        console.log(response);
                        if(response.result.call_complete==1){

                            activeRoom.disconnect();
                         }
                    }, error: function(error) {
                        toastr.info('Call Error');
                    }
                });
            }
        }
        $(document).ready(function() {
            $('#video-full').click(openFullscreen);
            $('#video-small').click(closeFullscreen);
        })



        var elem = document.getElementById("fulvido");
        function openFullscreen() {
            $('#video-full').hide();
            $('#video-small').show();
            $('#fulvido').addClass('escp');
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) { /* Firefox */
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE/Edge */
                elem.msRequestFullscreen();
            }
        }

        function closeFullscreen() {
            $('#video-full').show();
            $('#video-small').hide();
            $('#fulvido').removeClass('escp');
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }

        document.addEventListener('fullscreenchange', exitHandler);
        document.addEventListener('webkitfullscreenchange', exitHandler);
        document.addEventListener('mozfullscreenchange', exitHandler);
        document.addEventListener('MSFullscreenChange', exitHandler);

        function exitHandler() {
            if (!document.fullscreenElement && !document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
                $('#video-full').show();
                $('#video-small').hide();
                $('#fulvido').removeClass('escp');
            }
        }



        function startTimerCustomer(duration, display) {

        var minutes = '0'; var seconds = '01';
        var totMin = '0';
        var timer = duration, minutes, seconds;
        myInterval = setInterval(function () {
                var dur =  window.localStorage.getItem('maxTime');
                console.log(dur);
                var total_duration  = $('#total_duration').val();
                var tot = +total_duration+1;
                $('#total_duration').val(tot);
                timing = $('#total_duration').val();
                console.log(timing);
                minutes = parseInt(timer / 60, 10)
                seconds = parseInt(timer % 60, 10)+2;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                display.text("Time Elapsed :"+minutes + ":" + seconds);
                var totMin = Math.ceil(parseInt(minutes) + (parseFloat(seconds) + 2) / 60);
                if (timer++ < 0) {
                    timer = duration;
                }
        }, 1000);
    }

    function startTimerSender(duration,display)
    {
               var minutes = '0'; var seconds = '01';
               var totMin = '0';
               var timer = duration, minutes, seconds;
               myInterval = setInterval(function () {
               var dur = window.localStorage.getItem('maxTime');
               minutes = parseInt(timer / 60, 10)
               seconds = parseInt(timer % 60, 10)+2;
               minutes = minutes < 10 ? "0" + minutes : minutes;
               seconds = seconds < 10 ? "0" + seconds : seconds;
                display.text("Time Elapsed :"+minutes + ":" + seconds);
                var totMin = Math.ceil(parseInt(minutes) + (parseFloat(seconds) + 2) / 60);
                if (timer++ < 0) {
                    timer = duration;
                }
        }, 1000); 
    }
</script>

{{--    <script>
    function showMore(){
        $('.moreless-button-review').click(function() {

        if ($('.moreless-button-review').text() == "Read More +") {
            $('.aboutRemaove-review').hide();
            $('.moretext-review').show();
            $(this).text("Read Less -")
        } else {
            $('.aboutRemaove-review').show();
            $('.moretext-review').hide();
            $(this).text("Read More +")
        }
        // $('.moretext').slideToggle();

    });
    }

   
</script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/all.js"></script>

@endsection
