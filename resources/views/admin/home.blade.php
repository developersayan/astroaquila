@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | DashBoard</title>
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
                    <h4 class="pull-left page-title">Welcome !</h4>
                    <ol class="breadcrumb pull-right">
                        <li><a href="#">Astroaquila</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </div>
            </div>

            <!-- Start Widget -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-usd"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">15852</span>
                            Total Products
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-warning"><i class="fa fa-shopping-cart"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">956</span>
                            New Orders
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-pink"><i class="fa fa-user"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">5210</span>
                            New Customer
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-success"><i class="fa fa-eye"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">20544</span>
                            Unique Visitors
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-info"><i class="fa fa-usd"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">15852</span>
                            Total Customers
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-warning"><i class="fa fa-shopping-cart"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">956</span>
                            Total Astrologer
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-pink"><i class="fa fa-user"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">5210</span>
                            Total Pandits
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-3">
                    <div class="mini-stat clearfix bx-shadow bg-white">
                        <span class="mini-stat-icon bg-success"><i class="fa fa-eye"></i></span>
                        <div class="mini-stat-info text-right text-dark">
                            <span class="counter text-dark">20544</span>
                            Total Seller
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->







        </div> <!-- container -->

    </div> <!-- content -->

    <footer class="footer text-right">
        Copyright &copy; 2021 Astroaquila.com All rights reserved.
    </footer>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

@section('script')
@include('admin.includes.script')
@endsection
