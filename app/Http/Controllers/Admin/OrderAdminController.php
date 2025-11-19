<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderAdminController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items'])->orderByDesc('created_at')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $order->status = $request->input('status');
        $order->save();
        return redirect()->route('admin.orders.show', $order)->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function destroy(Order $order)
    {
        try {
            // Xóa các order items trước
            $order->items()->delete();
            
            // Sau đó xóa order
            $order->delete();
            
            return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Có lỗi xảy ra khi xóa đơn hàng!');
        }
    }
}
