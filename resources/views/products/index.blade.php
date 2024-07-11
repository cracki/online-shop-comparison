@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Products</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search Products">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Product A Name</th>
                                <th>Product B Name</th>
                                <th>Category</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    </td>
                                    <td>{{ $product->productA->name ?? 'N/A' }}</td>
                                    <td>{{ $product->productB->name ?? 'N/A' }}</td>
                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{-- Pagination links --}}
                        {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
        }
        .card-title {
            font-weight: bold;
            color: #007bff;
        }
        .btn-sm {
            margin-right: 5px;
        }
    </style>
@endsection

@section('js')
    {{-- Add your JS scripts here --}}
@endsection
