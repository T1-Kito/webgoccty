@extends('layouts.user')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="row">
    <div class="col-md-3">
        @include('components.sidebar', ['categories' => $categories])
    </div>
    <div class="col-md-9">
        <h3 class="mb-3 fw-bold" style="color:#007BFF; font-size:1.15rem; letter-spacing:0.5px;">Kết quả tìm kiếm cho: <span class="text-dark">"{{ $q }}"</span></h3>
        @if($products->count())
        <div class="row g-4 justify-content-center">
            @foreach($products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-5th d-flex">
                    <div class="card h-100 border-0 shadow product-card-modern w-100 position-relative">
                        @php
                            $oldPrice = $product->old_price ?? null;
                            $discount = $oldPrice && $oldPrice > $product->price ? round(100 - $product->price/$oldPrice*100) : null;
                        @endphp
                        @if($discount)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size:0.95em; z-index:2;">Giảm {{ $discount }}%</span>
                        @endif
                        <div class="product-img-wrap d-flex align-items-center justify-content-center" style="height:210px; background:#fff; border-radius:1.5rem 1.5rem 0 0; overflow:hidden;">
                            <a href="{{ route('product.show', $product->slug) }}" class="d-block w-100 h-100">
                                <img src="{{ asset('images/products/' . $product->image) }}" class="product-img-modern" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="card-body d-flex flex-column p-3" style="flex:1 1 auto;">
                            <a href="{{ route('product.show', $product->slug) }}" style="text-decoration:none; color:inherit;">
                                <h6 class="card-title fw-bold mb-2" style="font-size:1.08em; min-height:44px; color:#222; line-height:1.25;">{{ $product->name }}</h6>
                            </a>
                            <div class="mb-1 text-muted" style="font-size:0.97em; min-height:18px;">{{ $product->category->name ?? '' }}</div>
                            <div class="mb-2">
                                @if($product->price == 0)
                                    <span class="fw-bold" style="color:#d32f2f; font-size:1.18em;">
                                        <a href="https://zalo.me/0982751039" target="_blank" style="text-decoration:none; color:inherit;">Liên hệ</a>
                                    </span>
                                @else
                                    <span class="fw-bold" style="color:#d32f2f; font-size:1.18em;">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                    @if($oldPrice && $oldPrice > $product->price)
                                        <span class="text-decoration-line-through text-secondary ms-2" style="font-size:0.98em;">{{ number_format($oldPrice, 0, ',', '.') }}đ</span>
                                    @endif
                                @endif
                            </div>
                            <div class="mb-2 text-truncate" style="font-size:0.97em; color:#444;" title="{{ $product->description }}">{{ Str::limit($product->description, 60) }}</div>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-modern-main w-100 fw-bold mt-auto d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-eye"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
        @else
            <div class="alert alert-warning mt-4">Không tìm thấy sản phẩm nào phù hợp với từ khóa <b>"{{ $q }}"</b>.</div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
@media (min-width: 1200px) {
  .col-xl-5th {
    flex: 0 0 20%;
    max-width: 20%;
  }
}
</style>
@endpush 