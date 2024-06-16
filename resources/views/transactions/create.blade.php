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
                            <p>Total Amount: <span id="total-amount">0</span></p>
                            <p>
                                Tendered: 
                                <input type="number" id="tendered-input" value="0" step="0.01" min="0" />
                            </p>
                            <p>Change: <span id="change-amount">0</span></p>
                            <p>
                                Payment Method: 
                                <select id="payment-method" class="form-control">
                                    @foreach($paymentmethods as $paymentmethods)
                                        <option value="{{ $paymentmethods->pmethod_id }}">{{ $paymentmethods->paymentmethods }}</option>
                                    @endforeach
                                </select>
                            </p>
                            <button id="checkout-button" class="btn btn-success">Checkout</button>
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
        const orderAmount = document.getElementById('total-amount');
        const tenderedInput = document.getElementById('tendered-input');
        const changeAmount = document.getElementById('change-amount');
        let orderTotal = 0;
        const orderDetails = {};

        // Function to update quantity and total of an item in the order
        function updateOrderItemRow(id) {
            const item = orderDetails[id];
            item.element.querySelector('.product-quantity').textContent = item.quantity;
            const itemTotal = item.quantity * item.price;
            item.element.querySelector('.product-total').textContent = itemTotal.toFixed(2);
            updateOrderTotal();
        }

        // Function to remove an item from the order
        function removeOrderItem(id) {
            orderItems.removeChild(orderDetails[id].element);
            delete orderDetails[id];
            updateOrderTotal();
        }

        // Function to calculate and update total amount
        function updateOrderTotal() {
            orderTotal = Object.values(orderDetails).reduce((acc, item) => {
                const itemTotal = item.quantity * item.price;
                return acc + itemTotal;
            }, 0);
            orderAmount.textContent = orderTotal.toFixed(2);

            // Update change amount based on tendered amount
            const tenderedAmount = parseFloat(tenderedInput.value);
            const change = tenderedAmount - orderTotal;
            changeAmount.textContent = change.toFixed(2);
        }

        // Event listeners for add to order buttons
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
                    tr.dataset.productId = id;
                    tr.innerHTML = `
                        <td>${name}</td>
                        <td>${price.toFixed(2)}</td>
                        <td class="product-quantity">1</td>
                        <td class="product-total">${price.toFixed(2)}</td>
                        <td>
                            <button style="padding: 8px" class="btn btn-success btn-sm increase-quantity">+</button>
                            <button style="padding: 8px" class="btn btn-warning btn-sm decrease-quantity">-</button>
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
                    });

                    tr.querySelector('.decrease-quantity').addEventListener('click', function () {
                        if (orderDetails[id].quantity > 1) {
                            orderDetails[id].quantity--;
                            updateOrderItemRow(id);
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

        // Event listener for tendered amount input
        tenderedInput.addEventListener('input', updateOrderTotal);

        // Checkout button event listener
        const checkoutButton = document.getElementById('checkout-button');
        checkoutButton.addEventListener('click', function () {
            const tenderedAmount = parseFloat(tenderedInput.value);
            const paymentMethod = document.getElementById('payment-method').value;
            const orderItemsArray = Object.values(orderDetails).map(item => {
                return {
                    product_id: item.productId, // Ensure 'productId' matches your actual attribute
                    quantity: item.quantity,
                    price: item.price
                };
            });

            const formData = {
                total_amount: orderTotal,
                tendered: tenderedAmount,
                payment_method: paymentMethod,
                order_items: orderItemsArray
            };

            fetch('/transactions.create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>


@endsection
