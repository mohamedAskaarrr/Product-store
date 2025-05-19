@extends('layouts.master')

@section('title', 'Purchase History')

@section('content')
<div class="container py-4">
    <h2 class="text-gold mb-4"><i class="fas fa-history"></i> Purchase History</h2>
    <a href="{{ route('profile', $user->id) }}" class="btn btn-gold mb-3">
        <i class="fas fa-arrow-left"></i> Back to Profile
    </a>
    @if($purchases->isEmpty())
        <div class="alert alert-warning">No purchases found.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-success">
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->product_name }}</td>
                    <td>
                        @if($purchase->product_photo)
                            <img src="{{ asset('images/' . $purchase->product_photo) }}" class="img-thumbnail" width="80" alt="{{ $purchase->product_name }}">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    <td>{{ $purchase->quantity }}</td>
                    <td>${{ number_format($purchase->total_price, 2) }}</td>
                    <td>{{ $purchase->created_at ? \Carbon\Carbon::parse($purchase->created_at)->format('Y-m-d H:i') : '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
<style>
    .card {
        background-color: #2c1e1e;
        border: 1px solid #D4AF37;
        color: #f5f5f5;
    }
    .card-title {
        color: #D4AF37;
        font-weight: 600;
    }
    .table {
        background-color: #2c1e1e;
        color: #f5f5f5;
        border-color: #D4AF37;
    }
    .table th, .table td {
        border-color: #D4AF37;
        vertical-align: middle;
    }
    .img-thumbnail {
        border-radius: 8px;
        margin-right: 8px;
    }
    .btn-gold {
        background-color: #D4AF37;
        color: #2c1e1e;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-gold:hover {
        background-color: #B38F28;
        color: #2c1e1e;
        transform: scale(1.05);
    }
</style>
@endsection 