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
        <form method="GET" class="mb-3 row g-2 align-items-end">
            <div class="col-auto">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-auto">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="">All</option>
                    <option value="completed" @if(request('status')=='completed') selected @endif>Completed</option>
                    <option value="pending" @if(request('status')=='pending') selected @endif>Pending</option>
                    <option value="cancelled" @if(request('status')=='cancelled') selected @endif>Cancelled</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-gold">Filter</button>
            </div>
        </form>

        <div class="purchase-history-table-wrapper">
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
                            <td class="border-gold">
                                <span class="badge bg-credit">${{ number_format($order->total_price, 2) }}</span>
                            </td>
                            <td class="border-gold">{{ ucfirst($order->status) }}</td>
                            <td class="border-gold">
                                <div class="btn-group">
                                    <a href="{{ route('order.details', $order->id) }}" class="btn btn-view btn-sm">
                                        <i class="fas fa-eye"></i> Details
                                    </a>
                                    @if($order->status === 'completed')
                                        <button type="button" class="btn btn-refund btn-sm" data-bs-toggle="modal" data-bs-target="#refundRequestModal{{ $order->id }}">
                                            <i class="fas fa-undo-alt"></i> Request Refund
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@foreach($orders as $order)
@if($order->status === 'completed')
<!-- Refund Request Modal for each order -->
<div class="modal fade" id="refundRequestModal{{ $order->id }}" tabindex="-1" aria-labelledby="refundRequestModalLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-gold">
            <form action="{{ route('order.requestRefund', $order->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="refundRequestModalLabel{{ $order->id }}">Request Refund for Order #{{ $order->order_number }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Refund</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gold">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

<style>
    body {
        background-color: #2c1e1e;
        color: #f5f5f5;
    }
    .purchase-history-table-wrapper {
        background: #2c1e1e;
        border: 1px solid #D4AF37;
        border-radius: 1rem;
        box-shadow: 0 0 24px 0 rgba(212,175,55,0.10);
        overflow: hidden;
        padding: 0;
    }
    .table-dark {
        background-color: #2c1e1e !important;
        color: #f5f5f5 !important;
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 0;
        border: none !important;
    }
    .table-dark thead {
        border-bottom: 1px solid #D4AF37;
    }
    .table-dark thead tr {
        border-bottom: 1px solid #D4AF37;
    }
    .table-dark thead th {
        background-color: #3a2a2a !important;
        color: #D4AF37 !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none !important;
        padding: 0.75rem;
    }
    .table-dark thead th:first-child {
        border-top-left-radius: calc(1rem - 1px);
    }
    .table-dark thead th:last-child {
        border-top-right-radius: calc(1rem - 1px);
    }
    .table-dark tbody tr {
        background-color: #2c1e1e !important;
        transition: all 0.3s ease;
    }
    .table-dark tbody tr:hover {
        background-color: #3a2a2a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.1);
    }
    .table-dark td {
        color: #f5f5f5 !important;
        vertical-align: middle;
        border: none !important;
        padding: 0.75rem;
    }
    .table-dark tbody tr:last-child td {
        border-bottom: none;
    }
    .table-dark tbody tr:last-child td:first-child {
        border-bottom-left-radius: calc(1rem - 1px);
    }
    .table-dark tbody tr:last-child td:last-child {
        border-bottom-right-radius: calc(1rem - 1px);
    }
    .table-responsive > .table-dark {
        overflow: hidden;
        border: none !important;
    }
    .table-dark th, .table-dark td {
        border-color: transparent !important;
    }
    .border-gold {
        border-color: #D4AF37 !important;
    }
    .form-control {
        background-color: #2c1e1e !important;
        border-color: #D4AF37 !important;
        color: #f5f5f5 !important;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        background-color: #3a2a2a !important;
        border-color: #D4AF37 !important;
        color: #f5f5f5 !important;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25) !important;
    }
    .btn-view {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
    }
    .btn-refund {
        background-color: #E5C158 !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
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
    .badge.bg-credit {
        background-color: #D4AF37;
        color: #2c1e1e;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 20px;
    }
    .modal-content {
        background-color: #2c1e1e !important;
        border: 1px solid #D4AF37;
    }
    .modal-header {
        border-bottom-color: #D4AF37;
    }
    .modal-footer {
        border-top-color: #D4AF37;
    }
    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    @media (max-width: 768px) {
        .purchase-history-table-wrapper {
            padding: 1rem;
        }
        .container {
            padding: 1rem;
        }
    }
    @media (max-width: 576px) {
        .purchase-history-table-wrapper {
            padding: 0.8rem;
        }
        .container {
            padding: 0.8rem;
        }
        .btn-group > .btn {
             padding: 0.3rem 0.6rem;
             font-size: 0.875rem;
        }
    }
</style>

@push('scripts')
<script>
    // Add any additional JavaScript if needed
</script>
@endpush
@endsection 