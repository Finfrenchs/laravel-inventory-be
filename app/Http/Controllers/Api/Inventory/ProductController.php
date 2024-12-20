<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //filter by category id
        if (request()->category_id) {
            $products = Product::where('category_id', request()->category_id)->get();
            $products->load('category', 'brand', 'unit', 'warehouse');
            return response()->json([
                'status' => 'success',
                'message' => 'Products retrieved successfully',
                'data' => $products
            ], 200);
        }
        //filter by name
        if (request()->name) {
            $products = Product::where('name', 'like', '%' . request()->name . '%')->get();
            $products->load('category', 'brand', 'unit', 'warehouse');
            return response()->json([
                'status' => 'success',
                'message' => 'Products retrieved successfully',
                'data' => $products
            ], 200);
        }

        //filter by item code
        if (request()->item_code) {
            $products = Product::where('item_code', '=', request()->item_code)->get();
            $products->load('category', 'brand', 'unit', 'warehouse');
            return response()->json([
                'status' => 'success',
                'message' => 'Products retrieved successfully',
                'data' => $products
            ], 200);
        }
        $products = Product::all();
        $products->load('category', 'brand', 'unit', 'warehouse');
        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'data' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'unit_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',

            'warehouse_id' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'item_code' => 'required|string',
            'alert_stock' => 'nullable|integer',
            'status' => 'nullable|integer',

        ]);

        $product = new Product();
        $product->name = $request->name;
        //slug
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->unit_id = $request->unit_id;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;

        $product->warehouse_id = $request->warehouse_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->alert_stock = $request->alert_stock;
        //status
        $product->status = $request->status;
        $product->item_code = $request->item_code;
        $product->company_id = '1';

        //photo
        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $filePath = $photo->storeAs('images/products', $photo_name, 'public');
            $product->image = $filePath;
        }

        $product->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }
        $product->load('category', 'brand', 'unit', 'warehouse');
        return response()->json([
            'status' => 'success',
            'message' => 'Product retrieved successfully',
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'unit_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',

            'warehouse_id' => 'required|integer',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'item_code' => 'required|string',
            'alert_stock' => 'nullable|integer',
            'status' => 'nullable|integer',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->unit_id = $request->unit_id;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;

        $product->warehouse_id = $request->warehouse_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->alert_stock = $request->alert_stock;
        //status
        $product->status = $request->status;
        $product->item_code = $request->item_code;

        //photo
        if ($request->hasFile('image')) {
            $photo = $request->file('image');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $filePath = $photo->storeAs('images/products', $photo_name, 'public');
            $product->image = $filePath;
        }
        $product->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
