@extends('layouts.master')
@section('title', 'Manage Financials')
@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-gold">Manage Financials</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="text-gold mb-0">Sales</h4>
                <a href="{{ route('manage.financials.sales.all') }}" class="btn btn-gold btn-sm ms-2">See All</a>
            </div>
            @can('manage_sales')
            <a href="#" class="btn btn-gold mb-2" data-bs-toggle="modal" data-bs-target="#addSaleModal">Add Sale</a>
            <!-- Add Sale Modal -->
            <div class="modal fade" id="addSaleModal" tabindex="-1" aria-labelledby="addSaleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content bg-dark text-gold">
                  <form method="POST" action="{{ route('manage.financials.sales.store') }}">
                    @csrf
                    <div class="modal-header">
                      <h5 class="modal-title" id="addSaleModalLabel">Add Sale</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="number" step="0.01" name="total_amount" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Total Products</label>
                        <input type="number" name="total_products" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-control payment-method-select" required onchange="toggleOtherInput(this, 'sale-payment-method-other')">
                          <option value="cash">Cash</option>
                          <option value="credit">Credit</option>
                          <option value="bank_transfer">Bank Transfer</option>
                          <option value="other">Other</option>
                        </select>
                        <input type="text" name="payment_method_other" class="form-control mt-2 d-none" id="sale-payment-method-other" placeholder="Please specify" />
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                          <option value="completed">Completed</option>
                          <option value="pending">Pending</option>
                          <option value="cancelled">Cancelled</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-gold">Add Sale</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @endcan
            <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th class="border-gold">Date</th><th class="border-gold">Total Amount</th><th class="border-gold">Total Products</th><th class="border-gold">Payment Method</th><th class="border-gold">Status</th>
                        @can('manage_sales')<th class="border-gold">Actions</th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td class="border-gold">{{ $sale->date }}</td>
                        <td class="border-gold">
                            <span class="badge bg-credit">${{ number_format($sale->total_amount, 2) }}</span>
                        </td>
                        <td class="border-gold">{{ $sale->total_products }}</td>
                        <td class="border-gold">{{ $sale->payment_method }}</td>
                        <td class="border-gold">{{ $sale->status }}</td>
                        @can('manage_sales')
                        <td class="border-gold">
                            <div class="btn-group">
                                @can('view_sales')
                                <a href="{{ route('manage.financials.sales.show', $sale->id) }}" class="btn btn-view btn-sm me-2">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                                @endcan
                                <a href="{{ route('manage.financials.sales.edit', ['id' => $sale->id, 'return' => url()->current()]) }}" class="btn btn-edit btn-sm me-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('manage.financials.sales.delete', $sale->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure you want to delete this sale?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="text-gold mb-0">Expenses</h4>
                <a href="{{ route('manage.financials.expenses.all') }}" class="btn btn-gold btn-sm ms-2">See All</a>
            </div>
            @can('manage_expenses')
            <a href="#" class="btn btn-gold mb-2" data-bs-toggle="modal" data-bs-target="#addExpenseModal">Add Expense</a>
            <!-- Add Expense Modal -->
            <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content bg-dark text-gold">
                  <form method="POST" action="{{ route('manage.financials.expenses.store') }}">
                    @csrf
                    <div class="modal-header">
                      <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control category-select" required onchange="toggleOtherInput(this, 'expense-category-other')">
                          <option value="Salary">Salary</option>
                          <option value="Utilities">Utilities</option>
                          <option value="Rent">Rent</option>
                          <option value="Supplies">Supplies</option>
                          <option value="Marketing">Marketing</option>
                          <option value="Other">Other</option>
                        </select>
                        <input type="text" name="category_other" class="form-control mt-2 d-none" id="expense-category-other" placeholder="Please specify" />
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-control payment-method-select" required onchange="toggleOtherInput(this, 'expense-payment-method-other')">
                          <option value="cash">Cash</option>
                          <option value="credit">Credit</option>
                          <option value="bank_transfer">Bank Transfer</option>
                          <option value="other">Other</option>
                        </select>
                        <input type="text" name="payment_method_other" class="form-control mt-2 d-none" id="expense-payment-method-other" placeholder="Please specify" />
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                          <option value="paid">Paid</option>
                          <option value="pending">Pending</option>
                          <option value="cancelled">Cancelled</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-gold">Add Expense</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @endcan
            <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th class="border-gold">Date</th><th class="border-gold">Category</th><th class="border-gold">Description</th><th class="border-gold">Amount</th><th class="border-gold">Payment Method</th><th class="border-gold">Status</th>
                        @can('manage_expenses')<th class="border-gold">Actions</th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <td class="border-gold">{{ $expense->date }}</td>
                        <td class="border-gold">{{ $expense->category }}</td>
                        <td class="border-gold">{{ $expense->description }}</td>
                        <td class="border-gold">
                            <span class="badge bg-credit">${{ number_format($expense->amount, 2) }}</span>
                        </td>
                        <td class="border-gold">{{ $expense->payment_method }}</td>
                        <td class="border-gold">{{ $expense->status }}</td>
                        @can('manage_expenses')
                        <td class="border-gold">
                            <div class="btn-group">
                                @can('view_expenses')
                                <a href="{{ route('manage.financials.expenses.show', $expense->id) }}" class="btn btn-view btn-sm me-2">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                                @endcan
                                <a href="{{ route('manage.financials.expenses.edit', ['id' => $expense->id, 'return' => url()->current()]) }}" class="btn btn-edit btn-sm me-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('manage.financials.expenses.delete', $expense->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure you want to delete this expense?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4 class="text-gold mb-0">Profit</h4>
                <a href="{{ route('manage.financials.profit.all') }}" class="btn btn-gold btn-sm ms-2">See All</a>
            </div>
            @can('manage_profit')
            <a href="#" class="btn btn-gold mb-2" data-bs-toggle="modal" data-bs-target="#addProfitModal">Add Profit</a>
            <!-- Add Profit Modal -->
            <div class="modal fade" id="addProfitModal" tabindex="-1" aria-labelledby="addProfitModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content bg-dark text-gold">
                  <form method="POST" action="{{ route('manage.financials.profit.store') }}">
                    @csrf
                    <div class="modal-header">
                      <h5 class="modal-title" id="addProfitModalLabel">Add Profit</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Total Sales</label>
                        <input type="number" step="0.01" name="total_sales" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Total Expenses</label>
                        <input type="number" step="0.01" name="total_expenses" class="form-control" required>
                      </div>
                      <div class="mb-3">
                        <label class="form-label">Net Profit</label>
                        <input type="number" step="0.01" name="net_profit" class="form-control" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-gold">Add Profit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            @endcan
            <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th class="border-gold">Date</th><th class="border-gold">Total Sales</th><th class="border-gold">Total Expenses</th><th class="border-gold">Net Profit</th>
                        @can('manage_profit')<th class="border-gold">Actions</th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($profits as $profit)
                    <tr>
                        <td class="border-gold">{{ $profit->date }}</td>
                        <td class="border-gold">
                            <span class="badge bg-credit">${{ number_format($profit->total_sales, 2) }}</span>
                        </td>
                        <td class="border-gold">
                            <span class="badge bg-credit">${{ number_format($profit->total_expenses, 2) }}</span>
                        </td>
                        <td class="border-gold">
                            <span class="badge bg-credit">${{ number_format($profit->net_profit, 2) }}</span>
                        </td>
                        @can('manage_profit')
                        <td class="border-gold">
                            <div class="btn-group">
                                <a href="#" class="btn btn-edit btn-sm">Edit</a>
                            </div>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleOtherInput(select, inputId) {
    var input = document.getElementById(inputId);
    if (select.value === 'other' || select.value === 'Other') {
        input.classList.remove('d-none');
        input.required = true;
    } else {
        input.classList.add('d-none');
        input.required = false;
        input.value = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // For each select with .payment-method-select or .category-select, check value on modal open
    [
        {select: '.payment-method-select[name="payment_method"]', input: 'sale-payment-method-other', modal: '#addSaleModal'},
        {select: '.category-select[name="category"]', input: 'expense-category-other', modal: '#addExpenseModal'},
        {select: '.payment-method-select[name="payment_method"]', input: 'expense-payment-method-other', modal: '#addExpenseModal'}
    ].forEach(function(cfg) {
        var select = document.querySelector(cfg.modal + ' ' + cfg.select);
        var input = document.getElementById(cfg.input);
        var modal = document.querySelector(cfg.modal);
        if (select && input && modal) {
            select.addEventListener('change', function() {
                toggleOtherInput(this, cfg.input);
            });
            modal.addEventListener('shown.bs.modal', function() {
                toggleOtherInput(select, cfg.input);
            });
        }
    });
});
</script>
@endsection

@section('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Financials</title>
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