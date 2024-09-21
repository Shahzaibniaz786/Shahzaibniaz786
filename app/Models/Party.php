<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'supplier_id',
        'opening_balance',
        'balance',
        'email',
        'company_name',
        'address',
        'user_id',
    ];

    public function updateBalance(float $price, string $type)
    {
        if ($type == 'increment') {
            $this->balance += $price;
        } else {
            $this->balance -= $price;
        }

        $this->save();
    }

    public function supplier()
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }
}
