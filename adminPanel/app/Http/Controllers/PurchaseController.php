<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show_purchase_page(){

        $products = Product::get();

        return view('adminpanel/purchase/purchase',compact('products'));
    }

    public function fetchProductDetails(Request $request)
    {
        $product = Product::find($request->product_id);

        if ($product) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'stock' => $product->opening_stock,
                    'cost_price' => $product->cost_price, // Adjust as per your model
                    'qty' => 1, // Set the initial quantity (or modify as needed)
                    'total' => $product->cost_price // Adjust as per your logic
                ]
            ]);
        }

        return response()->json(['success' => false]);
    }

}
