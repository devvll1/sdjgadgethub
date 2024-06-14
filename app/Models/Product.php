<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table ='products';
    protected $primaryKey = 'products_id';
    protected $fillable = [
        'photo',
        'name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
