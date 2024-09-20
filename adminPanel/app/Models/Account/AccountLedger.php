<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'payment',
        'received',
        'balance',
        'deposit_id',
        'payment_id',
        'sub_payment_id',
        'sub_recevied_payment_id',
        'received_id',
        'expense_id',
        'account_id',
        'remarks',
        'user_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
