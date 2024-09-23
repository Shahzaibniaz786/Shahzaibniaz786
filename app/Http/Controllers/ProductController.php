<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_rate;
use App\Models\Product_stock;
use App\Models\Supplier;

class ProductController extends Controller
{
    public function add_product()
    {
        $suppliers = Supplier::orderBy('name', 'ASC')->get();
        $products = Product::get();
        

        return view('adminpanel/product/product',compact('suppliers','products'));
    }


    public function save_product(Request $request)
    {
        $request->validate([
            'product_code' => 'required|integer|max:255',
            'product_name' => 'required|string|max:255',
            'opening_stock' => 'nullable|integer',
        ]);

        $product = Product::create([
            'product_code' => $request->input('product_code'),
            'product_name' => $request->input('product_name'),
            'opening_stock' => $request->input('opening_stock'),
        ]);

        if ($product) {
            Product_stock::create([
                'product_id' => $product->id,
                'stock' => $request->input('opening_stock'),
            ]);
            Product_rate::create([
                'product_id' => $product->id,
                'cost_price' => $request->input('cost_price'),
                'retail_price' => $request->input('retail_price'),
            ]);
            return redirect()->back()->with('success', 'Product added successfully!');
        } else {
            return redirect()->with('success', 'Something went wrong! Product could not be added.');
        }
    }


    public function get_product($id)
    {
        $products = Product::find($id);
        return response()->json(['data' => $products]);
    }


    public function update_product(Request $request)
    {
        $request->validate([
            'productId' => 'required'
        ]);

        $result = Product::find($request->productId)
            ->update([
                'product_code' => $request->product_code,
                'product_name' => $request->product_name,
                'opening_stock' => $request->opening_stock,
            ]);
        if ($result) {
            return redirect()->back()->with(['success' => 'Product Updated Successfully']);
        }
        return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
    }

    public function delete_product(Request $request, $id)
    {
        $del_product = Product::find($id);

        $result = $del_product->delete();
        if ($result) {
            return redirect()->back()->with(['success' => 'Product Deleted Successfully']);
        }
        return redirect()->back()->with(['error' => 'Something Went Wrong Try Again']);
    }
}



