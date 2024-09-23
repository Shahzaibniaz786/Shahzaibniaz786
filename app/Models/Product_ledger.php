<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sale_id',
        'purchase_id',
        'supplier_id',
        'sale_stock',
        'purchase_stock',
        'balance',
    ];

}   