<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionService
{
    /**
     * @param  array<int, array{id: int|string, quantity: int|string}>  $items
     */
    public function checkout(array $items, int $pmethodId, float $tendered, int $userId): Transaction
    {
        if (empty($items)) {
            throw ValidationException::withMessages([
                'order_items' => 'Add at least one product to the order.',
            ]);
        }

        return DB::transaction(function () use ($items, $pmethodId, $tendered, $userId) {
            $productIds = collect($items)->pluck('id')->unique()->values();
            $products = Product::query()
                ->whereIn('products_id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('products_id');

            $lineItems = [];
            $total = 0.0;

            foreach ($items as $item) {
                $productId = (int) $item['id'];
                $quantity = (int) $item['quantity'];

                if ($quantity < 1) {
                    throw ValidationException::withMessages([
                        'order_items' => 'Each line item must have a quantity of at least 1.',
                    ]);
                }

                $product = $products->get($productId);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'order_items' => "Product #{$productId} was not found.",
                    ]);
                }

                if ($product->stock_quantity < $quantity) {
                    throw ValidationException::withMessages([
                        'order_items' => "Insufficient stock for {$product->name}. Available: {$product->stock_quantity}.",
                    ]);
                }

                $unitPrice = (float) $product->price;
                $lineTotal = $unitPrice * $quantity;
                $total += $lineTotal;

                $lineItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                ];
            }

            $change = round($tendered - $total, 2);

            if ($change < 0) {
                throw ValidationException::withMessages([
                    'tendered' => 'Tendered amount is less than the order total.',
                ]);
            }

            $transaction = Transaction::create([
                'total_amount' => round($total, 2),
                'tendered' => round($tendered, 2),
                'change' => $change,
                'pmethod_id' => $pmethodId,
                'user_id' => $userId,
            ]);

            foreach ($lineItems as $line) {
                TransactionItem::create([
                    'transaction_id' => $transaction->transaction_id,
                    'products_id' => $line['product']->products_id,
                    'quantity' => $line['quantity'],
                    'price' => $line['unit_price'],
                ]);

                $line['product']->decrement('stock_quantity', $line['quantity']);
            }

            return $transaction->load(['paymentMethod', 'user', 'items.product']);
        });
    }

    public function restoreStockAndDelete(Transaction $transaction): void
    {
        DB::transaction(function () use ($transaction) {
            $items = $transaction->items()->with('product')->get();

            foreach ($items as $item) {
                if ($item->product) {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }

            $transaction->items()->delete();
            $transaction->delete();
        });
    }

    public function buildReceiptPdf(Transaction $transaction): string
    {
        $transaction->load(['items.product', 'paymentMethod']);

        $orderItems = $transaction->items->map(fn ($item) => [
            'id' => $item->products_id,
            'name' => $item->product?->name ?? 'Unknown',
            'quantity' => $item->quantity,
            'price' => $item->price,
        ])->all();

        $html = view('transactions.receipt', [
            'transaction_id' => $transaction->transaction_id,
            'date' => $transaction->created_at?->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s'),
            'orderItems' => $orderItems,
            'total_amount' => $transaction->total_amount,
            'tendered' => $transaction->tendered,
            'change' => $transaction->change,
            'payment_method' => $transaction->paymentMethod?->paymentmethods ?? 'N/A',
        ])->render();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('Letter', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
