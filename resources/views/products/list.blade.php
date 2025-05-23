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
        .search-section .container {
            padding: 0 !important;
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

        <!-- Modern Search and Filter Section -->
        <div class="search-section">
            
                <div class="search-card">
                    <form action="{{ route('products_list') }}" method="GET" class="search-form">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="search-input-group">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" 
                                           name="keyword" 
                                           class="form-control search-input" 
                                           placeholder="Search products..."
                                           value="{{ request('keyword') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="search-input-group">
                                    <i class="fas fa-tag price-icon"></i>
                                    <input type="number" 
                                           name="min_price" 
                                           class="form-control search-input" 
                                           placeholder="Min Price"
                                           value="{{ request('min_price') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="search-input-group">
                                    <i class="fas fa-tag price-icon"></i>
                                    <input type="number" 
                                           name="max_price" 
                                           class="form-control search-input" 
                                           placeholder="Max Price"
                                           value="{{ request('max_price') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="search-input-group">
                                    <i class="fas fa-sort sort-icon"></i>
                                    <select name="sort" class="form-select search-input">
                                        <option value="">Sort By</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-gold w-100">
                                    <i class="fas fa-filter me-2"></i>Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="section-spacer mt-0">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 modern-product-grid">
            @foreach($products as $product)
            <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="modern-product-card h-100 d-flex flex-column">
                    <div class="modern-product-img-wrap position-relative">
                        @if($product->photo)
                            <img src="{{ asset('images/' . $product->photo) }}" class="modern-product-img" alt="{{ $product->name }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-image fa-3x"></i>
                                <span>No Image</span>
                            </div>
                        @endif
                        @if($product->stock <= 0)
                            <span class="badge modern-badge-out position-absolute top-0 end-0 m-2">Out of Stock</span>
                        @endif
                        @role('Admin')
                            @if ($product->favorite)
                                <span class="badge modern-badge-fav position-absolute top-0 start-0 m-2">
                                    <i class="fas fa-heart"></i> Favorited
                                </span>
                            @endif
                        @endrole
                    </div>
                    <div class="modern-product-body flex-grow-1 d-flex flex-column justify-content-between p-4">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="modern-product-title mb-0">{{ $product->name }}</h5>
                                <span class="product-id">#{{ $product->id }}</span>
                            </div>
                            <div class="modern-product-details mb-3">
                                <div class="detail-item">
                                    <span class="modern-label">Model:</span>
                                    <span class="modern-value">{{ $product->model }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="modern-label">Code:</span>
                                    <span class="modern-value">{{ $product->code }}</span>
                                </div>
                            </div>
                            <div class="modern-product-price mb-3">
                                <span class="modern-label">Price:</span>
                                <span class="modern-price">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <div class="modern-product-stock mb-3">
                                <span class="modern-label">Stock:</span>
                                <span class="modern-value">{{ $product->stock }}</span>
                            </div>
                            <div class="modern-description-container">
                                <p class="modern-description-short">{{ Str::limit($product->description, 100) }}</p>
                                @if(strlen($product->description) > 100)
                                    <button class="modern-view-more" onclick="toggleModernDescription(this)">
                                        View More
                                    </button>
                                    <p class="modern-description-full d-none">{{ $product->description }}</p>
                                    <button class="modern-view-less d-none" onclick="toggleModernDescription(this)">
                                        Show Less
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="modern-actions mt-4 d-flex flex-wrap gap-2">
                            @if($product->stock > 0)
                                <form action="{{ route('products.addTobasket', $product->id) }}" method="POST" class="d-inline flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn modern-btn-buy w-100">
                                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                    </button>
                                </form>


                          <!-- Add Stock for Supplier -->
                                @role('Supplier')
                        <form action="{{ route('products.addstock', $product->id) }}" method="POST">
                            @csrf

                            
                           <label for="stock-{{ $product->id }}" class="form-label">Quantity to Add:</label>
                           <input type="number" class="form-control" id="stock-{{ $product->id }}" name="stock"  required>
                           <button type="submit" class="btn modern-btn-buy w-100">Add Stock</button>
                           </form>
                           
                            @endrole



                            @else

                                <button class="btn modern-btn-disabled w-100" disabled>Out of Stock</button>
                            @endif
                            @role('Admin')
                                @if (!$product->favorite)
                                    <form action="{{ route('products.markAsFavorite', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn modern-btn-fav">
                                            <i class="fas fa-heart"></i>
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
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .products-page-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .products-heading-section {
        margin-bottom: 2rem;
    }

    .products-icon {
        font-size: 2.5rem;
        color: #D4AF37;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.2) 100%);
        border-radius: 16px;
        padding: 1rem;
        box-shadow: 0 4px 20px rgba(212, 175, 55, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(212, 175, 55, 0.2);
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
    }

    .products-subtitle {
        color: #b89b76;
        font-size: 1.1rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .search-section {
        margin-top: 76px;
        padding: 0.5rem 0 0 0;
        background: linear-gradient(135deg, rgba(44, 30, 30, 0.95) 0%, rgba(44, 30, 30, 0.8) 100%);
        border-bottom: 2px solid rgba(212, 175, 55, 0.3);
        margin-bottom: 0 !important;
    }

    .search-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 0.75rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(212, 175, 55, 0.2);
        margin-bottom: 0 !important;
    }

    .search-input-group {
        position: relative;
    }

    .search-icon, .price-icon, .sort-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #D4AF37;
        font-size: 1.1rem;
    }

    .search-input {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: #fffbe6;
        padding-left: 2.5rem;
        height: 45px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #D4AF37;
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        color: #fffbe6;
    }

    .search-input::placeholder {
        color: rgba(255, 251, 230, 0.6);
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23D4AF37' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-position: right 1rem center;
        background-size: 16px 12px;
        padding-right: 2.5rem;
    }

    .btn-gold {
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .modern-product-card {
        background: rgba(44, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .modern-product-card:hover {
        transform: translateY(-5px);
        border-color: rgba(212, 175, 55, 0.4);
        box-shadow: 0 8px 24px rgba(212, 175, 55, 0.15);
    }

    .modern-product-img-wrap {
        background: rgba(44, 30, 30, 0.9);
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 280px;
        position: relative;
    }

    .modern-product-img {
        max-width: 80%;
        max-height: 200px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .modern-product-card:hover .modern-product-img {
        transform: scale(1.05);
    }

    .no-image {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #D4AF37;
        font-size: 0.9rem;
    }

    .no-image i {
        margin-bottom: 0.5rem;
        opacity: 0.7;
    }

    .modern-product-title {
        color: #D4AF37;
        font-size: 1.25rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .product-id {
        color: #b89b76;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .detail-item {
        margin-bottom: 0.5rem;
    }

    .modern-label {
        color: #b89b76;
        font-weight: 500;
        margin-right: 0.5rem;
    }

    .modern-value {
        color: #fffbe6;
    }

    .modern-price {
        font-size: 1.4rem;
        font-weight: 700;
        background: linear-gradient(90deg, #D4AF37 0%, #fffbe6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-fill-color: transparent;
    }

    .modern-description-container {
        color: #fffbe6;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .modern-view-more, .modern-view-less {
        color: #D4AF37;
        background: none;
        border: none;
        padding: 0;
        font-size: 0.9rem;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .modern-view-more:hover, .modern-view-less:hover {
        color: #fffbe6;
    }

    .modern-badge-out {
        background: rgba(169, 68, 66, 0.9);
        color: #fffbe6;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .modern-badge-fav {
        background: rgba(212, 175, 55, 0.9);
        color: #2c1e1e;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .modern-actions .btn {
        padding: 0.8rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .modern-btn-buy {
        background: linear-gradient(135deg, #D4AF37 0%, #B38F28 100%);
        color: #2c1e1e;
        border: none;
    }

    .modern-btn-buy:hover {
        background: linear-gradient(135deg, #B38F28 0%, #D4AF37 100%);
        transform: translateY(-2px);
    }

    .modern-btn-fav, .modern-btn-edit, .modern-btn-delete {
        width: 45px;
        height: 45px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .modern-btn-fav {
        background: rgba(212, 175, 55, 0.1);
        color: #D4AF37;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }

    .modern-btn-fav:hover {
        background: rgba(212, 175, 55, 0.2);
        color: #D4AF37;
        border-color: rgba(212, 175, 55, 0.5);
    }

    .modern-btn-edit {
        background: rgba(212, 175, 55, 0.1);
        color: #D4AF37;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }

    .modern-btn-edit:hover {
        background: rgba(212, 175, 55, 0.2);
        color: #D4AF37;
        border-color: rgba(212, 175, 55, 0.5);
    }

    .modern-btn-delete {
        background: rgba(169, 68, 66, 0.1);
        color: #a94442;
        border: 1px solid rgba(169, 68, 66, 0.3);
    }

    .modern-btn-delete:hover {
        background: rgba(169, 68, 66, 0.2);
        color: #a94442;
        border-color: rgba(169, 68, 66, 0.5);
    }

    .modern-btn-disabled {
        background: rgba(44, 30, 30, 0.5);
        color: #b89b76;
        border: 1px solid rgba(184, 155, 118, 0.3);
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .search-section {
            padding: 1rem 0;
        }
        
        .search-card {
            padding: 1rem;
        }
        
        .search-input, .btn-gold {
            margin-bottom: 0.5rem;
        }

        .products-heading {
            font-size: 2rem;
        }

        .products-subtitle {
            font-size: 1rem;
        }

        .modern-product-img-wrap {
            min-height: 200px;
            padding: 1.5rem;
        }

        .modern-product-title {
            font-size: 1.1rem;
        }

        .modern-price {
            font-size: 1.2rem;
        }

        .modern-actions .btn {
            padding: 0.7rem 1.2rem;
        }
    }
</style>

<script>
function toggleModernDescription(button) {
    const container = button.closest('.modern-description-container');
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
        shortDesc.style.display = 'block';
        viewMore.style.display = 'inline';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    function updatePermissionsForRole() {
        var roleSelect = document.getElementById('role');
        var selectedOption = roleSelect.options[roleSelect.selectedIndex];
        var rolePermissions = selectedOption.getAttribute('data-permissions').split(',');

        document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
            if (rolePermissions.includes(checkbox.getAttribute('data-permission'))) {
                checkbox.checked = true;
                checkbox.disabled = true;
            } else {
                // Only enable if not checked by role
                checkbox.disabled = false;
                // If it was previously checked only because of the role, uncheck it
                if (!checkbox.hasAttribute('data-user-checked')) {
                    checkbox.checked = false;
                }
            }
        });
    }

    // Track user-checked permissions
    document.querySelectorAll('.permission-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (!checkbox.disabled) {
                if (checkbox.checked) {
                    checkbox.setAttribute('data-user-checked', '1');
                } else {
                    checkbox.removeAttribute('data-user-checked');
                }
            }
        });
    });

    document.getElementById('role').addEventListener('change', updatePermissionsForRole);

    // Initial update on page load
    updatePermissionsForRole();
});
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
