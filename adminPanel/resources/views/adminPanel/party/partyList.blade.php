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
                <h4 class="page-title">Parties</h4>
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
                            Parties List
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#standard-modal">
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
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Opening Balance</th>
                                    <th>Balance</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($parties)
                                @foreach($parties as $party)

                                <tr>
                                    <td>
                                        {{ $party->id }}
                                    </td>

                                    <td>
                                        {{ $party->name }}
                                    </td>
                                    <td>
                                        {{ $party->type }}
                                        @if($party->type == 'Customer')
                                        <br>Supplier: {{ $party->supplier->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $party->email }}
                                    </td>
                                    <td>
                                        {{ $party->opening_balance }}
                                    </td>
                                    <td>
                                        {{ $party->balance }}
                                    </td>
                                    <td class="table-action">
                                    <a href="javascript:void(0)"  data-id="{{ $party->id }}" class="action-icon text-success" data-bs-toggle="modal" data-bs-target="#edit-modal"> <i class="mdi mdi-square-edit-outline"></i></a>                                    </td>
                                </tr>
                                @endforeach
                                @endisset
                            </tbody>
                        </table>
                        {{ $parties->links() }}
                    </div>
                    
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

    <!-- Standard modal -->
    <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Add New Party</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ URL::to('/add-party') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Party Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Party Name">
                                    @error('name')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Party Type</label>
                                    <select name="type" onchange="selectType()" class="form-control" required id="particularType">
                                        <option value="">Select One</option>
                                        <option value="Marka">Marka</option>
                                        <option value="Driver">Driver</option>
                                        <option value="Customer">Customer</option>
                                    </select>
                                    @error('type')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12" style="display:none" id="suppliers-list-div">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Select Supplier</label>
                                    <select name="supplier_id" class="form-control" id="suppliers-list">
                                        <option value="">Select One</option>
                                        @isset($suppliers)
                                        @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                        @endisset
                                    </select>
                                    @error('type')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Party Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Party Email">
                                    @error('email')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Opening Balance</label>
                                    <input type="text" name="openingBalance" value="0" class="form-control" placeholder="Opening Balance">
                                    @error('openingBalance')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Company Name <span>Optional</span></label>
                                    <input type="text" name="company_name" class="form-control" placeholder="Company Name ">
                                    @error('company_name')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" placeholder="Party Address">
                                    @error('address')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
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

     <!-- edit modal -->
     <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-modalLabel">Edit Party</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ route('update.party') }}" method="post">
                    @csrf
                    <input type="hidden" name="partyId" id="party-id-field">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Party Name</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                    @error('name')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Party Type</label>
                                    <select name="type" onchange="selectTypeEdit()" disabled="true" class="form-control particularType" required id="partiyType">
                                        <option value="">Select One</option>
                                        <option value="Marka">Marka</option>
                                        <option value="Driver">Driver</option>
                                        <option value="Customer">Customer</option>
                                    </select>
                                    @error('type')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 suppliers-list-div" style="display:none" id="supplier-list-div">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Select Supplier</label>
                                    <select name="supplier_id" class="form-control supplier_id" id="supplier-list"  disabled="true">
                                        <option value="">Select One</option>
                                        @isset($suppliers)
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @error('type')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Party Email</label>
                                    <input type="text" id="email" name="email" class="form-control">
                                    @error('email')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Opening Balance</label>
                                    <input type="text" readonly id="openingBalance" name="openingBalance" value="0" class="form-control">
                                    @error('openingBalance')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Company Name <span>Optional</span></label>
                                    <input type="text" id="company_name" name="company_name" class="form-control">
                                    @error('company_name')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Address</label>
                                    <input type="text" id="address" name="address" class="form-control">
                                    @error('address')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
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

    function selectType() {
        var type = $('#particularType').val();
        if (type == 'Customer') {
            $('#suppliers-list-div').css('display', 'block');
            $('#suppliers-list').attr('required', true);
        } else {
            $('#suppliers-list-div').css('display', 'none');
            $('#suppliers-list').attr('required', false);
        }
    }
</script>

<script>
    $('#edit-modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var party = button.data('id'); 
        $(this).find('#party-id-field').val(party);
        $.ajax({
            type: 'GET',
            url: 'get-party/' + party,
        }).done(function(data) {
            $('#name').val(data.data.name);
            $('#email').val(data.data.email);
            $('#partiyType').val(data.data.type);
            $('.supplier_id').val(data.data.supplier_id);
            $('#openingBalance').val(data.data.opening_balance);
            $('#company_name').val(data.data.company_name);
            $('#address').val(data.data.address);
             // Dynamically update the selects
             if ($('#partiyType').val() == 'Customer') {
                $('#supplier-list-div').show(); // Show the supplier select
                $('.supplier-list').val(data.supplier_id); // Select the supplier
            } else {
                $('#supplier-list-div').hide(); // Hide the supplier select
            }
            $('#edit-modal').modal('show'); 
        });
    });

    function selectTypeEdit() {
        var type = $('#partiyType').val();
        if (type == 'Customer') {
            $('#supplier-list-div').css('display', 'block');
            $('#supplier-list').attr('required', true);
        } else {
            $('#supplier-list-div').css('display', 'none');
            $('#supplier-list').attr('required', false);
        }
    }
</script>
@endsection
<!-- container -->