@extends('layout.main')

@section('title', 'POS Checkout - SDJ Gadget Hub')

@section('content')
@include('include.nav')

<form id="transaction-form" action="{{ route('transactions.store') }}" method="post" class="pos-shell">
    @csrf
    <input type="hidden" id="total-amount-input" name="total_amount" value="0">
    <input type="hidden" id="change-amount-input" name="change" value="0">
    <input type="hidden" id="order-items-input" name="order_items" value="">

    <aside class="pos-cart">
        <div class="pos-cart-header">
            <div>
                <p class="pos-eyebrow mb-1">Checkout</p>
                <h1 class="pos-title mb-0">Current Sale</h1>
            </div>
            <span class="badge text-bg-dark">{{ ucfirst(auth()->user()?->role ?? 'cashier') }}</span>
        </div>

        @include('partials.flash')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="empty-cart" class="pos-empty">
            <i class="bi bi-bag-plus"></i>
            <span>Add products to start a sale.</span>
        </div>

        <div class="pos-cart-lines" id="order-items"></div>

        <div class="pos-summary">
            <div class="pos-summary-row">
                <span>Items</span>
                <strong id="item-count">0</strong>
            </div>
            <div class="pos-summary-row total">
                <span>Total</span>
                <strong>PHP <span id="total-amount">0.00</span></strong>
            </div>
        </div>

        <div class="pos-payment">
            <label for="payment-method" class="form-label">Payment method</label>
            <select id="payment-method" name="pmethod_id" class="form-select form-select-lg">
                @foreach($paymentmethods as $paymentmethod)
                    <option value="{{ $paymentmethod->pmethod_id }}">{{ $paymentmethod->paymentmethods }}</option>
                @endforeach
            </select>

            <label for="tendered-input" class="form-label mt-3">Tendered amount</label>
            <div class="input-group input-group-lg">
                <span class="input-group-text">PHP</span>
                <input type="number" id="tendered-input" name="tendered" value="0" step="0.01" min="0" class="form-control">
            </div>

            <div class="pos-change">
                <span>Change</span>
                <strong>PHP <span id="change">0.00</span></strong>
            </div>
        </div>

        <div class="pos-actions">
            <button type="submit" id="checkout-button" class="btn btn-dark btn-lg">
                <i class="bi bi-credit-card me-1"></i> Checkout
            </button>
            <button type="button" id="clear-order" class="btn btn-outline-danger btn-lg">
                <i class="bi bi-trash me-1"></i> Clear
            </button>
            <a class="btn btn-light btn-lg" href="{{ route('transactions.nav') }}">
                <i class="bi bi-arrow-left me-1"></i> Return
            </a>
        </div>
    </aside>

    <main class="pos-products">
        <div class="pos-products-toolbar">
            <div>
                <p class="pos-eyebrow mb-1">Products</p>
                <h2 class="pos-title mb-0">Select Items</h2>
            </div>
            <div class="pos-search">
                <i class="bi bi-search"></i>
                <input type="search" id="product-search" class="form-control" placeholder="Search products...">
            </div>
        </div>

        <div class="pos-product-grid" id="product-grid">
            @foreach($products as $product)
                <button
                    type="button"
                    class="pos-product-card add-to-order"
                    data-id="{{ $product->products_id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-stock="{{ $product->stock_quantity }}"
                    data-search="{{ \Illuminate\Support\Str::lower($product->name . ' ' . $product->description) }}"
                    @disabled($product->stock_quantity < 1)
                >
                    <span class="pos-product-topline">
                        <span class="pos-product-name">{{ $product->name }}</span>
                        <span class="badge text-bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'secondary') }}">
                            {{ $product->stock_quantity }} left
                        </span>
                    </span>
                    <span class="pos-product-desc">{{ $product->description }}</span>
                    <span class="pos-product-footer">
                        <strong>PHP {{ number_format((float) $product->price, 2) }}</strong>
                        <span class="pos-add-icon"><i class="bi bi-plus-lg"></i></span>
                    </span>
                </button>
            @endforeach
        </div>
    </main>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderItems = [];
        const products = new Map();
        const orderItemsContainer = document.getElementById('order-items');
        const emptyCart = document.getElementById('empty-cart');
        const totalAmountEl = document.getElementById('total-amount');
        const itemCountEl = document.getElementById('item-count');
        const tenderedInput = document.getElementById('tendered-input');
        const changeEl = document.getElementById('change');
        const totalAmountInput = document.getElementById('total-amount-input');
        const changeAmountInput = document.getElementById('change-amount-input');
        const orderItemsInput = document.getElementById('order-items-input');
        const checkoutButton = document.getElementById('checkout-button');

        document.querySelectorAll('.add-to-order').forEach(button => {
            products.set(button.dataset.id, {
                id: button.dataset.id,
                name: button.dataset.name,
                price: Number(button.dataset.price),
                stock: Number(button.dataset.stock),
            });

            button.addEventListener('click', function () {
                addOrderItem(this.dataset.id);
            });
        });

        document.getElementById('product-search').addEventListener('input', function () {
            const term = this.value.trim().toLowerCase();

            document.querySelectorAll('.pos-product-card').forEach(card => {
                card.hidden = term && ! card.dataset.search.includes(term);
            });
        });

        document.getElementById('clear-order').addEventListener('click', function () {
            orderItems.splice(0, orderItems.length);
            tenderedInput.value = '0';
            updateOrderDetails();
        });

        tenderedInput.addEventListener('input', updateChange);

        document.getElementById('transaction-form').addEventListener('submit', function (event) {
            const totalAmount = Number(totalAmountInput.value);
            const tenderedAmount = Number(tenderedInput.value);

            if (orderItems.length === 0 || tenderedAmount < totalAmount) {
                event.preventDefault();
                tenderedInput.focus();
            }
        });

        function addOrderItem(productId) {
            const product = products.get(productId);
            const existingItem = orderItems.find(item => item.id === productId);

            if (! product) {
                return;
            }

            if (existingItem) {
                if (existingItem.quantity < product.stock) {
                    existingItem.quantity++;
                }
            } else if (product.stock > 0) {
                orderItems.push({ ...product, quantity: 1 });
            }

            updateOrderDetails();
        }

        function updateOrderDetails() {
            orderItemsContainer.innerHTML = '';
            let totalAmount = 0;
            let itemCount = 0;

            orderItems.forEach(item => {
                totalAmount += item.price * item.quantity;
                itemCount += item.quantity;

                const line = document.createElement('div');
                line.className = 'pos-cart-line';
                line.innerHTML = `
                    <div>
                        <strong>${item.name}</strong>
                        <span>PHP ${(item.price * item.quantity).toFixed(2)}</span>
                    </div>
                    <div class="pos-qty">
                        <button type="button" class="btn btn-sm btn-light decrease" data-id="${item.id}" aria-label="Decrease ${item.name}">-</button>
                        <span>${item.quantity}</span>
                        <button type="button" class="btn btn-sm btn-light increase" data-id="${item.id}" aria-label="Increase ${item.name}">+</button>
                        <button type="button" class="btn btn-sm btn-outline-danger remove" data-id="${item.id}" aria-label="Remove ${item.name}">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                `;
                orderItemsContainer.appendChild(line);
            });

            totalAmountEl.textContent = totalAmount.toFixed(2);
            totalAmountInput.value = totalAmount.toFixed(2);
            itemCountEl.textContent = itemCount;
            orderItemsInput.value = JSON.stringify(orderItems.map(({ id, quantity }) => ({ id, quantity })));
            emptyCart.hidden = orderItems.length > 0;

            document.querySelectorAll('.increase').forEach(button => button.addEventListener('click', () => changeQuantity(button.dataset.id, 1)));
            document.querySelectorAll('.decrease').forEach(button => button.addEventListener('click', () => changeQuantity(button.dataset.id, -1)));
            document.querySelectorAll('.remove').forEach(button => button.addEventListener('click', () => removeOrderItem(button.dataset.id)));

            updateChange();
        }

        function changeQuantity(productId, change) {
            const item = orderItems.find(item => item.id === productId);
            const product = products.get(productId);

            if (! item || ! product) {
                return;
            }

            item.quantity += change;

            if (item.quantity <= 0) {
                removeOrderItem(productId);
            } else if (item.quantity > product.stock) {
                item.quantity = product.stock;
                updateOrderDetails();
            } else {
                updateOrderDetails();
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
            const totalAmount = Number(totalAmountInput.value);
            const tenderedAmount = Number(tenderedInput.value);
            const change = tenderedAmount - totalAmount;

            changeEl.textContent = Math.max(change, 0).toFixed(2);
            changeAmountInput.value = Math.max(change, 0).toFixed(2);
            checkoutButton.disabled = orderItems.length === 0 || tenderedAmount < totalAmount;
        }

        updateOrderDetails();
    });
</script>
@endsection
