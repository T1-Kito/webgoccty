@extends('layouts.user')

@section('title', $category->name . ' - VIKHANG')

@section('content')
<style>
.product-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    min-height: 400px;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,123,255,0.15);
}

.product-card .card-img-top {
    transition: transform 0.3s ease;
    height: 200px;
    object-fit: cover;
    width: 100%;
}

.product-card:hover .card-img-top {
    transform: scale(1.05);
}

.product-card .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 16px;
    justify-content: space-between;
}

.product-title-link {
    text-decoration: none;
    color: inherit;
    cursor: pointer;
    transition: color 0.3s;
}

.product-title-link:hover {
    color: var(--brand-primary) !important;
    text-decoration: underline;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,184,148,0.3);
}

/* Đảm bảo tất cả card có chiều cao đều nhau */
.col-6.col-md-4.col-lg-3 {
    display: flex;
    margin-bottom: 20px;
}

.col-6.col-md-4.col-lg-3 .card {
    width: 100%;
}

/* Đảm bảo ảnh placeholder khi không có ảnh */
.card-img-top:not([src]), .card-img-top[src=""] {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    font-size: 0.9em;
    text-align: center;
}

.card-img-top:not([src])::after, .card-img-top[src=""]::after {
    content: "Không có ảnh";
}

/* Mobile responsive */
@media (max-width: 767.98px) {
    /* Ẩn sidebar trên mobile */
    .col-md-3 {
        display: none;
    }
    
    /* Content chiếm toàn bộ width trên mobile */
    .col-md-9 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    /* Tối ưu card cho mobile */
    .product-card {
        min-height: 320px;
    }
    
    .product-card .card-img-top {
        height: 160px;
    }
    
    .product-card .card-body {
        padding: 12px;
    }
    
    .product-card .card-title {
        font-size: 1.4em !important;
        min-height: 40px !important;
        margin-bottom: 8px !important;
    }
    
    /* Tối ưu grid cho mobile */
    .col-6.col-md-4.col-lg-3 {
        margin-bottom: 16px;
    }
    
    /* Tối ưu header */
    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 8px;
    }
    
    .d-flex.justify-content-between.align-items-center h3 {
        font-size: 1.5em !important;
        margin-bottom: 0 !important;
    }
    
    .d-flex.justify-content-between.align-items-center .badge {
        font-size: 0.9em !important;
    }
    
    /* Tối ưu pagination */
    .pagination {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .pagination .page-link {
        padding: 8px 12px;
        font-size: 0.9em;
    }
    
    /* Tối ưu mobile dropdown */
    .dropdown-menu {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        border: 1px solid #e3e8f0;
    }
    
    .dropdown-item.active {
        background-color: #007BFF;
        color: white;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    .dropdown-item.active:hover {
        background-color: #0056b3;
    }
}
</style>
<div class="row">
    <div class="col-md-3">
        @include('components.sidebar', ['categories' => $categories])
    </div>
    <div class="col-md-9">
        <!-- Mobile Category Dropdown -->
        <div class="d-md-none mb-3">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" id="mobileCategoryDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="text-align: left; padding: 12px 16px; font-size: 1em;">
                    <i class="bi bi-list me-2"></i>Danh mục: {{ $category->name }}
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="mobileCategoryDropdown" style="max-height: 300px; overflow-y: auto;">
                    @foreach($categories as $cat)
                        <li>
                            <a class="dropdown-item {{ $cat->id == $category->id ? 'active' : '' }}" href="{{ route('category.show', $cat->slug) }}" style="padding: 10px 16px; font-size: 0.95em;">
                                <i class="bi bi-folder me-2"></i>{{ $cat->name }}
                            </a>
                        </li>
                        @if($cat->children && $cat->children->count() > 0)
                            @foreach($cat->children as $child)
                                <li>
                                    <a class="dropdown-item {{ $child->id == $category->id ? 'active' : '' }}" href="{{ route('category.show', $child->slug) }}" style="padding: 10px 16px 10px 32px; font-size: 0.9em; color: #666;">
                                        <i class="bi bi-folder-fill me-2"></i>{{ $child->name }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 style="color:var(--brand-secondary); margin:0;">
                <i class="bi bi-grid-3x3-gap me-2"></i>{{ $category->name }}
            </h3>
            <span class="badge bg-primary" style="font-size:1em;">{{ $products->total() }} sản phẩm</span>
        </div>
        <div class="row g-3">
            @forelse($products as $product)
                @php
                    // Debug: Log product info
                    \Log::info("Product: {$product->name} (ID: {$product->id}), Category: {$product->category_id}, Image: {$product->image}");
                @endphp
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 product-card">
                        <img src="{{ asset('images/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title" style="font-size:1.7em; font-weight:800; min-height:48px; line-height:1.3; margin-bottom: 12px;">
                                <a href="{{ route('product.show', $product->slug) }}" class="product-title-link">{{ $product->name }}</a>
                            </h6>
                            
                            <div class="mb-2" style="min-height: 24px; display: flex; align-items: center;">
                                @if($product->price == 0)
                                    <a href="https://zalo.me/0982751039" target="_blank" style="text-decoration:none; color:#d32f2f; font-weight:bold; font-size: 1.1em;">Liên hệ</a>
                                @else
                                    <span style="color:#d32f2f; font-weight:bold; font-size: 1.1em;">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                            
                            <div class="mb-3 flex-grow-1" style="font-size:1.1em; color:#444; min-height: 24px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; line-height: 1.2;">{{ $product->description }}</div>
                            
                            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-auto">
                                @csrf
                                <button type="submit" class="btn w-100 fw-bold" style="background:var(--brand-primary); color:#fff; border:1px solid var(--brand-primary); border-radius:8px; transition:all 0.3s ease; height:45px;">
                                    <i class="bi bi-cart-plus me-2"></i>Mua ngay
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Chưa có sản phẩm nào trong danh mục này.</div>
                </div>
            @endforelse
        </div>
        <div class="mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection 