@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Gold Purity</title>
@endsection

@section('style')
@include('admin.includes.style')
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')
<!-- Left Sidebar End -->



<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="pull-left page-title">Manage Gold Purity</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.gemstone.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    @include('admin.includes.message')
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Gold Purity</th>
                                                    <th>Ring Weight Carret</th>
                                                    <th>Ring Price INR</th>
                                                    <th>Ring Price USD</th>
                                                    <th>Bracelet Weight Carret</th>
                                                    <th>Bracelet Price INR</th>
                                                    <th>Bracelet Price USD</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$gold->isNotEmpty())
                                                @foreach (@$gold as $value)
                                                <tr>
                                                    <td>{{$value->purity}}</td>
                                                    <td>
                                                        @if(@$value->ring_weight_carat!="")
                                                        {{$value->ring_weight_carat}} (Carat)
                                                        @else
                                                        --
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(@$value->ring_price_inr!="")
                                                        {{$value->ring_price_inr}} INR
                                                        @else
                                                        --
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(@$value->ring_price_usd!="")
                                                        {{$value->ring_price_usd}} USD
                                                        @else
                                                        --
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(@$value->bracalet_weight_carat!="")
                                                        {{$value->bracalet_weight_carat}} (Carat)
                                                        @else
                                                        --
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(@$value->bracelet_price_inr!="")
                                                        {{$value->bracelet_price_inr}} INR
                                                        @else
                                                        --
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(@$value->bracelet_price_usd!="")
                                                        {{$value->bracelet_price_inr}} USD
                                                        @else
                                                        --
                                                        @endif
                                                    </td>
                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>                                                                
                                                                <li><a href="{{route('admin.manage.gold.purity.edit',['id'=>@$value->id])}}">Edit</a></li>
																
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr><td colspan="4"><center> No Data </center></td></tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>


                                   


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End row -->

        </div>
        <!-- container -->

    </div>
    <!-- content -->

    @include('admin.includes.footer')
</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

@section('script')
@include('admin.includes.script')

<script>
    $(document).ready(function(){
  @foreach (@$gold as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
});
</script>
@endsection
