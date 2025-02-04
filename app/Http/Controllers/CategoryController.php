<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    // Fetch All Categories
    public function index()
    {
        $categories = Category::all();

        // Check if categories exist
        if ($categories->isEmpty()) {
            return response()->json(['message' => 'No categories found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($categories, Response::HTTP_OK); // 200 OK
    }

    // Create a New Category
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'status' => 'boolean',
        ]);

        // Generate unique category_id
        $validatedData['category_id'] = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        try {
            $category = Category::create($validatedData);
            return response()->json($category, Response::HTTP_CREATED); // 201 Created
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating category', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
        }
    }

    // Fetch a Single Category by category_id
    public function showByCategoryId($category_id)
    {
        $category = Category::where('category_id', $category_id)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
        }

        return response()->json($category, Response::HTTP_OK); // 200 OK
    }

    // Update a Category
    public function update(Request $request, $id)
    {
        // Validate updated data
        $validatedData = $request->validate([
            'category_name' => 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'status' => 'sometimes|required|boolean',
        ]);

        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
        }

        try {
            $category->update($validatedData);
            return response()->json($category, Response::HTTP_OK); // 200 OK
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating category', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
        }
    }

    // Delete a Category
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND); // 404 Not Found
        }

        try {
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK); // 200 OK
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting category', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
        }
    }
}
