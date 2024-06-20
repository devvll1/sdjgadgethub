@extends('layout.main')

@section('content')

@include('include.nav')

<div class="container-fluid" style="padding: 0; min-height: 100vh; display: flex; flex-direction: column;">
    <div class="row justify-content-center flex-grow-1" style="margin: 0;">
        <div class="col-md-12" style="padding: 0;">
            <form action="{{ route('transactions.store') }}" method="post" class="needs-validation" enctype="multipart/form-data">
                @csrf
                <div class="form-container" style="background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1)); padding: 20px; min-height: 100vh;">
                    <div class="row">
                        <div class="col-md-5" style="background-color: white; padding: 20px;">
                            <h1 class="mb-4">TRANSACTION DETAILS</h1>
                            <div id="order-details">
                                <table class="table table-striped" id="transaction_items">
                                    <thead>
                                        <tr>
                                            <th>Quantity</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="order-items"></tbody>
                                </table>
                                <p>Total Amount: <span id="total-amount">0</span></p>
                                <p>
                                    Tendered: 
                                    <input type="number" id="tendered-input" name="tendered" value="0" step="0.01" min="0" />
                                </p>
                                <p>Change: <span id="change">0</span></p>
                                <p>
                                    Payment Method: 
                                    <select id="payment-method" name="pmethod_id" class="form-control">
                                        @foreach($paymentmethods as $paymentmethod)
                                            <option value="{{ $paymentmethod->pmethod_id }}">{{ $paymentmethod->paymentmethods }}</option>
                                        @endforeach
                                    </select>
                                </p>

                                <input type="hidden" id="total-amount-input" name="total_amount" value="0">
                                <input type="hidden" id="change-amount-input" name="change" value="0">
                                <input type="hidden" id="order-items-input" name="order_items" value="">  
                                <button type="submit" class="btn btn-success">Checkout</button>
                                <a class="btn btn-primary" href="{{ route('transactions.nav') }}">Return</a>
                                <a class="btn btn-danger"href="{{ route('transactions.create') }}" >Clear</a> <!-- Add Clear Button -->
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
                                                <button type="button" class="btn btn-primary add-to-order" data-id="{{ $product->products_id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderItems = [];
        const orderItemsContainer = document.getElementById('order-items');
        const totalAmountEl = document.getElementById('total-amount');
        const tenderedInput = document.getElementById('tendered-input');
        const changeEl = document.getElementById('change');
        const totalAmountInput = document.getElementById('total-amount-input');
        const changeAmountInput = document.getElementById('change-amount-input');
        const orderItemsInput = document.getElementById('order-items-input');

        document.querySelectorAll('.add-to-order').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = parseFloat(this.getAttribute('data-price'));

                addOrderItem(productId, productName, productPrice);
                updateOrderDetails();
            });
        });

        tenderedInput.addEventListener('input', function () {
            updateChange();
        });

        document.getElementById('transaction-form').addEventListener('submit', function (e) {
            e.preventDefault();
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this)
            }).then(response => {
                if (response.headers.get('X-Download-Complete')) {
                    window.location.reload();
                }
                return response.blob();
            }).then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `receipt-${transaction_id}.pdf`;
                document.body.appendChild(a);
                a.click();
                a.remove();
            }).catch(error => console.error('Error:', error));
        });

        function addOrderItem(id, name, price) {
            const existingItem = orderItems.find(item => item.id === id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                orderItems.push({ id, name, price, quantity: 1 });
            }
        }

        function updateOrderDetails() {
            orderItemsContainer.innerHTML = '';
            let totalAmount = 0;

            orderItems.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.quantity}</td>
                    <td>${item.name}</td>
                    <td>${item.price * item.quantity}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary increase" data-id="${item.id}">+</button>
                        <button type="button" class="btn btn-sm btn-secondary decrease" data-id="${item.id}">-</button>
                        <button type="button" class="btn btn-sm btn-danger remove" data-id="${item.id}">Remove</button>
                    </td>
                `;
                orderItemsContainer.appendChild(row);

                totalAmount += item.price * item.quantity;
            });

            totalAmountEl.textContent = totalAmount.toFixed(2);
            totalAmountInput.value = totalAmount.toFixed(2);
            orderItemsInput.value = JSON.stringify(orderItems);

            document.querySelectorAll('.increase').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-id');
                    changeQuantity(productId, 1);
                });
            });

            document.querySelectorAll('.decrease').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-id');
                    changeQuantity(productId, -1);
                });
            });

            document.querySelectorAll('.remove').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-id');
                    removeOrderItem(productId);
                });
            });

            updateChange();
        }

        function changeQuantity(productId, change) {
            const item = orderItems.find(item => item.id === productId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeOrderItem(productId);
                } else {
                    updateOrderDetails();
                }
            }
        }

        function removeOrderItem(productId) {
            const itemIndex = orderItems.findIndex(item => item.id === productId);
            if (itemIndex > -1) {
                orderItems.splice(itemIndex, 1);
                updateOrderDetails();
            }
        }

        function updateChange() {
            const totalAmount = parseFloat(totalAmountEl.textContent);
            const tenderedAmount = parseFloat(tenderedInput.value);
            const change = tenderedAmount - totalAmount;
            changeEl.textContent = change.toFixed(2);
            changeAmountInput.value = change.toFixed(2);
        }

    });
</script>
@endsection