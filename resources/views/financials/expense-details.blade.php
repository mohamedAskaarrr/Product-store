@extends('layouts.master')
@section('title', 'Expense Details')
@section('head')
<style>
    .list-group-item.bg-dark {
        background-color: #2c1e1e !important;
        color: #fffbe6 !important;
        border-bottom: 1px solid #D4AF37 !important;
    }
    .text-gold { color: #D4AF37 !important; }
    .text-white { color: #fffbe6 !important; }
    .card-title { color: #D4AF37 !important; }
</style>
@endsection
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-gold">Expense Details</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Expense #{{ $expense->id }}</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-dark text-gold"><strong>Date:</strong> {{ $expense->date }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Category:</strong> {{ $expense->category }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Description:</strong> {{ $expense->description }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Amount:</strong> ${{ number_format($expense->amount, 2) }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Payment Method:</strong> {{ $expense->payment_method }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Status:</strong> {{ ucfirst($expense->status) }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Created At:</strong> {{ $expense->created_at }}</li>
                <li class="list-group-item bg-dark text-gold"><strong>Updated At:</strong> {{ $expense->updated_at }}</li>
            </ul>
        </div>
    </div>
    <div class="d-flex gap-2 mt-3">
        <a href="{{ route('manage.financials') }}" class="btn btn-gold"><i class="fas fa-arrow-left me-2"></i>Back to Financials</a>
        @can('manage_expenses')
        <a href="{{ route('manage.financials.expenses.edit', $expense->id) }}" class="btn btn-info"><i class="fas fa-edit me-2"></i>Edit</a>
        @endcan
    </div>
</div>
@endsection 