<!-- resources/views/receipt.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Receipt</h1>
            <p>Thank you for your purchase!</p>
        </div>
        <div class="content">
            <p><strong>Date:</strong> {{ $date }}</p>
            <p><strong>Transaction ID:</strong> {{ $transaction_id }}</p>
            <table>
                <thead>
                    <tr>
                        <th>Quantity</th>
                        <th>Product</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $item)
                        <tr>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['price'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Total Amount:</strong> {{ $total_amount }}</p>
            <p><strong>Tendered:</strong> {{ $tendered }}</p>
            <p><strong>Change:</strong> {{ $change }}</p>
            <p><strong>Payment Method:</strong> {{ $payment_method }}</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} DEV GADGETHUB. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
