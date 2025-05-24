@extends('layouts.master')
@section('title', 'Sale Details')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-gold">Sale Details</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Sale #{{ $sale->id }}</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dark text-gold"><strong>Date:</strong> {{ $sale->date }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Total Amount:</strong> ${{ number_format($sale->total_amount, 2) }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Total Products:</strong> {{ $sale->total_products }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Payment Method:</strong> {{ $sale->payment_method }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Status:</strong> {{ ucfirst($sale->status) }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Created At:</strong> {{ $sale->created_at }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Updated At:</strong> {{ $sale->updated_at }}</li>
            </ul>
        </div>
    </div>
    <h4 class="text-gold">Products in this Sale</h4>
    <div class="table-responsive">
    <table class="table table-dark table-striped table-bordered align-middle">
        <thead class="thead-gold">
            <tr>
                <th class="text-gold">Product Name</th>
                <th class="text-gold">Model</th>
                <th class="text-gold">Quantity</th>
                <th class="text-gold">Unit Price</th>
                <th class="text-gold">Total Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td class="text-white">{{ $product->name }}</td>
                <td class="text-white">{{ $product->model }}</td>
                <td class="text-white">{{ $product->quantity }}</td>
                <td class="text-gold">${{ number_format($product->price, 2) }}</td>
                <td class="text-gold">${{ number_format($product->total_price, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-gold">No products found for this sale date.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    <div class="d-flex gap-2 mt-3">
        <a href="{{ route('manage.financials') }}" class="btn btn-gold"><i class="fas fa-arrow-left me-2"></i>Back to Financials</a>
        @can('manage_sales')
        <a href="{{ route('manage.financials.sales.edit', ['id' => $sale->id, 'return' => url()->current()]) }}" class="btn btn-info"><i class="fas fa-edit me-2"></i>Edit</a>
        @endcan
    </div>
</div>
@endsection

@section('head')
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
</style>
@endsection 