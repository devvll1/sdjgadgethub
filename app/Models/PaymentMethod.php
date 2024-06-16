<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;
    protected $table ='paymentmethods';
    protected $primaryKey = 'pmethod_id';
    protected $fillable = [
        'paymentmethods',
    ];
}
