<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'total_amount',
        'tendered',
        'change',
        'pmethod_id',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'tendered' => 'decimal:2',
            'change' => 'decimal:2',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'transaction_id';
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'pmethod_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }

    /** @deprecated Use paymentMethod() */
    public function paymentmethods()
    {
        return $this->paymentMethod();
    }

    /** @deprecated Use user() */
    public function users()
    {
        return $this->user();
    }
}
