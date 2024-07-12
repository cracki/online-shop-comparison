@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Category</h3>
                        </div>
                        <!-- form start -->
                        <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="categoryname">Category Name</label>
                                    <input type="text" class="form-control" id="categoryname" name="name" placeholder="Enter category name" value="{{ old('name', $category->name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter description" required>{{ old('description', $category->description) }}</textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('category.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <!-- Add your extra stylesheets here -->
@stop

@section('js')
    <!-- jQuery -->
    <script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ asset('vendor/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 elements
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
