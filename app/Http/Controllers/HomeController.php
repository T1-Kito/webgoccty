<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh mục cha và con nhiều cấp (menu đa cấp)
        $categories = \App\Models\Category::with(['children' => function($q) {
            $q->with('children');
        }])->whereNull('parent_id')->get();

        // Query sản phẩm với filter khoảng giá - CHỈ hiển thị sản phẩm có status = 1 (hiển thị)
        $query = Product::with('category')->active();
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        $products = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->only(['price_min', 'price_max']));

        // Lấy 6 sản phẩm nổi bật cho header - sử dụng scope featured()
        $featuredProducts = Product::with('category')
            ->featured()
            ->orderByDesc('created_at')
            ->take(6)
            ->get();
        if ($featuredProducts->count() < 6) {
            $more = Product::with('category')
                ->active()
                ->orderByDesc('created_at')
                ->whereNotIn('id', $featuredProducts->pluck('id'))
                ->take(6 - $featuredProducts->count())
                ->get();
            $featuredProducts = $featuredProducts->concat($more);
        }

        // Lấy sản phẩm hot sale cuối tuần - sử dụng scope featured()
        $hotSaleProducts = Product::with('category')
            ->featured()
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        return view('home.index', compact('categories', 'products', 'featuredProducts', 'hotSaleProducts'));
    }

    public function showProduct($slug)
    {
        // CHỈ hiển thị sản phẩm có status = 1 (hiển thị)
        $product = Product::with(['category', 'images'])->active()->where('slug', $slug)->firstOrFail();
        $categories = Category::with('children')->whereNull('parent_id')->get();
        // Sản phẩm liên quan cũng CHỈ hiển thị sản phẩm có status = 1 (hiển thị)
        $relatedProducts = Product::with('category')
            ->active()
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->paginate(8);
        $addons = $product->addonsWithProduct()->take(6)->get();
        $totalAddons = $product->addonsWithProduct()->count();
        return view('product.show', compact('product', 'categories', 'relatedProducts', 'addons', 'totalAddons'));
    }

    public function search(Request $request)
    {
        $q = trim($request->input('q'));
        $categories = \App\Models\Category::with(['children' => function($q) {
            $q->with('children');
        }])->whereNull('parent_id')->get();
        // Tìm kiếm cũng CHỈ hiển thị sản phẩm có status = 1 (hiển thị)
        $products = Product::with('category')
            ->active()
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%$q%")
                      ->orWhere('serial_number', 'like', "%$q%")
                      ->orWhere('slug', 'like', "%$q%")
                ;
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends(['q' => $q]);
        return view('search.results', compact('products', 'categories', 'q'));
    }

    // Giả sử có hàm addToCart và buyProduct, thêm kiểm tra auth
    public function addToCart(Request $request, $productId)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('status', 'Bạn cần đăng nhập để thêm vào giỏ hàng!');
        }
        // ... logic thêm vào giỏ ...
    }

    public function buyProduct(Request $request, $productId)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('status', 'Bạn cần đăng nhập để mua hàng!');
        }
        // ... logic mua hàng ...
    }
}
