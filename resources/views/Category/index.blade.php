@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search Categories">
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
                                <th>Actions</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit Category">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('category.show', $category->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="sync product">
                                            <i class="fas fa-sync"></i>
                                        </a>
                                        <a href="{{ route('index-product', $category->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="show products">
                                            <i class="fas fa-book-open"></i>
                                        </a>
                                        <a href="{{ route('compare.category.products', $category->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="compare products">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>{{ $category->created_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{-- {{ $categories->links() }} --}}
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
    {{-- Initialize tooltips --}}
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
