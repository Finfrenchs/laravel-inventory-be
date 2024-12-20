<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Brands retrieved successfully',
            'data' => $brands
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        // $brand->description = $request->description;
        $brand->company_id = '1';
        //image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $filePath = $image->storeAs('images/brands', $image_name, 'public');
            $brand->image = $filePath;
        }
        $brand->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Brand created successfully',
            'data' => $brand
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return response([
                'message' => 'Brand not found',
            ], 404);
        }

        return response([
            'message' => 'Brand retrieved successfully',
            'data' => $brand,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'status' => 'error',
                'message' => 'Brand not found'
            ], 404);
        }
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        //image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $filePath = $image->storeAs('images/brands', $image_name, 'public');
            $brand->image = $filePath;
        }
        $brand->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Brand updated successfully',
            'data' => $brand
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json([
                'status' => 'error',
                'message' => 'Brand not found'
            ], 404);
        }
        $brand->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Brand deleted successfully'
        ], 200);
    }
}
