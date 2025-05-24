@extends('layouts.master')
@section('title', 'Edit Expense')
@section('content')
<div class="container py-4 d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="edit-form-wrapper">
        <h2 class="mb-4 text-gold text-center">Edit Expense</h2>
        @include('financials._expense-form', [
            'expense' => $expense,
            'action' => route('manage.financials.expenses.update', $expense->id)
        ])
    </div>
</div>
<style>
.edit-form-wrapper {
    background: #2c1e1e;
    border-radius: 1rem;
    box-shadow: 0 0 24px 0 rgba(212,175,55,0.10);
    max-width: 500px;
    width: 100%;
    padding: 2rem 1.5rem;
    margin: 0 auto;
}
@media (max-width: 576px) {
    .edit-form-wrapper {
        padding: 1rem !important;
        border-radius: 0.7rem !important;
        max-width: 98vw !important;
    }
    h2.text-gold {
        font-size: 1.1rem !important;
        margin-bottom: 1rem !important;
    }
}
</style>
@endsection 