<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_ledger;
use App\Models\Product_stock;
use App\Models\Purchase_detail;
use App\Models\Purchases;
use App\Models\Supplier;
use App\Models\Supplier_ledger;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show_purchase_page(){

        $products = Product::get();
        $suppliers = Supplier::get();

        return view('adminpanel/purchase/purchase',compact('products', 'suppliers'));
    }

    public function fetchProductDetails(Request $request)
    {
        $product = Product::find($request->product_id);
        $stock = Product_stock::find($request->product_id);

        if ($product) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'stock' => $stock->stock,
                    'cost_price' => $product->cost_price, // Adjust as per your model
                    'qty' => 1, // Set the initial quantity (or modify as needed)
                    'total' => $product->cost_price // Adjust as per your logic
                ]
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function save_purchase(Request $request)
    {
        $purchase = $request->validate([
            'supplier_name' => 'required',
            'total_bill' => 'required|integer|max:255',
            'adjustment' => 'required|integer|max:255',
        ]);

        if($purchase){
            $purchase = new Purchases();
            $purchase->date = $request->date;
            $purchase->supplier_id = $request->supplier_name;
            $purchase->total_bill = $request->total_bill;
            $purchase->adjustment = $request->adjustment;
            $purchase->save();

            for ($i = 0; $i < count($request->pro_id); $i++) {
                // Check if the product ID, stock, and quantity are set for the current iteration
                if (isset($request->pro_id[$i]) && isset($request->stock[$i]) && isset($request->qty[$i])) {
                $purchaseDetail = new Purchase_detail();
                $purchaseDetail->purchase_id = $purchase->id;  // Reference the purchase
                $purchaseDetail->product_id = $request->pro_id[$i];
                $purchaseDetail->stock = $request->stock[$i];
                $purchaseDetail->cost_price = $request->cost_price[$i];
                $purchaseDetail->qty = $request->qty[$i];
                $purchaseDetail->total = $request->total[$i];
                $purchaseDetail->save();
            }
                $productStock = Product_stock::where('product_id', $request->pro_id[$i])->first();  

                if ($productStock) {
                    $productStock->stock += $request->qty[$i];  
                    $productStock->save();  
                }


                for ($i = 0; $i < count($request->pro_id); $i++) {
                    if (isset($request->pro_id[$i]) && isset($request->stock[$i]) && isset($request->qty[$i])) {
                        $purchase_ledger = new Product_ledger();
                        $purchase_ledger->product_id = $request->pro_id[$i];
                        $purchase_ledger->purchase_id = $purchase->id;
                        $purchase_ledger->supplier_id = $request->supplier_name;
                        $purchase_ledger->purchase_stock = $request->qty[$i];
                        $purchase_ledger->balance = $request->total[$i];
                        $purchase_ledger->save();
                    }
                    // for supplier ledger

                for ($i = 0; $i < count($request->pro_id); $i++) {
                    if (isset($request->pro_id[$i]) && isset($request->stock[$i]) && isset($request->qty[$i])) {
                        $supplier_ledger = new Supplier_ledger();
                        $supplier_ledger->product_id = $request->pro_id[$i];
                        $supplier_ledger->purchase_id = $purchase->id;
                        $supplier_ledger->supplier_id = $request->supplier_name;
                        $supplier_ledger->amount = $request->total[$i];
                        $supplier_ledger->balance = $request->total[$i];
                        $supplier_ledger->save();
                    }
           
            return redirect()->back()->with('success', 'Purchase added successfully!');
        }
    }


}
}
}
}
