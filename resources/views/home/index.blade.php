@extends('layouts.user')

@section('title', 'Vigilance Việt Nam JSC')

@section('content')

<!-- Thông báo lỗi từ middleware -->
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 20px; border-radius: 12px;">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Lỗi:</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Mobile Header (chỉ hiển thị trên mobile) -->
<div class="d-md-none mb-3">
    <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded-3 shadow-sm" style="position: sticky; top: 0; z-index: 1000;">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-primary rounded-circle" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" style="width: 40px; height: 40px;">
                <i class="bi bi-list"></i>
            </button>
            <img src="{{ asset('logovigilance.jpg') }}" alt="Logo" style="height: 35px; max-height: 35px; display: block;">
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('cart.view') }}" class="btn btn-outline-primary position-relative rounded-circle" style="width: 40px; height: 40px;">
                <i class="bi bi-cart3"></i>
                @if(auth()->check() && auth()->user()->cartItems && auth()->user()->cartItems->count() > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7em;">
                        {{ auth()->user()->cartItems->count() }}
                    </span>
                @endif
            </a>
            @auth
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle rounded-circle" type="button" data-bs-toggle="dropdown" style="width: 40px; height: 40px;">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('orders.index') }}">Đơn hàng của tôi</a></li>
                        <li><a class="dropdown-item" href="{{ route('wishlist.index') }}">Yêu thích</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            @else
                <button class="btn btn-outline-primary rounded-circle mobile-login-btn" type="button" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-circle"></i>
                </button>
            @endauth
        </div>
    </div>
</div>

<!-- Mobile Search Bar -->
<div class="d-md-none mb-3">
    <form action="{{ route('search') }}" method="GET" class="d-flex gap-2">
        <input type="text" name="q" class="form-control rounded-pill" placeholder="Tìm kiếm sản phẩm..." value="{{ request('q') }}" style="border: 2px solid var(--brand-secondary);">
        <button type="submit" class="btn btn-primary rounded-pill" style="width: 50px;">
            <i class="bi bi-search"></i>
        </button>
    </form>
</div>



<!-- Desktop Layout -->
<div class="row align-items-stretch mb-4 d-none d-md-flex">
    <!-- Menu dọc bên trái -->
    <div class="col-md-2">
        @include('components.sidebar', ['categories' => $categories])
    </div>
    <!-- Banner lớn ở giữa -->
    <div class="col-md-8 d-flex align-items-stretch">
        <div class="w-100 d-flex align-items-center justify-content-center">
            @include('components.banner-side')
        </div>
    </div>
    <!-- Demo Product Spotlight bên phải -->
    <div class="col-md-2 d-flex flex-column gap-3 justify-content-center">
        <!-- Live Chat Widget -->
        <div class="border-0 rounded-3 p-3 bg-white shadow-sm" style="border:1px solid #dbe7ff; background: linear-gradient(145deg, #ffffff 0%, #f5f9ff 100%);">
            <div class="text-center mb-3">
                <div class="badge mb-2" style="font-size:0.75em; background-color: var(--brand-primary); color:white;">CHAT TRỰC TUYẾN</div>
                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:8px; height:8px; background-color: #28a745;">
                        <div class="rounded-circle bg-white" style="width:4px; height:4px;"></div>
                    </div>
                    <span style="font-size:0.8em; color:#6c757d;">Online</span>
                </div>
            </div>
            <div class="text-center mb-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-size:1.3em; background-color: var(--brand-secondary);">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="fw-bold mb-1" style="font-size:0.9em; color:#333;">Chuyên viên tư vấn</div>
                <div class="text-muted" style="font-size:0.8em;">Sẵn sàng hỗ trợ 24/7</div>
            </div>
            <button class="btn w-100 fw-bold" style="border-radius:8px; font-size:0.9em; background-color: var(--brand-primary); color:white; border:none;" data-bs-toggle="modal" data-bs-target="#chatModal">
                <i class="bi bi-chat-dots me-1"></i>Bắt đầu chat
            </button>
        </div>
        
        <!-- Customer Testimonials Carousel -->
        <div class="border-0 rounded-3 p-3 bg-white shadow-sm" style="border:1px solid #dbe7ff; background: linear-gradient(145deg, #ffffff 0%, #f5f9ff 100%);">
            <div class="text-center mb-3">
                <div class="badge mb-2" style="font-size:0.75em; background-color: var(--brand-secondary); color:white;">ĐÁNH GIÁ KHÁCH HÀNG</div>
                <div class="d-flex justify-content-center mb-2">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                </div>
            </div>
            <div class="testimonial-carousel">
                <div class="testimonial-item text-center mb-3" data-index="0">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">NT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Nguyễn Thị Kiều Trang</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Sản phẩm chất lượng cao, nhân viên tư vấn nhiệt tình, giao hàng đúng hẹn!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="1" style="display:none;">
                    <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">NV</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Nguyễn Văn Thành</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Máy chấm công hoạt động ổn định, bảo hành tốt, giá cả hợp lý!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="2" style="display:none;">
                    <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">LH</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Lê Hữu Phước</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Dịch vụ chuyên nghiệp, sản phẩm chính hãng, hỗ trợ kỹ thuật nhanh chóng!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="3" style="display:none;">
                    <div class="rounded-circle bg-info d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">TT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Trần Thị Minh</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Camera giám sát chất lượng tốt, hình ảnh rõ nét, dễ cài đặt và sử dụng!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="4" style="display:none;">
                    <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">PH</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Phạm Hoàng Nam</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Hệ thống khóa từ hoạt động ổn định, an toàn, tiết kiệm chi phí vận hành!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="5" style="display:none;">
                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">VH</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Võ Hoàng Anh</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Cổng phân làn chất lượng tốt, lắp đặt nhanh, vận hành ổn định!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="6" style="display:none;">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">HT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Hoàng Thị Lan</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Thiết bị báo động hiện đại, cảm biến nhạy, bảo mật cao!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="7" style="display:none;">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">LQ</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Lý Quốc Bình</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Hệ thống POS tính tiền nhanh, giao diện thân thiện, hỗ trợ nhiều phương thức thanh toán!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="8" style="display:none;">
                    <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">DT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Đặng Thị Hương</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Phụ kiện đa dạng, chất lượng tốt, giá cả cạnh tranh!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="9" style="display:none;">
                    <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">BT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Bùi Thanh Tùng</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Phân tầng thang máy hoạt động chính xác, an toàn, tiết kiệm thời gian!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="10" style="display:none;">
                    <div class="rounded-circle bg-info d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">CM</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Châu Minh Khôi</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Dịch vụ bảo trì định kỳ tốt, nhân viên kỹ thuật chuyên nghiệp!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="11" style="display:none;">
                    <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">NT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Ngô Thị Mai</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Sản phẩm chính hãng, bảo hành uy tín, giá cả hợp lý!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="12" style="display:none;">
                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">TH</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Trịnh Hoàng Sơn</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Hệ thống tích hợp hoàn hảo, dễ quản lý, tiết kiệm chi phí!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="13" style="display:none;">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">LH</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Lâm Hoàng Vân</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Giao hàng nhanh chóng, đóng gói cẩn thận, hướng dẫn sử dụng chi tiết!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="14" style="display:none;">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">PT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Phan Thị Ngọc</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Camera IP chất lượng cao, hình ảnh sắc nét, dễ cài đặt!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="15" style="display:none;">
                    <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">VQ</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Vũ Quang Huy</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Máy chấm công vân tay chính xác, bảo mật cao, dễ sử dụng!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="16" style="display:none;">
                    <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">HT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Huỳnh Thị Linh</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Khóa điện tử hiện đại, an toàn, tiện lợi cho gia đình!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="17" style="display:none;">
                    <div class="rounded-circle bg-info d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">ND</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Nguyễn Đức Anh</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Hệ thống kiểm soát cửa ra vào hoạt động ổn định, bảo mật tốt!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="18" style="display:none;">
                    <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">LT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Lê Thị Thanh</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Dịch vụ khách hàng tận tâm, hỗ trợ 24/7, rất hài lòng!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="19" style="display:none;">
                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">TM</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Trần Minh Tuấn</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Sản phẩm đa dạng, đáp ứng mọi nhu cầu, giá cả phải chăng!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="20" style="display:none;">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">PH</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Phạm Hoàng Long</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Hệ thống báo cháy tự động, cảm biến nhạy, an toàn tuyệt đối!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="21" style="display:none;">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">VH</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Vũ Hoàng Nam</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Máy POS tính tiền nhanh, giao diện thân thiện, dễ sử dụng!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="22" style="display:none;">
                    <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">NT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Nguyễn Thị Hoa</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Camera dome chất lượng tốt, góc quay rộng, hình ảnh rõ nét!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="23" style="display:none;">
                    <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">LT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Lý Thị Bích</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Khóa từ thông minh, bảo mật cao, dễ cài đặt và sử dụng!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="24" style="display:none;">
                    <div class="rounded-circle bg-info d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">TH</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Trịnh Hoàng Anh</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Hệ thống quản lý tòa nhà tích hợp hoàn hảo, tiết kiệm chi phí!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="25" style="display:none;">
                    <div class="rounded-circle bg-danger d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">PM</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Phạm Minh Khang</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Dịch vụ bảo trì định kỳ tốt, nhân viên kỹ thuật chuyên nghiệp!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="26" style="display:none;">
                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">VQ</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Vũ Quang Minh</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Cổng xoay chất lượng tốt, lắp đặt nhanh, vận hành ổn định!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="27" style="display:none;">
                    <div class="rounded-circle bg-dark d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">NT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Ngô Thị Lan</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Thiết bị báo động hiện đại, cảm biến nhạy, bảo mật cao!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="28" style="display:none;">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">LH</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Lê Hoàng Sơn</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Hệ thống kiểm soát ra vào hoạt động chính xác, an toàn!"</div>
                </div>
                <div class="testimonial-item text-center mb-3" data-index="29" style="display:none;">
                    <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-2" style="width:50px; height:50px; color:white; font-weight:bold;">TT</div>
                    <div class="fw-bold mb-1" style="font-size:0.9em;">Trần Thị Hương</div>
                    <div class="text-muted" style="font-size:0.8em; line-height:1.4;">"Sản phẩm chính hãng, bảo hành uy tín, giá cả hợp lý!"</div>
                </div>
            </div>

        </div>
        
        <!-- Service Timeline -->
        <div class="border-0 rounded-3 p-3 bg-white shadow-sm" style="border:1px solid #dbe7ff; background: linear-gradient(145deg, #ffffff 0%, #f5f9ff 100%);">
            <div class="text-center mb-3">
                <div class="badge mb-2" style="font-size:0.75em; background-color: var(--brand-secondary); color:white;">QUY TRÌNH LÀM VIỆC</div>
            </div>
            <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:24px; height:24px; color:white; font-size:0.7em; font-weight:bold; background-color: var(--brand-primary);">1</div>
                    <span style="font-size:0.8em; color:#333;">Tư vấn miễn phí</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:24px; height:24px; color:white; font-size:0.7em; font-weight:bold; background-color: var(--brand-primary);">2</div>
                    <span style="font-size:0.8em; color:#333;">Báo giá chi tiết</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:24px; height:24px; color:white; font-size:0.7em; font-weight:bold; background-color: var(--brand-primary);">3</div>
                    <span style="font-size:0.8em; color:#333;">Giao hàng tận nơi</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:24px; height:24px; color:white; font-size:0.7em; font-weight:bold; background-color: var(--brand-primary);">4</div>
                    <span style="font-size:0.8em; color:#333;">Bảo hành 12 tháng</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Banner -->
<div class="d-md-none mb-3">
    @include('components.banner-side')
</div>

<!-- Mobile Chat & Info Boxes -->
<div class="d-md-none mb-3">
    <div class="row g-3">
        <!-- Mobile Chat Widget -->
        <div class="col-12">
            <div class="border-0 rounded-4 p-3 bg-white shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width:45px; height:45px;">
                            <i class="bi bi-headset text-primary" style="font-size: 1.5em;"></i>
                        </div>
                        <div>
                            <div class="fw-bold mb-1" style="font-size:0.95em;">Chuyên viên tư vấn</div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:8px; height:8px; background-color: #00ff88;">
                                    <div class="rounded-circle bg-white" style="width:4px; height:4px;"></div>
                                </div>
                                <span style="font-size:0.8em; opacity: 0.9;">Online 24/7</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="badge bg-white text-primary mb-1" style="font-size:0.7em;">CHAT</div>
                    </div>
                </div>
                <button class="btn w-100 fw-bold" style="border-radius:12px; font-size:0.9em; background-color:white; color:#667eea; border:none; box-shadow: 0 4px 15px rgba(255,255,255,0.3);" data-bs-toggle="modal" data-bs-target="#chatModal">
                    <i class="bi bi-chat-dots me-2"></i>Bắt đầu chat ngay
                </button>
            </div>
        </div>
        
        <!-- Mobile Customer Testimonials -->
        <div class="col-6">
            <div class="border-0 rounded-4 p-3 bg-white shadow-lg h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <div class="text-center mb-2">
                    <div class="d-flex justify-content-center mb-2">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                    <div class="badge bg-white text-danger mb-2" style="font-size:0.7em;">ĐÁNH GIÁ</div>
                </div>
                <div class="text-center">
                    <div class="rounded-circle bg-white d-inline-flex align-items-center justify-content-center mb-2" style="width:35px; height:35px; color:#f5576c; font-weight:bold; font-size:0.9em;">NT</div>
                    <div class="fw-bold mb-1" style="font-size:0.85em;">Nguyễn Thị Kiều Trang</div>
                    <div style="font-size:0.75em; opacity: 0.9; line-height:1.3;">"Sản phẩm chất lượng cao, nhân viên tư vấn nhiệt tình!"</div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Work Process -->
        <div class="col-6">
            <div class="border-0 rounded-4 p-3 bg-white shadow-lg h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <div class="text-center mb-2">
                    <div class="badge bg-white text-info mb-2" style="font-size:0.7em;">QUY TRÌNH</div>
                </div>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width:20px; height:20px; color:#4facfe; font-size:0.7em; font-weight:bold;">1</div>
                        <span style="font-size:0.8em;">Tư vấn</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width:20px; height:20px; color:#4facfe; font-size:0.7em; font-weight:bold;">2</div>
                        <span style="font-size:0.8em;">Báo giá</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width:20px; height:20px; color:#4facfe; font-size:0.7em; font-weight:bold;">3</div>
                        <span style="font-size:0.8em;">Giao hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    // Nếu đã có banner trong DB (module mới), ẩn banner-horizontal cũ để tránh trùng lặp
    $__hasDbBanners = \App\Models\Banner::active()->count() > 0;
@endphp
@if(!$__hasDbBanners)
    <!-- Desktop Banner (fallback khi chưa có banner trong DB) -->
    <div class="mb-4 d-none d-md-block">
        @include('components.banner-horizontal')
    </div>
@endif

{{-- HOT SALE CUỐI TUẦN --}}
@if(isset($hotSaleProducts) && $hotSaleProducts->count())
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<div class="hot-sale-section mb-4 p-3" style="background: linear-gradient(135deg, var(--brand-muted) 0%, #fff 100%); border-radius:1.5rem; box-shadow:0 4px 20px rgba(227,0,25,0.12); border:2.5px solid rgba(227,0,25,0.35);">
    <div class="d-flex align-items-center mb-3">
        <span style="font-size:2.1em; font-weight:900; color:var(--brand-primary); letter-spacing:1px; margin-right:18px;">
            <i class="bi bi-fire" style="font-size:1.2em; color:var(--brand-accent);"></i> HOT SALE CUỐI TUẦN
        </span>
    </div>
    <div class="swiper hot-sale-swiper">
        <div class="swiper-wrapper">
            @foreach($hotSaleProducts as $product)
                @php
                    $discount = $product->discount_percent ?? 0;
                    $oldPrice = $product->price;
                    $finalPrice = $discount ? round($oldPrice * (100 - $discount) / 100, -3) : $oldPrice;
                @endphp
                <div class="swiper-slide">
                    <div class="card h-100 border-0 shadow product-card-modern w-100 position-relative" style="box-shadow:0 6px 24px rgba(43,47,142,0.08);">
                        @if($discount)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size:0.95em; z-index:2;">Giảm {{ $discount }}%</span>
                        @endif
                        <div class="product-img-wrap d-flex align-items-center justify-content-center" style="height:180px; background:#fff; border-radius:1.5rem 1.5rem 0 0; overflow:hidden;">
                        <img src="{{ asset('images/products/' . $product->image) }}" class="product-img-modern" alt="{{ $product->name }}">                        </div>
                        <div class="card-body d-flex flex-column p-3" style="flex:1 1 auto;">
                            <div class="mb-2 d-flex align-items-center gap-1" style="font-size:1.08em; color:#FFC107;">
                                <i class="bi bi-star-fill"></i>
                                <span class="fw-bold" style="color:#222;">{{ number_format(mt_rand(48, 50) / 10, 1) }}</span>
                            </div>
                            <h6 class="card-title fw-bold mb-2" style="font-size:1.08em; font-weight:800; min-height:44px; color:#222; line-height:1.25; letter-spacing:-0.5px; text-transform:capitalize; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; text-overflow:ellipsis;" title="{{ $product->name }}">{{ Str::limit($product->name, 50) }}</h6>
                            <div class="mb-2">
                                @if($product->price == 0)
                                    <span class="product-price-main" style="font-size:1.08em; color:#d32f2f; font-weight:700;">
                                        <a href="https://zalo.me/0982751039" target="_blank" style="text-decoration:none; color:inherit;">Liên hệ</a>
                                    </span>
                                @else
                                    <span class="product-price-main" style="font-size:1.08em; color:#d32f2f; font-weight:700;">{{ number_format($finalPrice, 0, ',', '.') }}đ</span>
                                    @if($discount)
                                        <span class="product-price-old" style="font-size:0.98em; color:#888; text-decoration:line-through; margin-left:6px;">{{ number_format($oldPrice, 0, ',', '.') }}đ</span>
                                    @endif
                                @endif
                            </div>
                            <div style="background:rgba(227,0,25,0.06); color:var(--brand-primary); font-weight:600; border-radius:8px; font-size:0.98em; padding:6px 12px; margin-bottom:4px; margin-top:6px;">Khách hàng thân thiết: Tặng voucher 100.000đ</div>
                            <div style="background:rgba(43,47,142,0.06); color:var(--brand-secondary); font-weight:600; border-radius:8px; font-size:0.98em; padding:6px 12px;">Khách hàng doanh nghiệp: Hỗ trợ xuất hóa đơn VAT</div>
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-modern-main btn-compact flex-fill fw-bold d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-eye"></i> Xem chi tiết
                                </a>
                                @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline-block add-to-cart-form">
                                    @csrf
                                    <button type="submit" class="btn btn-compact flex-fill fw-bold d-flex align-items-center justify-content-center gap-2" style="border-radius:1.2rem; background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-accent) 100%); color:white; border:1px solid rgba(227,0,25,0.65);">
                                        <i class="bi bi-cart-plus"></i> Thêm giỏ hàng
                                    </button>
                                </form>
                                @else
                                <a href="{{ route('login') }}" class="btn btn-compact flex-fill fw-bold d-flex align-items-center justify-content-center gap-2" style="border-radius:1.2rem; background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-accent) 100%); color:white; border:1px solid rgba(227,0,25,0.65);">
                                    <i class="bi bi-cart-plus"></i> Thêm giỏ hàng
                                </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Testimonial Carousel
        let currentTestimonial = 0;
        const testimonials = document.querySelectorAll('.testimonial-item');
        
        function showTestimonial(index) {
            testimonials.forEach(item => item.style.display = 'none');
            testimonials[index].style.display = 'block';
        }
        
        function nextTestimonial() {
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(currentTestimonial);
        }
        
        // Auto change every 3 seconds
        setInterval(nextTestimonial, 3000);
        
        // Chat Modal Options (mở Zalo tin cậy hơn, tránh bị chặn popup)
        document.querySelectorAll('.chat-option-card').forEach(card => {
            card.addEventListener('click', function (e) {
                e.preventDefault();
                const service = this.getAttribute('data-service');
                let phoneNumber = '';

                switch (service) {
                    case 'consultation':
                        phoneNumber = '0982751039';
                        break;
                    case 'technical':
                        phoneNumber = '0919006976';
                        break;
                    case 'warranty':
                        phoneNumber = '0968220919';
                        break;
                }

                const zaloWebUrl = `https://zalo.me/${phoneNumber}`;

                // Cách 1: tạo anchor tạm và click (ít bị chặn hơn window.open trực tiếp)
                const a = document.createElement('a');
                a.href = zaloWebUrl;
                a.target = '_blank';
                a.rel = 'noopener noreferrer';
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);

                // Cách 2 (fallback): nếu popup bị chặn, mở trên tab hiện tại
                setTimeout(() => {
                    try {
                        // Kiểm tra nhanh nếu tab mới không mở được
                        // Trình duyệt không có API kiểm tra chắc chắn, nên dùng fallback sau 100ms
                        window.location.href = zaloWebUrl;
                    } catch (_) {}
                }, 150);

                // Đóng modal sau khi kích hoạt mở link
                const modal = bootstrap.Modal.getInstance(document.getElementById('chatModal'));
                if (modal) modal.hide();
            });
        });
        
        
        // Hot Sale Swiper
        new Swiper('.hot-sale-swiper', {
            slidesPerView: 5,
            spaceBetween: 24,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            speed: 700,
            effect: 'slide', // Đơn giản, không nghiêng, không 3D
            grabCursor: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            breakpoints: {
                1200: { slidesPerView: 5, spaceBetween: 24 },
                992: { slidesPerView: 4, spaceBetween: 20 },
                768: { slidesPerView: 3, spaceBetween: 16 },
                576: { slidesPerView: 2, spaceBetween: 12 },
                0: { slidesPerView: 1.2, spaceBetween: 10 }
            }
        });
    });
</script>
@endif
{{-- END HOT SALE CUỐI TUẦN --}}

<!-- Sản phẩm nổi bật (dữ liệu thật) -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0" style="color:var(--brand-secondary); font-size:1.15rem; letter-spacing:0.5px;">Sản phẩm nổi bật</h3>
        @auth
        <a href="{{ route('wishlist.index') }}" class="btn btn-outline-danger d-flex align-items-center gap-2 fw-bold" style="border-radius:1.2rem; font-size:1.04em;">
            <i class="bi bi-heart-fill"></i> Xem danh sách yêu thích
        </a>
        @endauth
    </div>
    <div class="row g-3 g-md-4 justify-content-center">
        @foreach($products as $product)
            @php
                // Random số sao từ 4.8 đến 5.0, làm tròn 1 số thập phân
                $star = number_format(mt_rand(48, 50) / 10, 1);
                $discount = $product->discount_percent ?? 0;
                $oldPrice = $product->price;
                $finalPrice = $discount ? round($oldPrice * (100 - $discount) / 100, -3) : $oldPrice;
            @endphp
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-5th d-flex">
                <div class="card h-100 border-0 shadow product-card-modern w-100 position-relative">
                    {{-- Nút thả tim --}}
                    <div class="position-absolute top-0 end-0 m-2" style="z-index:3;">
                        @auth
                            @php
                                $isFavorited = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                            @endphp
                            <button type="button" class="btn btn-light p-1 wishlist-btn" data-product-id="{{ $product->id }}" style="border-radius:50%; box-shadow:0 2px 8px rgba(43,47,142,0.13);">
                                <i class="bi bi-heart{{ $isFavorited ? '-fill text-danger' : '' }}" style="font-size:1.35em;"></i>
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light p-1" style="border-radius:50%; box-shadow:0 2px 8px rgba(43,47,142,0.13);">
                                <i class="bi bi-heart" style="font-size:1.35em;"></i>
                            </a>
                        @endauth
                    </div>
                    @if($discount)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="font-size:0.95em; z-index:2;">Giảm {{ $discount }}%</span>
                    @endif
                    <div class="product-img-wrap d-flex align-items-center justify-content-center" style="height:210px; background:#fff; border-radius:1.5rem 1.5rem 0 0; overflow:hidden;">
                        <a href="{{ route('product.show', $product->slug) }}" class="d-block w-100 h-100">
                            <img src="{{ asset('images/products/' . $product->image) }}" class="product-img-modern" alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div class="card-body d-flex flex-column p-3" style="flex:1 1 auto;">
                        {{-- Hiển thị số sao --}}
                        <div class="mb-2 d-flex align-items-center gap-1" style="font-size:1.08em; color:#FFC107;">
                            <i class="bi bi-star-fill"></i>
                            <span class="fw-bold" style="color:#222;">{{ $star }}</span>
                        </div>
                        <a href="{{ route('product.show', $product->slug) }}" style="text-decoration:none; color:inherit;">
                            <h6 class="card-title fw-bold mb-2" style="font-size:0.92em; font-weight:600; min-height:32px; color:#222; line-height:1.22; letter-spacing:-0.05px; text-transform:capitalize; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; text-overflow:ellipsis;" title="{{ $product->name }}">{{ Str::limit($product->name, 45) }}</h6>
                        </a>
                        <div class="mb-2">
                            @if($product->price == 0)
                                <span class="product-price-main" style="font-size:0.98em; color:#d32f2f; font-weight:700;">
                                    <a href="https://zalo.me/0982751039" target="_blank" style="text-decoration:none; color:inherit;">Liên hệ</a>
                                </span>
                            @else
                                <span class="product-price-main" style="font-size:0.98em; color:#d32f2f; font-weight:700;">{{ number_format($finalPrice, 0, ',', '.') }}đ</span>
                                @if($discount)
                                    <span class="product-price-old" style="font-size:0.92em; color:#888; text-decoration:line-through; margin-left:6px;">{{ number_format($oldPrice, 0, ',', '.') }}đ</span>
                                @endif
                            @endif
                            <div style="background:rgba(227,0,25,0.08); color:var(--brand-primary); font-weight:600; border-radius:8px; font-size:0.95em; padding:5px 10px; margin-bottom:4px; margin-top:6px;">Khách hàng thân thiết: Tặng voucher 100.000đ</div>
                            <div style="background:rgba(43,47,142,0.08); color:var(--brand-secondary); font-weight:600; border-radius:8px; font-size:0.95em; padding:5px 10px;">Khách hàng doanh nghiệp: Hỗ trợ xuất hóa đơn VAT</div>
                        </div>
                        <div class="mb-2 text-truncate" style="font-size:0.95em; color:#444; max-width:100%;" title="{{ $product->description }}">{{ Str::limit($product->description, 60) }}</div>
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
</div>

@auth
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.wishlist-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var productId = this.getAttribute('data-product-id');
            var icon = this.querySelector('i');
            fetch("{{ route('wishlist.toggle') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'added') {
                    icon.classList.add('bi-heart-fill', 'text-danger');
                    icon.classList.remove('bi-heart');
                } else {
                    icon.classList.remove('bi-heart-fill', 'text-danger');
                    icon.classList.add('bi-heart');
                }
            });
        });
    });
});
</script>
@endauth

<style>
    .product-card .card-title {
        font-size: 1em !important;
        word-wrap: break-word;
        hyphens: auto;
    }
    .product-card .fw-bold {
        font-size: 1.05em !important;
    }
    .product-card-modern .card-title {
        word-wrap: break-word;
        hyphens: auto;
        text-overflow: ellipsis;
        overflow: hidden;
    }
.product-card { min-height: 370px; display: flex; flex-direction: column; }
.product-card .card-body { flex: 1 1 auto; display: flex; flex-direction: column; }
.product-card:hover {
    box-shadow: 0 6px 24px 0 rgba(0,0,0,0.12), 0 1.5px 6px 0 rgba(0,0,0,0.08);
    z-index: 2;
}
.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.product-card-modern {
    border-radius: 1.5rem;
    box-shadow: 0 4px 24px 0 rgba(0,0,0,0.10);
    transition: box-shadow 0.25s, transform 0.18s;
    background: #fff;
    overflow: hidden;
    min-height: 420px;
    display: flex;
    flex-direction: column;
}
.product-card-modern:hover {
    box-shadow: 0 8px 32px 0 rgba(255,117,15,0.13), 0 2px 8px 0 rgba(0,0,0,0.08);
    transform: translateY(-4px) scale(1.025);
    z-index: 3;
}
.product-img-wrap {
    background: #fffbe9;
    border-radius: 1.5rem 1.5rem 0 0;
    overflow: hidden;
    height: 210px;
}
.product-img-modern {
    max-height: 180px;
    max-width: 100%;
    width: auto;
    margin: 0 auto;
    transition: transform 0.25s;
    display: block;
}
.product-card-modern:hover .product-img-modern {
    transform: scale(1.08);
}
.btn-modern-main {
    background: var(--brand-secondary);
    color: #fff;
    border-radius: 1.2rem;
        font-size: 0.95em;
        padding: 0.55em 0.9em;
        box-shadow: 0 2px 8px 0 rgba(43,47,142,0.18);
    border: none;
    transition: background 0.18s, color 0.18s;
}
.btn-compact {
    font-size: 0.88em !important;
    padding: 0.45em 0.8em !important;
    line-height: 1.1 !important;
}
.btn-modern-main:hover {
    background: var(--brand-primary);
    color: #fff;
}
@media (min-width: 1200px) {
  .col-xl-5th {
    flex: 0 0 20%;
    max-width: 20%;
  }
}
.pagination {
    border-radius: 1.5rem;
    box-shadow: 0 2px 12px 0 rgba(227,0,25,0.07);
    padding: 0.5rem 1.2rem;
    background: #fff;
    gap: 0.25rem;
}
.pagination .page-item .page-link {
    border-radius: 0.8rem !important;
    border: 1.5px solid var(--brand-secondary);
    color: var(--brand-secondary);
    font-weight: 500;
    margin: 0 2px;
    transition: all 0.18s;
    box-shadow: none;
}
.pagination .page-item.active .page-link,
.pagination .page-item .page-link:focus,
.pagination .page-item .page-link:hover {
    background: var(--brand-primary);
    color: #fff;
    border-color: var(--brand-primary);
    box-shadow: 0 2px 8px rgba(227,0,25,0.13);
}
.pagination .page-item.disabled .page-link {
    color: #ccc;
    background: #f8f9fa;
    border-color: #eee;
}
.hotline-box {
    box-shadow: 0 2px 10px 0 rgba(227,0,25,0.07) !important;
    border-radius: 1.2rem !important;
    min-height: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-size: 0.98em;
    transition: box-shadow 0.18s, border 0.18s;
}
.hotline-box:hover {
    box-shadow: 0 4px 18px 0 rgba(227,0,25,0.13) !important;
    border-width: 2px !important;
    background: var(--brand-muted) !important;
}
.hotline-box:hover .bi,
.hotline-box:hover .fw-bold {
    color: var(--brand-primary) !important;
}
.hotline-box:not(:last-child) {
    margin-bottom: 30px !important;
}
.product-price-main {
    color: #e30019;
    font-size: 1.3em;
    font-weight: 700;
    line-height: 1.1;
    letter-spacing: 0.2px;
    font-family: 'Arial', 'Helvetica Neue', Helvetica, sans-serif;
    display: inline-block;
}
.product-price-old {
    color: #888;
    font-size: 1em;
    text-decoration: line-through;
    margin-left: 10px;
    font-weight: 400;
    vertical-align: middle;
}

/* Chat Modal Styles */
.chat-option-card {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.chat-option-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.chat-option-card:active {
    transform: translateY(0);
}

/* Mobile optimizations */
@media (max-width: 767.98px) {
  html, body { overflow-x: hidden; }
  .hot-sale-section { border-radius: 1rem; padding: 1rem; }
  .product-img-wrap { height: 150px; }
  .product-img-modern { max-height: 130px; }
  .product-card-modern { border-radius: 1rem; min-height: 0; }
  .btn-modern-main { font-size: 0.95em; padding: 0.55em 0; }
  .swiper-button-next, .swiper-button-prev { display: none; }
  .swiper-pagination { bottom: 0; }
  .rounded-4 { border-radius: 14px !important; }
  .shadow-lg { box-shadow: 0 6px 18px rgba(0,0,0,0.08)!important; }
}
</style>

<script>
// Đảm bảo luôn bắt sự kiện click (kể cả khi phần Hot Sale không render)
document.addEventListener('click', function(e) {
    const card = e.target.closest('.chat-option-card');
    if (!card) return;
    e.preventDefault();

    const service = card.getAttribute('data-service');
    let phoneNumber = '';
    switch (service) {
        case 'consultation':
            phoneNumber = '0982751039';
            break;
        case 'technical':
            phoneNumber = '0919006976';
            break;
        case 'warranty':
            phoneNumber = '0968220919';
            break;
    }
    if (!phoneNumber) return;

    const zaloWebUrl = `https://zalo.me/${phoneNumber}`;
    const a = document.createElement('a');
    a.href = zaloWebUrl;
    a.target = '_blank';
    a.rel = 'noopener noreferrer';
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    // Fallback
    setTimeout(() => {
        try { window.location.href = zaloWebUrl; } catch (_) {}
    }, 200);

    const modalEl = document.getElementById('chatModal');
    if (modalEl && typeof bootstrap !== 'undefined') {
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();
    }
});
</script>

<!-- Chat Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="chatModalLabel">
                    <i class="bi bi-chat-dots text-primary me-2"></i>Chọn dịch vụ hỗ trợ
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row g-3">
                    <!-- Tư vấn & Báo giá -->
                    <div class="col-12">
                        <div class="chat-option-card" data-service="consultation" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 16px; padding: 24px; color: white; cursor: pointer; transition: all 0.3s ease; border: none; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; box-shadow: 0 4px 15px rgba(255,255,255,0.3);">
                                        <i class="bi bi-headset text-primary" style="font-size: 1.8em;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1" style="font-size: 1.1em;">Tư vấn sản phẩm & Báo giá</h6>
                                    <p class="mb-0" style="font-size: 0.95em; opacity: 0.95;">Nhận tư vấn chi tiết và báo giá tốt nhất</p>
                                </div>
                                <div>
                                    <i class="bi bi-arrow-right-circle text-white" style="font-size: 1.3em;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hỗ trợ kỹ thuật -->
                    <div class="col-12">
                        <div class="chat-option-card" data-service="technical" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 16px; padding: 24px; color: white; cursor: pointer; transition: all 0.3s ease; border: none; box-shadow: 0 8px 25px rgba(240, 147, 251, 0.3);">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; box-shadow: 0 4px 15px rgba(255,255,255,0.3);">
                                        <i class="bi bi-gear-wide-connected text-danger" style="font-size: 1.8em;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1" style="font-size: 1.1em;">Hỗ trợ kỹ thuật</h6>
                                    <p class="mb-0" style="font-size: 0.95em; opacity: 0.95;">Giải đáp thắc mắc và hỗ trợ cài đặt</p>
                                </div>
                                <div>
                                    <i class="bi bi-arrow-right-circle text-white" style="font-size: 1.3em;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Thông tin bảo hành -->
                    <div class="col-12">
                        <div class="chat-option-card" data-service="warranty" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 16px; padding: 24px; color: white; cursor: pointer; transition: all 0.3s ease; border: none; box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; box-shadow: 0 4px 15px rgba(255,255,255,0.3);">
                                        <i class="bi bi-patch-check-fill text-info" style="font-size: 1.8em;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1" style="font-size: 1.1em;">Thông tin bảo hành</h6>
                                    <p class="mb-0" style="font-size: 0.95em; opacity: 0.95;">Tra cứu và hỗ trợ bảo hành sản phẩm</p>
                                </div>
                                <div>
                                    <i class="bi bi-arrow-right-circle text-white" style="font-size: 1.3em;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sidebar -->
@include('components.mobile-sidebar', ['categories' => $categories])

<!-- Include Login Modal -->

<!-- Mobile Login Modal -->
<div id="mobileLoginModal" class="mobile-modal-overlay" style="display: none;">
    <div class="mobile-modal-content">
        <div class="mobile-modal-header">
            <h5 class="mobile-modal-title">
                <i class="bi bi-person-circle me-2"></i>Đăng nhập
            </h5>
            <button type="button" class="mobile-modal-close" onclick="closeMobileLoginModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="mobile-modal-body">
            <div id="mobileLoginAlert" class="alert" style="display: none;"></div>
            <form id="mobileLoginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="mobileLoginEmail" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
                        <input type="email" class="form-control" id="mobileLoginEmail" name="email" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="mobileLoginPassword" class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="mobileLoginPassword" name="password" required>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="mobileRemember" name="remember">
                    <label class="form-check-label" for="mobileRemember">Ghi nhớ đăng nhập</label>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="#" class="text-decoration-none">Quên mật khẩu?</a>
                    <a href="#" class="text-decoration-none">Đăng ký</a>
                </div>
                <button type="submit" class="btn btn-primary w-100" id="mobileLoginSubmitBtn">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.mobile-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.mobile-modal-content {
    background: white;
    border-radius: 18px;
    width: 100%;
    max-width: 400px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 8px 32px rgba(255, 117, 15, 0.2);
}

.mobile-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 20px 0 20px;
    border-bottom: none;
}

.mobile-modal-title {
    color: #FF750F;
    font-weight: bold;
    margin: 0;
}

.mobile-modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #666;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mobile-modal-close:hover {
    color: #333;
}

.mobile-modal-body {
    padding: 20px;
}

@media (max-width: 575.98px) {
    .mobile-modal-overlay {
        padding: 10px;
    }
    
    .mobile-modal-content {
        border-radius: 0;
        height: 100vh;
        max-height: 100vh;
    }
    
    .mobile-modal-header {
        padding: 15px 15px 0 15px;
    }
    
    .mobile-modal-body {
        padding: 15px;
    }
}

/* Alert styling for mobile modal */
#mobileLoginAlert {
    margin-bottom: 20px;
    border-radius: 12px;
    border: none;
    font-size: 0.95em;
    padding: 12px 16px;
}

#mobileLoginAlert.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border-left: 4px solid #28a745;
}

#mobileLoginAlert.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

#mobileLoginAlert.alert-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    color: #856404;
    border-left: 4px solid #ffc107;
}

#mobileLoginAlert.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    color: #0c5460;
    border-left: 4px solid #17a2b8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Home page loaded');
    
    // Mobile login button functionality
    const mobileLoginBtn = document.querySelector('.mobile-login-btn');
    if (mobileLoginBtn) {
        console.log('Mobile login button found');
        mobileLoginBtn.addEventListener('click', function(e) {
            console.log('Mobile login button clicked');
            e.preventDefault();
            openMobileLoginModal();
        });
    } else {
        console.log('Mobile login button not found');
    }
    
    // Close modal when clicking outside
    const modalOverlay = document.getElementById('mobileLoginModal');
    if (modalOverlay) {
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                closeMobileLoginModal();
            }
        });
    }
    
    // Handle mobile login form submission
    const mobileLoginForm = document.getElementById('mobileLoginForm');
    if (mobileLoginForm) {
        mobileLoginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleMobileLogin();
        });
    }
});

function openMobileLoginModal() {
    console.log('Opening mobile login modal');
    const modal = document.getElementById('mobileLoginModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        // Clear previous alerts
        hideMobileLoginAlert();
        // Focus on email input
        const emailInput = document.getElementById('mobileLoginEmail');
        if (emailInput) {
            setTimeout(() => emailInput.focus(), 100);
        }
    }
}

function closeMobileLoginModal() {
    console.log('Closing mobile login modal');
    const modal = document.getElementById('mobileLoginModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        // Clear form and alerts
        clearMobileLoginForm();
    }
}

function handleMobileLogin() {
    const form = document.getElementById('mobileLoginForm');
    const submitBtn = document.getElementById('mobileLoginSubmitBtn');
    const email = document.getElementById('mobileLoginEmail').value;
    const password = document.getElementById('mobileLoginPassword').value;
    
    // Validation
    if (!email || !password) {
        showMobileLoginAlert('Vui lòng nhập đầy đủ email và mật khẩu', 'danger');
        return;
    }
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Đang xử lý...';
    
    // Lấy CSRF token
    const csrfToken = document.querySelector('input[name="_token"]').value;
    console.log('CSRF Token:', csrfToken);
    
    // Sử dụng FormData để gửi form
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    formData.append('remember', document.getElementById('mobileRemember').checked);
    
    console.log('Submitting form to:', form.action);
    console.log('Form data:', {
        email: email,
        password: password,
        remember: document.getElementById('mobileRemember').checked
    });
    
    // Submit form via AJAX
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Kiểm tra content type
        const contentType = response.headers.get('content-type');
        console.log('Content-Type:', contentType);
        
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            // Nếu không phải JSON, có thể là redirect
            console.log('Non-JSON response, likely a redirect');
            return { success: true, redirect: true };
        }
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.redirect || data.success) {
            // Login successful
            showMobileLoginAlert('Đăng nhập thành công!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            // Login failed
            const errorMessage = data.message || 'Email hoặc mật khẩu không đúng';
            showMobileLoginAlert(errorMessage, 'danger');
            // Reset password field
            document.getElementById('mobileLoginPassword').value = '';
            document.getElementById('mobileLoginPassword').focus();
        }
    })
    .catch(error => {
        console.error('Login error:', error);
        
        // Xử lý các loại lỗi khác nhau
        let errorMessage = 'Có lỗi xảy ra, vui lòng thử lại';
        
        if (error.message.includes('HTTP error')) {
            if (error.message.includes('422')) {
                errorMessage = 'Email hoặc mật khẩu không đúng';
            } else if (error.message.includes('419')) {
                errorMessage = 'Phiên làm việc hết hạn, vui lòng tải lại trang';
            } else if (error.message.includes('500')) {
                errorMessage = 'Lỗi server, vui lòng thử lại sau';
            }
        }
        
        showMobileLoginAlert(errorMessage, 'danger');
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập';
    });
}

function showMobileLoginAlert(message, type) {
    const alertDiv = document.getElementById('mobileLoginAlert');
    if (alertDiv) {
        alertDiv.className = `alert alert-${type}`;
        alertDiv.innerHTML = message;
        alertDiv.style.display = 'block';
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideMobileLoginAlert();
        }, 5000);
    }
}

function hideMobileLoginAlert() {
    const alertDiv = document.getElementById('mobileLoginAlert');
    if (alertDiv) {
        alertDiv.style.display = 'none';
    }
}

function clearMobileLoginForm() {
    const form = document.getElementById('mobileLoginForm');
    if (form) {
        form.reset();
        hideMobileLoginAlert();
    }
}
</script>

@endsection 