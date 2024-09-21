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
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-light" id="dash-daterange">
                            <span class="input-group-text bg-primary border-primary text-white">
                                <i class="mdi mdi-calendar-range font-13"></i>
                            </span>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ms-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">User</h4>
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
                            Users List
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-modal">
                                    Add New
                                </button>
                                                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table id="scroll-horizontal-datatable" class="table table-centered w-100 nowrap">
                            <thead class="table-light">
                                <tr>

                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Rights</th>
                                    {{-- <th style="width: 85px;">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @isset($users)
                                @foreach($users as $user)

                                <tr>
                                    <td>
                                        {{ $user->id }}
                                    </td>

                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        @php
                                        $userPermissions = $user->permissions->pluck('name');
                                        @endphp

                                        @foreach($userPermissions as $permission)
                                        {{ $permission }}<br>
                                        @endforeach
                                    </td>
                                    {{-- <td>
                                        <button type="button" class="btn btn-sm btn-primary edit-user" data-bs-toggle="modal" data-bs-target="#user-modal" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-rights="{{ implode(',', $userPermissions->toArray()) }}">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        
                                    
                                    </td> --}}
                                </tr>
                                @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

{{-- <div id="user-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="user-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="user-modalLabel">Edit User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form id="user-form" action="{{ URL::to('/update-user') }}" method="post">
                @csrf
                <input type="hidden" name="user_id" id="user-id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3" style="margin-top:2rem;">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" name="userRight[]" value="orders" id="customCheckcolor2" checked="">
                                        <label class="form-check-label" for="customCheckcolor2">Order</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3" style="margin-top:2rem;">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" name="userRight[]" value="product-type" id="videos" checked="">
                                        <label class="form-check-label" for="videos">Product-Type</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3" style="margin-top:2rem;">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" name="userRight[]" value="suppliers" id="Offers" checked="">
                                        <label class="form-check-label" for="Offers">Supplier</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3" style="margin-top:2rem;">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" name="userRight[]" value="party" id="Locations" checked="">
                                        <label class="form-check-label" for="Locations">Parties</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3" style="margin-top:2rem;">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" name="userRight[]" value="accounts" id="Scoieties" checked="">
                                        <label class="form-check-label" for="Scoieties">Accounts</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3" style="margin-top:2rem;">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" name="userRight[]" value="expense" id="accounts" checked="">
                                        <label class="form-check-label" for="accounts">Expense</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3" style="margin-top:2rem;">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" name="userRight[]" value="reports" id="expense" checked="">
                                        <label class="form-check-label" for="expense">Reports</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3" style="margin-top:2rem;">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" name="userRight[]" value="user-management" id="user-management" checked="">
                                        <label class="form-check-label" for="user-management">User Management</label>
                                    </div>
                                </div>
                            </div>
                                
                            </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}


    <!-- Standard modal -->
    <div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="add-modalLabel">Add New User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ URL::to('/add-user') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label"> User Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="User Name">
                                    @error('name')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                    @error('email')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                    @error('password')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
                                    @error('password')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="product" id="customCheckcolor1" checked="">
                                                <label class="form-check-label" for="customCheckcolor1">Product</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="customer" id="customerCheckvideos" checked="">
                                                <label class="form-check-label" for="customerCheckvideos">Customer</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="suppliers" id="customercheckoffers" checked="">
                                                <label class="form-check-label" for="customercheckoffers">Supplier</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="nozzale" id="customercheckLocations" checked="">
                                                <label class="form-check-label" for="customercheckLocations">Nozzale</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="accounts" id="customercheckScoieties" checked="">
                                                <label class="form-check-label" for="customercheckScoieties">Accounts</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="expense" id="customercheckaccounts" checked="">
                                                <label class="form-check-label" for="customercheckaccounts">Expense</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="sale" id="customercheckexpense" checked="">
                                                <label class="form-check-label" for="customercheckexpense">Sale</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="purchase" id="customercheckexpense" checked="">
                                                <label class="form-check-label" for="customercheckexpense">Purchase</label>
                                            </div>
                                        </div>
                                    </div>
                                    div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="reports" id="customercheckepartyreports" checked="">
                                                <label class="form-check-label" for="customercheckepartyreports">Reports</label>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="party-reports" id="customercheckepartyreports" checked="">
                                                <label class="form-check-label" for="customercheckepartyreports">Party Reports</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="order-reports" id="customercheckeorderreports" checked="">
                                                <label class="form-check-label" for="customercheckeorderreports">Order Reports</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="expense-reports" id="customercheckeexpensereports" checked="">
                                                <label class="form-check-label" for="customercheckeexpensereports">Expense Reports</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="payment-receiving-reports" id="customercheckepaymentreceivingreports" checked="">
                                                <label class="form-check-label" for="customercheckepaymentreceivingreports">Payment & Receiving Reports</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="summary-reports" id="customercheckesummaryreports" checked="">
                                                <label class="form-check-label" for="customercheckesummaryreports">Summary Reports</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="party-statements" id="customercheckepartystatement" checked="">
                                                <label class="form-check-label" for="customercheckepartystatement">Party Statement</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="ledger" id="customercheckeledger" checked="">
                                                <label class="form-check-label" for="customercheckeledger">Ledger</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3" style="margin-top:2rem;">
                                            <div class="form-check form-checkbox-success mb-2">
                                                <input type="checkbox" class="form-check-input" name="userRight[]" value="user-management" id="customercheckuser-management" checked="">
                                                <label class="form-check-label" for="customercheckuser-management">User Management</label>
                                            </div>
                                        </div>
                                    </div> --}}

                                    

                                </div>



                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- end row -->

</div>
@endsection

@section('scripts')
<script src="{{ asset('public/adminPanel/assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminPanel/assets/js/vendor/dataTables.bootstrap5.js') }}"></script>

<script>
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
    console.log('page is load now');

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-user').forEach(function(button) {
            button.addEventListener('click', function() {
                var userId = this.getAttribute('data-id');
                var userName = this.getAttribute('data-name');
                var userEmail = this.getAttribute('data-email');
                var userRights = this.getAttribute('data-rights').split(',');

                // Set form action to update user
                // document.getElementById('user-form').action = '/update-user/';

                // Set form inputs
                document.getElementById('user-id').value = userId;
                document.getElementById('name').value = userName;
                document.getElementById('email').value = userEmail;
// // Reset all checkboxes to unchecked
// document.querySelectorAll('input[name="userRight[]"]').forEach(function(checkbox) {
//                     checkbox.checked = false;
//                 });
                // Set checkboxes or other inputs for rights
                document.querySelectorAll('input[name="userRight[]"]').forEach(function(checkbox) {
                    if (userRights.includes(checkbox.value)) {
                        checkbox.checked = true;
                        console.log(checkbox.checked = true);
                    }
            });
        });
    });
});
</script>
@endsection
<!-- container -->