<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Customer;
use App\Models\Nozzale;
use Illuminate\Http\Request;

class NozzaleController extends Controller
{
    public function add_nozzale()
    {
        return view('pages/nozeel');
    }


    public function save_nozzale(Request $request)
    {
        $request->validate([
            'date' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'opening_reading' => 'required|string|max:255',
        ]);

        Nozzale::create([
            'date' => $request->input('date'),
            'nozzale_name' => $request->input('name'),
            'opening_reading' => $request->input('opening_reading'),
        ]);

        return redirect()->back()->with('success', 'Nozzale added successfully!');
    }
}    
