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
                <h4 class="page-title">Product</h4>
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
                            Products List
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#standard-modal">Add New Product</button>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table id="scroll-horizontal-datatable" class="table table-sm table-centered w-100 nowrap">
                            <thead class="table-light">
                                <tr>

                                    <th>ID</th>
                                    <th>code</th>
                                    <th>Name</th>
                                    <th>opening_stock</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($products)
                                @foreach($products as $product)

                                <tr>
                                    <td>
                                        {{ $product->id }}
                                    </td>

                                    <td>
                                        {{ $product->product_code }}
                                    </td>
                                    <td>
                                        {{ $product->product_name }}
                                    </td>
                                    <td>
                                        {{ $product->opening_stock }}
                                    </td>

                                    <td class="table-action">
                                    <a href="javascript:void(0)"  data-id="{{ $product->id }}" class="action-icon text-success" data-bs-toggle="modal" data-bs-target="#edit-modal"> <i class="mdi mdi-square-edit-outline"></i></a> 
                                    <a href="{{ route('product.delete', $product->id) }}"><i class="mdi mdi-trash-can-outline"></i></a>
                                    
      
                                      
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







{{-- modal for add supplier  --}}

 {{-- <div id="add_supplier" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-modalLabel">Add Supplier</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ route('add_supplier') }}" method="post">
                    @csrf
                    <input type="hidden" name="supplierId" id="supplier-id-field">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Supplier Name</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                    @error('name')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Supplier Email</label>
                                    <input type="text" id="email" name="email" class="form-control">
                                    @error('email')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="example-input-normal" class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control">
                                    @error('phone')
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

</div> --}}



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


@endsection
<!-- container -->