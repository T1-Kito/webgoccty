@extends('layouts.user')

@section('title', 'Giỏ hàng của bạn')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4" style="color:#007BFF;">Giỏ hàng của bạn</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($cartItems->isEmpty())
        <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
    @else
    <div class="row justify-content-center">
        <div class="col-lg-10">
                @php $total = 0; @endphp
            @foreach($cartItems->where('parent_cart_item_id', null) as $item)
                    @php
                        $product = $item->product;
                    $finalPrice = $item->price;
                        $subtotal = $finalPrice * $item->quantity;
                        $total += $subtotal;
                    $addons = $cartItems->where('parent_cart_item_id', $item->id);
                    @endphp
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('product.show', $product->slug) }}" style="text-decoration:none;">
                                <img src="{{ asset('images/products/' . $product->image) }}" style="width:70px; height:70px; object-fit:cover; border-radius:8px; transition:transform 0.3s ease; cursor:pointer;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                            <div class="ms-3 flex-grow-1">
                                <div class="fw-bold" style="font-size:1.5em; font-weight:800;">
                                    <a href="{{ route('product.show', $product->slug) }}" style="text-decoration:none; color:inherit; transition:color 0.3s ease;" onmouseover="this.style.color='#007BFF'" onmouseout="this.style.color='inherit'">
                                        {{ $product->name }}
                                    </a>
                                </div>
                                <div style="color:#e53935; font-weight:700; font-size:1.1em;">{{ number_format($finalPrice, 0, ',', '.') }}đ</div>
                                <div class="mt-1" style="font-size:0.98em; color:#888;">Số lượng: {{ $item->quantity }}</div>
                                <div class="mt-1 fw-bold text-success">Thành tiền: {{ number_format($subtotal, 0, ',', '.') }}đ</div>
                            </div>
                            <form method="post" action="{{ route('cart.update', $item->id) }}" class="d-flex align-items-center gap-2 ms-3">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width:70px;">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Cập nhật</button>
                            </form>
                            <form method="post" action="{{ route('cart.remove', $item->id) }}" onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')" class="ms-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </div>
                        {{-- Block khuyến mãi --}}
                        <div class="mt-2" style="background:#f8fafc; border-radius:8px; padding:10px;">
                            <span class="text-danger"><i class="bi bi-gift"></i> Khuyến mãi hấp dẫn</span>
                            <ul class="mb-0" style="font-size:0.98em;">
                                <li>Khách hàng thân thiết: Tặng voucher 100.000đ</li>
                                <li>Khách hàng doanh nghiệp: Hỗ trợ xuất hóa đơn VAT</li>
                            </ul>
                        </div>
                        {{-- Block sản phẩm mua kèm --}}
                        @if($addons->count())
                            <div class="mt-3 p-3" style="background:#fffbe9; border-radius:8px;">
                                <div class="fw-bold mb-2" style="color:#e67e22;">Bạn đang mua kèm {{ $addons->count() }} sản phẩm:</div>
                                @foreach($addons as $addon)
                                    @php
                                        $addonProduct = $addon->addonProduct ?? $addon->product;
                                        $addonPrice = $addon->price;
                                        $addonSubtotal = $addonPrice * $addon->quantity;
                                        $total += $addonSubtotal;
                                    @endphp
                                    <div class="d-flex align-items-center mb-2" style="border-bottom:1px dashed #ffe082;">
                                        <a href="{{ route('product.show', $addonProduct->slug ?? '') }}" style="text-decoration:none;">
                                            <img src="{{ asset('images/products/' . ($addonProduct->image ?? '')) }}" style="width:48px; height:48px; object-fit:cover; border-radius:8px; transition:transform 0.3s ease; cursor:pointer;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                        </a>
                                        <div class="ms-2 flex-grow-1">
                                            <span class="badge bg-warning text-dark">Mua kèm</span>
                                            <a href="{{ route('product.show', $addonProduct->slug ?? '') }}" style="text-decoration:none; color:inherit; transition:color 0.3s ease;" onmouseover="this.style.color='#007BFF'" onmouseout="this.style.color='inherit'">
                                                {{ $addonProduct->name ?? '' }}
                                            </a>
                                            <span style="color:#e53935; font-weight:700;">{{ number_format($addonPrice, 0, ',', '.') }}đ</span>
                                            <span style="font-size:0.98em; color:#888;">x {{ $addon->quantity }}</span>
                                            <span class="fw-bold text-success ms-2">{{ number_format($addonSubtotal, 0, ',', '.') }}đ</span>
                                        </div>
                                        <form method="post" action="{{ route('cart.update', $addon->id) }}" class="d-flex align-items-center gap-2 ms-2">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $addon->quantity }}" min="1" class="form-control" style="width:60px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Cập nhật</button>
                                        </form>
                                        <form method="post" action="{{ route('cart.remove', $addon->id) }}" onsubmit="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')" class="ms-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            <div class="text-end mt-4">
                <div class="fw-bold" style="font-size:1.2em;">Tổng cộng: <span class="text-success">{{ number_format($total, 0, ',', '.') }}đ</span></div>
                <form action="{{ route('checkout.show') }}" method="get" style="display:inline;">
                    <button type="submit" class="btn btn-lg fw-bold mt-2" style="color:#fff; background:#00B894; border:1.5px solid #00B894;">Tiến hành đặt hàng</button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 