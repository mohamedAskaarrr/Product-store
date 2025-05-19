<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
@extends('layouts.master')
@section('title', 'Products')
@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h1 class="display-4 mb-0">🛍️ Products</h1>
        </div>
        <div class="col-md-4 text-end">
            @can('add_products')
            <a href="{{ route('products_edit') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Add Product
            </a>
            @endcan
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <form class="row g-3">
                <div class="col-md-3">
                    <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}">
                </div>
                <div class="col-md-2">
                    <input name="min_price" type="number" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}">
                </div>
                <div class="col-md-2">
                    <input name="max_price" type="number" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}">
                </div>
                <div class="col-md-3">
                    <select name="order_by" class="form-select">
                        <option value="">Sort By</option>
                        <option value="price">Price</option>
                        <option value="name">Name</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('products_list') }}" class="btn btn-outline-danger w-100">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($products as $product)
        <div class="col">
            <div class="card h-100 product-card">
                <div class="position-relative">
                    <img src="{{ asset('images/' . $product->photo) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                    @if($product->available_stock <= 0)
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-danger">Out of Stock</span>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title product-title">{{ $product->name }}</h5>
                    <div class="product-details">
                        <p class="card-text mb-2 text-white"><strong>Model:</strong> {{ $product->model }}</p>
                        <p class="card-text mb-2 text-white"><strong>Code:</strong> {{ $product->code }}</p>
                        <p class="card-text mb-2 text-white"><strong>Price:</strong> ${{ $product->price }}</p>
                        <p class="card-text mb-3 text-white"><strong>Stock:</strong> {{ $product->available_stock }}</p>
                        <div class="description-container">
                            <p class="card-text description">{{ $product->description }}</p>
                            <div class="description-fade"></div>
                            <span class="view-more" onclick="toggleDescription(this)">View more</span>
                            <span class="show-less" onclick="toggleDescription(this)">Show less</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        @if($product->available_stock > 0)
                        <form action="{{ route('products.addTobasket', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-shopping-cart"></i> Buy
                            </button>
                        </form>
                        @else
                        <button class="btn btn-secondary" disabled>Out of Stock</button>
                        @endif

                        <div class="btn-group">
                            @can('edit_products')
                            <a href="{{ route('products_edit', $product->id) }}" class="btn btn-outline-light">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('delete_products')
                            <form action="{{ route('products_delete', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>

                    @role('Employee')
                    <form action="{{ route('products.addstock', $product->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group">
                            <input type="number" class="form-control" name="stock" placeholder="Add stock">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </form>
                    @endrole
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    :root {
        --primary-color: #f5f5f5;
        --secondary-color: #c6a47e;
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

    .product-card {
        background-color: var(--card-bg);
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .product-img {
        width: 100%;
        height: 300px;
        object-fit: contain;
        background-color: var(--dark-bg);
        padding: 10px;
        border-radius: 8px 8px 0 0;
    }

    .position-relative {
        background-color: var(--dark-bg);
        border-radius: 8px 8px 0 0;
    }

    .product-title {
        color: var(--secondary-color);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .product-details {
        font-size: 0.9rem;
    }

    .description-container {
        position: relative;
        max-height: 3em;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .description {
        font-size: 0.85rem;
        color: #d1d1d1;
        margin-bottom: 0;
        line-height: 1.4;
    }

    .description-fade {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2em;
        background: linear-gradient(transparent, var(--card-bg));
        pointer-events: none;
    }

    .view-more, .show-less {
        position: absolute;
        bottom: 0;
        right: 0;
        font-size: 0.75rem;
        color: var(--secondary-color);
        background-color: var(--card-bg);
        padding: 0 5px;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .view-more:hover, .show-less:hover {
        opacity: 1;
    }

    .show-less {
        display: none;
    }

    .description-container.expanded {
        max-height: 1000px; /* Large enough to show full content */
    }

    .description-container.expanded .description-fade {
        display: none;
    }

    .description-container.expanded .view-more {
        display: none;
    }

    .description-container.expanded .show-less {
        display: block;
    }

    .form-control, .form-select {
        background-color: var(--dark-bg);
        border: 1px solid var(--secondary-color);
        color: var(--text-color);
    }

    .form-control:focus, .form-select:focus {
        background-color: var(--dark-bg);
        border-color: var(--secondary-color);
        color: var(--text-color);
        box-shadow: 0 0 0 0.25rem rgba(198, 164, 126, 0.25);
    }

    .btn-success {
        background: linear-gradient(45deg, var(--secondary-color), #b89b76);
        border: none;
    }

    .btn-outline-light {
        border-color: var(--secondary-color);
        color: var(--secondary-color);
    }

    .btn-outline-light:hover {
        background-color: var(--secondary-color);
        color: var(--dark-bg);
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.5em 1em;
    }

    .input-group .form-control {
        border-right: none;
    }

    .input-group .btn {
        border-left: none;
    }
</style>

<script>
function toggleDescription(element) {
    const container = element.closest('.description-container');
    container.classList.toggle('expanded');
}
</script>
@endsection
</body>
</html>
