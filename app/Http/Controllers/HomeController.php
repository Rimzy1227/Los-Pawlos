<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $featuredProducts = Product::take(4)->get();
        } catch (\Exception $e) {
            $featuredProducts = collect(); // Return empty if DB not ready
        }
        return view('home', compact('featuredProducts'));
    }
}
