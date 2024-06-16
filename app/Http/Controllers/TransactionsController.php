<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PaymentMethod;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;


class TransactionsController extends Controller
{
    public function create()
    {
        $products = Product::all();
        $paymentmethods = PaymentMethod::all();
        return view('transactions.create', compact('products', 'paymentmethods'));
    }

    public function store(Request $request)
    {
            // Validate the request data (if needed)
    
            // Calculate change (if necessary)
            $totalAmount = floatval($request->total_amount);
            $tendered = floatval($request->tendered);
            $change = $tendered - $totalAmount;
    
            // Create a new transaction record
            $transaction = new Transaction();
            $transaction->total_amount = $totalAmount;
            $transaction->tendered = $tendered;
            $transaction->change = $change;
            $transaction->pmethod_id = $request->payment_method;
            $transaction->user_id = Auth::id(); // Assuming you are using authentication
            $transaction->save();
    
            // Save transaction items
            foreach ($request->order_items as $item) {
                $transactionItem = new TransactionItem();
                $transactionItem->transaction_id = $transaction->transaction_id; // Use the ID of the saved transaction
                $transactionItem->product_id = $item['product_id'];
                $transactionItem->quantity = $item['quantity'];
                $transactionItem->price = $item['price'];
                $transactionItem->save();
    
                // Update product stock quantity
                $product = Product::find($item['product_id']);
                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }
    
            // Redirect or return a response as needed
            return redirect()->back()->with('success', 'Transaction completed successfully.');
    }
}
