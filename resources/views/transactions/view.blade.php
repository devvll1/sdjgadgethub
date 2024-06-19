@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container">
    <div class="row justify-content-center">

        <!-- Main Content -->
        <div class="col-md-10 mt-4">
            <h2>Product Details</h2>
            
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">ID</th>
                        <td>{{ $transaction->transaction_id }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Transaction Total</th>
                        <td>{{ $transaction->total_amount }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Client Tendered</th>
                        <td>{{ $transaction->tendered }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Client Change</th>
                        <td>{{ $transaction->change }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Payment Method</th>
                        <td>{{ $transaction->paymentmethods->paymentmethods }}</td>
                    </tr>
                    <tr>
                        <th scope="row">USER ID</th>
                        <td>{{ $transaction->users->user_id }}</td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Return Button -->
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Return</a>
        </div>
    </div>
</div>
@endsection