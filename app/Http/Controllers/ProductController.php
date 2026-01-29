<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();
            
        return view('products.show', compact('product', 'relatedProducts'));
    }
}
