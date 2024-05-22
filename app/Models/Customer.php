<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table ='customers';
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'gender_id',
        'email',
        'phone',
        'address',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
