@extends('layouts.app')

@section('title')
<title>Feedback/Suggestion</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
    }
    .u_ran {
    margin-top: 0px;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection

@section('body')

<div class="dashboard_sec dashboard_sec_education">
    <div class="container">
        <div class="dashboard_iner">
            @include('includes.profile_sidebar')
            <div class="astro-dash-pro-right">
                <h1>Feedback/Suggestion</h1>@include('includes.message')
                <div class="astro-dash-right_iner">
                    <form id="review_form" action="{{route('astro.suggestion.submit')}}" method="post" enctype="multipart/form-data">
                        @csrf
                    <input type="hidden" name="id" value="{{@$order->id}}">    
                    <div class="astro-dash-form">
                        <div class="post-review-sec">
                            <div class="u_ran">
                               <ul>
                                       {{-- <li><span><img src="{{asset('public/frontend/images/u.png')}}"></span> <label> {{@$data->astrologer->first_name}} {{@$data->astrologer->last_name}} </label></li> --}}
                                      <li><label>Order Id : {{@$order->order_id}}</label></li>
                                      
                               </ul>
                            </div>
                            <div class="rating_post_mainBox">
                                 

                                <div class="form_box_area your-rviewBox">
                                    <label>Suggestion/Feedback</label>
                                    <textarea placeholder="Suggestion/Feedback" name="astro_suggestion" id="astro_suggestion"></textarea>
                                </div>

                                <div class="col-sm-12" style="margin-bottom:10px;">
                                    <div class="uplodimg">
                                        <div class="uplodimgfil" style="width:71%;">
                                               <b>Attachment</b>
                                             <input type="file" id="file" name="astro_suggestion_attachment"
                                                                                class="astro_file" id="astro_suggestion_attachment">
                                             <label for="file" style="color: white">Upload Attachment<img src="{{ URL::to('public/frontend/images/clickhe.png') }}"alt=""></label>
                                           </div>
                                     </div>
                                   <span class="astro_file_names" id="astro_file_names"></span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="subbtn-sec">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="submit" value="Submit" class="subBtn"> </div>
                            </div>
                        </div>
                    </div>
                </form>
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

<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
    $( "#datepicker" ).datepicker();
  } );
</script>
<!-- End -->
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>



{{-- @include('includes.toaster') --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
       $("#review_form").validate({
        submitHandler: function(form){
            var astro_suggestion = $('#astro_suggestion').val();
            var astro_suggestion_attachment = $('#astro_file_names').html();
            
            if (astro_suggestion=='' && astro_suggestion_attachment=='') {
                alert('Please fill at least one field either suggestion or Attachment');
                return false;
            }
           
            form.submit();
        }  

        });
    });
</script>
<script type="text/javascript">
	$('.astro_file').change(function() {
            $('.astro_file_names').html('');
            var files = $('.astro_file').prop('files');
            $('.astro_file_names').html(files[0].name);
        });
</script>

@endsection
