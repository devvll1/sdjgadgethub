<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table ='transactions';
    protected $primaryKey = 'transaction_id';
    protected $fillable = [
        'total_amount',
        'tendered',
        'change',
        'pmethod_id',
        'user_id',
    ];

    public function paymentmethods()
    {
        return $this->belongsTo(PaymentMethod::class, 'pmethod_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function items()
{
    return $this->hasMany(TransactionItem::class, 'transaction_id');
}

}
