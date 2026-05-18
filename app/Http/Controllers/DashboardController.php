<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'users' => User::count(),
            'transactions' => Transaction::count(),
            'revenue' => (float) Transaction::sum('total_amount'),
            'low_stock' => Product::where('stock_quantity', '<=', 10)->count(),
        ];

        $recentTransactions = Transaction::query()
            ->with('paymentMethod')
            ->latest('transaction_id')
            ->limit(5)
            ->get();

        $lowStockProducts = Product::query()
            ->where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'recentTransactions', 'lowStockProducts'));
    }
}
