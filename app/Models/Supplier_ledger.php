<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'purchase_id',
        'product_id',
        'amount',
        'debit',
        'credit',
        'balance',
    ];
}
