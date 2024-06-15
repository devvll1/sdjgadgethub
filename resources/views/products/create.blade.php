@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container-fluid" style="padding: 0; min-height: 100vh; display: flex; flex-direction: column;">
    <div class="row justify-content-center flex-grow-1" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <div class="form-container" style="background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1)); padding: 20px; min-height: 100vh;">
                <div class="row">
                    <div class="col-md-4" style="background-color: white; padding: 20px;">
                        <h1 class="mb-4">ORDER DETAILS</h1>
                        <div id="order-details">
                            <form action="{{ route('orders.store') }}" method="post" class="needs-validation" enctype="multipart/form-data">
                                @csrf
                                <p>Product added:</p>
                                <ul id="order-items"></ul>
                                <p>Amount: <span id="order-amount">0</span></p>
                                <p>Total Amount: <span id="total-amount">0</span></p>
                                <p>Tendered: <span id="tendered-amount">0</span></p>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Submit Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h1 class="mb-4" style="color: white; font-weight: bold;">Products</h1>
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-md-3 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">{{ $product->description }}</p>
                                            <p class="card-text">Price: {{ $product->price }}</p>
                                            <button class="btn btn-primary add-to-order" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">Add</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderItems = document.getElementById('order-items');
        const orderAmount = document.getElementById('order-amount');
        const totalAmount = document.getElementById('total-amount');
        const tenderedAmount = document.getElementById('tendered-amount');
        let orderTotal = 0;

        document.querySelectorAll('.add-to-order').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = parseFloat(this.getAttribute('data-price'));

                const li = document.createElement('li');
                li.textContent = `${name} - ${price}`;
                orderItems.appendChild(li);

                orderTotal += price;
                orderAmount.textContent = orderTotal.toFixed(2);
                totalAmount.textContent = orderTotal.toFixed(2);
            });
        });
    });
</script>
@endsection
