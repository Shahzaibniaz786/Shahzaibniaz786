<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Account\AccountController;
use App\Models\Account\Account;
use App\Models\Account\AccountLedger;
use App\Models\Account\CashDeposit;
use App\Models\Account\MakePayment;
use App\Models\Account\MakePaymentItems;
use App\Models\Account\ReceivedPayment;
use App\Models\Account\ReceivedPaymentItems;
use App\Models\Order;
use App\Models\Party;
use App\Models\PartyLedger;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PartyReportsController extends Controller
{
    public function partyReports()
    {
        $parties = Party::get();
        $suppliers = Supplier::all();

        return view('adminPanel.party.partyReports.partyReports', ['suppliers' => $suppliers, 'parties' => $parties]);
    }

    public function partyWiseBalanceList(Request $request)
    {
        $supplier = null;
        if ($request->particularType == 'Customer') {
            $supplier = Supplier::find($request->supplier);
            $parties = Party::where('supplier_id', $request->supplier)
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $parties = Party::where('type', $request->particularType)
                ->orderBy('name', 'asc')
                ->get();
        }

        return view('adminPanel.party.partyReports.partyBalanceList', ['supplier' => $supplier, 'parties' => $parties, 'request' => $request->all()]);
    }

    public function allCustomerBalanceList()
    {
        $parties = Party::where('type', 'Customer')
            ->orderBy('name', 'asc')
            ->get();

        return view('adminPanel.party.partyReports.customersBalanceList', ['parties' => $parties]);
    }

    public function partyLastTranscation(Request $request)
    {
        $parties = Party::where('type', 'Customer')->get();

        $lastEntries = PartyLedger::selectRaw('MAX(id) as id')
            ->where('date', '<', $request->date)
            ->where('party_type', $request->particular)
            ->groupBy('party_id')
            ->get();

        // Now fetch the complete records based on the last entry IDs
        $partiesTranscations = PartyLedger::whereIn('id', $lastEntries->pluck('id'))->get();
        // dd($partiesTranscations);
        $partyLastTransArr = [];
        foreach ($partiesTranscations as $index => $partyTranscation) {
            $party = Party::find($partyTranscation->party_id);
            $partyLastTransArr[] = (object) [
                'id' => $party->id,
                'name' => $party->name,
                'balance' => $party->balance,
                'lastTranscation' => $partyTranscation->date,
                'supplier' => $party->supplier->name ?? '',
            ];
        }


        $partyLastTransCollection = collect($partyLastTransArr)->sortByDesc('name');

        // If you need it back as an array
        $partyLastTransArr = $partyLastTransCollection->values()->all();

        return view('adminPanel.party.partyReports.partyLastTransaction', ['partyLastTransArr' => $partyLastTransArr, 'type' => $request->particular, 'from_date' => $request->date]);
    }

    public function partyStatements()
    {
        $parties = Party::get();
        $suppliers = Supplier::all();
        $accounts = AccountController::getAllAccounts();

        return view('adminPanel.party.partyReports.partyStatements', ['suppliers' => $suppliers, 'parties' => $parties, 'accounts' => $accounts]);
    }

    public function generatePartyStatement(Request $request)
    {

        $party = Party::find($request->partyId);

        if ($party->type == 'Marka') {
            $orders = Order::where('marka_id', $request->partyId)->get();
        }

        if ($party->type == 'Driver') {
            $orders = Order::where('driver_id', $request->partyId)->get();
        }

        if ($party->type == 'Customer') {
            $orders = Order::where('customer_id', $request->partyId)->get();
        }

        $makePayments = MakePaymentItems::join('make_payments', 'make_payment_items.make_payment_id', '=', 'make_payments.id')
            ->where('make_payment_items.particular_id', $request->partyId)
            ->where('make_payment_items.particular', 'Party')
            ->get(['make_payment_items.*', 'make_payments.*', 'make_payments.id as payment_id']);

        $receivedPayments = ReceivedPaymentItems::join('received_payments', 'received_payment_items.received_payment_id', '=', 'received_payments.id')
            ->where('received_payment_items.particular_id', $request->partyId)
            ->where('received_payment_items.particular', 'Party')
            ->get(['received_payment_items.*', 'received_payments.*', 'received_payments.id as received_id']);

        $ordersCollection = collect($orders);
        $makePaymentsCollection = collect($makePayments);
        $receivedPaymentsCollection = collect($receivedPayments);

        $mergedCollection = $ordersCollection->merge($makePaymentsCollection)->merge($receivedPaymentsCollection);

        // Sort the merged collection by the date column in ascending order
        $sortedCollection = $mergedCollection->sortBy('date')->values();

        // Find the next party ID
        $nextParty = Party::where('id', '>', $request->partyId)
            ->where('type', $party->type)
            ->orderBy('id')
            ->first();
        $nextPartyId = $nextParty ? $nextParty->id : null;

        // Find the previous party ID of the same type
        $previousParty = Party::where('id', '<', $request->partyId)
            ->where('type', $party->type)
            ->orderBy('id', 'desc')
            ->first();
        $previousPartyId = $previousParty ? $previousParty->id : null;

        // Convert the sorted collection to an array if needed
        $sortedArray = $sortedCollection;
        return view('adminPanel.party.partyReports.partyStatementPrint', compact('party', 'sortedArray', 'nextPartyId', 'previousPartyId'));
    }

    public function generateAccountStatement(Request $request)
    {
        $account = Account::find($request->account_id);

        $makePayments = MakePayment::where('account_id', $request->account_id)
            ->select('make_payments.*', 'make_payments.id as main_make_payment_id')
            ->get();
        $receivedPayments = ReceivedPayment::where('account_id', $request->account_id)
            ->select('received_payments.*', 'received_payments.id as main_received_payment_id')
            ->get();

        $makePaymentItems = MakePaymentItems::join('make_payments', 'make_payment_items.make_payment_id', '=', 'make_payments.id')
            ->where('make_payment_items.particular_id', $request->account_id)
            ->where('make_payment_items.particular', 'Account')
            ->get(['make_payment_items.*', 'make_payment_items.id as payment_item_id', 'make_payments.*', 'make_payments.id as payment_id']);

        $receivedPaymentsItems = ReceivedPaymentItems::join('received_payments', 'received_payment_items.received_payment_id', '=', 'received_payments.id')
            ->where('received_payment_items.particular_id', $request->account_id)
            ->where('received_payment_items.particular', 'Account')
            ->get(['received_payment_items.*', 'received_payment_items.id as received_item_id', 'received_payments.*', 'received_payments.id as received_id']);

        $cashDeposit = CashDeposit::where('account_id', $request->account_id)
            ->select('cash_deposits.*', 'cash_deposits.created_at as date')
            ->get();

        $makePaymentsCollection = collect($makePayments);
        $receivedPaymentsCollection = collect($receivedPayments);
        $makePaymentItemsCollection = collect($makePaymentItems);
        $receivedPaymentsItemsCollection = collect($receivedPaymentsItems);
        $cashDepositCollection = collect($cashDeposit);

        $mergedCollection = $makePaymentsCollection->merge($receivedPaymentsCollection)
            ->merge($makePaymentItemsCollection)
            ->merge($receivedPaymentsItemsCollection)
            ->merge($cashDepositCollection);

        // Sort the merged collection by the date column in ascending order
        $sortedCollection = $mergedCollection->sortBy('date')->values();

        // Find the next party ID
        $nextParty = Account::where('id', '>', $request->account_id)
            ->orderBy('id')
            ->first();
        $nextPartyId = $nextParty ? $nextParty->id : null;

        // Find the previous party ID of the same type
        $previousParty = Account::where('id', '<', $request->account_id)
            ->orderBy('id', 'desc')
            ->first();
        $previousPartyId = $previousParty ? $previousParty->id : null;

        // Convert the sorted collection to an array if needed
        $sortedArray = $sortedCollection;

        return view('adminPanel.accounts.accountReports.accountStatementPrint', compact('account', 'sortedArray', 'previousPartyId', 'nextPartyId'));
    }

    public function generateAccountStatementDateWise(Request $request)
    {
        $account = Account::find($request->account_id);
        $ledgerLastTranscation = AccountLedger::where('account_id', $request->account_id)
            ->whereDate('date', '<', $request->start_date)
            ->latest()->first();

        $makePayments = MakePayment::where('account_id', $request->account_id)
            ->whereBetween('make_payments.date', [$request->start_date, $request->end_date])
            ->select('make_payments.*', 'make_payments.id as main_make_payment_id')
            ->get();
        $receivedPayments = ReceivedPayment::where('account_id', $request->account_id)
            ->whereBetween('received_payments.date', [$request->start_date, $request->end_date])
            ->select('received_payments.*', 'received_payments.id as main_received_payment_id')
            ->get();

        $makePaymentItems = MakePaymentItems::join('make_payments', 'make_payment_items.make_payment_id', '=', 'make_payments.id')
            ->where('make_payment_items.particular_id', $request->account_id)
            ->where('make_payment_items.particular', 'Account')
            ->whereBetween('make_payments.date', [$request->start_date, $request->end_date])
            ->get(['make_payment_items.*', 'make_payment_items.id as payment_item_id', 'make_payments.*', 'make_payments.id as payment_id']);

        $receivedPaymentsItems = ReceivedPaymentItems::join('received_payments', 'received_payment_items.received_payment_id', '=', 'received_payments.id')
            ->where('received_payment_items.particular_id', $request->account_id)
            ->where('received_payment_items.particular', 'Account')
            ->whereBetween('received_payments.date', [$request->start_date, $request->end_date])
            ->get(['received_payment_items.*', 'received_payment_items.id as received_item_id', 'received_payments.*', 'received_payments.id as received_id']);

        $cashDeposit = CashDeposit::where('account_id', $request->account_id)
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->select('cash_deposits.*', 'cash_deposits.created_at as date')
            ->get();

        $makePaymentsCollection = collect($makePayments);
        $receivedPaymentsCollection = collect($receivedPayments);
        $makePaymentItemsCollection = collect($makePaymentItems);
        $receivedPaymentsItemsCollection = collect($receivedPaymentsItems);
        $cashDepositCollection = collect($cashDeposit);

        $mergedCollection = $makePaymentsCollection->merge($receivedPaymentsCollection)
            ->merge($makePaymentItemsCollection)
            ->merge($receivedPaymentsItemsCollection)
            ->merge($cashDepositCollection);

        // Sort the merged collection by the date column in ascending order
        $sortedCollection = $mergedCollection->sortBy('date')->values();

        // Convert the sorted collection to an array if needed
        $sortedArray = $sortedCollection;
        $request_data = $request->all();

        // Find the previous party based on the given criteria
        $previousParty = Account::where('id', '<', $request->account_id)
            ->whereBetween('created_at', [$request->start_date, $request->end_date]) // Assuming created_at is the date column
            ->orderBy('id', 'desc')
            ->first();

        // Find the next party based on the given criteria
        $nextParty = Account::where('id', '>', $request->account_id)
            ->whereBetween('created_at', [$request->start_date, $request->end_date]) // Assuming created_at is the date column
            ->orderBy('id')
            ->first();

        // Get the previous and next party IDs
        $previousPartyId = $previousParty ? $previousParty->id : null;
        $nextPartyId = $nextParty ? $nextParty->id : null;

        return view('adminPanel.accounts.accountReports.accountStatementDateWise', compact('account', 'sortedArray', 'request_data', 'ledgerLastTranscation', 'previousPartyId', 'nextPartyId'));
    }

    public function partyStatementDateWise(Request $request)
    {
        // dd($request);
        $party = Party::find($request->partyId);
        $ledgerLastTranscation = PartyLedger::where('party_id', $request->partyId)
            ->whereDate('date', '<', $request->start_date)
            ->latest()->first();

        if ($party->type == 'Marka') {
            $orders = Order::where('marka_id', $request->partyId)
                ->whereBetween('date', [$request->start_date, $request->end_date])
                ->get();
        }

        if ($party->type == 'Driver') {
            $orders = Order::where('driver_id', $request->partyId)
                ->whereBetween('date', [$request->start_date, $request->end_date])
                ->get();
        }

        if ($party->type == 'Customer') {
            $orders = Order::where('customer_id', $request->partyId)
                ->whereBetween('date', [$request->start_date, $request->end_date])
                ->get();
        }

        $makePayments = MakePaymentItems::join('make_payments', 'make_payment_items.make_payment_id', '=', 'make_payments.id')
            ->where('make_payment_items.particular_id', $request->partyId)
            ->where('make_payment_items.particular', 'Party')
            ->whereBetween('make_payments.date', [$request->start_date, $request->end_date])
            ->get(['make_payment_items.*', 'make_payments.*', 'make_payments.id as payment_id']);

        $receivedPayments = ReceivedPaymentItems::join('received_payments', 'received_payment_items.received_payment_id', '=', 'received_payments.id')
            ->where('received_payment_items.particular_id', $request->partyId)
            ->where('received_payment_items.particular', 'Party')
            ->whereBetween('received_payments.date', [$request->start_date, $request->end_date])
            ->get(['received_payment_items.*', 'received_payments.*', 'received_payments.id as received_id']);

        $ordersCollection = collect($orders);
        $makePaymentsCollection = collect($makePayments);
        $receivedPaymentsCollection = collect($receivedPayments);

        $mergedCollection = $ordersCollection->merge($makePaymentsCollection)->merge($receivedPaymentsCollection);

        // Sort the merged collection by the date column in ascending order
        $sortedCollection = $mergedCollection->sortBy('date')->values();

        $previousParty = Party::where('type', $party->type)
        ->where('id', '<', $request->partyId)
        ->whereDate('created_at', '<=', $request->end_date) // Corrected to match the field name
        ->orderBy('id', 'desc')
        ->first();

        $nextParty = Party::where('type', $party->type)
        ->where('id', '>', $request->partyId)
        ->whereDate('created_at', '>=', $request->start_date) // Corrected to match the field name
        ->orderBy('id')
        ->first();


        // Get the previous and next party IDs
        $previousPartyId = $previousParty ? $previousParty->id : null;
        $nextPartyId = $nextParty ? $nextParty->id : null;

        // Convert the sorted collection to an array if needed
        $sortedArray = $sortedCollection;
        $request = $request->all();
        return view('adminPanel.party.partyReports.partyStatementDateWise', compact('party', 'sortedArray', 'request', 'ledgerLastTranscation', 'previousPartyId', 'nextPartyId'));
    }
}
