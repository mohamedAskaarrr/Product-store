@extends('layouts.master')
@section('title', 'All ' . ucfirst($type))
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-gold">All {{ ucfirst($type) }}</h2>
    <form method="GET" class="mb-3 row g-2 align-items-end">
        <div class="col-auto">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ $filters['date'] ?? '' }}">
        </div>
        @if($type === 'sales' || $type === 'expenses')
        <div class="col-auto">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="">All</option>
                <option value="completed" @if(($filters['status'] ?? '')=='completed') selected @endif>Completed</option>
                <option value="pending" @if(($filters['status'] ?? '')=='pending') selected @endif>Pending</option>
                <option value="cancelled" @if(($filters['status'] ?? '')=='cancelled') selected @endif>Cancelled</option>
                <option value="paid" @if(($filters['status'] ?? '')=='paid') selected @endif>Paid</option>
            </select>
        </div>
        @endif
        @if($type === 'expenses')
        <div class="col-auto">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" id="category" class="form-control" value="{{ $filters['category'] ?? '' }}">
        </div>
        @endif
        <div class="col-auto">
            <button type="submit" class="btn btn-gold">Filter</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    @if($type === 'sales')
                        <th>Date</th><th>Total Amount</th><th>Total Products</th><th>Payment Method</th><th>Status</th>
                    @elseif($type === 'expenses')
                        <th>Date</th><th>Category</th><th>Description</th><th>Amount</th><th>Payment Method</th><th>Status</th>
                    @else
                        <th>Date</th><th>Total Sales</th><th>Total Expenses</th><th>Net Profit</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($records as $rec)
                    <tr>
                        @if($type === 'sales')
                            <td>{{ $rec->date }}</td>
                            <td>${{ number_format($rec->total_amount, 2) }}</td>
                            <td>{{ $rec->total_products }}</td>
                            <td>{{ $rec->payment_method }}</td>
                            <td>{{ $rec->status }}</td>
                        @elseif($type === 'expenses')
                            <td>{{ $rec->date }}</td>
                            <td>{{ $rec->category }}</td>
                            <td>{{ $rec->description }}</td>
                            <td>${{ number_format($rec->amount, 2) }}</td>
                            <td>{{ $rec->payment_method }}</td>
                            <td>{{ $rec->status }}</td>
                        @else
                            <td>{{ $rec->date }}</td>
                            <td>${{ number_format($rec->total_sales, 2) }}</td>
                            <td>${{ number_format($rec->total_expenses, 2) }}</td>
                            <td>${{ number_format($rec->net_profit, 2) }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $records->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection 