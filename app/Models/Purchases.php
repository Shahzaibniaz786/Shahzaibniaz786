<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'supplier_id',
        'total_bill',
        'adjustment',
    ];

    public function purchaseDetails()
    {
        return $this->hasMany(Purchase_detail::class);
    }
}
