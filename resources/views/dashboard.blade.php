@extends('layout.main')

@section('title', 'Dashboard — SDJ Gadget Hub')

@section('content')
@include('include.nav')
@include('partials.flash')

<div class="container-fluid page-shell">
    <div class="dashboard-hero mb-4">
        <div>
            <p class="dashboard-eyebrow mb-1">Overview</p>
            <h1 class="dashboard-title mb-1">Hello, {{ session('myFullName') ?? auth()->user()?->full_name ?? 'there' }} 👋</h1>
            <p class="text-muted mb-0">Here's what's happening in your store today.</p>
        </div>
        <a href="{{ route('transactions.create') }}" class="btn btn-dark btn-lg shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> New sale
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-box-seam"></i></div>
                <div>
                    <p class="stat-label">Products</p>
                    <p class="stat-value">{{ number_format($stats['products']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon bg-success-subtle text-success"><i class="bi bi-receipt"></i></div>
                <div>
                    <p class="stat-label">Transactions</p>
                    <p class="stat-value">{{ number_format($stats['transactions']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-cash-stack"></i></div>
                <div>
                    <p class="stat-label">Total revenue</p>
                    <p class="stat-value">₱{{ number_format($stats['revenue'], 0) }}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger-subtle text-danger"><i class="bi bi-exclamation-triangle"></i></div>
                <div>
                    <p class="stat-label">Low stock</p>
                    <p class="stat-value">{{ number_format($stats['low_stock']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="page-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 mb-0 fw-bold">Quick actions</h2>
                </div>
                <div class="row g-3">
                    @php
                        $actions = [
                            ['New sale', 'bi-cart-plus', route('transactions.create'), 'Open POS'],
                            ['History', 'bi-clock-history', route('transactions.history'), 'Past line items'],
                        ];

                        if (auth()->user()?->isAdmin()) {
                            $actions = [
                                ['Products', 'bi-box-seam', route('products.index'), 'Manage inventory'],
                                ['New sale', 'bi-cart-plus', route('transactions.create'), 'Open POS'],
                                ['Users', 'bi-people', route('users.index'), 'Staff accounts'],
                                ['Reports', 'bi-bar-chart', route('transactions.report'), 'Sales insights'],
                                ['History', 'bi-clock-history', route('transactions.history'), 'Past line items'],
                                ['Add product', 'bi-plus-circle', route('products.create'), 'Expand catalog'],
                            ];
                        }
                    @endphp
                    @foreach ($actions as [$label, $icon, $url, $desc])
                        <div class="col-md-4 col-sm-6">
                            <a href="{{ $url }}" class="quick-action-card text-decoration-none">
                                <i class="bi {{ $icon }}"></i>
                                <span class="fw-semibold d-block">{{ $label }}</span>
                                <small class="text-muted">{{ $desc }}</small>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="page-card mb-4">
                <h2 class="h6 fw-bold mb-3">Recent sales</h2>
                @forelse($recentTransactions as $tx)
                    <div class="recent-item">
                        <div>
                            <span class="fw-semibold">#{{ $tx->transaction_id }}</span>
                            <small class="text-muted d-block">{{ $tx->paymentMethod?->paymentmethods }}</small>
                        </div>
                        <span class="fw-semibold">₱{{ number_format($tx->total_amount, 2) }}</span>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No transactions yet.</p>
                @endforelse
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-dark w-100 mt-3">View all</a>
            </div>

            @if($lowStockProducts->isNotEmpty())
                <div class="page-card border-warning-subtle">
                    <h2 class="h6 fw-bold mb-3 text-warning"><i class="bi bi-exclamation-triangle me-1"></i> Low stock</h2>
                    @foreach($lowStockProducts as $product)
                        <div class="recent-item">
                            <span>{{ $product->name }}</span>
                            <span class="badge text-bg-warning">{{ $product->stock_quantity }} left</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
