<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductColor;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thêm vào giỏ hàng!');
        }
        
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);
        $addons = $request->input('addons', []);
        $colorId = $request->input('color_id');
        $colorPrice = null;
        $colorSale = null;
        if ($colorId) {
            $color = ProductColor::where('id', $colorId)->where('product_id', $productId)->first();
            if ($color && $color->price !== null) {
                // Nếu màu có giá riêng, không áp dụng giảm giá sản phẩm gốc
                $colorPrice = $color->price;
                $colorSale = null;
            } else {
                // Nếu màu không có giá riêng, áp dụng giảm giá sản phẩm gốc
                $colorPrice = $product->final_price;
                $colorSale = $product->sale;
            }
        }
        // Thêm sản phẩm chính
        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->where('color_id', $colorId)
            ->first();
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            if ($colorPrice !== null) {
                $cartItem->price = $colorPrice;
                $cartItem->sale = $colorSale;
            }
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'color_id' => $colorId,
                'quantity' => $quantity,
                'price' => $colorPrice !== null ? $colorPrice : $product->price,
                'sale' => $colorSale !== null ? $colorSale : $product->sale,
            ]);
        }
        
        // Thêm sản phẩm mua kèm
        if (!empty($addons)) {
            foreach ($addons as $addonId) {
                $addon = \App\Models\ProductAddon::with('addonProduct')->find($addonId);
                if ($addon && $addon->addonProduct) {
                    $addonProduct = $addon->addonProduct;
                    $addonCartItem = CartItem::where('user_id', $user->id)
                        ->where('product_id', $addonProduct->id)
                        ->where('is_addon', true)
                        ->where('parent_cart_item_id', $cartItem->id)
                        ->first();
                    
                    if ($addonCartItem) {
                        $addonCartItem->quantity += $quantity;
                        $addonCartItem->save();
                    } else {
                        CartItem::create([
                            'user_id' => $user->id,
                            'product_id' => $addonProduct->id,
                            'quantity' => $quantity,
                            'price' => $addon->addon_price,
                            'sale' => 0,
                            'is_addon' => true,
                            'parent_cart_item_id' => $cartItem->id,
                            'addon_product_id' => $addonProduct->id,
                        ]);
                    }
                }
            }
        }
        
        $message = 'Đã thêm vào giỏ hàng!';
        if (!empty($addons)) {
            $message .= ' (bao gồm ' . count($addons) . ' sản phẩm mua kèm)';
        }
        
        return redirect()->route('cart.view')->with('success', $message);
    }

    public function viewCart()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $categories = \App\Models\Category::with(['children' => function($q) { $q->with('children'); }])->whereNull('parent_id')->get();
        return view('cart.index', compact('cartItems', 'categories'));
    }

    public function showCheckout()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $categories = \App\Models\Category::with(['children' => function($q) { $q->with('children'); }])->whereNull('parent_id')->get();
        return view('checkout.show', compact('cartItems', 'categories'));
    }

    public function postCheckoutInfo(Request $request)
    {
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:100',
            'receiver_phone' => 'required|string|max:20',
            'receiver_address' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
        ]);
        session(['checkout_info' => $validated]);
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $categories = \App\Models\Category::with(['children' => function($q) { $q->with('children'); }])->whereNull('parent_id')->get();
        return view('checkout.payment', compact('cartItems', 'categories', 'validated'));
    }

    public function updateCart(Request $request, $itemId)
    {
        $user = Auth::user();
        $cartItem = CartItem::where('id', $itemId)->where('user_id', $user->id)->firstOrFail();
        $cartItem->quantity = max(1, (int)$request->input('quantity', 1));
        $cartItem->save();
        return back()->with('success', 'Cập nhật số lượng thành công!');
    }

    public function removeFromCart($itemId)
    {
        $user = Auth::user();
        $cartItem = CartItem::where('id', $itemId)->where('user_id', $user->id)->firstOrFail();
        $cartItem->delete();
        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function confirmOrder(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,bank,momo',
        ]);
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $checkoutInfo = session('checkout_info');
        if (!$checkoutInfo || $cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Thông tin đơn hàng không hợp lệ.');
        }
        // Lưu đơn hàng vào DB (giả sử có model Order, OrderItem)
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'receiver_name' => $checkoutInfo['receiver_name'],
            'receiver_phone' => $checkoutInfo['receiver_phone'],
            'receiver_address' => $checkoutInfo['receiver_address'],
            'note' => $checkoutInfo['note'] ?? null,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);
        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'sale' => $item->sale,
                'color_id' => $item->color_id,
                'parent_order_item_id' => null, // Xử lý parent/child nếu có
            ]);
        }
        // Xóa giỏ hàng
        CartItem::where('user_id', $user->id)->delete();
        session()->forget('checkout_info');
        // Thay vì trả về view, chuyển hướng về lịch sử đơn hàng và flash order_id
        return redirect()->route('orders.index')->with('new_order_id', $order->id);
    }
} 