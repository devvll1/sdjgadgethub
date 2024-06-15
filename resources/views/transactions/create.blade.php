@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container-fluid" style="padding: 0; min-height: 100vh; display: flex; flex-direction: column;">
    <div class="row justify-content-center flex-grow-1" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <div class="form-container" style="background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1)); padding: 20px; min-height: 100vh;">
                <div class="row">
                    <div class="col-md-5" style="background-color: white; padding: 20px;">
                        <h1 class="mb-4">TRANSACTION DETAILS</h1>
                        <div id="order-details">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="order-items"></tbody>
                            </table>
                            <p>Amount: <span id="order-amount">0</span></p>
                            <p>Total Amount: <span id="total-amount">0</span></p>
                            <p>Tendered: <span id="tendered-amount">0</span></p>
                        </div>
                    </div>
                    <div class="col-md-7">
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
        let orderTotal = 0;
        const orderDetails = {};

        document.querySelectorAll('.add-to-order').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = parseFloat(this.getAttribute('data-price'));

                if (orderDetails[id]) {
                    orderDetails[id].quantity++;
                    updateOrderItemRow(id);
                } else {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${name}</td>
                        <td>${price.toFixed(2)}</td>
                        <td class="product-quantity">1</td>
                        <td class="product-total">${price.toFixed(2)}</td>
                        <td>
                            <button style="padding: 8px" class="btn btn-success btn-sm increase-quantity">+</button>
                            <button style="padding: 8px"  class="btn btn-warning btn-sm decrease-quantity">-</button>
                            <button style="padding: 10px" class="btn btn-danger btn-sm remove-from-order">Remove</button>
                        </td>
                    `;
                    orderItems.appendChild(tr);

                    orderDetails[id] = {
                        quantity: 1,
                        price: price,
                        name: name,
                        element: tr
                    };

                    tr.querySelector('.increase-quantity').addEventListener('click', function () {
                        orderDetails[id].quantity++;
                        updateOrderItemRow(id);
                        updateOrderTotal();
                    });

                    tr.querySelector('.decrease-quantity').addEventListener('click', function () {
                        if (orderDetails[id].quantity > 1) {
                            orderDetails[id].quantity--;
                            updateOrderItemRow(id);
                            updateOrderTotal();
                        } else {
                            removeOrderItem(id);
                        }
                    });

                    tr.querySelector('.remove-from-order').addEventListener('click', function () {
                        removeOrderItem(id);
                    });
                }

                updateOrderTotal();
            });
        });

        function updateOrderItemRow(id) {
            const item = orderDetails[id];
            item.element.querySelector('.product-quantity').textContent = item.quantity;
            item.element.querySelector('.product-total').textContent = (item.quantity * item.price).toFixed(2);
        }

        function removeOrderItem(id) {
            orderItems.removeChild(orderDetails[id].element);
            delete orderDetails[id];
            updateOrderTotal();
        }

        function updateOrderTotal() {
            orderTotal = Object.values(orderDetails).reduce((sum, item) => sum + (item.quantity * item.price), 0);
            orderAmount.textContent = orderTotal.toFixed(2);
            totalAmount.textContent = orderTotal.toFixed(2);
        }
    });
</script>
@endsection
