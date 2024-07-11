@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                        </div>
                        <form action="{{ route('sync-product', ['category' => $category->id]) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="colesProducts">Coles Products</label>
                                    <select id="colesProducts" class="form-control select2 @error('colesProductIds') is-invalid @enderror" multiple="multiple" data-placeholder="Select Products" style="width: 100%;" name="colesProductIds[]">
                                        @foreach($colesProducts as $colesProduct)
                                            <option value="{{ $colesProduct->id }}">{{ $colesProduct->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('colesProductIds')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="woolworthsProducts">Woolworths Products</label>
                                    <select id="woolworthsProducts" class="form-control select2 @error('woolworthsProductIds') is-invalid @enderror" multiple="multiple" data-placeholder="Select Products" style="width: 100%;" name="woolworthsProductIds[]">
                                        @foreach($woolworthsProducts as $woolworthsProduct)
                                            <option value="{{ $woolworthsProduct->id }}">{{ $woolworthsProduct->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('woolworthsProductIds')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck1">
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
