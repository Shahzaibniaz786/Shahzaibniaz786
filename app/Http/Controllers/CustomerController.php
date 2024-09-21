<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function add_customer()
    {
        $customers = Customer::orderBy('id', 'ASC')->get();

        return view('adminpanel/customer/customer', compact('customers'));
    }


    public function save_customer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'opening_balance' => 'nullable|integer',
        ]);

        Customer::create([
            'customer_name' => $request->input('name'),
            'email' => $request->input('email'),
            'contact' => $request->input('contact'),
            'address' => $request->input('address'),
            'opening_balance' => $request->input('opening_balance'), // Fixed typo here
        ]);

        Accounts::create([
            'account_name' => $request->input('name'),
            'balance' => $request->input('opening_balance'), // Fixed typo here
            'opening_balance' => $request->input('opening_balance'), // Fixed typo here
            'user_id' => $request->input('opening_balance'), // Fixed typo here
        ]);

        return redirect()->back()->with('success', 'Customer added successfully!');
    }



    public function get_customer($id)
    {
        $customers = Customer::find($id);
        return response()->json(['data' => $customers]);
    }


    public function update_customer(Request $request)
    {
        $request->validate([
            'customerId' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'opening_balance' => 'nullable|integer',
        ]);

        $result = Customer::find($request->customerId)
            ->update([
                'customer_name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'address' => $request->address,
                'opening_balance' => $request->opening_balance,
            ]);
        if ($result) {
            return redirect()->back()->with(['success' => 'Customer Updated Successfully']);
        }
        return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
    }

    public function delete_customer(Request $request, $id)
    {
        $del_customer = Customer::find($id);

        $result = $del_customer->delete();
        if ($result) {
            return redirect()->back()->with(['success' => 'customer Deleted Successfully']);
        }
        return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
    }
}
