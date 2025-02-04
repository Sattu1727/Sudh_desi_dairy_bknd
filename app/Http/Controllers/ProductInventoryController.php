<?php

namespace App\Http\Controllers;

use App\Models\ProductInventory;
use Illuminate\Http\Request;

class ProductInventoryController extends Controller
{
    // Fetch all products
    public function index()
    {
        return response()->json(ProductInventory::all(), 200);
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'stack' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        $product = ProductInventory::create($request->all());

        return response()->json($product, 201);
    }

    // Show a single product
    public function show($id)
    {
        $product = ProductInventory::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $product = ProductInventory::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'stack' => 'sometimes|string',
            'quantity' => 'sometimes|integer',
        ]);

        $product->update($request->all());

        return response()->json($product, 200);
    }

    // Delete a product
    public function destroy($id)
    {
        $product = ProductInventory::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
