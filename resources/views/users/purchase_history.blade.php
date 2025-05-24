@extends('layouts.master')

@section('title', 'Purchase History')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-gold mb-0">
                <i class="fas fa-history me-2"></i>Purchase History
                <small class="text-light d-block mt-2" style="font-size: 1rem;">View your past purchases and orders</small>
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('profile', $user->id) }}" class="btn btn-gold">
                <i class="fas fa-arrow-left me-2"></i>Back to Profile
            </a>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="card empty-state-card">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-bag fa-3x text-gold mb-3"></i>
                <h4 class="text-gold mb-3">No Orders Yet</h4>
                <p class="text-light mb-4">You haven't made any orders yet. Start shopping to see your order history here.</p>
                <a href="{{ route('products_list') }}" class="btn btn-gold">
                    <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                </a>
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th class="border-gold">Order #</th>
                        <th class="border-gold">Date</th>
                        <th class="border-gold">Total</th>
                        <th class="border-gold">Status</th>
                        <th class="border-gold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="border-gold">{{ $order->order_number }}</td>
                        <td class="border-gold">{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('M d, Y H:i') : '' }}</td>
                        <td class="border-gold">${{ number_format($order->total_price, 2) }}</td>
                        <td class="border-gold">{{ ucfirst($order->status) }}</td>
                        <td class="border-gold">
                            <a href="{{ route('order.details', $order->id) }}" class="btn btn-info btn-sm">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
        border-radius: 12px;
        padding: 30px;
    }

    .purchase-card {
        background-color: #3a2a2a;
        border: 1px solid #D4AF37;
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .purchase-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(212, 175, 55, 0.1);
    }

    .purchase-img {
        max-height: 200px;
        width: auto;
        border: 2px solid #D4AF37;
        border-radius: 8px;
        padding: 8px;
        background-color: #2c1e1e;
    }

    .no-image {
        width: 100%;
        height: 200px;
        background-color: #2c1e1e;
        border: 2px solid #D4AF37;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #D4AF37;
        font-size: 0.9rem;
        gap: 8px;
    }

    .no-image i {
        font-size: 2rem;
    }

    .badge.bg-gold {
        background-color: #D4AF37;
        color: #2c1e1e;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .price-badge {
        background-color: #2c1e1e;
        color: #D4AF37;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        border: 1px solid #D4AF37;
    }

    .date-badge {
        color: #D4AF37;
        font-weight: 500;
        text-align: right;
    }

    .empty-state-card {
        max-width: 600px;
        margin: 0 auto;
        background-color: #3a2a2a;
        border: 1px solid #D4AF37;
        border-radius: 12px;
    }

    .text-gold {
        color: #D4AF37;
        font-weight: 600;
    }

    .text-light {
        color: #f5f5f5 !important;
    }

    .btn-gold {
        background-color: #D4AF37;
        color: #2c1e1e;
        border: none;
        transition: all 0.3s ease;
        padding: 8px 16px;
        font-weight: 500;
        border-radius: 20px;
    }

    .btn-gold:hover {
        background-color: #B38F28;
        color: #2c1e1e;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
    }

    .purchase-details {
        background-color: #2c1e1e;
        border-radius: 8px;
        padding: 12px;
        margin-top: 12px;
    }

    .btn-refund {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
        font-weight: 500;
        padding: 8px 16px;
        border-radius: 6px;
    }

    .btn-refund:hover {
        background-color: #B38F28 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
    }

    @media (max-width: 768px) {
        .purchase-img {
            max-height: 150px;
        }
        
        .no-image {
            height: 150px;
        }
        
        .card-body {
            padding: 1rem;
        }
    }
</style>

@push('scripts')
<script>
    // Add any additional JavaScript if needed
</script>
@endpush
@endsection 