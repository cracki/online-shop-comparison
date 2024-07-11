@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Category Form</h3>
                        </div>
                        <form action="{{ route('category.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="categoryname">Category Name</label>
                                    <input type="text" class="form-control" id="categoryname" name="name" placeholder="Enter category" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" required>
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
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
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
