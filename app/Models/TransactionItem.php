<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;
    protected $table ='transaction_items';
    protected $primaryKey = 'transaction_item_id';
    protected $fillable = [
        'transaction_id',
        'products_id',
        'quantity',
        'price',
    ];

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

}
