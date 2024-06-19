@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container-fluid">
    <div class="row">
        <!-- Pagination Links and Search Form -->
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mt-4 mb-3">
                    <!-- Pagination Links -->
                    {{ $transactions->links() }}
                </div>
                <!-- Search Form -->
                <form action="{{ route('transactions.index') }}" method="GET" class="search-form col-md-6 mt-3 mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- User Table -->
        <div class="table-responsive col-md-12">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th>TRANSACTION ID</th>
                        <th>TOTAL AMOUNT</th>
                        <th>TENDERED</th>
                        <th>CHANGE</th>
                        <th>PAYMENT METHOD</th>
                        <th>USER ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>                                  
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transaction->transaction_id }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transaction->total_amount }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transaction->tendered }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transaction->change }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transaction->paymentmethods->paymentmethods }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transaction->user_id }}</td>
                        
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="product Actions">
                                    <a href="{{ route('transactions.show', $transaction->transaction_id) }}" class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ route('transactions.edit', $transaction->transaction_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('transactions.destroy', $transaction->transaction_id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Product?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Return button -->
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Return</a>
            <a class="btn btn-primary" href="{{ route('transactions.nav') }}">Main Menu</a>
        </div>
    </div>
</div>

@endsection