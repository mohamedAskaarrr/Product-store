@extends('layouts.master')
@section('title', 'Order Details')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-gold">Order Details</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Order #{{ $order->order_number }}</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dark text-gold"><strong>Date:</strong> {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('M d, Y H:i') : '' }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Total:</strong> ${{ number_format($order->total_price, 2) }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
            </ul>
        </div>
    </div>
    <h4 class="text-gold">Products in this Order</h4>
    <div class="table-responsive">
        <table class="table table-dark table-striped table-bordered align-middle">
            <thead class="thead-gold">
                <tr>
                    <th class="text-gold">Product Name</th>
                    <th class="text-gold">Quantity</th>
                    <th class="text-gold">Unit Price</th>
                    <th class="text-gold">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="text-white">{{ $item->product->name ?? 'N/A' }}</td>
                    <td class="text-gold">{{ $item->quantity }}</td>
                    <td class="text-gold">${{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-gold">${{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex gap-2 mt-3">
        <a href="{{ route('purchase_history', $order->user_id) }}" class="btn btn-gold"><i class="fas fa-arrow-left me-2"></i>Back to Orders</a>
        @can('manage_refunds')
            @if($order->status === 'completed')
            <form action="{{ route('order.refund', $order->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-refund" onclick="return confirm('Are you sure you want to refund this order? This will return the money to the user and restock all products.')">
                    <i class="fas fa-undo-alt me-2"></i>Refund Order
                </button>
            </form>
            @endif
        @endcan
    </div>
</div>
<style>
    .thead-gold th {
        background-color: #2c1e1e !important;
        color: #D4AF37 !important;
        font-weight: bold;
        border-bottom: 2px solid #D4AF37 !important;
    }
    .table-dark td, .table-dark th {
        color: #fffbe6;
    }
    .text-gold { color: #D4AF37 !important; }
    .text-white { color: #fffbe6 !important; }
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
</style>
@endsection 