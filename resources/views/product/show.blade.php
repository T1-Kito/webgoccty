@extends('layouts.user')

@section('title', $product->name . ' - VIKHANG')

<style>
/* Category Sidebar Styling */
.category-sidebar {
    border: 1px solid #e2e8f0;
}

.category-sidebar .category-sidebar {
    border: none !important;
    box-shadow: none !important;
    background: transparent !important;
    padding: 0 !important;
}

.category-sidebar .fw-bold {
    font-size: 1.1em !important;
    color: #007BFF !important;
    border-bottom: 2px solid #e3e8f0;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

/* Product Info Card Styling */
.product-info-card {
    transition: all 0.3s ease;
}

.product-info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}

/* Product Gallery Styling */
.product-gallery {
    transition: all 0.3s ease;
}

.product-gallery:hover {
    transform: scale(1.02);
}

/* Commit Cards Styling */
.commit-card {
    transition: all 0.3s ease;
    border: 1px solid #e3e8f0 !important;
}

.commit-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    border-color: #007BFF !important;
}

/* Tabs title should be larger than content */
#productTab {
    font-size: 1.25em !important;
}

#productTab .nav-link {
    font-weight: 700;
    letter-spacing: 0.2px;
}

#productTab .nav-link.active {
    border-bottom-width: 3px;
}

/* Mobile responsive cho sidebar */
@media (max-width: 767.98px) {
    /* Ẩn sidebar trên mobile */
    .col-12.col-md-3 {
        display: none;
    }
    
    /* Content chiếm toàn bộ width trên mobile */
    .col-12.col-md-9 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .category-sidebar {
        position: static !important;
        margin-bottom: 20px;
        border-radius: 8px !important;
        padding: 16px !important;
    }
    
    .product-info-card {
        margin-top: 20px;
        padding: 16px !important;
    }
    
    /* Mobile Product Title */
    .product-title-mobile {
        font-size: 1.15em !important;
        line-height: 1.3 !important;
        margin-bottom: 12px !important;
    }
    
    /* Mobile Product Gallery */
    .product-gallery {
        margin-bottom: 16px;
    }
    
    .product-gallery .main-image-container {
        min-height: 280px !important;
        padding: 16px !important;
        border-radius: 16px !important;
    }
    
    .product-gallery .main-image-container img {
        max-height: 240px !important;
    }
    
    /* Mobile Thumbnails */
    .thumbnail-container {
        gap: 6px !important;
    }
    
    .thumbnail-wrapper img {
        width: 60px !important;
        height: 60px !important;
    }
    
    /* Mobile Commit Cards */
    .commit-card {
        min-height: 100px !important;
        padding: 12px !important;
    }
    
    .commit-card .rounded-circle {
        width: 40px !important;
        height: 40px !important;
    }
    
    .commit-card i {
        font-size: 1.8em !important;
    }
    
    .commit-card div {
        font-size: 0.9em !important;
    }
    
    /* Mobile Product Info */
    .product-info-card .price-section {
        margin-bottom: 16px !important;
    }
    
    .product-info-card .price-section div:first-child {
        font-size: 0.9em !important;
    }
    
    /* Chỉ áp dụng cho giá tiền số, không áp dụng cho "Liên hệ" */
    .product-info-card .price-section > div:last-child > div:not(.product-contact-price):not(a) {
        font-size: 2em !important;
    }
    
    /* Mobile Buttons */
    .btn-mobile {
        padding: 12px 16px !important;
        font-size: 1em !important;
        border-radius: 12px !important;
    }
    
    /* Mobile Addon Section */
    .addon-section-mobile {
        margin-top: 16px !important;
    }
    
    .addon-item-mobile {
        padding: 8px !important;
        min-height: 60px !important;
    }
    
    .addon-item-mobile img {
        width: 36px !important;
        height: 36px !important;
    }
    
    /* Mobile Related Products */
    .related-products-mobile {
        margin-top: 24px !important;
    }
    
    .related-product-card-mobile {
        min-height: 280px !important;
    }
    
    .related-product-card-mobile img {
        max-height: 120px !important;
    }
    
    .related-product-card-mobile .card-title {
        font-size: 0.9em !important;
        min-height: 40px !important;
    }
    
    /* Ẩn hover effects trên mobile */
    .product-hover-tooltip {
        display: none !important;
    }
    
    .product-hover-container:hover {
        transform: none !important;
    }
    
    .product-hover-container:hover .product-hover-tooltip {
        opacity: 0 !important;
        visibility: hidden !important;
    }
    
    /* Tối ưu touch targets */
    .btn, .btn-mobile {
        min-height: 44px !important;
    }
    
    input[type="checkbox"], input[type="radio"] {
        min-width: 20px !important;
        min-height: 20px !important;
    }
    
    /* Tối ưu scrolling */
    .container-fluid {
        overflow-x: hidden;
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
    
    /* Tối ưu product title trên mobile */
    .product-title-mobile {
        font-size: 1.3em !important;
        line-height: 1.2 !important;
        margin-bottom: 12px !important;
    }
    
    /* Tối ưu product gallery trên mobile */
    .product-gallery .main-image-container {
        min-height: 250px !important;
        padding: 12px !important;
        border-radius: 12px !important;
    }
    
    .product-gallery .main-image-container img {
        max-height: 200px !important;
    }
    
    /* Tối ưu thumbnails trên mobile */
    .thumbnail-container {
        gap: 4px !important;
        margin-top: 12px !important;
    }
    
    .thumbnail-wrapper img {
        width: 50px !important;
        height: 50px !important;
    }
    
    /* Tối ưu commit cards trên mobile */
    .commit-card {
        min-height: 80px !important;
        padding: 10px !important;
        margin-bottom: 12px !important;
    }
    
    .commit-card .rounded-circle {
        width: 35px !important;
        height: 35px !important;
    }
    
    .commit-card i {
        font-size: 1.5em !important;
    }
    
    .commit-card div {
        font-size: 0.85em !important;
    }
    
    /* Tối ưu addon section trên mobile */
    .addon-section-mobile {
        margin-top: 12px !important;
    }
    
    .addon-item-mobile {
        padding: 6px !important;
        min-height: 50px !important;
    }
    
    .addon-item-mobile img {
        width: 30px !important;
        height: 30px !important;
    }
    
    /* Tối ưu tabs trên mobile */
    .nav-tabs {
        font-size: 1.1em !important;
    }
    
    .nav-tabs .nav-link {
        padding: 8px 12px !important;
        font-size: 0.9em !important;
    }
    
    /* Tối ưu related products trên mobile */
    .related-products-mobile {
        margin-top: 20px !important;
    }
    
    .related-product-card-mobile {
        min-height: 250px !important;
    }
    
    .related-product-card-mobile img {
        max-height: 100px !important;
    }
    
    .related-product-card-mobile .card-title {
        font-size: 0.8em !important;
        min-height: 35px !important;
    }
    
    /* Kích thước chữ "Liên hệ" trên mobile - Chỉ target class product-contact-price */
    .product-contact-price,
    .product-info-card .price-section .product-contact-price,
    .product-info-card .price-section a .product-contact-price,
    .product-info-card .price-section > div > a > .product-contact-price,
    .price-section .product-contact-price,
    .price-section a .product-contact-price,
    .price-section > div > a > .product-contact-price,
    div.product-contact-price[style*="font-size:2.7em"],
    div.product-contact-price[style*="font-size:2em"] {
        font-size: 1.5em !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
        letter-spacing: 0 !important;
    }
}

/* CSS riêng với độ ưu tiên cao nhất cho "Liên hệ" trên mobile - Đặt ngoài media query để đảm bảo override */
@media (max-width: 767.98px) {
    /* Force override inline style cho "Liên hệ" - Chỉ target class product-contact-price */
    .product-contact-price,
    .product-contact-price[style*="font-size"],
    .product-info-card .price-section .product-contact-price,
    .product-info-card .price-section a .product-contact-price,
    .product-info-card .price-section > div > a > .product-contact-price,
    .price-section .product-contact-price,
    .price-section a .product-contact-price,
    .price-section > div > a > .product-contact-price {
        font-size: 1.5em !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
        letter-spacing: 0 !important;
    }
}

/* Mobile responsive cho sidebar */
@media (max-width: 767.98px) {
    .category-sidebar {
        position: static !important;
        margin-bottom: 20px;
        border-radius: 8px !important;
    }
    
    .category-sidebar .fw-bold {
        font-size: 1em !important;
        padding-bottom: 8px;
        margin-bottom: 15px;
    }
}

.product-hover-container {
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.product-hover-container:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,123,255,0.15) !important;
}

.product-hover-container:hover .product-hover-tooltip {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateY(0) !important;
}

.product-hover-tooltip {
    transform: translateY(20px);
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0,123,255,0.15);
    position: relative;
}

.product-hover-tooltip::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #007bff, #00d4ff, #007bff);
    border-radius: 0 0 1.5rem 1.5rem;
    z-index: -1;
    opacity: 0.6;
    animation: borderGlow 2s ease-in-out infinite alternate;
}

@keyframes borderGlow {
    0% { opacity: 0.4; }
    100% { opacity: 0.8; }
}

.product-hover-tooltip .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,123,255,0.4) !important;
}

.product-hover-tooltip .btn-outline-primary:hover {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-color: #007bff;
    color: white;
}
</style>

@section('content')
<!-- Layout 2 cột với sidebar bên trái -->
<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Cột trái: Sidebar danh mục -->
        <div class="col-12 col-md-3">
            <div class="category-sidebar" style="background: #fff; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); padding: 24px; position: sticky; top: 20px; border: 1px solid #e2e8f0;">
                @include('components.sidebar', ['categories' => $categories])
            </div>
        </div>
        
        <!-- Cột phải: Nội dung sản phẩm -->
        <div class="col-12 col-md-9">
            <!-- Mobile Category Dropdown -->
            <div class="d-md-none mb-3">
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" id="mobileCategoryDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="text-align: left; padding: 12px 16px; font-size: 1em;">
                        <i class="bi bi-list me-2"></i>Danh mục: {{ $product->category->name ?? 'Không phân loại' }}
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="mobileCategoryDropdown" style="max-height: 300px; overflow-y: auto;">
                        @foreach($categories as $cat)
                            <li>
                                <a class="dropdown-item {{ $cat->id == ($product->category->id ?? 0) ? 'active' : '' }}" href="{{ route('category.show', $cat->slug) }}" style="padding: 10px 16px; font-size: 0.95em;">
                                    <i class="bi bi-folder me-2"></i>{{ $cat->name }}
                                </a>
                            </li>
                            @if($cat->children && $cat->children->count() > 0)
                                @foreach($cat->children as $child)
                                    <li>
                                        <a class="dropdown-item {{ $child->id == ($product->category->id ?? 0) ? 'active' : '' }}" href="{{ route('category.show', $child->slug) }}" style="padding: 10px 16px 10px 32px; font-size: 0.9em; color: #666;">
                                            <i class="bi bi-folder-fill me-2"></i>{{ $child->name }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- Product Title -->
            <div class="mb-4">
                <h1 class="fw-bold mb-0 product-title-mobile"
                    style="color:#222; font-size:1.8em !important; font-weight:900; line-height:1.2; letter-spacing:-0.5px; word-break:break-word; text-align:left; white-space:normal;">
                    {{ $product->name }}
                </h1>
            </div>
            
            <!-- Product Main Content -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    {{-- Product Image Gallery --}}
                    <div class="product-gallery">
                {{-- Main Image Container --}}
                <div class="main-image-container" style="display:flex; align-items:center; justify-content:center; min-height:400px; background:#fff; border-radius:24px; box-shadow:0 6px 32px 0 rgba(0,0,0,0.10); margin-bottom:16px; padding:20px; overflow:hidden; position:relative;">

                    
                    {{-- Main Image --}}
                    <img id="mainProductImage" src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-width:100%; max-height:320px; width:auto; height:auto; object-fit:contain; cursor:zoom-in;">
                </div>

                {{-- Thumbnail Images --}}
                @if($product->images && $product->images->count() > 0)
                    <div class="thumbnail-container" style="display:flex; gap:8px; justify-content:center; flex-wrap:wrap;">
                        {{-- Thumbnail cho ảnh chính --}}
                        <div class="thumbnail-wrapper" style="position:relative; cursor:pointer;">
                            <img src="{{ asset('images/products/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="product-thumbnail-img" 
                                 data-index="0"
                                 style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:2px solid #007bff; transition:all 0.3s ease;"
                                 onclick="changeMainImage(0)">
                            <div class="active-indicator" style="position:absolute; top:-4px; right:-4px; width:20px; height:20px; background:#007bff; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:0.7em; font-weight:bold;">✓</div>
                        </div>
                        
                        {{-- Thumbnail cho ảnh bổ sung --}}
                        @foreach($product->images as $index => $image)
                            <div class="thumbnail-wrapper" style="position:relative; cursor:pointer;">
                                <img src="{{ asset('images/products/' . $image->image_path) }}" 
                                     alt="{{ $image->alt_text ?? $product->name }}" 
                                     class="product-thumbnail-img" 
                                     data-index="{{ $index + 1 }}"
                                     style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:2px solid #e3e8f0; transition:all 0.3s ease;"
                                     onclick="changeMainImage({{ $index + 1 }})">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            {{-- Block cam kết sản phẩm --}}
            <div class="product-commitments mt-4 mb-4">
                <div class="fw-bold mb-3" style="font-size:1.2em; text-align:left; color: #007BFF;">Cam kết sản phẩm</div>
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="commit-card h-100 d-flex align-items-center p-3 rounded-4 shadow-sm" style="background:#f8fafc; min-height:120px; border:1.5px solid #e3e8f0; font-size:0.92em;">
                            <span class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width:54px; height:54px; background:#e30019;">
                                <i class="bi bi-patch-check-fill text-white" style="font-size:2.3em;"></i>
                            </span>
                            <div style="font-size:1.1em; font-weight:500; color:#222; text-align:left;">
                                Máy mới 100%, chính hãng, đầy đủ giấy tờ từ nhà phân phối.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="commit-card h-100 d-flex align-items-center p-3 rounded-4 shadow-sm" style="background:#f8fafc; min-height:120px; border:1.5px solid #e3e8f0; font-size:0.92em;">
                            <span class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width:54px; height:54px; background:#007bff;">
                                <i class="bi bi-arrow-repeat text-white" style="font-size:2.3em;"></i>
                            </span>
                            <div style="font-size:1.1em; font-weight:500; color:#222; text-align:left;">
                                1 đổi 1 trong 30 ngày nếu lỗi phần cứng, bảo hành 12 tháng tại trung tâm chính hãng.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="commit-card h-100 d-flex align-items-center p-3 rounded-4 shadow-sm" style="background:#f8fafc; min-height:120px; border:1.5px solid #e3e8f0; font-size:0.92em;">
                            <span class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width:54px; height:54px; background:var(--brand-primary);">
                                <i class="bi bi-box-seam text-white" style="font-size:2.3em;"></i>
                            </span>
                            <div style="font-size:1.1em; font-weight:500; color:#222; text-align:left;">
                                Đầy đủ phụ kiện: Hộp, sách hướng dẫn, cáp, phụ kiện theo tiêu chuẩn.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="commit-card h-100 d-flex align-items-center p-3 rounded-4 shadow-sm" style="background:#f8fafc; min-height:120px; border:1.5px solid #e3e8f0; font-size:0.92em;">
                            <span class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width:54px; height:54px; background:#ffc107;">
                                <i class="bi bi-receipt text-white" style="font-size:2.3em;"></i>
                            </span>
                            <div style="font-size:1.1em; font-weight:500; color:#222; text-align:left;">
                                Giá sản phẩm đã bao gồm VAT, xuất hóa đơn đầy đủ, minh bạch chi phí.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
                <div class="col-md-6">
                    <!-- Product Info Card -->
                    <div class="product-info-card" style="background:#fff; border-radius:16px; padding:24px; box-shadow:0 4px 20px rgba(0,0,0,0.08); border:1px solid #e3e8f0;">
                        <!-- Price Section -->
                        <div class="mb-4 price-section">
                            <div style="font-size:1em; color:#64748b; font-weight:500; margin-bottom:8px;">Giá sản phẩm</div>
                            @if($product->has_discount)
                                <span class="badge bg-danger" style="position:absolute; top:18px; right:24px; font-size:1.1em; padding:7px 18px; border-radius:1em; z-index:2;">Giảm {{ $product->discount_percent }}%</span>
                                <div style="display:flex; align-items:baseline; gap:18px;">
                                    <div style="font-size:2.1em; font-weight:900; color:#e30019; line-height:1; letter-spacing:-2px;">{{ number_format($product->final_price, 0, ',', '.') }}đ</div>
                                    <div style="font-size:1.3em; color:#b0b0b0; text-decoration:line-through; font-weight:500;">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                                </div>
                            @else
                                <div style="display:flex; align-items:baseline; gap:18px;">
                                    @if($product->price > 0)
                                        <div style="font-size:2.7em; font-weight:900; color:#d32f2f; line-height:1; letter-spacing:-2px;">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                                    @else
                                        <a href="https://zalo.me/0982751039" target="_blank" style="text-decoration:none;">
                                            <div class="product-contact-price" style="font-size:2.7em; font-weight:900; color:#d32f2f; line-height:1; letter-spacing:-2px; cursor:pointer; transition:color 0.3s ease;" onmouseover="this.style.color='#b71c1c'" onmouseout="this.style.color='#d32f2f'">Liên hệ</div>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
            {{-- Chọn màu sắc sản phẩm - Design hiện đại --}}
            @if($product->colors && $product->colors->count())
            <div class="mb-4">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:16px;">
                    <label class="form-label fw-bold" style="font-size:1.8em; margin:0;">Màu sắc:</label>
                    <span class="badge bg-warning" style="font-size:0.9em;">Chọn màu yêu thích</span>
                </div>
                <div class="d-flex flex-wrap gap-4" id="color-options">
                    @foreach($product->colors as $color)
                        <div class="color-option-wrapper" style="position:relative;">
                            <button type="button"
                                class="btn color-option-btn"
                                data-price="{{ $color->price ?? $product->final_price }}"
                                data-quantity="{{ $color->quantity }}"
                                data-color="{{ $color->color_code }}"
                                data-color-name="{{ $color->color_name }}"
                                data-id="{{ $color->id }}"
                                style="border:3px solid {{ $color->quantity > 0 ? '#e3e8f0' : '#ffcdd2' }}; background:linear-gradient(145deg, #ffffff 0%, #f8fafc 100%); min-width:180px; min-height:80px; position:relative; opacity:{{ $color->quantity > 0 ? '1' : '0.6' }}; padding:16px 20px; font-size:1.1em; display:flex; align-items:center; gap:16px; border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,0.08); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); overflow:hidden;"
                                @if($color->quantity == 0) disabled @endif
                            >
                                {{-- Color swatch với gradient và shine effect --}}
                                <div style="position:relative; width:48px; height:48px; border-radius:50%; background:{{ $color->color_code }}; border:3px solid #fff; box-shadow:0 2px 8px rgba(0,0,0,0.15); display:flex; align-items:center; justify-content:center; overflow:hidden;">
                                    <div style="position:absolute; top:-50%; left:-50%; width:200%; height:200%; background:linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.3) 50%, transparent 70%); transform:rotate(45deg); transition:transform 0.3s;"></div>
                                </div>
                                
                                <div style="flex:1; text-align:left;">
                                    <div style="font-weight:700; color:#2d3748; margin-bottom:4px;">{{ $color->color_name }}</div>
                                    <div style="font-size:1.05em; font-weight:600; color:#e30019;">@if($color->price){{ number_format($color->price, 0, ',', '.') }}đ @else {{ number_format($product->final_price, 0, ',', '.') }}đ @endif</div>
                                </div>
                                
                                {{-- Stock indicator --}}
                                @if($color->quantity > 0)
                                    <div style="position:absolute; top:8px; right:8px; background:#007BFF; color:#fff; font-size:0.75em; padding:2px 6px; border-radius:8px; font-weight:600; z-index:2;">Còn hàng</div>
                                @else
                                    <div style="position:absolute; top:8px; right:8px; background:#ef4444; color:#fff; font-size:0.75em; padding:2px 6px; border-radius:8px; font-weight:600; z-index:2;">Hết hàng</div>
                                @endif
                                @if($loop->first)
                                    <div style="position:absolute; top:8px; left:8px; background:#f59e0b; color:#fff; font-size:0.7em; padding:2px 6px; border-radius:6px; font-weight:600; z-index:2;">Phổ biến</div>
                @endif
                                
                                {{-- Selection indicator --}}
                                <div class="selection-indicator" style="position:absolute; top:-2px; right:-2px; width:24px; height:24px; background:var(--brand-primary); border-radius:50%; display:none; align-items:center; justify-content:center; color:#fff; font-size:0.8em; font-weight:bold; box-shadow:0 2px 8px rgba(227,0,25,0.3);">
                                    ✓
                                </div>
                            </button>
                        </div>
                    @endforeach
                </div>
                
                {{-- Color preview section --}}
                <div id="color-preview" style="margin-top:16px; padding:16px; background:linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); border-radius:12px; border:1px solid #e2e8f0; display:none;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div id="preview-color-swatch" style="width:32px; height:32px; border-radius:50%; border:2px solid #fff; box-shadow:0 2px 6px rgba(0,0,0,0.1);"></div>
                        <div>
                            <div id="preview-color-name" style="font-weight:600; color:#2d3748;"></div>
                            <div id="preview-color-price" style="font-size:0.9em; color:#718096;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const colorBtns = document.querySelectorAll('.color-option-btn');
                const priceBlock = document.querySelector('.price-section');
                // Make addon card clickable to open product
                document.querySelectorAll('.addon-card').forEach(function(card){
                    card.addEventListener('click', function(e){
                        // avoid navigate when clicking checkbox
                        if(e.target && (e.target.tagName === 'INPUT' || e.target.classList.contains('form-check-input'))) return;
                        const url = this.getAttribute('data-url');
                        if(url && url !== '#') {
                            window.location.href = url;
                        }
                    });
                });
                const colorPreview = document.getElementById('color-preview');
                const previewColorSwatch = document.getElementById('preview-color-swatch');
                const previewColorName = document.getElementById('preview-color-name');
                const previewColorPrice = document.getElementById('preview-color-price');
                const addToCartForm = document.getElementById('addToCartForm');
                
                let selectedBtn = null;
                const originalPriceBlock = priceBlock ? priceBlock.innerHTML : '';
                
                colorBtns.forEach(btn => {
                    // Hover effects
                    btn.addEventListener('mouseenter', function() {
                        if (!this.disabled) {
                            this.style.transform = 'translateY(-4px) scale(1.02)';
                            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
                            this.style.borderColor = 'var(--brand-primary)';
                            
                            // Show color preview
                            const colorCode = this.dataset.color;
                            const colorName = this.dataset.colorName;
                            const price = this.dataset.price;
                            
                            previewColorSwatch.style.background = colorCode;
                            previewColorName.textContent = colorName;
                            previewColorPrice.textContent = Number(price).toLocaleString() + 'đ';
                            colorPreview.style.display = 'block';
                        }
                    });
                    
                    btn.addEventListener('mouseleave', function() {
                        if (!this.classList.contains('selected')) {
                            this.style.transform = 'translateY(0) scale(1)';
                            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.08)';
                            this.style.borderColor = this.dataset.quantity > 0 ? '#e3e8f0' : '#ffcdd2';
                        }
                    });
                    
                    // Click handler
                    btn.addEventListener('click', function() {
                        if (this.disabled) return;
                        
                        // Remove previous selection
                        colorBtns.forEach(b => {
                            b.classList.remove('selected');
                            b.style.transform = 'translateY(0) scale(1)';
                            b.style.boxShadow = '0 4px 12px rgba(0,0,0,0.08)';
                            b.style.borderColor = b.dataset.quantity > 0 ? '#e3e8f0' : '#ffcdd2';
                            b.querySelector('.selection-indicator').style.display = 'none';
                        });
                        
                        // Toggle selection
                        if(selectedBtn === this) {
                            selectedBtn = null;
                            if(priceBlock) {
                                const priceDisplay = priceBlock.querySelector('div[style*="display:flex"]');
                                if(priceDisplay) {
                                    // Reset về giá gốc của sản phẩm
                                    @if($product->has_discount)
                                        priceDisplay.innerHTML = `<div style="display:flex; align-items:baseline; gap:18px;">
                                            <div style="font-size:2.1em; font-weight:900; color:#e30019; line-height:1; letter-spacing:-2px;">{{ number_format($product->final_price, 0, ',', '.') }}đ</div>
                                            <div style="font-size:1.3em; color:#b0b0b0; text-decoration:line-through; font-weight:500;">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                                        </div>`;
                                    @else
                                        @if($product->price > 0)
                                            priceDisplay.innerHTML = `<div style="display:flex; align-items:baseline; gap:18px;">
                                                <div style="font-size:2.7em; font-weight:900; color:#007BFF; line-height:1; letter-spacing:-2px;">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                                            </div>`;
                                        @else
                                            priceDisplay.innerHTML = `<div style="display:flex; align-items:baseline; gap:18px;">
                                                <a href="https://zalo.me/0909123456" target="_blank" style="text-decoration:none;">
                                                    <div class="product-contact-price" style="font-size:2.7em; font-weight:900; color:#007BFF; line-height:1; letter-spacing:-2px; cursor:pointer; transition:color 0.3s ease;" onmouseover="this.style.color='#00B894'" onmouseout="this.style.color='#007BFF'">Liên hệ</div>
                                                </a>
                                            </div>`;
                                            // Force adjust size trên mobile
                                            setTimeout(function() {
                                                if (window.innerWidth <= 767.98) {
                                                    const contactEl = priceDisplay.querySelector('.product-contact-price');
                                                    if (contactEl) {
                                                        contactEl.style.setProperty('font-size', '1.5em', 'important');
                                                        contactEl.style.setProperty('font-weight', '600', 'important');
                                                        contactEl.style.setProperty('line-height', '1.2', 'important');
                                                        contactEl.style.setProperty('letter-spacing', '0', 'important');
                                                    }
                                                }
                                            }, 100);
                                        @endif
                                    @endif
                                }
                            }
                            colorPreview.style.display = 'none';
                            return;
                        }
                        
                        // Select new color
                        this.classList.add('selected');
                        this.style.transform = 'translateY(-2px) scale(1.01)';
                        this.style.boxShadow = '0 6px 20px rgba(0,184,148,0.3)';
                        this.style.borderColor = '#00b894';
                        this.querySelector('.selection-indicator').style.display = 'flex';
                        
                        selectedBtn = this;
                        const price = this.dataset.price;
                        const quantity = this.dataset.quantity;
                        
                        // Update price
                        if(priceBlock) {
                            const priceLabel = priceBlock.querySelector('div[style*="color:#64748b"]');
                            const priceDisplay = priceBlock.querySelector('div[style*="display:flex"]');
                            
                            if(quantity == 0) {
                                if(priceDisplay) {
                                    priceDisplay.innerHTML = '<div style="color:#e30019; font-size:2em; font-weight:900;">Liên hệ admin để đặt màu</div>';
                                }
                            } else if(price == 0) {
                                if(priceDisplay) {
                                    priceDisplay.innerHTML = '<a href="https://zalo.me/0982751039" target="_blank" style="text-decoration:none;"><div class="product-contact-price" style="font-size:2.7em; font-weight:900; color:#d32f2f; line-height:1; letter-spacing:-2px; cursor:pointer; transition:color 0.3s ease;" onmouseover="this.style.color=\'#b71c1c\'" onmouseout="this.style.color=\'#d32f2f\'">Liên hệ</div></a>';
                                    // Force adjust size trên mobile
                                    setTimeout(function() {
                                        if (window.innerWidth <= 767.98) {
                                            const contactEl = priceDisplay.querySelector('.product-contact-price');
                                            if (contactEl) {
                                                contactEl.style.setProperty('font-size', '1.5em', 'important');
                                                contactEl.style.setProperty('font-weight', '600', 'important');
                                                contactEl.style.setProperty('line-height', '1.2', 'important');
                                                contactEl.style.setProperty('letter-spacing', '0', 'important');
                                            }
                                        }
                                    }, 100);
                                }
                            } else {
                                if(priceDisplay) {
                                    priceDisplay.innerHTML = `<div style="display:flex; align-items:baseline; gap:18px;">
                                        <div style="font-size:2.7em; font-weight:900; color:#e30019; line-height:1; letter-spacing:-2px;">${Number(price).toLocaleString()}đ</div>
                                    </div>`;
                                }
                            }
                        }
                        
                        // Show color preview permanently when selected
                        const colorCode = this.dataset.color;
                        const colorName = this.dataset.colorName;
                        previewColorSwatch.style.background = colorCode;
                        previewColorName.textContent = colorName;
                        previewColorPrice.textContent = Number(price).toLocaleString() + 'đ';
                        colorPreview.style.display = 'block';
                        
                        // Add selection animation
                        this.style.animation = 'colorSelect 0.3s ease';
                        setTimeout(() => {
                            this.style.animation = '';
                        }, 300);

                        // Set giá trị color_id đúng trong form
                        if(addToCartForm) {
                            const colorInput = addToCartForm.querySelector('input[name="color_id"]');
                            if(colorInput) colorInput.value = this.dataset.id;
                            console.log('Chọn màu:', this.dataset.id);
                        }
                    });
                });
                
                // Xử lý form submit để cập nhật quantity
                if(addToCartForm) {
                    addToCartForm.addEventListener('submit', function(e) {
                        const qtyInput = document.getElementById('qty');
                        const quantityInput = document.getElementById('addToCartQty');
                        if(qtyInput && quantityInput) {
                            quantityInput.value = qtyInput.value;
                            console.log('Số lượng được cập nhật:', qtyInput.value);
                        }
                    });
                }
                
                // Add CSS animation
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes colorSelect {
                        0% { transform: scale(1); }
                        50% { transform: scale(1.05); }
                        100% { transform: scale(1.01) translateY(-2px); }
                    }
                    
                    .color-option-btn:hover .selection-indicator {
                        transform: scale(1.1);
                    }
                    
                    .color-option-btn.selected {
                        background: linear-gradient(145deg, #f0fff4 0%, #e6fffa 100%) !important;
                    }
                `;
                document.head.appendChild(style);
            });
            </script>
            @endif
            <div class="mb-3">
                <span class="badge" style="font-size:1.1em; background-color: #007BFF; color: white;">Còn hàng</span>
                <span class="badge" style="font-size:1.1em; background-color: #007BFF; color: white;">Mới</span>
            </div>
            <div class="mb-3">
                <label for="qty" class="form-label fw-bold" style="font-size:1.25em; font-weight:600;">Số lượng:</label>
                <input type="number" id="qty" name="qty" value="1" min="1" class="form-control w-100" style="max-width:180px; font-size:1.1em;">
            </div>
            <div class="mb-3 d-flex gap-2 flex-wrap w-100">
                @auth
                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-inline-block w-100" id="addToCartForm">
                    @csrf
                    <input type="hidden" name="quantity" value="1" id="addToCartQty">
                    <input type="hidden" name="color_id" value="">
                    <div id="selectedAddonsInputs"></div>
                    <button type="submit" class="btn fw-bold w-100 mb-3 btn-mobile" style="background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-accent) 100%); color:#fff; font-size:1.3em; padding: 18px 0; border-radius: 12px; box-shadow: 0 8px 25px rgba(227,0,25,0.4); transition: all 0.3s ease; border: none; cursor: pointer; position: relative; overflow: hidden; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">
                        <span style="position: relative; z-index: 2;">🛒 THÊM VÀO GIỎ HÀNG</span>
                        <div style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s; z-index: 1;"></div>
                    </button>
                    {{-- Block sản phẩm mua kèm --}}
                    @if(isset($addons) && $addons->count())
                        <div class="mb-4 addon-section-mobile" id="addon-block" style="margin-top:35px;">
                            <div class="row g-2 g-md-3" style="background: #f8fbff; border: 1.5px solid #dbe7ff; border-radius: 1.2em; padding: 12px 8px 14px 8px;">
                                <div class="fw-bold mb-2 d-flex justify-content-between align-items-center flex-wrap" style="font-size:1.15em; color:#2F74FF;">
                                    <span style="font-size:1.2em;"><i class="bi bi-fire"></i> Mua kèm giá sốc</span>
                                    @if(isset($totalAddons) && $totalAddons > 6)
                                        <a href="#" onclick="showAllAddonsModal(); return false;" style="font-size:0.95em; color:#2F74FF;">Xem tất cả &gt;</a>
                                    @endif
                                </div>
                                @foreach($addons as $addon)
                                    <div class="col-12 col-sm-6 col-md-4 mb-2">
                                        <label class="addon-card d-flex flex-column p-2 p-md-3 rounded-3 shadow-sm w-100 addon-item-mobile" data-url="{{ isset($addon->addonProduct) ? route('product.show', $addon->addonProduct->slug) : '#' }}" style="background:#fff; border:1.5px solid #e6eeff; cursor:pointer; min-height:90px;">
                                            <div class="d-flex align-items-center gap-2 gap-md-3 mb-2">
                                                <input type="checkbox" class="form-check-input addon-checkbox" name="addons[]" value="{{ $addon->id }}" style="margin-top:2px;">
                                                <img src="{{ asset('images/products/' . ($addon->addonProduct->image ?? '')) }}" style="width:56px; height:56px; object-fit:cover; border-radius:10px; border:1.5px solid #eee;">
                                                <div style="flex:1; min-width:0;">
                                                    <div style="font-weight:600; color:#222; font-size:0.98em; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $addon->addonProduct->name ?? '' }}</div>
                                                </div>
                                            </div>
                                            <div style="color:#e30019; font-weight:800; font-size:1.2em; line-height:1.2; text-align:center; padding:4px 0;">
                                                {{ number_format($addon->addon_price, 0, ',', '.') }}đ
                                                @if($addon->addonProduct->price)
                                                    <span style="color:#9aa0a6; font-weight:500; text-decoration:line-through; font-size:0.95em; margin-left:4px;">
                                                        {{ number_format($addon->addonProduct->price, 0, ',', '.') }}đ
                                                    </span>
                                                @endif
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </form>
                @else
                <a href="{{ route('login') }}" class="btn fw-bold w-100 mb-3 btn-mobile" style="background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-accent) 100%); color:#fff; font-size:1.3em; padding: 18px 0; border-radius: 12px; box-shadow: 0 8px 25px rgba(227,0,25,0.4); transition: all 0.3s ease; border: none; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; text-decoration: none;">
                    🔐 ĐĂNG NHẬP ĐỂ MUA
                </a>
                @endauth
            </div>
        </div>
    </div>
    <!-- Đặt block tab ở đây, ngoài row trên -->
    <div class="row">
        <div class="col-12">
            {{-- Tabs chức năng chính, đặc điểm kỹ thuật, hướng dẫn sử dụng, bình luận --}}
            <ul class="nav nav-tabs mb-3" id="productTab" role="tablist" style="font-size:1.7em;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="main-tab" data-bs-toggle="tab" data-bs-target="#main" type="button" role="tab">Các tính năng chính</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="spec-tab" data-bs-toggle="tab" data-bs-target="#spec" type="button" role="tab">Đặc điểm kỹ thuật</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="guide-tab" data-bs-toggle="tab" data-bs-target="#guide" type="button" role="tab">Hướng dẫn sử dụng</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment" type="button" role="tab">Bình luận</button>
                </li>
            </ul>
            <style>
                /* Mobile: biến tabs thành dạng pill cuộn ngang, dễ bấm và gọn */
                @media (max-width: 576px) {
                    #productTab {
                        font-size: 0.95em !important;
                        border-bottom: none !important;
                        display: flex !important;
                        flex-wrap: nowrap !important;
                        gap: 10px !important;
                        overflow-x: auto !important;
                        -webkit-overflow-scrolling: touch !important;
                        padding: 6px 2px 2px !important;
                        scrollbar-width: none; /* Firefox */
                    }
                    #productTab::-webkit-scrollbar { display: none; } /* Chrome/Safari */
                    #productTab .nav-item { flex: 0 0 auto !important; }
                    #productTab .nav-link {
                        white-space: nowrap !important;
                        text-align: center;
                        border-radius: 999px;
                        border: 1px solid #e5e7eb;
                        background: #fff;
                        color: #007BFF;
                        padding: 8px 14px;
                        font-weight: 700;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                    }
                    #productTab .nav-link.active {
                        background: #007BFF !important;
                        color: #fff !important;
                        border-color: #007BFF !important;
                        box-shadow: 0 4px 12px rgba(0,123,255,0.25);
                    }
                }

                /* Nút Xem thêm: thu nhỏ, cân chữ và responsive */
                #toggle-description {
                    font-size: 0.88em !important; /* Desktop to hơn một chút */
                    padding: 6px 12px !important;
                    line-height: 1.15 !important;
                    border-radius: 10px !important;
                }
                #toggle-description .bi { font-size: 0.95em; }
                @media (max-width: 576px) {
                    #toggle-description {
                        font-size: 0.68em !important; /* Mobile nhỏ hơn nữa */
                        padding: 3px 8px !important;
                    }
                }
            </style>
            <div class="tab-content p-3 bg-white rounded shadow-sm" id="productTabContent">
                <div class="tab-pane fade show active" id="main" role="tabpanel">
                   <h5 class="fw-bold mb-2" style="font-size:1.1em;">Mô tả sản phẩm</h5>
                    <div style="position: relative;">
                        <div id="product-description" style="font-size:1.08em; line-height:1.6; max-height: 120px; overflow: hidden; position: relative; border: 1px solid transparent;">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        <div id="description-overlay" style="display: none; position: absolute; bottom: 0; left: 0; right: 0; height: 40px; background: linear-gradient(transparent, white); pointer-events: none; z-index: 1;"></div>
                    </div>
                    <button id="toggle-description" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="bi bi-chevron-down me-1"></i>Xem thêm
                    </button>
                </div>
                <div class="tab-pane fade" id="spec" role="tabpanel">
                   <h5 class="fw-bold mb-2" style="font-size:1.05em;">Thông số kỹ thuật</h5>
                    @php
                        $specs = $product->specifications ?? '';
                    @endphp
                    @if(Str::contains($specs, '<table'))
                        {!! $specs !!}
                    @else
                        <table class="table table-bordered rounded shadow-sm" style="background:#fff; border-radius:12px; overflow:hidden;">
                            <tbody>
                            @foreach(preg_split('/\r?\n/', $specs) as $line)
                                @php
                                    $cols = preg_split('/\t|: /', $line, 2);
                                @endphp
                                @if(trim($cols[0]))
                                    <tr>
                                        <th style="width:220px; background:#F1F1F1; color:#007BFF; font-weight:600;">{{ trim($cols[0]) }}</th>
                                        <td style="background:#FFF7E6;">{{ $cols[1] ?? '' }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="tab-pane fade" id="guide" role="tabpanel">
                   <h5 class="fw-bold mb-2" style="font-size:1.05em;">Hướng dẫn sử dụng</h5>
                    <div>Chưa cập nhật hướng dẫn sử dụng.</div>
                </div>
                <div class="tab-pane fade" id="comment" role="tabpanel">
                   <h5 class="fw-bold mb-2" style="font-size:1.05em;">Bình luận</h5>
                    <div>Chức năng bình luận sẽ cập nhật sau.</div>
                </div>
            </div>

            <div class="bg-white rounded shadow-sm p-3">
                <div class="fw-bold mb-2">Sản phẩm liên quan</div>
                <div>Chức năng này sẽ cập nhật sau.</div>
            </div>
        </div>
    </div>
    <div class="row mt-5 related-products-mobile">
        <div class="col-12">
            <h4 class="fw-bold text-center mb-4" style="letter-spacing:1px; font-size:1.8em;">SẢN PHẨM KHÁC</h4>
            <div class="row g-3 justify-content-center">
                @forelse($relatedProducts as $item)
                    <div class="col-6 col-md-3">
                        <div class="card h-100 shadow-sm border-0 product-card position-relative product-hover-container related-product-card-mobile" style="min-height: 360px; display: flex; flex-direction: column;">
                            <!-- Product Hover Tooltip -->
                            <div class="product-hover-tooltip" style="position:absolute; bottom:0; left:0; width:100%; height:60%; background:linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(240,248,255,0.95) 100%); backdrop-filter:blur(10px); border-radius:0 0 1.5rem 1.5rem; padding:20px; z-index:10; opacity:0; visibility:hidden; transition:all 0.4s cubic-bezier(0.4, 0, 0.2, 1); display:flex; flex-direction:column; justify-content:center; box-shadow:0 8px 32px rgba(0,123,255,0.15); border:2px solid rgba(0,123,255,0.3); border-top:2px solid rgba(0,123,255,0.5);">
                                <div class="tooltip-header mb-3">
                                    <h6 class="fw-bold mb-2" style="color:#1a1a1a; font-size:1.1em; text-shadow:0 1px 2px rgba(0,0,0,0.1);">{{ $item->name }}</h6>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="badge bg-primary" style="font-size:0.75em; padding:4px 8px;">{{ $item->serial_number ?? 'N/A' }}</span>
                                        <span class="badge" style="font-size:0.75em; padding:4px 8px; background-color: #007BFF; color: white;">Còn hàng</span>
                                    </div>
                                </div>
                                <div class="tooltip-content mb-3" style="flex:1;">
                                    <p style="font-size:0.9em; line-height:1.5; color:#444; margin:0; text-shadow:0 1px 1px rgba(255,255,255,0.8);">
                                        {{ Str::limit($item->description ?? 'Sản phẩm chất lượng cao với thiết kế hiện đại, phù hợp cho mọi không gian.', 120) }}
                                    </p>
                                </div>
                                <div class="tooltip-footer">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('product.show', $item->slug) }}" class="btn btn-primary fw-bold flex-fill" style="border-radius:1rem; font-size:0.9em; padding:8px 16px; box-shadow:0 4px 15px rgba(0,123,255,0.3); transition:all 0.3s ease;">
                                            <i class="bi bi-eye me-1"></i>Xem chi tiết
                                        </a>
                                        <button class="btn btn-outline-primary" style="border-radius:1rem; padding:8px 12px; box-shadow:0 2px 8px rgba(0,123,255,0.2);">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('product.show', $item->slug) }}" class="text-decoration-none">
                                <img src="{{ asset('images/products/' . $item->image) }}" class="card-img-top rounded-3" alt="{{ $item->name }}" style="object-fit:cover; max-height:140px; width:auto; max-width:100%; margin:auto;">
                            </a>
                            <div class="card-body pb-2 d-flex flex-column" style="flex:1 1 auto;">
                                <a href="{{ route('product.show', $item->slug) }}" class="text-decoration-none" style="color:#222;">
                                    <h6 class="product-card-title card-title mb-2 product-title-mobile" style="font-size:1.4em; min-height:60px; font-weight:800; line-height:1.3; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $item->name }}</h6>
                                </a>
                                <div class="product-card-desc mb-3 text-truncate" title="{{ $item->description }}" style="font-size:0.95em; color:#666; min-height:20px;">{{ $item->description }}</div>
                                <div class="mb-3" style="min-height:60px;">
                                    <div style="background:#e0f7fa; color:#00796b; font-size:0.9em; border-radius:8px; padding:6px 12px; margin-bottom:4px;">Khách hàng thân thiết: Tặng voucher 100.000đ</div>
                                    <div style="background:#e0f7fa; color:#00796b; font-size:0.9em; border-radius:8px; padding:6px 12px;">Khách hàng doanh nghiệp: Hỗ trợ xuất hóa đơn VAT</div>
                                </div>
                                <div class="product-card-price mb-3" style="min-height:30px; display:flex; align-items:center;">
                                    @if($item->price > 0)
                                        <span class="fw-bold" style="color:#d32f2f; font-size:1.2em;">{{ number_format($item->price, 0, ',', '.') }}đ</span>
                                    @else
                                        <a href="https://zalo.me/0982751039" target="_blank" style="text-decoration:none;">
                                            <span class="fw-bold" style="color:#d32f2f; font-size:1.2em;">Liên hệ</span>
                                        </a>
                                    @endif
                                </div>
                                <a href="{{ route('product.show', $item->slug) }}" class="btn btn-outline-success fw-bold mt-auto" style="color:var(--brand-secondary); border:1.5px solid var(--brand-secondary); font-size:1.1em; padding:8px 16px;">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted" style="font-size:1.2em;">Không có sản phẩm liên quan.</div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $relatedProducts->links('pagination::bootstrap-4') }}
            </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal xem lớn ảnh (full screen + zoom) -->
<div class="modal fade" id="productImageModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content" style="background:rgba(0,0,0,0.9); border:none; box-shadow:none;">
      <div class="modal-body p-0 d-flex justify-content-center align-items-center position-relative" style="min-height:100vh;">
        <!-- Control buttons group - Top right corner -->
        <div class="position-absolute" style="top:20px; right:20px; z-index:1050; display:flex; gap:8px; align-items:center; background:rgba(0,0,0,0.6); padding:8px 12px; border-radius:30px;">
          <!-- Zoom controls -->
          <button id="zoomOutBtn" type="button" class="btn btn-light btn-sm" style="border-radius:50%; width:36px; height:36px; display:flex; align-items:center; justify-content:center; font-size:1.2em; font-weight:bold; padding:0; opacity:0.9;" title="Thu nhỏ">-</button>
          <button id="zoomInBtn" type="button" class="btn btn-light btn-sm" style="border-radius:50%; width:36px; height:36px; display:flex; align-items:center; justify-content:center; font-size:1.2em; font-weight:bold; padding:0; opacity:0.9;" title="Phóng to">+</button>
          <!-- Close button -->
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="margin-left:4px; opacity:1; font-size:1.2em; width:36px; height:36px;"></button>
        </div>
        
        <!-- Navigation buttons -->
        @if($product->images && $product->images->count() > 0)
          <button id="prevBtn" type="button" class="btn btn-light position-absolute" style="left:24px; top:50%; transform:translateY(-50%); z-index:1050; font-size:1.5em; border-radius:50%; width:50px; height:50px; display:flex; align-items:center; justify-content:center; opacity:0.9; box-shadow:0 2px 8px rgba(0,0,0,0.3);" onclick="prevImage()" title="Ảnh trước">
            <i class="bi bi-chevron-left"></i>
          </button>
          <button id="nextBtn" type="button" class="btn btn-light position-absolute" style="right:24px; top:50%; transform:translateY(-50%); z-index:1050; font-size:1.5em; border-radius:50%; width:50px; height:50px; display:flex; align-items:center; justify-content:center; opacity:0.9; box-shadow:0 2px 8px rgba(0,0,0,0.3);" onclick="nextImage()" title="Ảnh sau">
            <i class="bi bi-chevron-right"></i>
          </button>
        @endif
        
        <!-- Image counter -->
        @if($product->images && $product->images->count() > 0)
          <div class="position-absolute" style="bottom:24px; left:50%; transform:translateX(-50%); z-index:1050; background:rgba(0,0,0,0.7); color:#fff; padding:8px 16px; border-radius:20px; font-size:0.9em;">
            <span id="imageCounter">1</span> / <span>{{ $product->images->count() + 1 }}</span>
          </div>
        @endif
        
        <img id="modalProductImage" src="" alt="Ảnh sản phẩm" class="img-fluid rounded" style="max-height:98vh; max-width:98vw; box-shadow:0 4px 32px rgba(0,0,0,0.18); transition: transform 0.2s;" />
      </div>
    </div>
  </div>
</div>


@push('scripts')
<script>
// Product Images Data
const productImages = [
    '{{ asset('images/products/' . $product->image) }}',
    @if($product->images && $product->images->count() > 0)
        @foreach($product->images as $image)
            '{{ asset('images/products/' . $image->image_path) }}'{{ !$loop->last ? ',' : '' }}
        @endforeach
    @endif
];

let currentImageIndex = 0;

// Function to change main image
function changeMainImage(index) {
    console.log('changeMainImage called with index:', index);
    console.log('productImages length:', productImages.length);
    console.log('productImages:', productImages);
    
    if (index >= 0 && index < productImages.length) {
        currentImageIndex = index;
        const mainImg = document.getElementById('mainProductImage');
        
        console.log('Updating main image to:', productImages[index]);
        
        // Update main image
        mainImg.src = productImages[index];
        
        // Update thumbnails
        updateThumbnailSelection(index);
    } else {
        console.log('Invalid index:', index);
    }
}

// Function to update thumbnail selection
function updateThumbnailSelection(activeIndex) {
    // Remove all active indicators
    document.querySelectorAll('.active-indicator').forEach(indicator => {
        indicator.remove();
    });
    
    // Reset all thumbnail borders
    document.querySelectorAll('.product-thumbnail-img').forEach((img, index) => {
        img.style.borderColor = '#e3e8f0';
    });
    
    // Add active indicator and border to selected thumbnail
    const activeThumbnail = document.querySelector(`[data-index="${activeIndex}"]`);
    if (activeThumbnail) {
        activeThumbnail.style.borderColor = '#007bff';
        
        // Add active indicator
        const indicator = document.createElement('div');
        indicator.className = 'active-indicator';
        indicator.style.cssText = 'position:absolute; top:-4px; right:-4px; width:20px; height:20px; background:#007bff; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:0.7em; font-weight:bold;';
        indicator.textContent = '✓';
        activeThumbnail.parentElement.appendChild(indicator);
    }
}

// Function to open image modal
function openImageModal() {
    modalImageIndex = currentImageIndex;
    const modalImg = document.getElementById('modalProductImage');
    if (modalImg && productImages[modalImageIndex]) {
        modalImg.src = productImages[modalImageIndex];
        const modal = new bootstrap.Modal(document.getElementById('productImageModal'));
        modal.show();
    }
}

// Function to open modal with specific image
function openModalWithImage(index) {
    modalImageIndex = index;
    const modalImg = document.getElementById('modalProductImage');
    if (modalImg && productImages[modalImageIndex]) {
        modalImg.src = productImages[modalImageIndex];
        const modal = new bootstrap.Modal(document.getElementById('productImageModal'));
        modal.show();
    }
}

// Navigation functions for modal
function nextImage() {
    modalImageIndex = (modalImageIndex + 1) % productImages.length;
    updateModalImage(modalImageIndex);
}

function prevImage() {
    modalImageIndex = modalImageIndex === 0 ? productImages.length - 1 : modalImageIndex - 1;
    updateModalImage(modalImageIndex);
}

// Function to update modal image
function updateModalImage(index) {
    const modalImg = document.getElementById('modalProductImage');
    const imageCounter = document.getElementById('imageCounter');
    
    if (modalImg && productImages[index]) {
        modalImg.src = productImages[index];
        if (imageCounter) {
            imageCounter.textContent = index + 1;
        }
    }
}

// Variable to track current modal image index
let modalImageIndex = 0;

document.addEventListener('DOMContentLoaded', function() {
    var modalImg = document.getElementById('modalProductImage');
    var zoom = 1;
    
    // Click on main image to open modal - chỉ gắn một lần
    var mainImg = document.getElementById('mainProductImage');
    if(mainImg) {
        mainImg.style.cursor = 'zoom-in';
        mainImg.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openImageModal();
        });
    }
    
    // Zoom controls
    document.getElementById('zoomInBtn').onclick = function() {
        zoom = Math.min(zoom + 0.2, 3);
        modalImg.style.transform = 'scale(' + zoom + ')';
    };
    
    document.getElementById('zoomOutBtn').onclick = function() {
        zoom = Math.max(zoom - 0.2, 1);
        modalImg.style.transform = 'scale(' + zoom + ')';
    };
    
    // Reset zoom when modal is closed
    document.getElementById('productImageModal').addEventListener('hidden.bs.modal', function() {
        zoom = 1;
        modalImg.style.transform = 'scale(1)';
    });

    // Keyboard navigation in modal
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('productImageModal');
        if (modal.classList.contains('show')) {
            if (e.key === 'ArrowRight') {
                nextImage();
            } else if (e.key === 'ArrowLeft') {
                prevImage();
            } else if (e.key === 'Escape') {
                bootstrap.Modal.getInstance(modal).hide();
            }
        }
    });


    // Xử lý chức năng "Xem thêm" cho mô tả sản phẩm
    function initDescriptionToggle() {
        const descriptionElement = document.getElementById('product-description');
        const toggleButton = document.getElementById('toggle-description');
        const overlayElement = document.getElementById('description-overlay');
        
        if (descriptionElement && toggleButton && overlayElement) {
            console.log('Đã tìm thấy các element cần thiết');
            
            const originalHeight = descriptionElement.scrollHeight;
            const maxHeight = 120; // 3-4 dòng (khoảng 120px)
            
            console.log('Chiều cao gốc:', originalHeight, 'px');
            console.log('Chiều cao tối đa:', maxHeight, 'px');
            
            // Kiểm tra nếu nội dung ngắn thì không cần nút "Xem thêm"
            if (originalHeight <= maxHeight) {
                console.log('Nội dung ngắn, ẩn nút và overlay');
                toggleButton.style.display = 'none';
                overlayElement.style.display = 'none';
            } else {
                console.log('Nội dung dài, hiển thị nút và overlay');
                // Hiển thị overlay gradient
                overlayElement.style.display = 'block';
                
                // Thêm event listener
                toggleButton.addEventListener('click', function() {
                    console.log('Nút được click!');
                    console.log('Trạng thái hiện tại:', descriptionElement.style.maxHeight);
                    
                    if (descriptionElement.style.maxHeight === 'none' || descriptionElement.style.maxHeight === '') {
                        // Thu gọn
                        console.log('Thu gọn nội dung');
                        descriptionElement.style.maxHeight = maxHeight + 'px';
                        descriptionElement.style.overflow = 'hidden';
                        overlayElement.style.display = 'block';
                        toggleButton.innerHTML = '<i class="bi bi-chevron-down me-1"></i>Xem thêm';
                    } else {
                        // Mở rộng
                        console.log('Mở rộng nội dung');
                        descriptionElement.style.maxHeight = 'none';
                        descriptionElement.style.overflow = 'visible';
                        overlayElement.style.display = 'none';
                        toggleButton.innerHTML = '<i class="bi bi-chevron-up me-1"></i>Thu gọn';
                    }
                });
                
                console.log('Đã thêm event listener cho nút toggle');
            }
        } else {
            console.error('Không tìm thấy các element cần thiết:');
            console.log('descriptionElement:', descriptionElement);
            console.log('toggleButton:', toggleButton);
            console.log('overlayElement:', overlayElement);
        }
    }
    
    // Khởi tạo ngay khi DOM sẵn sàng
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDescriptionToggle);
    } else {
        initDescriptionToggle();
    }
    
    // Force thay đổi kích thước chữ "Liên hệ" trên mobile
    function adjustContactTextSize() {
        if (window.innerWidth <= 767.98) {
            const contactElements = document.querySelectorAll('.product-contact-price');
            contactElements.forEach(function(el) {
                el.style.setProperty('font-size', '1.5em', 'important');
                el.style.setProperty('font-weight', '600', 'important');
                el.style.setProperty('line-height', '1.2', 'important');
                el.style.setProperty('letter-spacing', '0', 'important');
            });
        }
    }
    
    // Chạy ngay khi load
    adjustContactTextSize();
    
    // Chạy lại khi resize
    window.addEventListener('resize', adjustContactTextSize);
    
    // Chạy lại sau khi DOM load xong (để bắt phần JavaScript động tạo "Liên hệ")
    setTimeout(adjustContactTextSize, 500);
    setTimeout(adjustContactTextSize, 1000);
});
</script>
@endpush 