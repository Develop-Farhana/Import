<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Category;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('category')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-info editProduct">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-danger deleteProduct">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('products.index');
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            // Handle image upload
            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->save();

        return response()->json(['success' => 'Product updated successfully.']);
    }

    // ...

}