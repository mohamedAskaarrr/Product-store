<form action="{{ $action }}" method="POST" class="card p-4 bg-dark text-gold">
    @csrf
    @if(isset($expense))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $expense->date ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select class="form-control category-select" name="category" id="expense-category" required>
            <option value="Utilities" {{ (old('category', $expense->category ?? '') == 'Utilities') ? 'selected' : '' }}>Utilities</option>
            <option value="Rent" {{ (old('category', $expense->category ?? '') == 'Rent') ? 'selected' : '' }}>Rent</option>
            <option value="Supplies" {{ (old('category', $expense->category ?? '') == 'Supplies') ? 'selected' : '' }}>Supplies</option>
            <option value="Marketing" {{ (old('category', $expense->category ?? '') == 'Marketing') ? 'selected' : '' }}>Marketing</option>
            <option value="Other" {{ (old('category', $expense->category ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
        </select>
        <input type="text" class="form-control mt-2 d-none" id="expense-category-other" name="category_other" placeholder="Specify other category" value="{{ old('category_other', (isset($expense) && !in_array($expense->category ?? '', ['Utilities','Rent','Supplies','Marketing'])) ? $expense->category : '') }}">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" required>{{ old('description', $expense->description ?? '') }}</textarea>
    </div>
    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount', $expense->amount ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="payment_method" class="form-label">Payment Method</label>
        <select class="form-control payment-method-select" name="payment_method" id="expense-payment-method" required>
            <option value="cash" {{ (old('payment_method', $expense->payment_method ?? '') == 'cash') ? 'selected' : '' }}>Cash</option>
            <option value="credit" {{ (old('payment_method', $expense->payment_method ?? '') == 'credit') ? 'selected' : '' }}>Credit</option>
            <option value="bank_transfer" {{ (old('payment_method', $expense->payment_method ?? '') == 'bank_transfer') ? 'selected' : '' }}>Bank Transfer</option>
            <option value="other" {{ (old('payment_method', $expense->payment_method ?? '') == 'other') ? 'selected' : '' }}>Other</option>
        </select>
        <input type="text" class="form-control mt-2 d-none" id="expense-payment-method-other" name="payment_method_other" placeholder="Specify other payment method" value="{{ old('payment_method_other', (isset($expense) && !in_array($expense->payment_method ?? '', ['cash','credit','bank_transfer'])) ? $expense->payment_method : '') }}">
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="paid" {{ (old('status', $expense->status ?? '') == 'paid') ? 'selected' : '' }}>Paid</option>
            <option value="pending" {{ (old('status', $expense->status ?? '') == 'pending') ? 'selected' : '' }}>Pending</option>
            <option value="cancelled" {{ (old('status', $expense->status ?? '') == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-gold">{{ isset($expense) ? 'Save Changes' : 'Add Expense' }}</button>
        <a href="{{ isset($returnUrl) ? $returnUrl : (isset($expense) ? route('manage.financials.expenses.show', $expense->id) : route('manage.financials')) }}" class="btn btn-secondary ms-2">Cancel</a>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var catSelect = document.getElementById('expense-category');
    var catOther = document.getElementById('expense-category-other');
    function toggleCatOther() {
        if (catSelect.value === 'Other') {
            catOther.classList.remove('d-none');
            catOther.required = true;
        } else {
            catOther.classList.add('d-none');
            catOther.required = false;
            catOther.value = '';
        }
    }
    catSelect.addEventListener('change', toggleCatOther);
    toggleCatOther();

    var paySelect = document.getElementById('expense-payment-method');
    var payOther = document.getElementById('expense-payment-method-other');
    function togglePayOther() {
        if (paySelect.value === 'other') {
            payOther.classList.remove('d-none');
            payOther.required = true;
        } else {
            payOther.classList.add('d-none');
            payOther.required = false;
            payOther.value = '';
        }
    }
    paySelect.addEventListener('change', togglePayOther);
    togglePayOther();
});
</script>
<style>
@media (max-width: 576px) {
    form.card.p-4 {
        padding: 0.7rem !important;
        border-radius: 0.7rem !important;
    }
    .form-label {
        font-size: 1rem !important;
    }
    .form-control, .category-select, .payment-method-select {
        font-size: 1rem !important;
        padding: 0.7rem 1rem !important;
    }
    .d-flex.gap-2 {
        flex-direction: column !important;
        gap: 0.5rem !important;
    }
    .btn {
        width: 100% !important;
        font-size: 1rem !important;
        padding: 0.7rem 1rem !important;
    }
}
</style> 