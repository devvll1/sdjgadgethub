@extends('layout.main')

@section('title', 'Transaction History — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    <div class="page-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1 font-display">Transaction history</h1>
                <p class="text-muted mb-0">Line items from completed sales</p>
            </div>
        </div>

        <form action="{{ route('transactions.history') }}" method="GET" class="row g-2 mb-4">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Search transaction ID or product name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary flex-grow-1">Search</button>
                <a href="{{ route('transactions.history') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Transaction</th>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaction_items as $item)
                        <tr>
                            <td>#{{ $item->transaction_id }}</td>
                            <td class="fw-semibold">{{ $item->product?->name ?? '—' }}</td>
                            <td class="text-muted small">{{ $item->product?->description ?? '—' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">No transaction items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            {{ $transaction_items->links() }}
            <a href="{{ route('transactions.nav') }}" class="btn btn-secondary">Main menu</a>
        </div>
    </div>
</div>
@endsection
