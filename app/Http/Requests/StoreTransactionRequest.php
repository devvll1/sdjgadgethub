<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tendered' => ['required', 'numeric', 'min:0'],
            'pmethod_id' => ['required', 'exists:paymentmethods,pmethod_id'],
            'order_items' => ['required', 'json'],
        ];
    }

    /**
     * @return array<int, array{id: int, quantity: int}>
     */
    public function orderItems(): array
    {
        $items = json_decode($this->input('order_items'), true);

        if (! is_array($items)) {
            return [];
        }

        return collect($items)
            ->map(fn ($item) => [
                'id' => (int) ($item['id'] ?? 0),
                'quantity' => (int) ($item['quantity'] ?? 0),
            ])
            ->filter(fn ($item) => $item['id'] > 0 && $item['quantity'] > 0)
            ->values()
            ->all();
    }
}
