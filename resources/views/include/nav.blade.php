
<style>
    .btn {
        padding: .45rem 1.5rem .35rem;
    }

    .gradient-custom {
        background: linear-gradient(to right, rgba(255, 235, 59, 1), rgba(0, 0, 0, 1));
    }

    .navbar-brand,
    .nav-link {
        color: #fff !important;
    }

    .nav-link .fa {
        margin-right: 5px;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler:focus {
        outline: none;
        box-shadow: none;
    }

    .dropdown-menu {
        background-color: #333;
    }

    .dropdown-item {
        color: #fff !important;
    }

    .dropdown-item:hover {
        background-color: #555;
    }

    .input-group .form-control {
        border-radius: 0;
    }

    .input-group .btn {
        border-radius: 0;
    }

    .navbar-brand img {
        height: 40px; /* Adjust the height according to your logo size */
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark gradient-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('img/login.png') }}" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-light"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                    <a class="nav-link" href="#!">
                        <i class="far fa-envelope"></i> Home
                    </a>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="far fa-envelope"></i> Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                        <li><a class="dropdown-item" href="#">Product List</a></li>
                        <li><a class="dropdown-item" href="#">Add Product</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="usersDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="far fa-envelope"></i> Users
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="usersDropdown">
                        <li><a class="dropdown-item" href="#">User List</a></li>
                        <li><a class="dropdown-item" href="{{ route('users.create') }}">Add User</a></li>
                        
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="far fa-envelope"></i> Order
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="orderDropdown">
                        <li><a class="dropdown-item" href="#">Order List</a></li>
                        <li><a class="dropdown-item" href="#">Add Order</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-globe-americas"></i> Logout
                    </a>
                </li>
            </ul>

            <form class="d-flex input-group w-auto ms-lg-3 my-3 my-lg-0">
                <input type="search" class="form-control" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-light" type="button" data-mdb-ripple-color="dark">
                    Search
                </button>
            </form>
        </div>
    </div>
</nav>

