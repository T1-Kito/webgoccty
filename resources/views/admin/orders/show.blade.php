@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="content-card p-4">
    <h2 class="fw-bold mb-4" style="color:#007BFF;">Chi tiết đơn hàng {{ $order->order_code ?? ("VK" . str_pad($order->id, 6, '0', STR_PAD_LEFT)) }}</h2>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-2"><b>Trạng thái:</b> <span class="badge bg-{{ $order->status=='pending'?'warning':'success' }}">{{ $order->status }}</span></div>
            <div class="mb-2"><b>Ngày đặt:</b> {{ $order->created_at->format('d/m/Y H:i') }}</div>
            <div class="mb-2"><b>Người nhận:</b> {{ $order->receiver_name }}</div>
            <div class="mb-2"><b>SĐT:</b> {{ $order->receiver_phone }}</div>
            <div class="mb-2"><b>Địa chỉ:</b> {{ $order->receiver_address }}</div>
            @if($order->note)
                <div class="mb-2"><b>Ghi chú:</b> {{ $order->note }}</div>
            @endif
            <div class="mb-2"><b>Phương thức thanh toán:</b> {{ strtoupper($order->payment_method) }}</div>
        </div>
        <div class="col-lg-6 text-end">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <select name="status" class="form-select d-inline w-auto" style="display:inline-block;">
                    <option value="pending" @if($order->status=='pending') selected @endif>Chờ xử lý</option>
                    <option value="completed" @if($order->status=='completed') selected @endif>Đã hoàn thành</option>
                </select>
                <button type="submit" class="btn btn-success ms-2">Cập nhật</button>
            </form>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Danh sách sản phẩm</h5>
            <ul class="list-group mb-3">
                @php $total = 0; @endphp
                @foreach($order->items as $item)
                    @php $subtotal = $item->price * $item->quantity; $total += $subtotal; @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $item->product->name ?? 'Sản phẩm đã xóa' }} <span class="text-muted">x{{ $item->quantity }}</span></span>
                        <span class="fw-bold text-success">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                    </li>
                @endforeach
            </ul>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <span class="fw-bold">Tổng cộng:</span>
                <span class="fw-bold text-success" style="font-size:1.2em;">{{ number_format($total, 0, ',', '.') }}đ</span>
            </div>
        </div>
    </div>
    <div class="d-flex gap-3 mt-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">&larr; Quay lại danh sách</a>
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa đơn hàng</button>
        </form>
    </div>
</div>
@endsection 