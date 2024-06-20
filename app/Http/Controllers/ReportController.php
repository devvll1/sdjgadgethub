<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function showReport(Request $request)
    {
        // Calculate total amount and count of orders
        $totalAmount = Transaction::sum('total_amount');
        $totalOrders = Transaction::count();

        // Calculate weekly totals
        $weeklyTotals = Transaction::select(
            DB::raw('YEARWEEK(created_at) as week'),
            DB::raw('SUM(total_amount) as total_amount')
        )->groupBy('week')
        ->orderBy('week', 'asc')
        ->pluck('total_amount', 'week');

        // Calculate monthly totals
        $monthlyTotals = Transaction::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(total_amount) as total_amount')
        )->groupBy('month')
        ->orderBy('month', 'asc')
        ->pluck('total_amount', 'month');

        // Calculate yearly totals
        $yearlyTotals = Transaction::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total_amount) as total_amount')
        )->groupBy('year')
        ->orderBy('year', 'asc')
        ->pluck('total_amount', 'year');

        // Pass the data to the view
        return view('transactions.report', compact('totalAmount', 'totalOrders', 'weeklyTotals', 'monthlyTotals', 'yearlyTotals'));
    }
}
