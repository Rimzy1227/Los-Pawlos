<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::latest();
        
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id', // Ensure category exists in DB
            'image' => 'nullable|image',
            'description' => 'nullable'
        ]);

        $data = $request->except('image');
        
        // Fetch category name to store in the denormalized 'category' column if needed, or rely on relationship
        $category = Category::find($request->category_id);
        $data['category'] = $category->name; 

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Store in public/assets/images/category_name/ to match legacy structure or a new one
            // For simplicity/compatibility, let's put it in public/assets/images/general or organized by cat
            // But standard Laravel is storage/app/public. Let's stick to public_path for legacy compat if viewed directly
            // Or better, use proper storage but I'll stick to moving to public assets for now to match current views
            $path = public_path('assets/images/' . strtolower($category->name));
             if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file->move($path, $filename);
            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image',
            'description' => 'nullable'
        ]);

        $data = $request->except('image');
        $category = Category::find($request->category_id);
        $data['category'] = $category->name;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = public_path('assets/images/' . strtolower($category->name));
             if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file->move($path, $filename);
            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
