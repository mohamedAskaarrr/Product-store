@extends('layouts.master')
@section('title', 'Edit Product')
@section('content')

<div class="container py-4">
    <h1 class="text-gold mb-4">🛠️ Fragrence managment</h1>

    <!-- Error messages -->
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        <strong>Error!</strong> {{$error}}
    </div>
    @endforeach

    <!-- Product Edit Form -->
    <form action="{{route('products_save', $product->id)}}" method="post" class="p-4 rounded shadow-sm product-form">
        {{ csrf_field() }}
        
        <div class="row mb-3">
            <div class="col-6">
                <label for="code" class="form-label text-gold">Code:</label>
                <input type="text" class="form-control" placeholder="Product Code" name="code" required value="{{$product->code}}">
            </div>
            <div class="col-6">
                <label for="model" class="form-label text-gold">Model:</label>
                <input type="text" class="form-control" placeholder="Product Model" name="model" required value="{{$product->model}}">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <label for="name" class="form-label text-gold">Name:</label>
                <input type="text" class="form-control" placeholder="Product Name" name="name" required value="{{$product->name}}">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-6">
                <label for="price" class="form-label text-gold">Price:</label>
                <input type="number" class="form-control" placeholder="Product Price" name="price" required value="{{$product->price}}">
            </div>
            <div class="col-6">
                <label for="photo" class="form-label text-gold">Photo URL:</label>
                <input type="text" class="form-control" placeholder="Product Photo" name="photo" required value="{{$product->photo}}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="description" class="form-label text-gold">Description:</label>
                <textarea class="form-control" placeholder="Product Description" name="description" required rows="4">{{$product->description}}</textarea>
            </div>
        </div>
        @can('manage_inventory')
        <div class="row mb-3">
            <div class="col-6">
                <label for="stock" class="form-label text-gold">Stock:</label>
                <input type="number" class="form-control" placeholder="Stock" name="stock" min="0" value="{{$product->stock}}">
            </div>
        </div>
        @endcan
        <!-- Submit Button -->
        <button type="submit" class="btn btn-gold w-100">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </form>
</div>

<style>
    :root {
        --primary-color: #f5f5f5;
        --secondary-color: #D4AF37;
        --card-bg: #3a2828;
        --light-bg: #2c1e1e;
        --danger-color: #a94442;
        --text-color: #f5f5f5;
        --dark-bg: #1c1212;
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Roboto', sans-serif;
        color: var(--text-color);
    }

    .product-form {
        background-color: var(--card-bg);
        border: 1px solid var(--secondary-color);
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control {
        background-color: var(--dark-bg);
        border: 1px solid var(--secondary-color);
        color: var(--text-color);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background-color: var(--dark-bg);
        border-color: var(--secondary-color);
        color: var(--text-color);
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
    }

    .form-control::placeholder {
        color: #666;
    }

    .btn-gold {
        background: linear-gradient(45deg, var(--secondary-color), #b89b76);
        color: var(--dark-bg);
        border: none;
        font-weight: 500;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }

    .btn-gold:hover {
        background: linear-gradient(45deg, #b89b76, var(--secondary-color));
        color: var(--dark-bg);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .text-gold {
        color: var(--secondary-color);
    }

    .alert-danger {
        background-color: var(--danger-color);
        color: var(--text-color);
        border: none;
        border-radius: 8px;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .container {
        max-width: 900px;
    }

    h1 {
        font-weight: 600;
        letter-spacing: 0.5px;
    }
</style>

@endsection
