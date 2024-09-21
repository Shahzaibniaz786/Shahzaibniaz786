<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
  
class PartyController extends Controller
{
    public function addParty(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'type' => ['required', 'in:Marka,Driver,Customer'],
            'opening_balance' => ['integer'],
            'balance' => ['integer'],
            'email' => ['nullable', 'email', 'unique:parties'],
        ]);

        $result = Party::create([
            'name' => $request->name,
            'type' => $request->type,
            'supplier_id' => $request->supplier_id,
            'opening_balance' => $request->openingBalance,
            'balance' => $request->openingBalance,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'user_id' => Auth::user()->id,
        ]);

        if ($result) {
            return redirect()->back()->with(['success' => 'Party Added Successfully']);
        }
        return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
    }

    public function addPartyWithAjax(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'type' => ['required', 'in:Marka,Driver,Customer'],
            'opening_balance' => ['integer'],
            'balance' => ['integer'],
            'email' => ['nullable', 'email', 'unique:parties'],
        ]);

        $result = Party::create([
            'name' => $request->name,
            'type' => $request->type,
            'supplier_id' => $request->supplier_id,
            'opening_balance' => $request->openingBalance,
            'balance' => $request->openingBalance,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'user_id' => Auth::user()->id,
        ]);

        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Party Added Successfully',
            ]);
        }
        return response()->json([
            'error' => true,
            'message' => 'Something Went Wrong Try Again',
        ]);
    }

    public function fetchPartieswithTypes($type)
    {
        $parties = Party::where('type', $type)->get();
        return response()->json([
            'error' => false,
            'data' => [
                'parties' => $parties
            ]
        ]);
    }

    public function getpartiesList()
    {
        $allParties = $this->getPartiesWithPagination(5);
        $suppliers = Supplier::all();
        return view('adminPanel.party.partyList', ['parties' => $allParties, 'suppliers' => $suppliers]);
    }

    public function getParty($id)
    {
        $party = Party::find($id);
        return response()->json(['data' => $party]);
    }

    public function updateParty(Party $party, Request $request)
    {
        $request->validate([
            'partyId' => 'required'
        ]);

        $result = Party::find($request->partyId)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'company_name' => $request->company_name,
                'address' => $request->address,
            ]);

        if ($result) {
            return redirect()->back()->with(['success' => 'Party Updated Successfully']);
        }
        return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
    }

    static public function getAllParties(): Collection
    {
        return Party::all();
    }

    public function getPartiesWithPagination(int $items)
    {
        $parties = Party::OrderBy('id', 'desc')->paginate($items);
        return $parties;
    }
}
