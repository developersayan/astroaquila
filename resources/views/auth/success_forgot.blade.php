@extends('layouts.app')

@section('title')
<title>{{__('auth.forgot_success_title')}}</title>
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
                    <div class="main-center-div" style="max-width: none; !important">
                        <div class="login-from-area">
                            <h2>{{__('auth.forgot_success_header')}}</h2>
                            <p>{{__('auth.forgot_success_massage')}} </p>
                            <div class="bottom-account-div">
                                <p><a href="{{route('login')}}"> {{__('auth.go_to_sign_in')}}</a></p>
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
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- @include('includes.toaster') --}}
@endsection
