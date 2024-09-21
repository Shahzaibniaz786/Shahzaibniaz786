<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $fillable = ['account_name', 'balance', 'opening_balance', 'account_number', 'user_id'];

    // Mutator to set a serial number prefix for the 'user' field
    public function setAccountNameAttribute($value)
    {
        // Initialize prefix
        $prefix = '';

        // Determine the prefix based on the route (Customer or Supplier)
        if (request()->routeIs('customer.save')) {
            $prefix = 'c'; // Prefix for Customer
        } elseif (request()->routeIs('add_supplier')) {
            $prefix = 's'; // Prefix for Supplier
        }

        // Get the latest account with the same prefix
        $lastAccount = self::where('account_name', 'like', $prefix . '%')->latest('id')->first();

        // Determine the next serial number
        if ($lastAccount && preg_match('/' . $prefix . '(\d+)/', $lastAccount->account_name, $matches)) {
            // Increment the last serial number by 1
            $serialNumber = intval($matches[1]) + 1;
        } else {
            // Start at 1 if no matching accounts are found
            $serialNumber = 1;
        }

        // Format the serial number with leading zeros (e.g., 001, 002, etc.)
        $formattedSerialNumber = str_pad($serialNumber, 3, '0', STR_PAD_LEFT);

        // Set the account_name with the prefix and formatted serial number
        $this->attributes['account_name'] = $prefix . $formattedSerialNumber . $value;
    }
}
