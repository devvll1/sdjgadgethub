<nav class="navbar navbar-expand-lg navbar-dark navbar-brand-gradient shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <img src="{{ asset('img/login.png') }}" alt="SDJ Gadget Hub" height="36">
            <span class="font-display d-none d-md-inline">SDJ Gadget Hub</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                @if(auth()->user()?->isAdmin())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-box-seam me-1"></i> Products
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="productsDropdown">
                        <li><a class="dropdown-item" href="{{ route('products.index') }}">Product list</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.create') }}">Add product</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-people me-1"></i> Users
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="usersDropdown">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}">User list</a></li>
                        <li><a class="dropdown-item" href="{{ route('users.create') }}">Add user</a></li>
                    </ul>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-cart-check me-1"></i> Orders
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="orderDropdown">
                        @if(auth()->user()?->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('transactions.index') }}">Transactions</a></li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('transactions.history') }}">History</a></li>
                        <li><a class="dropdown-item" href="{{ route('transactions.create') }}">New sale</a></li>
                        @if(auth()->user()?->isAdmin())
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('transactions.report') }}">Reports</a></li>
                        @endif
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <span class="nav-link text-white-50 d-none d-lg-inline">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ session('myFullName', auth()->user()?->full_name) }}
                        <span class="badge rounded-pill text-bg-light text-dark ms-1">{{ ucfirst(auth()->user()?->role ?? 'cashier') }}</span>
                    </span>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm ms-lg-2">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
