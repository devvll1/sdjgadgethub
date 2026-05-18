<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function __construct(
        private readonly TransactionService $transactionService
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $transactionsQuery = Transaction::query()->with('paymentMethod');

        if ($search) {
            $transactionsQuery->where(function ($query) use ($search) {
                $query->where('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('paymentMethod', function ($paymentQuery) use ($search) {
                        $paymentQuery->where('paymentmethods', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $transactionsQuery
            ->latest('transaction_id')
            ->simplePaginate(10)
            ->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $paymentmethods = PaymentMethod::orderBy('paymentmethods')->get();

        return view('transactions.create', compact('products', 'paymentmethods'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = $this->transactionService->checkout(
            $request->orderItems(),
            (int) $request->input('pmethod_id'),
            (float) $request->input('tendered'),
            (int) auth()->id()
        );

        $pdf = $this->transactionService->buildReceiptPdf($transaction);

        return response()->streamDownload(
            fn () => print($pdf),
            "receipt-{$transaction->transaction_id}.pdf",
            ['Content-Type' => 'application/pdf', 'X-Download-Complete' => 'true']
        );
    }

    public function show($id)
    {
        $transaction = Transaction::with(['paymentMethod', 'user', 'items.product'])->findOrFail($id);

        return view('transactions.view', compact('transaction'));
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->transactionService->restoreStockAndDelete($transaction);

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted and stock restored.');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $paymentmethods = PaymentMethod::orderBy('paymentmethods')->get();

        return view('transactions.edit', compact('transaction', 'paymentmethods'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $validated = $request->validate([
            'total_amount' => ['required', 'numeric', 'min:0'],
            'tendered' => ['required', 'numeric', 'min:0'],
            'change' => ['required', 'numeric', 'min:0'],
            'pmethod_id' => ['required', 'exists:paymentmethods,pmethod_id'],
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function nav()
    {
        return view('transactions.nav');
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load(['items.product', 'paymentMethod']);

        return view('transactions.receipt', [
            'transaction_id' => $transaction->transaction_id,
            'date' => $transaction->created_at?->format('Y-m-d H:i:s'),
            'orderItems' => $transaction->items->map(fn ($item) => [
                'id' => $item->products_id,
                'name' => $item->product?->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ])->all(),
            'total_amount' => $transaction->total_amount,
            'tendered' => $transaction->tendered,
            'change' => $transaction->change,
            'payment_method' => $transaction->paymentMethod?->paymentmethods,
        ]);
    }

    public function history(Request $request)
    {
        $search = $request->input('search');

        $transactionItemsQuery = TransactionItem::query()
            ->with(['product', 'transaction'])
            ->latest('transaction_item_id');

        if ($search) {
            $transactionItemsQuery->where(function ($query) use ($search) {
                $query->where('transaction_id', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $transaction_items = $transactionItemsQuery
            ->simplePaginate(15)
            ->withQueryString();

        return view('transactions.history', compact('transaction_items'));
    }
}
