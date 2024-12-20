<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\StockHistory;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('supplier', 'items.product')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Purchases retrieved successfully',
            'data' => $purchases
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string',
            'invoice_date' => 'required|date',
            'supplier_id' => 'required|integer',
            'total' => 'required|numeric',
            'status' => 'required|integer',
            'note' => 'nullable|string',
            'due_date' => 'nullable|date',
            'items' => 'required|array',
        ]);

        $purchase = new Purchase();
        $purchase->invoice_number = $request->invoice_number;
        $purchase->invoice_date = $request->invoice_date;
        $purchase->supplier_id = $request->supplier_id;
        $purchase->total = $request->total;
        $purchase->status = $request->status;
        $purchase->note = $request->note;
        $purchase->due_date = $request->due_date;
        $purchase->save();

        foreach ($request->items as $item) {
            $purchase->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);

            //save to stock history
            $stockHistory = new StockHistory();
            $stockHistory->product_id = $item['product_id'];
            $stockHistory->quantity = $item['quantity'];
            $stockHistory->type_change = 'purchase';
            $stockHistory->warehouse_id = 1;
            $stockHistory->date_change = now();
            $stockHistory->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Purchase created successfully',
            'data' => $purchase
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::with('supplier', 'items.product.category', 'items.product.brand')->find($id);
        if (!$purchase) {
            return response()->json([
                'status' => 'error',
                'message' => 'Purchase not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Purchase retrieved successfully',
            'data' => $purchase
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase) {
            return response()->json([
                'status' => 'error',
                'message' => 'Purchase not found'
            ], 404);
        }
        $purchase->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Purchase deleted successfully'
        ], 200);
    }
}
