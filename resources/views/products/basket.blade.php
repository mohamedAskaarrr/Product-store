@extends('layouts.master')

@section('title', 'Your Basket')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success shadow-sm text-center border-gold">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning shadow-sm text-center border-gold">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('warning') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm text-center border-gold">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    @if(count($basketItems) > 0)
        <div class="card shadow-sm border-gold">
            <div class="card-header bg-dark text-gold">
                <h4 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Your Shopping Basket</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="border-gold">Image</th>
                                <th class="border-gold">Name</th>
                                <th class="border-gold">Price</th>
                                <th class="border-gold">Quantity</th>
                                <th class="border-gold">Total</th>
                                <th class="border-gold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($basketItems as $item)
                                @php
                                    $total = $item->price * $item->quantity;
                                    $grandTotal += $total;
                                @endphp
                                <tr>
                                    <td class="border-gold">
                                        @if($item->photo)
                                            <img src="{{ asset('images/' . $item->photo) }}" 
                                                 class="img-thumbnail product-img" 
                                                 alt="{{ $item->name }}">
                                        @else
                                            <div class="no-image">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="border-gold text-gold">{{ $item->name }}</td>
                                    <td class="border-gold">${{ number_format($item->price, 2) }}</td>
                                    <td class="border-gold">
                                        <span class="badge bg-gold text-dark">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="border-gold text-gold">${{ number_format($total, 2) }}</td>
                                    <td class="border-gold">
                                        <form action="{{ route('products.removeFromBasket', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete btn-sm">
                                                <i class="fas fa-trash-alt"></i> Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end border-gold">
                                    <h5 class="text-gold mb-0">Grand Total:</h5>
                                </td>
                                <td colspan="2" class="border-gold">
                                    <h5 class="text-gold mb-0">${{ number_format($grandTotal, 2) }}</h5>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('products_list') }}" class="btn btn-gold">
                <i class="fas fa-arrow-left me-2"></i> Continue Shopping
            </a>
            <form action="{{ route('products.checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-gold">
                    <i class="fas fa-credit-card me-2"></i> Proceed to Checkout
                </button>
            </form>
        </div>
    @else
        <div class="card empty-basket border-gold">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-gold mb-3"></i>
                <h4 class="text-gold mb-3">Your Basket is Empty</h4>
                <p class="text-light mb-4">Looks like you haven't added any items to your basket yet.</p>
                <a href="{{ route('products_list') }}" class="btn btn-gold">
                    <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    body {
        background-color: #2c1e1e;
        color: #f5f5f5;
    }

    .container {
        background-color: #2c1e1e;
    }

    .card {
        background-color: #2c1e1e;
        border: 1px solid #D4AF37;
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        background-color: #3a2a2a !important;
        border-bottom: 1px solid #D4AF37;
        padding: 1rem;
    }

    .table-dark {
        background-color: #2c1e1e !important;
        color: #f5f5f5 !important;
    }

    .table-dark thead th {
        background-color: #3a2a2a !important;
        color: #D4AF37 !important;
        border-color: #D4AF37 !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-dark tbody tr {
        background-color: #2c1e1e !important;
        border-color: #D4AF37 !important;
        transition: all 0.3s ease;
    }

    .table-dark tbody tr:hover {
        background-color: #3a2a2a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.1);
    }

    .border-gold {
        border-color: #D4AF37 !important;
    }

    .text-gold {
        color: #D4AF37 !important;
    }

    .text-light {
        color: #f5f5f5 !important;
    }

    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 2px solid #D4AF37;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .product-img:hover {
        transform: scale(1.1);
    }

    .no-image {
        width: 80px;
        height: 80px;
        background-color: #3a2a2a;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #D4AF37;
        border: 2px solid #D4AF37;
        border-radius: 8px;
    }

    .btn-gold {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-gold:hover {
        background-color: #B38F28 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
    }

    .btn-delete {
        background-color: #f9cf6e !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #f5d280 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
    }

    .badge.bg-gold {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
        font-weight: 500;
        padding: 6px 12px;
    }

    .empty-basket {
        max-width: 600px;
        margin: 0 auto;
    }

    .alert {
        background-color: #3a2a2a;
        border: 1px solid #D4AF37;
        color: #f5f5f5;
    }

    .alert-success {
        border-left: 4px solid #28a745;
    }

    .alert-warning {
        border-left: 4px solid #ffc107;
    }
</style>
@endsection

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Basket</title>

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-success {
            transition: 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .no-image {
            width: 80px;
            height: 80px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 0.75rem;
            border-radius: 0.25rem;
        }

        .img-thumbnail {
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }

        .alert {
            font-weight: 500;
        }
    </style>
@endsection
