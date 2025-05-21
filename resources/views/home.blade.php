<body style="background-color: #2c1e1e; color: #f5f5f5;">

@extends('layouts.scentora')

@section('title', 'Scentora - Luxury Perfumes')

@section('main-content')

    <!-- Hero Section -->
    <section class="hero-section py-5 text-center d-flex align-items-center justify-content-center" style="min-height: 60vh;">
        <div class="container" data-aos="fade-up">
            <h1 class="display-3 fw-bold mb-3 text-gold">Discover the Essence of Elegance</h1>
            <p class="lead mb-4 text-light">Signature scents curated just for you</p>
            <a href="{{ route('products_list') }}" class="btn btn-gold btn-lg px-4 py-2 mt-2" data-aos="zoom-in" data-aos-delay="200">
                <i class="fas fa-shopping-bag me-2"></i>Shop Now
            </a>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products-list" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 text-gold" data-aos="fade-up">Our Signature Scents</h2>
            <div class="row justify-content-center g-4">
                @if(isset($products) && count($products) > 0)
                    @foreach($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ 100 + $loop->index * 100 }}">
                            <div class="card product-card h-100 shadow-sm">
                                <div class="product-img-wrapper">
                                    <img src="{{ asset('images/' . $product->photo) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-gold mb-2">{{ $product->name }}</h5>
                                    <p class="card-text text-light mb-2" style="font-size: 0.95rem;">{{ Str::limit($product->description, 80) }}</p>
                                    <div class="mt-auto">
                                        <span class="h5 text-gold">${{ number_format($product->price, 2) }}</span>
                                        <a href="{{ route('products_list') }}" class="btn btn-gold w-100 mt-3">
                                            <i class="fas fa-shopping-cart me-2"></i>Order Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info text-center" data-aos="fade-up">
                        No featured products available at the moment.
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer Text -->
    <!-- <section class="footer-text py-5 bg-light">
        <div class="container text-center">
            <p class="lead fst-italic" data-aos="fade-up">Crafted with passion. Inspired by nature. Worn with pride.</p>
        </div>
    </section> -->

    <style>
        body {
            background-color: #2c1e1e;
            color: #f5f5f5;
        }
        .hero-section {
            background: linear-gradient(rgba(44,30,30,0.95), rgba(44,30,30,0.95)), url('https://images.unsplash.com/photo-1587017539504-67cfbddac569?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover no-repeat;
            min-height: 60vh;
            border-radius: 18px;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }
        .text-gold {
            color: #D4AF37 !important;
            font-weight: 700;
        }
        .btn-gold {
            background-color: #D4AF37 !important;
            color: #2c1e1e !important;
            border: none !important;
            font-weight: 600;
            border-radius: 24px;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(212,175,55,0.08);
        }
        .btn-gold:hover {
            background-color: #B38F28 !important;
            color: #fff !important;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(212,175,55,0.18);
        }
        .product-card {
            background-color: #3a2a2a;
            border: 1.5px solid #D4AF37;
            border-radius: 16px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            min-height: 420px;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 32px rgba(212,175,55,0.12);
        }
        .product-img-wrapper {
            background: #2c1e1e;
            padding: 12px;
            border-bottom: 1px solid #D4AF37;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 220px;
        }
        .product-img {
            max-height: 180px;
            width: auto;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        .product-card:hover .product-img {
            transform: scale(1.07);
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .card-text {
            color: #f5f5f5;
        }
        @media (max-width: 768px) {
            .hero-section {
                min-height: 40vh;
                padding: 2rem 0;
            }
            .product-img-wrapper {
                min-height: 140px;
            }
            .product-img {
                max-height: 100px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 900,
                easing: 'ease-in-out',
                once: true
            });
        });
    </script>
@endsection 
</body>