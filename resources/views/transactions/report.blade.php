@extends('layout.main')

@section('content')

@include('include.nav')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<body>
    <div class="container">
        <h1 class="mt-5">Transaction Report</h1>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Total Orders</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $totalOrders }}</td>
                    <td>{{ number_format($totalAmount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <h2 class="mt-5">Weekly Totals</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Week</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($weeklyTotals as $week => $amount)
                <tr>
                    <td>{{ $week }}</td>
                    <td>{{ number_format($amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="mt-5">Monthly Totals</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlyTotals as $month => $amount)
                <tr>
                    <td>{{ $month }}</td>
                    <td>{{ number_format($amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="mt-5">Yearly Totals</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($yearlyTotals as $year => $amount)
                <tr>
                    <td>{{ $year }}</td>
                    <td>{{ number_format($amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a class="btn btn-primary mt-5" href="{{ route('dashboard') }}">Return</a>
    </div>
</body>

@endsection
