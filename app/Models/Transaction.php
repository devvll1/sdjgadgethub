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
        'transaction_date',
        'total_amount',
        'pmethod_id',
        'user_id',
    ];

    public function paymentmethods()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
