<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Allow sorting by 'name' or 'created_at' with direction
        $sortField = in_array($request->input('sort'), ['title', 'created_at']) ? $request->input('sort') : 'created_at';
        $sortDirection = $request->input('direction') === 'asc' ? 'asc' : 'desc';

        $categories = Category::query()
            ->orderBy($sortField, $sortDirection)
            ->paginate(5)
            ->withQueryString();

        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            'filters' => $request->only(['sort', 'direction']),
        ]);
    }


    public function create()
    {
        return Inertia::render('Categories/Index', [
            'modal' => 'Categories/Create'
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:255'
        ]);


        $task = Category::create([
            'title' => $request->title,
            'description' => !empty($request->description) ? $request->description : '',
            'status' => !empty($request->status) ? 0 : 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),

        ]);

        return redirect(route('categories'))->with('success', 'Category created successfully!');

    }

    public function update(Request $request,$id)
    {

         $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
             'status' => 'required|boolean',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'title' =>  $request->input('title'),
            'description' => $request->input('description'),
            'status' => !empty($request->input('status')) ? 0 : 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);


        return response()->json([
            'message' => 'Category  updated successfully',
            'categories' => $category
        ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('categories')->with('error', 'categories not found.');
        }

        $category->delete();

        return redirect()->route('categories')->with('success', 'Category deleted successfully.');
    }

}
