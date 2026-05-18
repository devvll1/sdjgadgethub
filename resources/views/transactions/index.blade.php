@extends('layout.main')

@section('title', 'Transactions — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    <div class="page-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1 font-display">Transactions</h1>
                <p class="text-muted mb-0">Sales and payment records</p>
            </div>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                <i class="bi bi-cart-plus me-1"></i> New sale
            </a>
        </div>

        <form action="{{ route('transactions.index') }}" method="GET" class="row g-2 mb-4">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Search by ID or payment method..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary flex-grow-1">Search</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Tendered</th>
                        <th>Change</th>
                        <th>Payment</th>
                        <th>Cashier</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td class="fw-semibold">#{{ $transaction->transaction_id }}</td>
                            <td>₱{{ number_format($transaction->total_amount, 2) }}</td>
                            <td>₱{{ number_format($transaction->tendered, 2) }}</td>
                            <td>₱{{ number_format($transaction->change, 2) }}</td>
                            <td>{{ $transaction->paymentMethod?->paymentmethods ?? '—' }}</td>
                            <td>{{ $transaction->user_id }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('transactions.show', $transaction->transaction_id) }}" class="btn btn-outline-primary">View</a>
                                    <a href="{{ route('transactions.receipt', $transaction->transaction_id) }}" class="btn btn-outline-secondary" target="_blank">Receipt</a>
                                    <form action="{{ route('transactions.destroy', $transaction->transaction_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this transaction and restore stock?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            {{ $transactions->links() }}
            <a href="{{ route('transactions.nav') }}" class="btn btn-secondary">Main menu</a>
        </div>
    </div>
</div>
@endsection
