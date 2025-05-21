@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="favorites-header text-center mb-5" data-aos="fade-down">
        <h2 class="display-4 text-gold mb-3">
            <i class="fas fa-heart me-2"></i>My Favorites
        </h2>
        <p class="text-light opacity-75">Your cherished collection of favorite products</p>
    </div>

    @if($products->isEmpty())
        <div class="empty-state text-center py-5" data-aos="fade-up">
            <div class="empty-state-icon mb-4">
                <i class="fas fa-heart-broken fa-4x text-gold"></i>
            </div>
            <h3 class="text-gold mb-3">No Favorites Yet</h3>
            <p class="text-light opacity-75 mb-4">Start adding products to your favorites to see them here</p>
            <a href="{{ route('products_list') }}" class="btn btn-gold">
                <i class="fas fa-shopping-bag me-2"></i>Browse Products
            </a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($products as $product)
                <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="product-card card h-100 border-0">
                        <div class="card-img-wrapper">
                            @if($product->photo)
                                <img src="{{ asset('images/' . $product->photo) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image fa-2x"></i>
                                    <span>No Image</span>
                                </div>
                            @endif
                            <div class="favorite-badge">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title text-gold mb-0">{{ $product->name }}</h5>
                                <span class="product-id">#{{ $product->id }}</span>
                            </div>
                            <p class="card-text text-light mb-4">{{ Str::limit($product->description, 100) }}</p>
                            <div class="card-footer bg-transparent border-0 p-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="text-gold mb-0">${{ number_format($product->price, 2) }}</h4>
                                    <div class="product-actions">
                                        <button class="btn btn-sm btn-outline-gold me-2" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-gold" title="Add to Cart">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .text-gold {
        color: var(--primary-color);
    }
    
    .btn-gold {
        background-color: var(--primary-color);
        color: var(--background-color);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-gold:hover {
        background-color: var(--secondary-color);
        color: var(--background-color);
        transform: translateY(-2px);
    }
    
    .btn-outline-gold {
        color: var(--primary-color);
        border-color: var(--primary-color);
        transition: all 0.3s ease;
    }
    
    .btn-outline-gold:hover {
        background-color: var(--primary-color);
        color: var(--background-color);
        transform: translateY(-2px);
    }
    
    .product-card {
        background-color: var(--card-bg);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    
    .card-img-wrapper {
        position: relative;
        overflow: hidden;
        padding-top: 75%; /* 4:3 Aspect Ratio */
        background: linear-gradient(135deg, #3a2828 80%, #D4AF37 100%);
    }
    
    .card-img-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 1rem;
        transition: transform 0.3s ease;
    }
    
    .no-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        background: rgba(0,0,0,0.1);
    }
    
    .no-image span {
        margin-top: 0.5rem;
        font-size: 0.9rem;
    }
    
    .product-card:hover .card-img-wrapper img {
        transform: scale(1.05);
    }
    
    .favorite-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(0,0,0,0.6);
        color: var(--primary-color);
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .product-card:hover .favorite-badge {
        background-color: var(--primary-color);
        color: var(--background-color);
    }
    
    .product-id {
        font-size: 0.8rem;
        color: var(--text-color);
        opacity: 0.7;
    }
    
    .product-actions {
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }
    
    .product-card:hover .product-actions {
        opacity: 1;
        transform: translateY(0);
    }
    
    .empty-state {
        background-color: var(--card-bg);
        border-radius: 15px;
        padding: 3rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .empty-state-icon {
        color: var(--primary-color);
        opacity: 0.8;
    }
    
    .favorites-header {
        position: relative;
    }
    
    .favorites-header::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: linear-gradient(to right, transparent, var(--primary-color), transparent);
    }
    
    @media (max-width: 768px) {
        .product-actions {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection
