<?php

use Illuminate\Support\Facades\Auth;

$agent_data = Auth::user()->img;




?>


<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/hyper/saas/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jun 2022 08:24:45 GMT -->

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Bricks ERP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public/adminPanel/assets/images/favicon.ico') }}">

    <!-- third party css -->
    <link href="{{ asset('public/adminPanel/assets/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link href="{{ asset('public/adminPanel/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/adminPanel/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet"> @yield('style')

    <!-- <link href="{{ asset('public/adminPanel/assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> -->
    <style>
        .change_user:hover {
            cursor: pointer;
        }
    </style>
</head>

<body class="loading" data-layout-color="light" data-leftbar-theme="light" data-layout-mode="fluid" data-rightbar-onstart="true">
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="{{ URL::to('/dashboard') }}" style="font-size: 1.3rem;color: #0acf97;" class="logo text-center logo-light">
                <!--<span class="logo-lg">-->
                <!--    <img src="{{ asset('public/adminPanel/assets/images/logo.png') }}" alt="" style="width:180px;">-->
                <!--</span>-->

                Bricks ERP
                <span class="logo-sm">
                    <img src="{{ asset('public/adminPanel/assets/images/logo_sm.png') }}" alt="" height="16">
                </span>
            </a>

            <!-- LOGO -->
            <a href="{{ URL::to('/dashboard') }}" class="logo text-center logo-dark">
                <span class="logo-lg">
                    Skywaves Bricks ERP
                    <!-- <img src="{{ asset('public/adminPanel/assets/images/logo-dark.png') }}" alt="" height="16"> -->
                </span>
                <span class="logo-sm">
                    <!-- <img src="{{ asset('public/adminPanel/assets/images/logo_sm_dark.png') }}" alt="" height="16"> -->
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title side-nav-item">Navigation</li>
                    @can('product')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#product" aria-expanded="false" aria-controls="product" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <!-- <span class="badge bg-success float-end">4</span> -->
                            <span> Product </span>
                        </a>
                        <div class="collapse" id="product">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{route('product.from')}}">Product</a>
                                </li>
                               

                            </ul>
                        </div>
                    </li>
                    @endcan
                    
                    @can('customer')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#customer" aria-expanded="false" aria-controls="customer" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <!-- <span class="badge bg-success float-end">4</span> -->
                            <span> Customer </span>
                        </a>
                        <div class="collapse" id="customer">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{route('customer.from')}}">Customer</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endcan
                    
                    @can('suppliers')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#fields" aria-expanded="false" aria-controls="fields" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <!-- <span class="badge bg-success float-end">4</span> -->
                            <span> Suppliers </span>
                        </a>
                        <div class="collapse" id="fields">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ URL::to('get-supplier-list') }}">Suppliers</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endcan
                    
                    @can('nozzale')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#party" aria-expanded="false" aria-controls="party" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <!-- <span class="badge bg-success float-end">4</span> -->
                            <span> Nozzale</span>
                        </a>
                        <div class="collapse" id="party">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="">Nozzale</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endcan
                    
                    @can('accounts')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#account" aria-expanded="false" aria-controls="accountNav" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <!-- <span class="badge bg-success float-end">4</span> -->
                            <span> Accounts </span>
                        </a>
                        <div class="collapse" id="account">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ URL::to('add-account') }}">Accounts list</a>
                                </li>
                                <li>
                                    <a href="{{ URL::to('add-make-payment') }}">Payments & Receiving</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endcan
                    
                    @can('expense')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#expenseNav" aria-expanded="false" aria-controls="expenseNav" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-success float-end">4</span>
                            <span> Expense </span>
                        </a>
                        <div class="collapse" id="expenseNav">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ URL::to('expense-list') }}">Expense List</a>
                                </li>

                                <li>
                                    <a href="{{ URL::to('expense-categories') }}">Categories</a>
                                </li>
                                <li>
                                    <a href="{{ URL::to('expense-sub-categories') }}">Sub Categories</a>
                                </li>
                            </ul>
                        </div>
                    </li>   
                    @endcan
                    @can('sale')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#saleNav" aria-expanded="false" aria-controls="saleNav" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-success float-end">4</span>
                            <span> Sale </span>
                        </a>
                        <div class="collapse" id="saleNav">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="">Sale</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endcan
                    @can('purchase')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#purchaseNav" aria-expanded="false" aria-controls="purchaseNav" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-success float-end">4</span>
                            <span> Purchase </span>
                        </a>
                        <div class="collapse" id="purchaseNav">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{route('purchase.form')}}">Purchase</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endcan
                    @can('user-management')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#usersNav" aria-expanded="false" aria-controls="usersNav" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-success float-end">4</span>
                            <span> Users </span>
                        </a>
                        <div class="collapse" id="usersNav">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ URL::to('users-list') }}">User List</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endcan
                    @can('reports')
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="reports" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-success float-end">4</span>
                            <span> Reports </span>
                        </a>
                        <div class="collapse" id="reports">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="">Reports</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    @endcan
                    
                   




                </ul>



                <!-- Help Box -->

                <!-- end Help Box -->
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">

                    <ul class="list-unstyled topbar-menu float-end mb-0">

                        <li class="dropdown notification-list d-lg-none">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-search noti-icon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                <form class="p-3">
                                    <input type="text" class="form-control" placeholder="Search bar..." aria-label="Recipient's username">
                                </form>
                            </div>
                        </li>

                        <li class="notification-list">
                            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                <i class="dripicons-gear noti-icon"></i>
                            </a>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">

                                    <img src="{{ asset('images/persons/'.Auth::user()->img.'') }}" alt="user-image" class="rounded-circle">
                                </span>

                                <span>
                                    <span class="account-user-name">{{ Auth::user()->name }}</span>
                                    <span class="account-position">Super Admin</span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->


                                <!-- item-->
                                <a href="{{ URL::to('change_password') }}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>Change Password</span>
                                </a>



                                <!-- item-->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item notify-item">
                                        <i class="mdi mdi-logout me-1"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </li>

                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                    <ul class="list-unstyled topbar-menu float-start mt-2 mb-0">

                        {{-- <li class="dropdown notification-list ">
                            <a class="nav-link " href="{{ URL::to('create-order') }}" role="button">
                                <i class="btn btn-success rounded-pill">Order</i>
                            </a>
                        </li> --}}

                        <li class="dropdown notification-list ">
                            <a class="nav-link " href="" role="button">
                                <i class="btn btn-secondary rounded-pill">Customer</i>
                            </a>
                        </li>
                        <li class="dropdown notification-list ">
                            <a class="nav-link " href="{{ URL::to('get-supplier-list') }}" role="button">
                                <i class="btn btn-info rounded-pill">Suppliers</i>
                            </a>
                        </li>
                        <li class="dropdown notification-list ">
                            <a class="nav-link " href="{{ URL::to('add-make-payment') }}" role="button">
                                <i class="btn btn-warning rounded-pill">Payments and Receiving</i>
                            </a>
                        </li>
                        <li class="dropdown notification-list ">
                            <a class="nav-link " href="{{ URL::to('expense-list') }}" role="button">
                                <i class="btn btn-danger rounded-pill">Expanse</i>
                            </a>
                        </li>
                        <li class="dropdown notification-list ">
                            <a class="nav-link " href="" role="button">
                                <i class="btn btn-dark rounded-pill">Reports</i>
                            </a>
                        </li>

                    </ul>



                    <!--<div class="app-search dropdown d-none d-lg-block">-->
                    <!--    <form>-->
                    <!--        <div class="input-group">-->
                    <!--            <input type="text" class="form-control dropdown-toggle"  placeholder="Search..." id="top-search">-->
                    <!--            <span class="mdi mdi-magnify search-icon"></span>-->
                    <!--            <button class="input-group-text btn-primary" type="submit">Search</button>-->
                    <!--        </div>-->
                    <!--    </form>-->

                    <!--    <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">-->
                    <!-- item-->
                    <!--        <div class="dropdown-header noti-title">-->
                    <!--            <h5 class="text-overflow mb-2">Found <span class="text-danger">17</span> results</h5>-->
                    <!--        </div>-->

                    <!-- item-->
                    <!--        <a href="javascript:void(0);" class="dropdown-item notify-item">-->
                    <!--            <i class="uil-notes font-16 me-1"></i>-->
                    <!--            <span>Analytics Report</span>-->
                    <!--        </a>-->

                    <!-- item-->
                    <!--        <a href="javascript:void(0);" class="dropdown-item notify-item">-->
                    <!--            <i class="uil-life-ring font-16 me-1"></i>-->
                    <!--            <span>How can I help you?</span>-->
                    <!--        </a>-->

                    <!-- item-->
                    <!--        <a href="javascript:void(0);" class="dropdown-item notify-item">-->
                    <!--            <i class="uil-cog font-16 me-1"></i>-->
                    <!--            <span>User profile settings</span>-->
                    <!--        </a>-->

                    <!-- item-->
                    <!--        <div class="dropdown-header noti-title">-->
                    <!--            <h6 class="text-overflow mb-2 text-uppercase">Users</h6>-->
                    <!--        </div>-->

                    <!--        <div class="notification-list">-->
                    <!-- item-->
                    <!--            <a href="javascript:void(0);" class="dropdown-item notify-item">-->
                    <!--                <div class="d-flex">-->
                    <!--                    <img class="d-flex me-2 rounded-circle" src="{{ asset('public/adminPanel/assets/images/users/avatar-2.jpg') }}" alt="Generic placeholder image" height="32">-->
                    <!--                    <div class="w-100">-->
                    <!--                        <h5 class="m-0 font-14">Erwin Brown</h5>-->
                    <!--                        <span class="font-12 mb-0">UI Designer</span>-->
                    <!--                    </div>-->
                    <!--                </div>-->
                    <!--            </a>-->

                    <!-- item-->
                    <!--            <a href="javascript:void(0);" class="dropdown-item notify-item">-->
                    <!--                <div class="d-flex">-->
                    <!--                    <img class="d-flex me-2 rounded-circle" src="{{ asset('public/adminPanel/assets/images/users/avatar-5.jpg') }}" alt="Generic placeholder image" height="32">-->
                    <!--                    <div class="w-100">-->
                    <!--                        <h5 class="m-0 font-14">Jacob Deo</h5>-->
                    <!--                        <span class="font-12 mb-0">Developer</span>-->
                    <!--                    </div>-->
                    <!--                </div>-->
                    <!--            </a>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
                <!-- end Topbar -->