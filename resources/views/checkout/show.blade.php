@extends('layouts.user')

@section('title', 'Xác nhận đơn hàng')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4" style="color:#007BFF;">Xác nhận đơn hàng</h2>
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Danh sách sản phẩm đã chọn</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach($cartItems->where('parent_cart_item_id', null) as $item)
                                    @php
                                        $product = $item->product;
                                        $finalPrice = $item->price;
                                        $subtotal = $finalPrice * $item->quantity;
                                        $total += $subtotal;
                                        $addons = $cartItems->where('parent_cart_item_id', $item->id);
                                    @endphp
                                    <tr>
                                        <td>
                                            <img src="{{ asset('images/products/' . $product->image) }}" style="width:48px; height:48px; object-fit:cover; border-radius:8px;">
                                            <span class="ms-2 fw-bold">{{ $product->name }}</span>
                                        </td>
                                        <td class="text-danger fw-bold">{{ number_format($finalPrice, 0, ',', '.') }}đ</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="fw-bold text-success">{{ number_format($subtotal, 0, ',', '.') }}đ</td>
                                    </tr>
                                    @if($addons->count())
                                        @foreach($addons as $addon)
                                            @php
                                                $addonProduct = $addon->addonProduct ?? $addon->product;
                                                $addonPrice = $addon->price;
                                                $addonSubtotal = $addonPrice * $addon->quantity;
                                                $total += $addonSubtotal;
                                            @endphp
                                            <tr style="background:#fffbe9;">
                                                <td>
                                                    <img src="{{ asset('images/products/' . ($addonProduct->image ?? '')) }}" style="width:36px; height:36px; object-fit:cover; border-radius:8px;">
                                                    <span class="ms-2">{{ $addonProduct->name ?? '' }} <span class="badge bg-warning text-dark">Mua kèm</span></span>
                                                </td>
                                                <td class="text-danger">{{ number_format($addonPrice, 0, ',', '.') }}đ</td>
                                                <td>{{ $addon->quantity }}</td>
                                                <td class="text-success">{{ number_format($addonSubtotal, 0, ',', '.') }}đ</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold">Tạm tính:</span>
                            </div>
                            <div class="fw-bold text-success" style="font-size:1.2em;">{{ number_format($total, 0, ',', '.') }}đ</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div>Khuyến mãi/Phí giao hàng:</div>
                            <div class="text-muted">Miễn phí</div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div>Mã giảm giá:</div>
                            <div><input type="text" class="form-control form-control-sm" style="width:160px; display:inline-block;" placeholder="Nhập mã nếu có"></div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('checkout.info') }}" method="post" id="checkout-info-form">
                @csrf
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">2. Thông tin người nhận</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Họ tên người nhận <span class="text-danger">*</span></label>
                                <input type="text" name="receiver_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số điện thoại liên hệ <span class="text-danger">*</span></label>
                                <input type="text" name="receiver_phone" class="form-control" required pattern="[0-9]{9,12}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Địa chỉ giao hàng chi tiết <span class="text-danger">*</span></label>
                                <input type="text" name="receiver_address" class="form-control" required placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Ghi chú thêm</label>
                                <textarea name="note" class="form-control" rows="2" placeholder="Ví dụ: giao giờ hành chính, xuất hóa đơn..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('cart.view') }}" class="btn btn-outline-secondary">&larr; Quay lại giỏ hàng</a>
                    <button type="submit" class="btn btn-primary fw-bold ms-2">Tiếp tục &rarr;</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 