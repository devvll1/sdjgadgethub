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
                    {{ $transaction_items->links() }}
                </div>
            </div>
        </div>
        <!-- User Table -->
        <div class="table-responsive col-md-12">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <th>TRANSACTION ID</th>
                        <th>PRODUCT ID</th>
                        <th>PRODUCT NAME</th>
                        <th>DESCRIPTION</th>
                        <th>QUANTITY</th>
                        <th>PRICE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction_items as $transactionitem)
                        <tr>                                  
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transactionitem->transaction_id }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transactionitem->products_id }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transactionitem->products->name }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transactionitem->products->description }}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transactionitem->quantity}}</td>
                            <td class="align-middle" style="font-size: 0.9rem;">{{ $transactionitem->price }}</td>
    
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Return button -->
            <a href="{{ route('transactions.history') }}" class="btn btn-secondary">Return</a>
            <a class="btn btn-primary" href="{{ route('transactions.nav') }}">Main Menu</a>
        </div>
    </div>
</div>

@endsection