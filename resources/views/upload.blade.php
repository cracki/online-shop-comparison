@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <head>
        <title>Upload JSON File</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container mt-5">
        <h2>Upload JSON File</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('upload.json') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="jsonFile" class="form-label">Select JSON file</label>
                <input type="file" name="jsonFile" id="jsonFile" class="form-control" accept=".json" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Select category</label>
                <select name="category" id="category" class="form-control">
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="shop" class="form-label">Select Shop</label>
                <select name="online_shop_id" id="shop" class="form-control">
                    @foreach($onlineShops  as $onlineShop)
                        <option value="{{$onlineShop->id}}">{{$onlineShop->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop


