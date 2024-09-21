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
                <h4 class="page-title">Received Payment</h4>
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
                            <h5>Received Payment Details</h5>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table id="scroll-horizontal-datatable" class="table table-centered w-100 nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr</th>
                                    <th>Received Payment Id</th>
                                    <th>Transcation Id</th>
                                    <th>Particular</th>
                                    <th>Particular Name</th>
                                    <th>Payment</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($receivedPaymentItems)
                                @foreach($receivedPaymentItems as $item)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $item->received_payment_id }}
                                    </td>
                                    <td>
                                        {{ $item->id }}
                                    </td>
                                    <td>
                                        {{ $item->particular }}
                                    </td>
                                    <td>
                                        {{ $item->particular_name}}
                                    </td>
                                    <td>
                                        {{ number_format($item->payment) }}
                                    </td>
                                    <td>
                                        {{ $item->remarks }}
                                    </td>
                                    <td>
                                        <button onclick="openUpdatePaymentModel({{ $item->id }})" class="btn btn-success btn-sm"><i class="mdi mdi-clipboard-edit-outline"></i></button>
                                        <a href="{{ URL::to('delete-payment-received-item/'.$item->id.'') }}" onclick="return confirm('Are You Sure To Delete This')" class="btn btn-danger btn-sm">X</a>
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


    <div id="payment-modal" class="modal fade" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Update Received Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ URL::to('/update-payment-received-item') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label"> Party Id</label>
                                    <input type="text" id="payment-item-id" hidden name="payment_received_id" class="form-control" placeholder="">
                                    <input type="text" id="party_id" readonly name="party_id" class="form-control" placeholder="">
                                    @error('date')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Type</label>
                                    <input type="text" id="party-type" class="form-control" name="party-type" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Name</label>
                                    <input type="text" id="party-name" class="form-control" name="party-name" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Total Payment</label>
                                    <input type="text" name="total_payment" id="total-payments" class="form-control" placeholder="Total Payments">

                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">remarks</label>
                                    <input type="text" id="remarks" class="form-control" name="remarks">
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

    function openUpdatePaymentModel(id) {
        console.log('payment id ' + id);
        $('#payment-modal').modal('show');

        $.ajax({
            url: "{{ URL::to('get-recevied-payment-item') }}/" + id + "",
            type: 'GET',
            data: {},
            success: function(paymentData) {
                var payment = paymentData['data']['paymentItem'];
                console.log(payment['account_id']);

                $('#payment-item-id').val(payment['id']);
                $('#party_id').val(payment['particular_id']);
                $('#party-type').val(payment['particular']);
                $('#party-name').val(payment['particular_name']);
                $('#total-payments').val(payment['payment']);
                $('#remarks').val(payment['remarks']);

            }
        });
    }
    console.log('page is load now');
</script>
@endsection
<!-- container -->