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
                        <th class="border-gold">Date</th><th class="border-gold">Total Amount</th><th class="border-gold">Total Products</th><th class="border-gold">Payment Method</th><th class="border-gold">Status</th>
                    @elseif($type === 'expenses')
                        <th class="border-gold">Date</th><th class="border-gold">Category</th><th class="border-gold">Description</th><th class="border-gold">Amount</th><th class="border-gold">Payment Method</th><th class="border-gold">Status</th>
                    @else
                        <th class="border-gold">Date</th><th class="border-gold">Total Sales</th><th class="border-gold">Total Expenses</th><th class="border-gold">Net Profit</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($records as $rec)
                    <tr>
                        @if($type === 'sales')
                            <td class="border-gold">{{ $rec->date }}</td>
                            <td class="border-gold"><span class="badge bg-credit">${{ number_format($rec->total_amount, 2) }}</span></td>
                            <td class="border-gold">{{ $rec->total_products }}</td>
                            <td class="border-gold">{{ $rec->payment_method }}</td>
                            <td class="border-gold">{{ $rec->status }}</td>
                        @elseif($type === 'expenses')
                            <td class="border-gold">{{ $rec->date }}</td>
                            <td class="border-gold">{{ $rec->category }}</td>
                            <td class="border-gold">{{ $rec->description }}</td>
                            <td class="border-gold"><span class="badge bg-credit">${{ number_format($rec->amount, 2) }}</span></td>
                            <td class="border-gold">{{ $rec->payment_method }}</td>
                            <td class="border-gold">{{ $rec->status }}</td>
                        @else
                            <td class="border-gold">{{ $rec->date }}</td>
                            <td class="border-gold"><span class="badge bg-credit">${{ number_format($rec->total_sales, 2) }}</span></td>
                            <td class="border-gold"><span class="badge bg-credit">${{ number_format($rec->total_expenses, 2) }}</span></td>
                            <td class="border-gold"><span class="badge bg-credit">${{ number_format($rec->net_profit, 2) }}</span></td>
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

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All {{ ucfirst($type) }}</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> --}}
<style>
    body {
        background-color: #2c1e1e;
        color: #f5f5f5;
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
    .table-dark td {
        border-color: #D4AF37 !important;
        color: #f5f5f5 !important;
        vertical-align: middle;
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
    .btn-edit {
        background-color: #E5C158 !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
    }
    .btn-delete {
        background-color: #f9cf6e !important;
        color: #2c1e1e !important;
        border: none !important;
        transition: all 0.3s ease;
    }
    .badge.bg-admin {
        background-color: #8B6914 !important;
        color: #f5f5f5 !important;
    }
    .badge.bg-employee {
        background-color: #B38F28 !important;
        color: #f5f5f5 !important;
    }
    .badge.bg-supplier {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
    }
    .badge.bg-manager {
        background-color: #E5C158 !important;
        color: #2c1e1e !important;
    }
    .badge.bg-customer {
        background-color: #F5D280 !important;
        color: #2c1e1e !important;
    }
    .badge.bg-credit {
        background-color: #D4AF37 !important;
        color: #2c1e1e !important;
    }
    .btn-view:hover, .btn-edit:hover, .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
        color: #2c1e1e !important;
        opacity: 0.9;
    }
    .badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .text-gold {
        color: #D4AF37 !important;
        font-weight: 600;
    }
    .text-light {
        color: #f5f5f5 !important;
    }
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #D4AF37;
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
        color: #2c1e1e !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
    }
    @media (max-width: 576px) {
        .container.py-4 {
            padding: 0.5rem !important;
        }
        .row.mb-4 > .col-md-6, .row.mb-4 > .col-md-6.text-end {
            flex: 0 0 100%;
            max-width: 100%;
            text-align: left !important;
            margin-bottom: 0.5rem !important;
        }
        .row.mb-4 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        .d-flex.gap-2, .d-flex {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
        .btn, .btn-gold, .btn-view, .btn-edit, .btn-delete {
            width: 100% !important;
            margin-bottom: 0.3rem !important;
            font-size: 1rem !important;
            padding: 0.7rem 1rem !important;
        }
        .badge {
            font-size: 0.95rem !important;
            padding: 0.4em 0.7em !important;
            margin-bottom: 0.2em !important;
        }
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        .table {
            min-width: 600px !important;
            font-size: 0.95rem !important;
        }
        .form-control {
            font-size: 1rem !important;
            padding: 0.7rem 1rem !important;
        }
        form.d-flex.gap-2 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }
    }
</style>
@endsection 