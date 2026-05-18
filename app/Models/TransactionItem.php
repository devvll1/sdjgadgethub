<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $table = 'transaction_items';

    protected $primaryKey = 'transaction_item_id';

    protected $fillable = [
        'transaction_id',
        'products_id',
        'quantity',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    /** @deprecated Use transaction() */
    public function transactions()
    {
        return $this->transaction();
    }

    /** @deprecated Use product() */
    public function products()
    {
        return $this->product();
    }
}
