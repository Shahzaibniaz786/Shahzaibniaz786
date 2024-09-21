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
                <h4 class="page-title">Purchase</h4>
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
                            Purchase List
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#standard-modal">Purchase list</button>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="form">
                        <form id="addProductForm" action="{{ route('Fetch.product') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                            <div class="mb-3 col-lg-4">
                                <label for="date" class="mb-2">Date</label>
                                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" placeholder="Add date" value="{{ old('date') }}">
                                @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label for="supplier_name" class="mb-2">Supplier name</label>
                                <input type="text" name="supplier_name" id="supplier_name" class="form-control @error('supplier_name') is-invalid @enderror" placeholder="Add product"value="{{ old('supplier_name') }}">
                                @error('supplier_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-lg-4">
                               <label for="total_bill" class="mb-2">Total bill</label>
                               <input type="number" name="total_bill" id="total_bill" class="form-control @error('total_bill') is-invalid @enderror" placeholder="0" value="{{ old('total_bill') }}">
                               @error('total_bill')
                               <div class="invalid-feedback">
                                   {{ $message }}
                               </div>
                               @enderror
                           </div>

                        </div>

                        <div class="row">
                            <div class="mb-3 col-lg-4">
                               {{-- <label for="total_bill" class="mb-2">Adjustment</label> --}}
                               <input type="hidden" name="adjustment" id="adjustment" class="form-control @error('adjustment') is-invalid @enderror" placeholder="Enter type" value="{{ old('adjustment') }}">
                               @error('adjustment')
                               <div class="invalid-feedback">
                                   {{ $message }}
                               </div>
                               @enderror
                           </div>
                            <div class="mb-3 col-lg-4">
                               <label for="total_bill" class="mb-2">Adjustment</label>
                               <input type="number" name="adjustment" id="adjustment" class="form-control @error('adjustment') is-invalid @enderror" placeholder="0" value="{{ old('adjustment') }}">
                               @error('adjustment')
                               <div class="invalid-feedback">
                                   {{ $message }}
                               </div>
                               @enderror
                           </div>
                            <div class="mb-3 col-lg-4">
                               <label for="total_bill" class="mb-2">Net Payable</label>
                               <input type="number" name="net_payable" id="net_payable" class="form-control @error('net_payable') is-invalid @enderror" placeholder="0" value="{{ old('net_payable') }}">
                               @error('net_payable')
                               <div class="invalid-feedback">
                                   {{ $message }}
                               </div>
                               @enderror
                           </div>

                           <div class="row">
                                <div class="mb-3 col-lg-10">
                                    <label for="total_bill" class="mb-2">Select Product</label>
                                    <select name="select_product" id="select_product" class="form-control @error('select_product') is-invalid @enderror"  value="{{ old('select_product') }}">
                                        <option value="">Select product</option>
                                        @foreach ($products as $product)
                                        <option value="{{$product->id}}">{{$product->product_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('select_product')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                
                                <div class=" col-lg-2 d-flex align-self-center justify-content-end">
                                    <button type="submit" class="btn btn-warning">Add Product</button>
                                </div>
                            </div>



                        </div>

                        


                </div>
                
            </form>
                    </div>

                    
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>

                    <div class="table-responsive">
                        <table id="product-table" class="table table-sm table-centered w-100 nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>Cost price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="product-table-body">
                                <!-- Dynamically added products will appear here -->
                            </tbody>
                        </table>
                    </div>




 



   <!-- Standard modal for edit product -->
<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
    <div class="modal-dialog "> <!-- Use modal-xl for larger modal width -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="edit-modalLabel">Edit Product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('update.product')}}" method="post">
                @csrf
                <input type="hidden" name="productId" id="product-id-field">
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3 col-lg-4">
                            <label for="product_code" class="mb-2">Product Code</label>
                            <input type="number" name="product_code" id="product_code" class="form-control @error('product_code') is-invalid @enderror" placeholder="Add product">
                            @error('product_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3 col-lg-4">
                            <label for="email" class="mb-2">Product Name</label>
                            <input type="text" name="product_name" id="product_name" class="form-control @error('product_name') is-invalid @enderror" placeholder="Add product">
                            @error('product_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3 col-lg-4">
                           <label for="item_type" class="mb-2">Opening Stock</label>
                           <input type="number" name="opening_stock" id="opening_stock" class="form-control @error('opening_stock') is-invalid @enderror" placeholder="Enter type">
                           @error('opening_stock')
                           <div class="invalid-feedback">
                               {{ $message }}
                           </div>
                           @enderror
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





   <!-- Standard modal -->
<div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog " >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Add New Product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{route('products.save')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                            <div class="mb-3 col-lg-4">
                                <label for="product_code" class="mb-2">Product Code</label>
                                <input type="number" name="product_code" id="product_code" class="form-control @error('product_code') is-invalid @enderror" placeholder="Add product" value="{{ old('product_code') }}">
                                @error('product_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 col-lg-4">
                                <label for="email" class="mb-2">Product Name</label>
                                <input type="text" name="product_name" id="product_name" class="form-control @error('product_name') is-invalid @enderror" placeholder="Add product"value="{{ old('product_name') }}">
                                @error('product_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-lg-4">
                               <label for="item_type" class="mb-2">Opening Stock</label>
                               <input type="number" name="opening_stock" id="opening_stock" class="form-control @error('opening_stock') is-invalid @enderror" placeholder="Enter type" value="{{ old('opening_stock') }}">
                               @error('opening_stock')
                               <div class="invalid-feedback">
                                   {{ $message }}
                               </div>
                               @enderror
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
        var product = button.data('id'); 
        $(this).find('#product-id-field').val(product);
        $.ajax({
            type: 'GET',
            url: 'get-product/' + product,
        }).done(function(data) {
            $('#product_code').val(data.data.product_code);
            $('#product_name').val(data.data.product_name);
            $('#opening_stock').val(data.data.opening_stock);
            $('#edit-modal').modal('show'); 
        });
    });
</script>

<script>
    // Set today's date as the value for the date input
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
        dateInput.value = today;
    });
</script>

<script>
$(document).ready(function() {
    $('#addProductForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Get the selected product ID
        const selectedProductId = $('#select_product').val();
        
        // Perform an AJAX request to fetch the product details
        $.ajax({
            url: "{{ route('fetch.product.details') }}", // Route to fetch product details
            method: 'POST',
            data: {
                product_id: selectedProductId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Assuming response contains the product details
                if (response.success) {
                    const product = response.data;

                    // Append the new row to the product table
                    $('#product-table-body').append(`
                        <tr>
                            <td>${product.id}</td>
                            <td>${product.name}</td>
                            <td>${product.stock}</td>
                            <td>${product.cost_price}</td>
                            <td>${product.qty}</td>
                            <td>${product.total}</td>
                            <td>
                                <button class="btn btn-danger" onclick="removeProduct(${product.id})">Remove</button>
                            </td>
                        </tr>
                    `);
                } else {
                    // Handle error if product not found
                    alert('Product not found.');
                }
            },
            error: function(xhr) {
                // Handle any errors
                console.error(xhr);
            }
        });
    });
});

// Function to remove a product from the table
function removeProduct(productId) {
    // Logic to remove the product from the table (you can implement confirmation here)
    $(`#product-table-body tr:has(td:contains(${productId}))`).remove();
}
</script>



@endsection
<!-- container -->