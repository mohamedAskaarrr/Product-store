<form action="{{ $action }}" method="POST" class="card p-4 bg-dark text-gold">
    @csrf
    @if(isset($sale))
        @method('PUT')
    @endif
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $sale->date ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="total_amount" class="form-label">Total Amount</label>
        <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', $sale->total_amount ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="total_products" class="form-label">Total Products</label>
        <input type="number" class="form-control" id="total_products" name="total_products" value="{{ old('total_products', $sale->total_products ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label for="payment_method" class="form-label">Payment Method</label>
        <select class="form-control payment-method-select" name="payment_method" id="sale-payment-method" required>
            <option value="cash" {{ (old('payment_method', $sale->payment_method ?? '') == 'cash') ? 'selected' : '' }}>Cash</option>
            <option value="credit" {{ (old('payment_method', $sale->payment_method ?? '') == 'credit') ? 'selected' : '' }}>Credit</option>
            <option value="bank_transfer" {{ (old('payment_method', $sale->payment_method ?? '') == 'bank_transfer') ? 'selected' : '' }}>Bank Transfer</option>
            <option value="other" {{ (old('payment_method', $sale->payment_method ?? '') == 'other') ? 'selected' : '' }}>Other</option>
        </select>
        <input type="text" class="form-control mt-2 d-none" id="sale-payment-method-other" name="payment_method_other" placeholder="Specify other payment method" value="{{ old('payment_method_other', (isset($sale) && !in_array($sale->payment_method ?? '', ['cash','credit','bank_transfer'])) ? $sale->payment_method : '') }}">
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="completed" {{ (old('status', $sale->status ?? '') == 'completed') ? 'selected' : '' }}>Completed</option>
            <option value="pending" {{ (old('status', $sale->status ?? '') == 'pending') ? 'selected' : '' }}>Pending</option>
            <option value="cancelled" {{ (old('status', $sale->status ?? '') == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-gold">{{ isset($sale) ? 'Save Changes' : 'Add Sale' }}</button>
        <a href="{{ isset($sale) ? route('manage.financials.sales.show', $sale->id) : route('manage.financials') }}" class="btn btn-secondary ms-2">Cancel</a>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var select = document.getElementById('sale-payment-method');
    var otherInput = document.getElementById('sale-payment-method-other');
    function toggleOther() {
        if (select.value === 'other') {
            otherInput.classList.remove('d-none');
            otherInput.required = true;
        } else {
            otherInput.classList.add('d-none');
            otherInput.required = false;
            otherInput.value = '';
        }
    }
    select.addEventListener('change', toggleOther);
    toggleOther();
});
</script> 