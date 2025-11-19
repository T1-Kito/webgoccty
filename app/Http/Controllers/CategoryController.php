<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $categories = Category::with(['children' => function($q) {
            $q->with('children');
        }])->whereNull('parent_id')->get();
        $products = Product::where('category_id', $category->id)->active()->orderBy('created_at', 'desc')->paginate(12);
        return view('category.show', compact('category', 'categories', 'products'));
    }
} 