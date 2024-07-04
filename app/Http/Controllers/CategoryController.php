<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CategoriesImport;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
        public function index()
    {
        return view('categories.index');
    }

    public function getCategories(Request $request)
{
    if ($request->ajax()) {
        $data = Category::select(['id', 'name']);
        return datatables()->of($data)
            ->addColumn('action', function($row){
                $btn = "<button class='edit btn btn-primary btn-sm' data-id='$row->id'>Edit</button>";
                $btn .= " <button class='delete btn btn-danger btn-sm' data-id='$row->id'>Delete</button>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new CategoriesImport, $request->file('file'));

        return back()->with('success', 'Categories Imported Successfully.');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::find($id);
        $category->update($request->only('name'));

        return response()->json(['success' => 'Category updated successfully.']);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['success' => 'Category deleted successfully.']);
    }
}

