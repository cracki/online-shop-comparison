@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
        <section class="content">
            <div class="row">
                <div class="col-md-10 offset-md-1"> <!-- Adjusted column classes to center content and bring closer to sidebar -->
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-4 col-lg-3 mb-4">
                                <div class="card card-solid">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center"> <!-- Center align items -->
                                            <div class="product-image-container mb-2">
                                                <img src="{{ asset('dist/img/prod-1.jpg') }}" class="product-image" alt="Product Image">
                                            </div>
                                            <h5 class="my-1 text-center">{{ $product->name }}</h5> <!-- Center align text -->
                                            <p class="small text-center">{{ $product->description }}</p> <!-- Center align text -->
                                            <div class="bg-gray py-1 px-2 mt-auto">
                                                <h6 class="mb-0">
                                                    ${{ $product->price }}
                                                </h6>
                                            </div>

                                            <div class="mt-2">
                                                <form action="{{ route('cheapest-product', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm btn-flat">
                                                        <i class="fas fa-cart-plus fa-sm mr-1"></i> Add to Cart
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop

@section('css')
    <style>
        .product-image-container {
            max-height: 150px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: auto;
        }

        .card-body {
            padding: 0.5rem;
        }

        .card h5,
        .card p {
            margin: 0.5rem 0;
        }

        .btn-sm {
            font-size: 0.875rem;
        }

        .card-solid {
            height: 100%;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
