<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductTypeController extends Controller
{
    public function productList()
    {
        $productTypes = ProductType::paginate(10);

        return view('adminPanel.orders.productType', ['productTypes' => $productTypes]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $result = ProductType::create([
            'name' => $request->name,
            'user_id' => Auth::user()->id
        ]);

        if ($result) {
            return redirect()->back()->with(['success' => 'Crop Service Type Added Successfully']);
        } else {
            return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
        }
    }

    public function getProduct($id)
    {
        $product = ProductType::find($id);
        return response()->json(['data' => $product]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'productId' => 'required'
        ]);

        $result = ProductType::find($request->productId)
            ->update(['name' => $request->name]);
        if ($result) {
            return redirect()->back()->with(['success' => 'Product Updated Successfully']);
        } else {
            return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
        }
    }
}
