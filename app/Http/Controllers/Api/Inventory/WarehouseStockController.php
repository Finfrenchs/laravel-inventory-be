<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\WarehouseStock;
use Illuminate\Http\Request;

class WarehouseStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = WarehouseStock::with('product', 'warehouse')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Warehouse stocks retrieved successfully',
            'data' => $warehouses
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|integer',
            'product_id' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        $warehouse = Warehouse::find($request->warehouse_id);
        if (!$warehouse) {
            return response()->json([
                'status' => 'error',
                'message' => 'Warehouse not found'
            ], 404);
        }

        $warehouseStock = $warehouse->products()->where('product_id', $request->product_id)->first();
        // $warehouseStock = $warehouse->products()->where('warehouse_id', $request->warehouse_id)
        // ->where('product_id', $request->product_id)
        // ->first();
        if ($warehouseStock) {
            //$warehouseStock->stock = $request->stock;
            // $warehouseStock->date_stock = now();
            //warehouseStock->save();
            // Tambahkan stok baru ke stok yang sudah ada
            //$warehouseStock->pivot->stock += $request->stock;
            $warehouseStock->stock += $request->stock;
            // $warehouseStock->pivot->save();
            $warehouseStock->save();

            $stock = new WarehouseStock();
            $stock->warehouse_id = $request->warehouse_id;
            $stock->product_id = $request->product_id;
            $stock->stock = $request->stock;
            //date stock
            $stock->date_stock = now();
            $stock->save();
        } else {
            //create new warehouse stock
            $warehouse->products()->attach($request->product_id, [
                'stock' => $request->stock,

            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Warehouse stock updated successfully',
            'data' => $warehouse
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
