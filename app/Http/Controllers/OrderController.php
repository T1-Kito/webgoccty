<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->orderByDesc('created_at')->get();
        $categories = \App\Models\Category::with(['children' => function($q) { $q->with('children'); }])->whereNull('parent_id')->get();
        return view('orders.index', compact('orders', 'categories'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();
        
        // Kiểm tra xem đơn hàng có tồn tại không
        if (!$order) {
            abort(404, 'Đơn hàng không tồn tại');
        }
        
        // Kiểm tra xem user có tồn tại không
        if (!$user) {
            abort(401, 'Vui lòng đăng nhập để xem đơn hàng');
        }
        
        // So sánh với kiểu dữ liệu chính xác và thêm debug
        $orderUserId = (int)$order->user_id;
        $currentUserId = (int)$user->id;
        
        if ($orderUserId !== $currentUserId) {
            // Log để debug
            \Log::info('Order access denied', [
                'order_id' => $order->id,
                'order_user_id' => $orderUserId,
                'current_user_id' => $currentUserId,
                'user_email' => $user->email
            ]);
            
            abort(403, 'Bạn không có quyền xem đơn hàng này. Order User ID: ' . $orderUserId . ', Current User ID: ' . $currentUserId);
        }
        
        $categories = \App\Models\Category::with(['children' => function($q) { $q->with('children'); }])->whereNull('parent_id')->get();
        return view('orders.show', compact('order', 'categories'));
    }
}
