@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Product</h3>
                        </div>
                        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="productname">Product Name</label>
                                    <input type="text" class="form-control @error('product') is-invalid @enderror" id="productname" name="product" placeholder="Enter Product Name" value="{{ old('product', $product->product) }}">
                                    @error('product')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Enter Description" value="{{ old('description', $product->description) }}">
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('file') is-invalid @enderror" id="exampleInputFile" name="file">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                    @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Online Shops</label>
                                    <select class="select2 @error('productIds') is-invalid @enderror" multiple="multiple" data-placeholder="Select Online Shops" style="width: 100%;" name="productIds[]">
                                        @foreach($products as $prod)
                                            <option value="{{ $prod->id }}" {{ in_array($prod->id, old('product_id', $product->onlineShops->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $prod->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('productIds')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck1" {{ $product->exampleCheck1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@stop
