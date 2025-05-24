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
            <h4 class="text-gold">Sales</h4>
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
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Date</th><th>Total Amount</th><th>Total Products</th><th>Payment Method</th><th>Status</th>
                        @can('manage_sales')<th>Actions</th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->date }}</td>
                        <td>${{ number_format($sale->total_amount, 2) }}</td>
                        <td>{{ $sale->total_products }}</td>
                        <td>{{ $sale->payment_method }}</td>
                        <td>{{ $sale->status }}</td>
                        @can('manage_sales')
                        <td>
                            @can('view_sales')
                            <a href="{{ route('manage.financials.sales.show', $sale->id) }}" class="btn btn-sm btn-info">Details</a>
                            @endcan
                            <a href="#" class="btn btn-sm btn-outline-gold">Edit</a>
                            <form action="#" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-12 mb-4">
            <h4 class="text-gold">Expenses</h4>
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
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Date</th><th>Category</th><th>Description</th><th>Amount</th><th>Payment Method</th><th>Status</th>
                        @can('manage_expenses')<th>Actions</th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $expense->date }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>${{ number_format($expense->amount, 2) }}</td>
                        <td>{{ $expense->payment_method }}</td>
                        <td>{{ $expense->status }}</td>
                        @can('manage_expenses')
                        <td>
                            @can('view_expenses')
                            <a href="{{ route('manage.financials.expenses.show', $expense->id) }}" class="btn btn-sm btn-info">Details</a>
                            @endcan
                            <a href="#" class="btn btn-sm btn-outline-gold">Edit</a>
                            <form action="#" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-12 mb-4">
            <h4 class="text-gold">Profit</h4>
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
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Date</th><th>Total Sales</th><th>Total Expenses</th><th>Net Profit</th>
                        @can('manage_profit')<th>Actions</th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($profits as $profit)
                    <tr>
                        <td>{{ $profit->date }}</td>
                        <td>${{ number_format($profit->total_sales, 2) }}</td>
                        <td>${{ number_format($profit->total_expenses, 2) }}</td>
                        <td>${{ number_format($profit->net_profit, 2) }}</td>
                        @can('manage_profit')
                        <td>
                            <a href="#" class="btn btn-sm btn-outline-gold">Edit</a>
                            <form action="#" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
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