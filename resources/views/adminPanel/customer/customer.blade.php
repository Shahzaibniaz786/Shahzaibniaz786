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
                <h4 class="page-title">Customer</h4>
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
                            Customer List
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#standard-modal">Add New Customer</button>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table id="scroll-horizontal-datatable" class="table table-sm table-centered w-100 nowrap">
                            <thead class="table-light">
                                <tr>

                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Address</th>
                                    <th>Opening balance</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($customers)
                                @foreach($customers as $customer)

                                <tr>
                                    <td>
                                        {{ $customer->id }}
                                    </td>

                                    <td>
                                        {{ $customer->customer_name }}
                                    </td>
                                    <td>
                                        {{ $customer->email }}
                                    </td>
                                    <td>
                                        {{ $customer->contact }}
                                    </td>
                                    <td>
                                        {{ $customer->address }}
                                    </td>
                                    <td>
                                        {{ $customer->opening_balance }}
                                    </td>

                                    <td class="table-action">
                                    <a href="javascript:void(0)"  data-id="{{ $customer->id }}" class="action-icon text-success" data-bs-toggle="modal" data-bs-target="#edit-modal"> <i class="mdi mdi-square-edit-outline"></i></a>    
                                    <a href="{{ route('customer.delete', $customer->id) }}"><i class="mdi mdi-trash-can-outline"></i></a>  
                                      
                                    </td>
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






 



    
    <!-- Standard modal for edit supplier  -->
    <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-modalLabel">Edit Supplier</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                    <form action="{{route('update.customer')}}" method="post">
                @csrf
                <input type="hidden" name="customerId" id="customer-id-field">
                <div class="modal-body">
                    <div class="row">
                            <div class="mb-3 col-lg-4">
                                <label for="name" class="mb-2"> Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Add product">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label for="email" class="mb-2">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter unit">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label for="item_type" class="mb-2">Contacts</label>
                                <input type="number" name="contact" id="contact" class="form-control @error('contact') is-invalid @enderror" placeholder="Enter type">
                                @error('contact')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                             <div class="mb-3 col-lg-4">
                                <label for="address" class="mb-2">Address</label>
                                <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter type">
                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label for="opening_balance" class="mb-2">Opening balance</label>
                                <input type="number" name="opening_balance" id="opening_balance" class="form-control @error('opening_balance') is-invalid @enderror" placeholder="Enter type">
                                @error('opening_balance')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- end row -->

</div>




   <!-- Standard modal -->
<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 83.3333%; margin: 1.75rem auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Add New Supplier</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('customer.save')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                            <div class="mb-3 col-lg-4">
                                <label for="name" class="mb-2"> Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Add product">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label for="email" class="mb-2">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter unit">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label for="item_type" class="mb-2">Contacts</label>
                                <input type="number" name="contact" id="contact" class="form-control @error('contact') is-invalid @enderror" placeholder="Enter type">
                                @error('contact')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                             <div class="mb-3 col-lg-4">
                                <label for="address" class="mb-2">Address</label>
                                <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter type">
                                @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label for="opening_balance" class="mb-2">Opening balance</label>
                                <input type="number" name="opening_balance" id="opening_balance" class="form-control @error('opening_balance') is-invalid @enderror" placeholder="Enter type">
                                @error('opening_balance')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">save</button>
                        </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->










@endsection

@section('scripts')
<script src="{{ asset('public/adminPanel/assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/adminPanel/assets/js/vendor/dataTables.bootstrap5.js') }}"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
</script>

<script>
    $('#edit-modal').on('show.bs.modal', function(event) {
        // console.log('Button clicked!');
        var button = $(event.relatedTarget);
        var customer = button.data('id'); 
        $(this).find('#customer-id-field').val(customer);
        $.ajax({
            type: 'GET',
            url: 'get-customer/' + customer,
        }).done(function(data) {
            $('#name').val(data.data.customer_name);
            $('#email').val(data.data.email);
            $('#contact').val(data.data.contact);
            $('#address').val(data.data.address);
            $('#opening_balance').val(data.data.opening_balance);
            $('#edit-modal').modal('show'); 
        });
    });
</script>


@endsection
<!-- container -->