@extends('layouts.app')

@section('title')
<title>
{{ @$selectPuja ? __('profile.Puja_update_title') :__('profile.Puja_title')}}
</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
    }
</style>
@endsection

@section('header')
{{-- @include('includes.heder_profile') --}}
@include('includes.header')
@endsection

@section('body')
<div class="dashboard_sec">
    <div class="container">
        <div class="dashboard_iner">
            @include('includes.profile_sidebar')

            <div class="astro-dash-pro-right">
                <h1>{{__('profile.puja')}}</h1>@include('includes.message')
                <div class="astro_bac_list">
                    <ul>
                        <li><a href="{{route('pundit.profile')}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                            {{__('profile.basic_info')}}</a>
                        </li>
                        <li class="actv"><a href="{{route('pundit.puja')}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon5.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon55.png')}}" class="bacicon2" alt="">
                            {{__('profile.puja')}}</a>
                        </li>
                        <li>
                            <a href="{{route('pundit.puja.service')}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Service Area</a>
                        </li>

                        <li><a href="{{route('pundit.availability')}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            {{__('profile.availability')}}</a></li>
                    </ul>
                </div>
                <div class="astro-dash-right_iner">
                    {{-- <form method="POST" action="{{ @$selectPuja ? route('pundit.puja.edit.save' ,['id'=>@$selectPuja->id]): route('pundit.puja.add')}}" id="addpujaform"> --}}
                    <form method="POST" action="{{ route('pundit.puja.add')}}" id="addpujaform">
                        @csrf
                        <div class="astro-dash-form">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.puja_name_label')}}</label>
                                        <select name="puja" id="pujaList" @if(@$selectPuja) disabled="disabled" @endif>
                                            <option value="" data-price='0'>{{__('profile.select_puja_placeholder')}}</option>
                                            @foreach ($allPuja as $puja)
                                            {{-- <option value="{{$puja->id}}" data-price='{{(int)$puja->price_starting_from}}' @if(@$selectPuja->puja_id==$puja->id) selected @endif>{{$puja->puja_name}}</option> --}}
                                            <option value="{{$puja->id}}">{{$puja->puja_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.price_of_puja_label')}}</label>
                                        <input type="text" placeholder="{{__('profile.price_of_puja_placeholder')}}" name="price" value="{{@$selectPuja->price?(int)@$selectPuja->price:''}}">
                                    </div>
                                </div> --}}
                                {{-- <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.starting_price_label')}}</label> --}}
                                        {{-- <input type="hidden" id='min' value={{@$selectPuja?(int)@$selectPuja->pujas->price_starting_from:0}} readonly> --}}
                                    {{-- </div>
                                </div> --}}
                                <div class="col-md-12 col-sm-12">
                                    <div class="add_btnbx">
                                        <input type="submit" value="{{@$selectPuja?__('profile.edit'):__('profile.add')}}" class="res">
                                    </div>
                                    <div class="add_btnbx">
                                        <a href="{{route('pundit.puja')}}" class="res">{{__('profile.cancel')}}</a>
                                    </div>
                                    <div class="clearfix"></div>

                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="save_coniBx">

                    </div>
                    <div class="table_sec">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">{{__('profile.puja_name_label')}}</th>
                                    <th scope="col">Homam  Available</th>
                                    <th scope="col">No. of Recitals</th>
                                    <th scope="col">{{__('profile.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( @$pujalist as $puja)

                                <tr>
                                    <td>{{@$puja->pujas->puja_name}}</td>
                                    <td>{{@$puja->pujas->with_homam=='Y'?'Yes':'No'}}</td>
                                    <td>{{@$puja->pujas->no_of_recitals?@$puja->pujas->no_of_recitals:'-'}}</td>
                                    <td>
                                        <ul class="edit_action">
                                            {{-- <li><a href="{{route('pundit.puja.edit' , ['id' => $puja->id])}}" data-toggle="tooltip" data-placement="top" title="{{__('profile.edit')}}"><i class="fa fa-pencil-square-o"></i></a></li> --}}
                                            <li><a href="{{route('pundit.puja.delete' , ['id' => $puja->id])}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('{{__('profile.confrontation_msg_delete_puja')}}');"><i class="fa fa-trash" aria-hidden="true"></i></a></li>

                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


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
        // var price=50;
        // var ck='{{(int)@$selectPuja->price}}';
        // console.log(ck);
        // if(ck>0){
        //     price='{{(int)@$selectPuja->pujas->price_starting_from}}';
        // }
        // $('#pujaList').change(function(event){
        //     var price = event.target.options[event.target.selectedIndex].dataset.price;
        //     // price=$(this).data('price');
        //     console.log(price);
        //     $('#min').val(price);
        // });
        // $.validator.addMethod("minprice", function(value, element, min) {
        //     if(value>=min){
        //         return true;
        //     }
        //     else if(value==''){
        //         return true;
        //     }
        // }, "Minium price should ");

        $("#addpujaform").validate({
            rules: {
                puja:{
                    required: true,
                },
                // price:{
                //     required: true,
                //     number: true ,
                //     min: function(){
                //         return parseInt($('#min').val());
                //     },
                // },
            },
            messages: {
                puja:{
                    required: '{{__('profile.required_puja')}}',
                },
                // price:{
                //     required: '{{__('profile.required_puja_price')}}',
                //     number: '{{__('profile.number_puja_price')}}' ,
                //     min: function(){
                //         return '{{__('profile.minium_price_should')}}'+$('#min').val();
                //     },
                // },
            },
        });
    })
</script>
@endsection
