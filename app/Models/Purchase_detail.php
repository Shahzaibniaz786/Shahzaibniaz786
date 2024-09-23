<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'stock',
        'cost_price',
        'qty',
        'total',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchases::class);
    }
}
