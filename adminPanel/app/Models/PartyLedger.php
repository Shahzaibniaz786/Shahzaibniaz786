<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'party_id',
        'party_type',
        'payment',
        'received',
        'price',
        'balance',
        'payment_id',
        'recevied_id',
        'order_id',
        'remarks',
        'user_id'
    ];
}
