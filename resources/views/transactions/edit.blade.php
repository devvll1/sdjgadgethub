@extends('layout.main')

@section('title', 'Edit transaction — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    <x-admin-form
        title="Edit transaction"
        subtitle="Transaction #{{ $transaction->transaction_id }}"
        :action="route('transactions.update', $transaction->transaction_id)"
        method="PUT"
        :back-url="route('transactions.index')"
        submit-label="Save changes"
    >
        <div class="row g-3">
            <div class="col-md-4">
                <label for="total_amount" class="form-label">Total amount (₱)</label>
                <input type="number" step="0.01" min="0" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', $transaction->total_amount) }}" required>
                @error('total_amount')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="tendered" class="form-label">Tendered (₱)</label>
                <input type="number" step="0.01" min="0" class="form-control" id="tendered" name="tendered" value="{{ old('tendered', $transaction->tendered) }}" required>
                @error('tendered')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label for="change" class="form-label">Change (₱)</label>
                <input type="number" step="0.01" min="0" class="form-control" id="change" name="change" value="{{ old('change', $transaction->change) }}" required>
                @error('change')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="pmethod_id" class="form-label">Payment method</label>
                <select class="form-select" id="pmethod_id" name="pmethod_id" required>
                    <option value="">Select payment method</option>
                    @foreach($paymentmethods as $method)
                        <option value="{{ $method->pmethod_id }}" @selected(old('pmethod_id', $transaction->pmethod_id) == $method->pmethod_id)>{{ $method->paymentmethods }}</option>
                    @endforeach
                </select>
                @error('pmethod_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
        </div>
    </x-admin-form>
</div>
@endsection
