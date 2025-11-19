@extends('layouts.user')

@section('title', 'Chọn phương thức thanh toán')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4" style="color:#007BFF;">Chọn phương thức thanh toán</h2>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Thông tin người nhận</h5>
                    <div class="mb-2"><b>Họ tên:</b> {{ $validated['receiver_name'] }}</div>
                    <div class="mb-2"><b>SĐT:</b> {{ $validated['receiver_phone'] }}</div>
                    <div class="mb-2"><b>Địa chỉ:</b> {{ $validated['receiver_address'] }}</div>
                    @if(!empty($validated['note']))
                        <div class="mb-2"><b>Ghi chú:</b> {{ $validated['note'] }}</div>
                    @endif
                </div>
            </div>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Danh sách sản phẩm</h5>
                    <ul class="list-group mb-3">
                        @php $total = 0; @endphp
                        @foreach($cartItems->where('parent_cart_item_id', null) as $item)
                            @php
                                $product = $item->product;
                                $finalPrice = $item->price;
                                $subtotal = $finalPrice * $item->quantity;
                                $total += $subtotal;
                                $addons = $cartItems->where('parent_cart_item_id', $item->id);
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $product->name }} <span class="text-muted">x{{ $item->quantity }}</span></span>
                                <span class="fw-bold text-success">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                            </li>
                            @if($addons->count())
                                @foreach($addons as $addon)
                                    @php
                                        $addonProduct = $addon->addonProduct ?? $addon->product;
                                        $addonPrice = $addon->price;
                                        $addonSubtotal = $addonPrice * $addon->quantity;
                                        $total += $addonSubtotal;
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background:#fffbe9;">
                                        <span>{{ $addonProduct->name ?? '' }} <span class="badge bg-warning text-dark">Mua kèm</span> <span class="text-muted">x{{ $addon->quantity }}</span></span>
                                        <span class="text-success">{{ number_format($addonSubtotal, 0, ',', '.') }}đ</span>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="fw-bold">Tổng cộng:</span>
                        <span class="fw-bold text-success" style="font-size:1.2em;">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>
            <form action="{{ route('checkout.confirm') }}" method="post" id="checkout-payment-form">
                @csrf
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">3. Chọn hình thức thanh toán</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank">
                            <label class="form-check-label" for="bank">Chuyển khoản ngân hàng</label>
                        </div>
                        <div id="bank-info" class="mb-2" style="display:none;">
                            <div class="alert alert-info mt-2">
                                <b>Thông tin chuyển khoản công ty Vi Khang:</b><br>
                                Ngân hàng: Vietcombank<br>
                                Số tài khoản: 0123456789<br>
                                Chủ tài khoản: CÔNG TY VI KHANG<br>
                                Nội dung: [Tên khách hàng] + SĐT + Đặt hàng VIKHANG
                            </div>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="momo" value="momo">
                            <label class="form-check-label" for="momo">Ví điện tử (Momo, ZaloPay...)</label>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('checkout.show') }}" class="btn btn-outline-secondary">&larr; Quay lại</a>
                    <button type="submit" class="btn btn-success fw-bold ms-2">Xác nhận đơn hàng</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bankRadio = document.getElementById('bank');
    const codRadio = document.getElementById('cod');
    const momoRadio = document.getElementById('momo');
    const bankInfo = document.getElementById('bank-info');
    function toggleBankInfo() {
        if(bankRadio.checked) bankInfo.style.display = '';
        else bankInfo.style.display = 'none';
    }
    bankRadio.addEventListener('change', toggleBankInfo);
    codRadio.addEventListener('change', toggleBankInfo);
    momoRadio.addEventListener('change', toggleBankInfo);
    toggleBankInfo();
});
</script>
@endsection 