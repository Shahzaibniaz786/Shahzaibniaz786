<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Models\Account\Account;
use Illuminate\Validation\Rule;
use App\Models\Account\CashDeposit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PartyController;

class AccountController extends Controller
{
    static public function getAllAccounts()
    {
        return Account::all();
    }

    public function accountsList()
    {
        $accounts = Account::all();
        $cashdeposits = CashDeposit::all();
        return view('adminPanel.accounts.addAccounts', ['accounts' => $accounts, 'cashdeposits' => $cashdeposits]);
    }

    public function getAccount($id)
    {
        $account = Account::find($id);
        return response()->json(['data' => $account]);
    }

    public function fetchAllAcounts()
    {
        $account = $this->getAllAccounts();
        $parties = PartyController::getAllParties();
        return response()->json([
            'error' => false,
            'data' => [
                'accounts' => $account,
                'parties' => $parties
            ]
        ]);
    }


    public function addAccount(Request $request)
    {
        $request->validate([
            'account_name' => ['required', 'string', 'unique:accounts'],
            'openingBalance' => ['integer'],
            'accountNumber' => ['required', 'string'],
        ]);
        // dd($request);


        $result = Account::create([
            'account_name' => $request->account_name,
            'opening_balance' => $request->openingBalance,
            'balance' => $request->openingBalance,
            'account_number' => $request->accountNumber,
            'user_id' => Auth::user()->id,
        ]);

        if ($result) {
            return redirect()->back()->with(['success' => 'Account Added Successfully']);
        }
        return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
    }

    public function updateAccount(Request $request)
    {

        $account = Account::find($request->accountId);

        $request->validate([
            'accountId' => 'required',
        ]);

        $result = $account->update([
            'account_name' => $request->account_name,
            'account_number' => $request->accountNumber,
            'user_id' => Auth::user()->id,
        ]);

        if ($result) {
            return redirect()->back()->with(['success' => 'Account Updated Successfully']);
        }
        return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
    }
}
