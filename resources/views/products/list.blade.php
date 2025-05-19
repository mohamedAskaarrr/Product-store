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
    <style>
        body {
            padding-top: 90px !important;
        }
        .products-page-wrapper {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 16px 8px 16px;
        }
        .products-page-wrapper > .section-spacer:first-child,
        .products-page-wrapper > .section-spacer:first-child .row,
        .products-page-wrapper > .section-spacer:first-child h1,
        .products-page-wrapper h1 {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        .products-page-wrapper > .section-spacer:first-child {
            margin-bottom: 1.2rem !important;
        }
        .products-heading-section {
            margin-top: 0;
            margin-bottom: 1.5rem;
            align-items: flex-end;
        }
        .products-icon {
            font-size: 2.8rem;
            color: #D4AF37;
            background: linear-gradient(135deg, #D4AF37 60%, #fffbe6 100%);
            border-radius: 16px;
            padding: 8px 16px 8px 12px;
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.10);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .products-heading {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(90deg, #fffbe6 30%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            letter-spacing: 1px;
            margin-bottom: 0.2rem;
        }
        .products-subtitle {
            color: #b89b76;
            font-size: 1.1rem;
            font-weight: 500;
            margin-left: 2px;
            letter-spacing: 0.5px;
        }
        @media (max-width: 600px) {
            .products-heading-section { flex-direction: column; align-items: flex-start; }
            .products-icon { font-size: 2rem; padding: 6px 10px; }
            .products-heading { font-size: 1.5rem; }
            .products-subtitle { font-size: 0.95rem; }
        }
        .credit-pill-nav {
            background: linear-gradient(90deg, #2c1e1e 60%, #D4AF37 100%);
            border: 2px solid #D4AF37;
            border-radius: 32px;
            padding: 7px 26px 7px 14px;
            color: #fffbe6;
            font-weight: 600;
            font-size: 1.13rem;
            box-shadow: 0 2px 12px rgba(212, 175, 55, 0.10);
            transition: box-shadow 0.2s, transform 0.2s, background 0.2s;
            margin-right: 18px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        .credit-pill-nav:hover, .credit-pill-nav:focus {
            background: linear-gradient(90deg, #D4AF37 80%, #fffbe6 100%);
            color: #2c1e1e;
            box-shadow: 0 4px 24px rgba(212, 175, 55, 0.18);
            transform: scale(1.04);
            text-decoration: none;
        }
        .credit-pill-icon {
            background: #fffbe6;
            color: #D4AF37;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 1.25rem;
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.10);
        }
        .credit-pill-label {
            color: #b89b76;
            font-size: 1.02rem;
            margin-right: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        .credit-pill-amount {
            color: #fffbe6;
            font-size: 1.13rem;
            font-weight: 700;
            background: linear-gradient(90deg, #D4AF37 60%, #fffbe6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        @media (max-width: 600px) {
            .credit-pill-nav { padding: 6px 12px 6px 8px; font-size: 0.98rem; }
            .credit-pill-icon { width: 26px; height: 26px; font-size: 1rem; margin-right: 6px; }
            .credit-pill-label { display: none; }
        }
    </style>
</head>

<body>
@extends('layouts.master')
@section('title', 'Products')
@section('content')
<div class="products-page-wrapper">
    <div class="section-spacer">
        <div class="row align-items-center">
            <div class="col-md-10">
                <div class="products-heading-section d-flex align-items-center mb-4">
                    <span class="products-icon me-3"><i class="fas fa-shopping-bag"></i></span>
                    <div>
                        <h1 class="products-heading mb-1">Products</h1>
                        <div class="products-subtitle">Browse our exclusive collection</div>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Modern Compact Search and Filter Section -->
        <div class="modern-search-bar d-flex flex-wrap align-items-center justify-content-center mb-5">
            <form class="d-flex flex-wrap gap-2 align-items-center w-100 justify-content-center">
                <div class="input-group search-pill">
                    <span class="input-group-text search-icon"><i class="fas fa-search"></i></span>
                    <input name="keywords" type="text" class="form-control search-pill-input" placeholder="Search Keywords" value="{{ request()->keywords }}">
                </div>
                <div class="input-group search-pill">
                    <span class="input-group-text price-icon"><i class="fas fa-dollar-sign"></i></span>
                    <input name="min_price" type="number" class="form-control search-pill-input" placeholder="Min Price" value="{{ request()->min_price }}">
                </div>
                <div class="input-group search-pill">
                    <span class="input-group-text price-icon"><i class="fas fa-dollar-sign"></i></span>
                    <input name="max_price" type="number" class="form-control search-pill-input" placeholder="Max Price" value="{{ request()->max_price }}">
                </div>
                <div class="input-group search-pill">
                    <span class="input-group-text sort-icon"><i class="fas fa-sort"></i></span>
                    <select name="order_by" class="form-select search-pill-input">
                        <option value="">Sort By</option>
                        <option value="price">Price</option>
                        <option value="name">Name</option>
                    </select>
                </div>
                <a href="{{ route('products_list') }}" class="btn search-reset-btn ms-2">
                    <i class="fas fa-undo"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="section-spacer">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 modern-product-grid">
            @foreach($products as $product)
            <div class="col">
                <div class="modern-product-card h-100 d-flex flex-column">
                    <div class="modern-product-img-wrap position-relative">
                        <img src="{{ asset('images/' . $product->photo) }}" class="modern-product-img" alt="{{ $product->name }}">
                        @if($product->stock <= 0)
                        <span class="badge modern-badge-out position-absolute top-0 end-0 m-2">Out of Stock</span>
                        @endif
                        @role('Customer')
                            @if ($product->favorite)
                                <span class="badge modern-badge-fav position-absolute top-0 start-0 m-2"><i class="fas fa-heart"></i> Favorited</span>
                            @endif
                        @endrole
                    </div>
                    <div class="modern-product-body flex-grow-1 d-flex flex-column justify-content-between p-3">
                        <div>
                            <h5 class="modern-product-title mb-2">{{ $product->name }}</h5>
                            <div class="modern-product-details mb-2">
                                <span class="modern-label">Model:</span> <span class="modern-value">{{ $product->model }}</span><br>
                                <span class="modern-label">Code:</span> <span class="modern-value">{{ $product->code }}</span>
                            </div>
                            <div class="modern-product-price mb-2">
                                <span class="modern-label">Price:</span> <span class="modern-price">${{ $product->price }}</span>
                            </div>
                            <div class="modern-product-stock mb-2">
                                <span class="modern-label">Stock:</span> <span class="modern-value">{{ $product->stock }}</span>
                            </div>
                            <div class="modern-description-container">
                                <span class="modern-description-short">{{ Str::limit($product->description, 60) }}</span>
                                @if(strlen($product->description) > 60)
                                    <span class="modern-view-more" onclick="toggleModernDescription(this)">View More</span>
                                    <span class="modern-description-full d-none">{{ $product->description }}</span>
                                    <span class="modern-view-less d-none" onclick="toggleModernDescription(this)">Show Less</span>
                                @endif
                            </div>
                        </div>
                        <div class="modern-actions mt-3 d-flex flex-wrap gap-2">
                            @if($product->stock > 0)
                                <form action="{{ route('products.addTobasket', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn modern-btn-buy">
                                        <i class="fas fa-shopping-cart"></i> Buy
                                    </button>
                                </form>
                            @else
                                <button class="btn modern-btn-disabled" disabled>Out of Stock</button>
                            @endif
                            @role('Customer')
                                @if (!$product->favorite)
                                    <form action="{{ route('products.markAsFavorite', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn modern-btn-fav">
                                            <i class="fas fa-heart"></i> Favorite
                                        </button>
                                    </form>
                                @endif
                            @endrole
                            @can('edit_products')
                                <a href="{{ route('products_edit', $product->id) }}" class="btn modern-btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete_products')
                                <form action="{{ route('products_delete', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn modern-btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endcan
                            @role('Employee')
                                <form action="{{ route('products.addstock', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <div class="input-group input-group-sm modern-addstock-group">
                                        <input type="number" class="form-control" name="stock" placeholder="Add stock">
                                        <button type="submit" class="btn modern-btn-addstock">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
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

    .modern-product-grid {
        margin-top: 0.5rem;
    }
    .modern-product-card {
        background: linear-gradient(120deg, #2c1e1e 90%, #D4AF37 100%);
        border: 2px solid #D4AF37;
        border-radius: 18px;
        box-shadow: 0 6px 24px rgba(212, 175, 55, 0.10), 0 1.5px 4px rgba(0,0,0,0.10);
        transition: transform 0.25s, box-shadow 0.25s;
        overflow: hidden;
        min-height: 480px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .modern-product-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 12px 36px rgba(212, 175, 55, 0.18), 0 4px 16px rgba(0,0,0,0.18);
    }
    .modern-product-img-wrap {
        background: linear-gradient(135deg, #3a2828 80%, #D4AF37 100%);
        border-bottom: 1.5px solid #D4AF37;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 240px;
        padding: 18px 0 10px 0;
        position: relative;
    }
    .modern-product-img {
        max-width: 80%;
        max-height: 180px;
        object-fit: contain;
        border-radius: 12px;
        background: #fffbe6;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.08);
    }
    .modern-product-title {
        color: #D4AF37;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }
    .modern-product-details, .modern-product-stock {
        color: #f5f5f5;
        font-size: 0.98rem;
        margin-bottom: 0.2rem;
    }
    .modern-label {
        color: #b89b76;
        font-weight: 500;
    }
    .modern-value {
        color: #fffbe6;
        font-weight: 400;
    }
    .modern-product-price {
        color: #D4AF37;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }
    .modern-price {
        background: linear-gradient(90deg, #D4AF37 60%, #fffbe6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
        font-size: 1.2rem;
        font-weight: 700;
    }
    .modern-badge-out {
        background: #a94442;
        color: #fffbe6;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 8px;
        padding: 6px 14px;
        box-shadow: 0 2px 8px rgba(169, 68, 66, 0.12);
    }
    .modern-badge-fav {
        background: #D4AF37;
        color: #2c1e1e;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 8px;
        padding: 6px 14px;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.12);
    }
    .modern-description-container {
        margin-top: 0.5rem;
        color: #fffbe6;
        font-size: 0.97rem;
        position: relative;
    }
    .modern-description-short {
        display: inline;
    }
    .modern-view-more, .modern-view-less {
        color: #D4AF37;
        cursor: pointer;
        font-size: 0.97rem;
        margin-left: 8px;
        font-weight: 500;
    }
    .modern-description-full {
        display: block;
        margin-top: 0.3rem;
    }
    .modern-actions .btn {
        border-radius: 22px;
        font-size: 1rem;
        font-weight: 500;
        padding: 8px 18px;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.08);
    }
    .modern-btn-buy {
        background: linear-gradient(90deg, #D4AF37 70%, #fffbe6 100%);
        color: #2c1e1e;
        border: none;
    }
    .modern-btn-buy:hover {
        background: linear-gradient(90deg, #fffbe6 70%, #D4AF37 100%);
        color: #2c1e1e;
    }
    .modern-btn-fav {
        background: #fffbe6;
        color: #D4AF37;
        border: 1.5px solid #D4AF37;
    }
    .modern-btn-fav:hover {
        background: #D4AF37;
        color: #2c1e1e;
    }
    .modern-btn-edit {
        background: #3a2828;
        color: #D4AF37;
        border: 1.5px solid #D4AF37;
    }
    .modern-btn-edit:hover {
        background: #D4AF37;
        color: #2c1e1e;
    }
    .modern-btn-delete {
        background: #a94442;
        color: #fffbe6;
        border: none;
    }
    .modern-btn-delete:hover {
        background: #fffbe6;
        color: #a94442;
        border: 1.5px solid #a94442;
    }
    .modern-btn-disabled {
        background: #3a2828;
        color: #b89b76;
        border: 1.5px solid #b89b76;
        cursor: not-allowed;
    }
    .modern-btn-addstock {
        background: #D4AF37;
        color: #2c1e1e;
        border: none;
        border-radius: 0 22px 22px 0;
    }
    .modern-btn-addstock:hover {
        background: #b89b76;
        color: #2c1e1e;
    }
    .modern-addstock-group .form-control {
        border-radius: 22px 0 0 22px;
        border: 1.5px solid #D4AF37;
        background: #fffbe6;
        color: #2c1e1e;
        max-width: 90px;
    }
    @media (max-width: 767px) {
        .modern-product-img-wrap { min-height: 160px; }
        .modern-product-card { min-height: 380px; }
        .modern-product-title { font-size: 1.1rem; }
        .modern-product-details, .modern-product-stock, .modern-product-price { font-size: 0.93rem; }
    }

    .modern-search-bar {
        background: none;
        border: none;
        box-shadow: none;
        padding: 0;
        margin-bottom: 2.5rem;
    }
    .search-pill {
        border-radius: 50px;
        background: #2c1e1e;
        border: 2px solid #D4AF37;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.08);
        margin: 0 6px 8px 6px;
        min-width: 180px;
        max-width: 220px;
        flex: 1 1 180px;
    }
    .search-pill-input, .search-pill .form-select {
        border: none;
        background: transparent;
        color: #fffbe6;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 500;
        box-shadow: none;
        padding-left: 0.5rem;
        height: 44px;
        min-width: 120px;
        display: flex;
        align-items: center;
    }
    .search-pill-input:focus, .search-pill .form-select:focus {
        outline: none;
        box-shadow: none;
        background: transparent;
        color: #fffbe6;
    }
    .input-group-text {
        height: 44px;
        display: flex;
        align-items: center;
        border-radius: 50px 0 0 50px;
        background: none;
        border: none;
        color: #D4AF37;
        font-size: 1.1rem;
        padding-left: 16px;
        padding-right: 8px;
    }
    .search-reset-btn {
        border-radius: 50px;
        border: 2px solid #D4AF37;
        background: #2c1e1e;
        color: #D4AF37;
        font-weight: 600;
        padding: 8px 24px;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
        margin-left: 8px;
        margin-top: 2px;
    }
    .search-reset-btn:hover {
        background: #D4AF37;
        color: #2c1e1e;
        border-color: #D4AF37;
    }
    .search-pill .form-select {
        padding-right: 2rem;
        height: 44px;
        min-width: 120px;
        display: flex;
        align-items: center;
    }
    .input-group.search-pill {
        min-width: 180px;
        max-width: 220px;
        flex: 1 1 180px;
        height: 44px;
        align-items: center;
    }
    @media (max-width: 900px) {
        .modern-search-bar form { flex-direction: column !important; align-items: stretch !important; }
        .search-reset-btn { width: 100%; margin-left: 0; }
    }
</style>

<script>
function toggleModernDescription(element) {
    const container = element.closest('.modern-description-container');
    const shortDesc = container.querySelector('.modern-description-short');
    const fullDesc = container.querySelector('.modern-description-full');
    const viewMore = container.querySelector('.modern-view-more');
    const viewLess = container.querySelector('.modern-view-less');
    if (fullDesc.classList.contains('d-none')) {
        fullDesc.classList.remove('d-none');
        viewLess.classList.remove('d-none');
        shortDesc.style.display = 'none';
        viewMore.style.display = 'none';
    } else {
        fullDesc.classList.add('d-none');
        viewLess.classList.add('d-none');
        shortDesc.style.display = 'inline';
        viewMore.style.display = 'inline';
    }
}
</script>

@php
    use App\Models\User;
    use App\Models\Product;
    $isAdmin = auth()->user() && auth()->user()->hasRole('Admin');
    $totalUsers = User::count();
    $totalProducts = Product::count();
@endphp

@if($isAdmin)

<div class="admin-dashboard-card d-flex flex-wrap align-items-center justify-content-between mb-4 p-3">
    <div class="dashboard-stat">
        <div class="stat-label">Total Products</div>
        <div class="stat-value">{{ $totalProducts }}</div>
    </div>
    <div class="dashboard-actions">
        <a href="{{ route('users') }}" class="btn btn-outline-light me-2" title="Manage Users">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="{{ route('products_edit') }}" class="btn btn-success btn-lg px-4" title="Add Product">
            <i class="fas fa-plus-circle"></i> Add Product
        </a>
    </div>
</div>
@endif

<style>
.admin-panel-badge {
    text-align: left;
}
.admin-dashboard-card {
    background: linear-gradient(90deg, #3a2828 90%, #D4AF37 100%);
    border: 2px solid #D4AF37;
    border-radius: 18px;
    box-shadow: 0 4px 16px rgba(212, 175, 55, 0.08);
    margin-bottom: 2rem;
    color: #fffbe6;
    gap: 2rem;
}
.dashboard-stat {
    min-width: 140px;
    text-align: center;
}
.stat-label {
    font-size: 1.1rem;
    color: #b89b76;
    font-weight: 500;
}
.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #D4AF37;
}
.dashboard-actions .btn {
    border-radius: 30px;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 6px;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
}
.dashboard-actions .btn-success {
    background: linear-gradient(90deg, #D4AF37 70%, #fffbe6 100%);
    color: #2c1e1e;
    border: none;
    box-shadow: 0 2px 8px rgba(212, 175, 55, 0.10);
}
.dashboard-actions .btn-success:hover {
    background: linear-gradient(90deg, #fffbe6 70%, #D4AF37 100%);
    color: #2c1e1e;
}
.dashboard-actions .btn-outline-light {
    border: 2px solid #D4AF37;
    color: #D4AF37;
    background: transparent;
}
.dashboard-actions .btn-outline-light:hover {
    background: #D4AF37;
    color: #2c1e1e;
}
/* Action button tooltips and hover */
.modern-actions .btn[title] {
    position: relative;
}
.modern-actions .btn[title]:hover::after {
    content: attr(title);
    position: absolute;
    left: 50%;
    bottom: 120%;
    transform: translateX(-50%);
    background: #D4AF37;
    color: #2c1e1e;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 0.95rem;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(212, 175, 55, 0.10);
    z-index: 10;
    opacity: 1;
    pointer-events: none;
}
</style>
@endsection
</body>
</html>
