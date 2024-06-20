<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use Carbon\Carbon;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $transactionsQuery = Transaction::query()->with('paymentmethods'); // Eager load the gender relationship
    
        if ($search) {
            $transactionsQuery->where(function ($query) use ($search) {
                $query->where('transaction_id', 'LIKE', "%{$search}%");
                    
                if (strtolower($search) == 'cash' || strtolower($search) == 'gcash' ||
                 strtolower($search) == 'maya' || strtolower($search) == 'credit' || strtolower($search) == 'debit' || strtolower($search) == 'savings') {
                    $query->orWhereHas('paymentmethods', function ($query) use ($search) {
                        $query->where('paymentmethods', $search);
                    });
                }
            });
        }
    
        $transactions = $transactionsQuery->simplePaginate(10); // Paginate the results
        $transactions->appends(['search' => $search]); // Append the search query to the pagination links
        return view('transactions.index', compact('transactions'));
    }
    
    public function create()
    {
        $products = Product::all();
        $paymentmethods = PaymentMethod::all();
        return view('transactions.create', compact('products', 'paymentmethods'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        // Validate the request
        $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'tendered' => 'required|numeric|min:0',
            'change' => 'required|numeric|min:0',
            'pmethod_id' => 'required|exists:paymentmethods,pmethod_id',
            'order_items' => 'required|json'
        ]);

        // Create a new transaction
        $transaction = Transaction::create([
            'total_amount' => $request->input('total_amount'),
            'tendered' => $request->input('tendered'),
            'change' => $request->input('change'),
            'pmethod_id' => $request->input('pmethod_id'),
            'user_id' => auth()->id(), // Assuming the user is authenticated
        ]);

        $orderItems = json_decode($request->order_items, true);
        foreach ($orderItems as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->transaction_id,
                'products_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Update stock quantity of products
            $product = Product::findOrFail($item['id']);
            $product->stock_quantity -= $item['quantity'];
            $product->save();
        }  
        
        // Get the transaction details
        $transaction_id = $transaction->transaction_id;
        $date = now()->format('Y-m-d H:i:s');
        $total_amount = $request->total_amount;
        $tendered = $request->tendered;
        $change = $request->change;
        $payment_method = PaymentMethod::find($request->pmethod_id)->paymentmethods; // Fetch the payment method name

        // Generate the receipt HTML
        $html = view('transactions.receipt', compact('transaction_id', 'date', 'orderItems', 'total_amount', 'tendered', 'change', 'payment_method'))->render();

        // Generate the PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('Letter', 'portrait');
        $dompdf->render();

        // Return the PDF as a downloadable response
        return response()->streamDownload(
            fn () => print($dompdf->output()),
            "receipt-{$transaction_id}.pdf",
            ['Content-Type' => 'application/pdf', 'X-Download-Complete' => 'true']
        );
    }


    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.view', compact('transaction'));
    }

    public function destroy($id)
    {
        // Find the user by ID and delete it
        // Find the user by ID
        $transaction = Transaction::findOrFail($id);
        // Delete the product
        $transaction->delete();

        // Redirect back with a success message
        return redirect()->route('transactions.index')->with('success', 'product deleted successfully.');
    }

    public function edit($id)
    {
        // Find the user by ID
        $transaction = Transaction::findOrFail($id);
        $paymentmethods = PaymentMethod::all();
        // Return the view with the user data
        return view('transactions.edit', compact('transaction', 'paymentmethods'));
    }

    public function update(Request $request, $id)
    {
        // Find the user by ID
        $transaction = Transaction::findOrFail($id);
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            
            'total_amount' => ['required'],
            'tendered' => ['required'],
            'change' => ['required'],
            'pmethod_id' => ['required'],

        ]);
    
        // Update the product with the new data
        $transaction->update($validatedData);
        
        // Redirect back with a success message
        return redirect()->route('transactions.index')->with('message_success', 'User updated successfully.');
    }
    public function nav() {
        return view('transactions.nav');
    }

    // TransactionController.php
    public function receipt(Transaction $transaction)
    {
        return view('transactions.receipt', compact('transaction'));
    }

    public function history(Request $request)
    {
        $transactionitemQuery = TransactionItem::query()->with('transactions');
        // Fetch transaction items from the database
        $transaction_items = TransactionItem::with('products')->get();
        
        $transaction_items = $transactionitemQuery->simplePaginate(15);
        return view('transactions.history', compact('transaction_items'));
    }

}
