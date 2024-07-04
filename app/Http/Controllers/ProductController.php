<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'image' => $imageName,
        ]);

        return response()->json(['success' => 'Product created successfully.']);
    }

    public function edit(Product $product)
    {
        return $product;
        //return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return response()->json(['success' => 'Product updated successfully.']);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
