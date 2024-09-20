@extends('adminPanel/master')
@section('style')
<link href="{{ asset('public/adminPanel/assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            
            <div class="page-title-box">
                <div class="page-title-right">

                </div>
                <h4 class="page-title">Summary Reports</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <h4 class="page-title">Summary Reports</h4>
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <!-- <a href="{{ URL::to('payments-add') }}" class="btn btn-success" ><i class="mdi mdi-plus-circle me-2"></i>Add Payment</a> -->
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                <li class="nav-item">
                                    <a href="#date_wise_pay" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active">
                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Date wise Summary</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#supplier_wise_pay" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 mx-2">
                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Supplier wise Summary</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="date_wise_pay">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Date Wise Summary Report</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <form action="{{ URL::to('day-summary-report') }}" target="blank" method="post">
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="col-md-5">
                                                        <label for="exampleInputEmail1" class="form-label">Date</label>
                                                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="date" id="">
                                                    </div>
                                                    
                                                    <div class="col-md-2">
                                                        <button type="submit" style="margin-top:1.8rem;" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="supplier_wise_pay">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>Supllier Wise Summary Report</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <form action="{{ URL::to('supplier-wise-summary-report') }}" target="blank" method="post">
                                                @csrf
                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <label for="exampleInputEmail1" class="form-label">Date</label>
                                                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="date" id="">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="superlier-id" class="form-label">Select Supplier</label>
                                                        <select class="form-control" name="supplier" id="supplier-id" class="form-control">
                                                            <option value="" disabled selected >Select Supplier</option>
                                                            @foreach ($suppliers as $supplier )
                                                                <option value="{{ $supplier->id }}">{{ Str::ucfirst($supplier->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="account-id" class="form-label">Select Account</label>
                                                        <select class="form-control" name="account" id="account-id" class="form-control">
                                                            <option value="" disabled selected >Select Account</option>
                                                            @foreach ($accounts as $account )
                                                                <option value="{{ $account->id }}">{{ Str::ucfirst($account->account_name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" style="margin-top:1.8rem;" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                        </div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

    <!-- end row -->

</div>


@endsection

@section('scripts')
<script src="{{ asset('public/adminPanel/assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminPanel/assets/js/vendor/dataTables.bootstrap5.js') }}"></script>

<script>
    @if(session('success'))
    $(document).ready(function() {
        $("#success-alert-modal").modal('show');
    })
    @endif

    @if(session('error'))
    $(document).ready(function() {
        $("#error-alert-modal").modal('show');
    })
    @endif

    $("#scroll-horizontal-datatable").DataTable({
        scrollX: !0,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function() {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
    })
</script>
@endsection
<!-- container -->