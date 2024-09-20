<?php

namespace App\Http\Controllers;

use App\Models\Account\Account;
use App\Models\Account\AccountLedger;
use App\Models\Account\expense;
use App\Models\Account\MakePayment;
use App\Models\Account\ReceivedPayment;
use App\Models\Supplier;
use App\Models\Order;
use Illuminate\Http\Request;

class SummaryReportController extends Controller
{
    public function summaryReports()
    {
        $suppliers = Supplier::all();
        $accounts = Account::all();
        return view('adminPanel.Summary.summaryReports',compact('suppliers','accounts'));
    }

    public function daySummary(Request $request)
    {
        $orders = Order::where('date', $request->date)->get();
        $expense = expense::join('expense_categories', 'expense_categories.id', '=', 'expenses.category_id') // joining the contacts table , where user_id and contact_user_id are same
            ->join('accounts', 'accounts.id', '=', 'expenses.account_id')
            ->join('expense_sub_categories', 'expense_sub_categories.id', '=', 'expenses.sub_category_id') // joining the contacts table , where user_id and contact_user_id are same
            ->where('date', $request->date)
            ->select('expenses.*', 'expense_categories.exp_category_name', 'accounts.account_name', 'accounts.account_number', 'expense_sub_categories.exp_sub_category')
            ->get();

        $makePayment = MakePayment::with('paymentItems')->where('date', $request->date)->get();
        $reaceivedPayment = ReceivedPayment::with('paymentItems')->where('date', $request->date)->get();

        $date = $request->date;
        return view('adminPanel.Summary.daySummary', compact('orders', 'expense', 'makePayment', 'reaceivedPayment', 'date'));
    }

    public function supplierWiseSummary(Request $request)
    {
        $supplier = $request->supplier;
        $date = $request->date;
        $account = $request->account;
    
        $orders = Order::where('supplier_id', $supplier)
                       ->where('date', $date)
                       ->get(); 
                      // Fetch account ledger summaries
    $accountSums = AccountLedger::where('account_id', $account)
                                ->whereDate('date', $date)
                                ->selectRaw('SUM(payment) as total_payment, SUM(received) as total_received')
                                ->first();

    // Handle case where no account ledger records are found
    $accountPayment = $accountSums ? $accountSums->total_payment : 0;
    $accountReceived = $accountSums ? $accountSums->total_received : 0;

    // Get the last transaction record based on date
    $lastTransaction = AccountLedger::where('account_id', $account)
                                    ->whereDate('date', $date)
                                    ->orderBy('created_at','desc')
                                    ->first();

    // Calculate the balance
    $balance = 0;
    if ($lastTransaction) {
        $balance = $lastTransaction->balance; // Assuming balance is stored directly in the record
    }
    $accountPayment = $accountSums->total_payment;
    $accountReceived = $accountSums->total_received;
     $makePayment = MakePayment::with('paymentItems')
                               ->where('date', $date)
                               ->where('account_id', $account)
                               ->get();
 
     $receivedPayment = ReceivedPayment::with('paymentItems')
                                       ->where('date', $date)
                                       ->where('account_id', $account)
                                       ->get();
 

        return view('adminPanel.Summary.supplierWiseSummary', compact('orders','accountPayment','accountReceived', 'makePayment', 'receivedPayment', 'date', 'supplier','balance'));
    }
    
}
