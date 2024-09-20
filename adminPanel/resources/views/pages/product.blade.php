@extends('layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session()->has('success'))
                <div class="card shadow border-0 mt-4 p-3">
                    <p>{{ session()->get('success') }}</p>
                </div>
                @endif

                <!-- Login card -->
                <div class="card shadow border-0 p-5 mt-4"> 
                    <h1 class="h3">Add Product</h1>
                    <form action="{{route('products.save')}}" method="POST">
                        @csrf
                        <div class="row">
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
                                <label for="item_unit" class="mb-2">Item Unit</label>
                                <input type="text" name="item_unit" id="item_unit" class="form-control @error('item_unit') is-invalid @enderror" placeholder="Enter unit">
                                @error('item_unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label for="item_type" class="mb-2">Item Type</label>
                                <input type="text" name="item_type" id="item_type" class="form-control @error('item_type') is-invalid @enderror" placeholder="Enter type">
                                @error('item_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                             <div class="mb-3 col-lg-4">
                                <label for="item_type" class="mb-2">Opening Stock</label>
                                <input type="number" name="opening_stock" id="opening_stock" class="form-control @error('opening_stock') is-invalid @enderror" placeholder="Enter type">
                                @error('opening_stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-3  mb-3">
                                <label for="" class="mb-2">Supplier<span class="req">*</span></label>
                                <select name="supplier" id="supplier" class="form-control">
                                    <option value="1">Select a supplier</option>
                                    @if ($suppliers->isNotEmpty())
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->Supplier_name}}</option>

                                    @endforeach
                                        
                                    @endif
                                    
                                    {{-- <option value="">Fashion designing</option> --}}
                                </select>
                            </div>

                            <div class="mb-3 col-lg-1 d-flex align-items-end">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                    Add
                                </button>
                            </div>

                            <div class="mb-3 col-lg-4">
                                <label for="cost_price" class="mb-2">Cost Price</label>
                                <input type="number" name="cost_price" id="cost_price" class="form-control @error('cost_price') is-invalid @enderror" placeholder="Enter type">
                                @error('cost_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">

                            <div class="mb-3 col-lg-4">
                                <label for="retail_price" class="mb-2">Retail Price</label>
                                <input type="number" name="retail_price" id="retail_price" class="form-control @error('retail_price') is-invalid @enderror" placeholder="Enter type">
                                @error('retail_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="justify-content-between d-flex">
                            <button class="btn btn-primary mt-2">submit</button>
                        </div>
                    </form>
                    
                </div>
                <!-- End of Login card -->
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>







    {{-- modal  --}}

    <div class="container col-lg-10">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <!-- Modal Structure -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content col-lg-10 mx-auto">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-lg-4">
                                            <label for="name" class="mb-2">Name</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Add product">
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-lg-4">
                                            <label for="email" class="mb-2">Email</label>
                                            <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter unit">
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

                                    <div class="justify-content-between d-flex">
                                        <button class="btn btn-primary mt-2">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- jQuery and Bootstrap JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</section>
@endsection
