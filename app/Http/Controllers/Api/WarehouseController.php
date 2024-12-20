<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();

        return response([
            'message' => 'Warehouses retrieved successfully',
            'data' => $warehouses,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'email' => 'required|email',
        ]);

        $warehouse = Warehouse::create([
            'company_id' => 1,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'slug' => Str::slug($request->name),
        ]);

        return response([
            'message' => 'Warehouse created successfully',
            'data' => $warehouse,
        ], 201);
    }

    public function show(string $id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return response([
                'message' => 'Warehouse not found',
            ], 404);
        }

        return response([
            'message' => 'Warehouse retrieved successfully',
            'data' => $warehouse,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'email' => 'required|email',
        ]);

        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return response([
                'message' => 'Warehouse not found',
            ], 404);
        }

        $warehouse->update([
            'company_id' => 1,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
        ]);

        return response([
            'message' => 'Warehouse updated successfully',
            'data' => $warehouse,
        ], 200);
    }

    public function destroy(string $id)
    {
        $warehouse = Warehouse::find($id);

        if (!$warehouse) {
            return response([
                'message' => 'Warehouse not found',
            ], 404);
        }

        $warehouse->delete();

        return response([
            'message' => 'Warehouse deleted successfully',
        ], 200);
    }
}
