<!-- Topbar: KHÔNG sticky, chỉ chạy ở trên cùng, cuộn xuống sẽ ẩn -->
<div class="header-topbar py-1 small" style="background: var(--brand-primary); color: #fff; border-bottom: 1px solid #F1F1F1;">
    <div class="container-fluid d-flex align-items-center flex-wrap" style="font-size: 1em;">
        <div class="flex-grow-1 overflow-hidden" style="min-width: 0;">
            <marquee behavior="scroll" direction="left" scrollamount="6" style="font-size: 1em; white-space:nowrap; color:#fff;">
                <i class="bi bi-gift"></i> Ưu đãi doanh nghiệp &nbsp;&nbsp; <i class="bi bi-truck"></i> Giao hàng nhanh toàn quốc &nbsp;&nbsp; <i class="bi bi-shield-check"></i> Chính hãng - Bảo hành 12 tháng &nbsp;&nbsp; <i class="bi bi-geo-alt"></i> Cửa hàng gần bạn
            </marquee>
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap topbar-links" style="margin-left: 32px;">
            <a href="#" class="d-flex align-items-center gap-1 topbar-link" style="color:#fff; text-decoration:none; font-weight:500;">
                <i class="bi bi-geo-alt"></i> Cửa hàng gần bạn
            </a>
            <a href="#" class="d-flex align-items-center gap-1 topbar-link" style="color:#fff; text-decoration:none; font-weight:500;">
                <i class="bi bi-receipt"></i> Tra cứu đơn hàng
            </a>
            <a href="{{ route('warranty.check') }}" class="d-flex align-items-center gap-1 topbar-link" style="color:#fff; text-decoration:none; font-weight:500;">
                <i class="bi bi-shield-check"></i> Tra cứu bảo hành
            </a>
            <a href="tel:0982751075" class="d-flex align-items-center gap-1 topbar-link" style="color:#fff; text-decoration:none; font-weight:500;">
                <i class="bi bi-telephone"></i> 0982 751 075
            </a>
            <a href="#" class="d-flex align-items-center gap-1 topbar-link" style="color:#fff; text-decoration:none; font-weight:500;">
                <i class="bi bi-phone"></i> Tải ứng dụng
            </a>
        </div>
    </div>
</div>

<!-- Đảm bảo đã import Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<!-- Navbar sticky: chỉ logo (to) + menu + search + giỏ hàng + đăng nhập -->
<nav class="navbar navbar-expand-lg shadow-sm sticky-top" style="background: #fff; top:0; z-index:1039; min-height:110px; height:110px; display:flex; align-items:center; border-bottom:1.5px solid #F1F1F1;">
    <div class="container d-flex align-items-center justify-content-between flex-nowrap position-relative" style="height:110px;">
        <!-- Logo to, không có chữ VIKHANG -->
        <a class="navbar-brand d-flex align-items-center justify-content-center me-3 mb-2 mb-lg-0" href="/" style="gap: 12px; min-width:120px; height:100%; align-items:center;">
            <img src="/logovigilance.jpg" alt="Logo" style="height:70px; max-height:70px; display:block; margin:0 auto;">
        </a>
        <!-- Danh mục: Đặt lại về vị trí cũ cạnh logo -->
        <div class="dropdown me-2 mb-2 mb-lg-0 header-category">
            <button class="btn btn-light d-flex align-items-center fw-bold px-3" data-bs-toggle="dropdown" style="color:var(--brand-secondary); border:1.5px solid var(--brand-secondary); background:#fff;">
                <i class="bi bi-grid-3x3-gap-fill me-2" style="color:var(--brand-secondary);"></i> Danh mục <i class="bi bi-chevron-down ms-1"></i>
            </button>
            <ul class="dropdown-menu p-2" style="min-width:260px; max-height:60vh; overflow:auto;">
                @php
                  if(!function_exists('renderHeaderMenu')){
                    function renderHeaderMenu($nodes,$level=0){
                      foreach($nodes as $node){
                        echo '<li class="position-relative header-cat-item">';
                        echo '<a class="dropdown-item d-flex align-items-center" href="'.route('category.show',$node->slug).'">'.e($node->name);
                        if($node->children && $node->children->count()){
                          echo '<i class="bi bi-chevron-down ms-auto small"></i>';
                        }
                        echo '</a>';
                        if($node->children && $node->children->count()){
                          echo '<ul class="list-unstyled ps-3 submenu">';
                          renderHeaderMenu($node->children,$level+1);
                          echo '</ul>';
                        }
                        echo '</li>';
                      }
                    }
                  }
                  renderHeaderMenu($categories);
                @endphp
            </ul>
        </div>
        <!-- Chọn tỉnh/thành -->
        <div class="dropdown me-2 mb-2 mb-lg-0">
            <button class="btn btn-light d-flex align-items-center px-3" data-bs-toggle="dropdown" style="color:var(--brand-secondary); border:1.5px solid var(--brand-secondary); background:#fff;">
                <i class="bi bi-geo-alt-fill me-2" style="color:var(--brand-secondary);"></i> Hồ Chí Minh <i class="bi bi-chevron-down ms-1"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Hà Nội</a></li>
                <li><a class="dropdown-item" href="#">Đà Nẵng</a></li>
                <li><a class="dropdown-item" href="#">Hồ Chí Minh</a></li>
                <li><a class="dropdown-item" href="#">Cần Thơ</a></li>
            </ul>
        </div>
        <!-- Thanh tìm kiếm -->
        <form class="d-flex flex-grow-1 mx-3 mb-2 mb-lg-0 position-relative" role="search" style="max-width:500px;" method="GET" action="{{ route('search') }}">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0" style="border:1.5px solid var(--brand-secondary);"><i class="bi bi-search" style="color:var(--brand-secondary);"></i></span>
                <input class="form-control border-start-0" type="search" name="q" id="mainSearchInput" placeholder="Bạn muốn mua gì hôm nay?" aria-label="Search" style="border:1.5px solid var(--brand-secondary);">
            </div>
            @if(isset($featuredProducts) && $featuredProducts->count())
            <div id="search-featured-dropdown" class="search-featured-dropdown" style="display:none;">
                <div class="px-3 pt-3 pb-2">
                    <div class="fw-bold mb-2" style="font-size:1.08em; color:var(--brand-secondary);">Sẩn Phẩm Mới Nhất <i class="bi bi-fire" style="color:var(--brand-primary);"></i></div>
                    <div class="row g-2">
                        @foreach($featuredProducts as $product)
                        <div class="col-12 d-flex align-items-center gap-2 mb-2">
                            <a href="{{ route('product.show', $product->slug) }}" class="d-flex align-items-center gap-2 text-decoration-none search-featured-item">
                                @php
                                    $imageName = $product->image ?? '';
                                    $imageDir = public_path('images/products/');
                                    $imageUrl = null;
                                    if ($imageName && file_exists($imageDir . $imageName)) {
                                        $imageUrl = asset('images/products/' . $imageName);
                                    } else {
                                        $baseName = pathinfo($imageName, PATHINFO_FILENAME);
                                        $foundName = null;
                                        foreach (['webp','png','jpg','jpeg','JPG','PNG','JPEG'] as $ext) {
                                            if ($baseName && file_exists($imageDir . $baseName . '.' . $ext)) {
                                                $foundName = $baseName . '.' . $ext;
                                                break;
                                            }
                                        }
                                        if ($foundName) {
                                            $imageUrl = asset('images/products/' . $foundName);
                                        } else {
                                            $imageUrl = asset('logovigilance.jpg');
                                        }
                                    }
                                @endphp
                                @php
                                    $primaryUrl = asset('images/products/' . basename($imageUrl));
                                    $fallbackLogo = asset('logovigilance.jpg');
                                @endphp
                                <img src="{{ $primaryUrl }}" alt="{{ $product->name }}" style="width:38px; height:38px; object-fit:cover; border-radius:10px; box-shadow:0 2px 8px #007bff22;"
                                     onerror="this.onerror=null;this.src='{{ $fallbackLogo }}';">
                                <span class="fw-semibold" style="color:#222; font-size:1.04em; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:180px;">{{ $product->name }}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </form>
        <!-- Giỏ hàng -->
        <a href="/cart" class="btn btn-outline-light position-relative d-flex align-items-center me-2 mb-2 mb-lg-0" style="color:var(--brand-secondary); border:1.5px solid var(--brand-secondary); background:#fff;">
            <i class="bi bi-cart3 fs-4" style="color:var(--brand-secondary);"></i>
            <span class="ms-1 d-none d-md-inline" style="color:var(--brand-secondary);">Giỏ hàng</span>
            @if(isset($cartCount) && $cartCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.8em;">{{ $cartCount }}</span>
            @else
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary" style="font-size:0.8em;">0</span>
            @endif
        </a>
        {{-- Đã xóa hoàn toàn nút Yêu thích trên header --}}
        <!-- Đăng nhập -->
        @guest
            <button class="btn d-flex align-items-center gap-2 ms-2" style="border-radius:2em; height:48px; border:1.5px solid var(--brand-secondary); color:var(--brand-secondary); background:#fff;" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="bi bi-person-circle"></i> Đăng nhập
            </button>
        @else
            <div class="dropdown ms-2">
                <a href="#" class="btn btn-outline-primary d-flex align-items-center gap-2 dropdown-toggle"
                   id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                   style="border-radius:2em; height:48px; font-weight:600;">
                    <i class="bi bi-person-circle"></i>
                    {{ Str::words(Auth::user()->name, 1, '') }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-bag"></i> Đơn hàng của tôi</a></li>
                    <li><a class="dropdown-item" href="{{ route('wishlist.index') }}"><i class="bi bi-heart"></i> Yêu thích</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bi bi-box-arrow-right"></i> Đăng xuất
              </a>
                    </li>
                </ul>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endguest
    </div>
</nav>

<style>
.topbar-link:hover {
    color: #fff;
    background: #00B894;
    border-radius: 4px;
    padding: 2px 8px;
    transition: all 0.15s;
}
.navbar .btn, .navbar .btn:focus {
    transition: all 0.18s;
    box-shadow: none;
}
.navbar .btn:hover, .navbar .btn:active {
    background: #007BFF !important;
    color: #fff !important;
    border-color: #007BFF !important;
}
.navbar .btn-outline-success:hover, .navbar .btn-outline-success:active {
    background: #00B894 !important;
    color: #fff !important;
    border-color: #00B894 !important;
}
.navbar .btn-outline-primary:hover, .navbar .btn-outline-primary:active {
    background: #007BFF !important;
    color: #fff !important;
    border-color: #007BFF !important;
}
.navbar .btn-outline-light:hover, .navbar .btn-outline-light:active {
    background: #007BFF !important;
    color: #fff !important;
    border-color: #007BFF !important;
}
.navbar .btn .bi {
    transition: color 0.18s;
}
.navbar .btn:hover .bi, .navbar .btn:active .bi {
    color: #fff !important;
}
.sticky-category-floating {
    position: fixed;
    top: 110px;
    left: 24px;
    z-index: 1050;
    border-radius: 12px;
    box-shadow: 0 4px 24px 0 rgba(0,0,0,0.10);
    background: transparent;
    animation: stickyFadeIn 0.4s;
}
.sticky-category-btn-float {
    border-radius: 12px !important;
    background: #fffbe9 !important;
    color: #FF750F !important;
    font-weight: bold;
    box-shadow: 0 2px 8px 0 rgba(0,0,0,0.06);
    border: 1.5px solid #FFE5B4;
    transition: box-shadow 0.2s;
}
.sticky-category-btn-float:hover {
    background: #FFE5B4 !important;
    color: #FF750F !important;
    box-shadow: 0 6px 24px 0 rgba(0,0,0,0.13);
}
@keyframes stickyFadeIn {
    from { opacity: 0; transform: translateY(-16px); }
    to { opacity: 1; transform: none; }
}
@media (max-width: 991px) {
    .sticky-category-floating { display: none !important; }
    .navbar .container { flex-direction: column; align-items: stretch; }
    .navbar form { margin: 10px 0; }
    
    /* Đảm bảo dropdown menu hiển thị đúng trên mobile */
    .dropdown-menu {
        position: absolute !important;
        right: 0 !important;
        left: auto !important;
        min-width: 180px !important;
    }
}
    .search-featured-dropdown {
        position: absolute;
        top: 110%;
        left: 0;
        width: 100%;
        background: #fff;
        border-radius: 1.2em;
        box-shadow: 0 8px 32px 0 #007bff22;
        z-index: 1051;
        min-width: 320px;
        max-width: 420px;
        border: 1.5px solid #F1F1F1;
        animation: fadeInDropdown 0.18s;
    }
    @keyframes fadeInDropdown {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: none; }
    }
    .search-featured-item:hover span {
        color: #007BFF;
        text-decoration: underline;
    }
    .search-featured-item img {
        transition: transform 0.18s;
    }
    .search-featured-item:hover img {
        transform: scale(1.08);
        box-shadow: 0 4px 16px #007bff33;
    }
</style>

<style>
.user-dropdown-fix {
  white-space: nowrap !important;
  overflow: visible !important;
}

/* Đảm bảo dropdown menu hiển thị đúng */
.dropdown-menu {
  z-index: 1050 !important;
  min-width: 200px !important;
}

.dropdown-item {
  padding: 8px 16px !important;
  font-size: 0.95em !important;
}

.dropdown-item:hover {
  background-color: #f8f9fa !important;
  color: #007BFF !important;
}

/* Hover to open nested submenu like sidebar */
.header-category .dropdown-menu .submenu { display: none; }
.header-category .dropdown-menu li.header-cat-item:hover > .submenu { display: block; }
.header-category .dropdown-menu { overflow: visible; }

.dropdown-divider {
  margin: 4px 0 !important;
}
</style>

<!-- Modal Đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:18px; box-shadow:0 8px 32px #ff750f33; background:linear-gradient(120deg,#fffbe9 0%,#ffe5b4 100%);">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="loginModalLabel" style="color:#FF750F;">
          <i class="bi bi-person-circle me-1" style="font-size:1.5em;"></i> Đăng nhập
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        {{-- Thông báo thành công khi đăng ký xong --}}
        @if (session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        {{-- Hiển thị lỗi đăng nhập --}}
        @if ($errors->any() && !session('showRegisterModal'))
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form id="loginForm" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3 input-group">
            <span class="input-group-text bg-white border-end-0" style="color:#FF750F;"><i class="bi bi-envelope-at"></i></span>
            <input type="email" class="form-control border-start-0" id="loginEmail" name="email" required autofocus autocomplete="username" placeholder="Email">
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text bg-white border-end-0" style="color:#FF750F;"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control border-start-0" id="loginPassword" name="password" required autocomplete="current-password" placeholder="Mật khẩu">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="#" class="text-decoration-underline" style="color:#FF750F; font-size:14px;" data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">Quên mật khẩu?</a>
            <a href="#" class="text-decoration-underline" style="color:#FF750F; font-size:14px;" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Đăng ký</a>
          </div>
          <button type="submit" class="btn w-100 fw-bold d-flex align-items-center justify-content-center gap-2" style="background:#FF750F; color:white; border-radius:8px; font-size:1.1em; box-shadow:0 2px 8px #ff750f33;">
            <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:18px; box-shadow:0 8px 32px #ff750f33; background:linear-gradient(120deg,#fffbe9 0%,#ffe5b4 100%);">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="registerModalLabel" style="color:#FF750F;">
          <i class="bi bi-person-plus-fill me-1" style="font-size:1.5em;"></i> Đăng ký tài khoản
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        {{-- Hiển thị lỗi đăng ký --}}
        @if ($errors->any() && session('showRegisterModal'))
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <form id="registerForm" method="POST" action="{{ route('register') }}">
          @csrf
          <div class="mb-3 input-group">
            <span class="input-group-text bg-white border-end-0" style="color:#FF750F;"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control border-start-0" name="name" required placeholder="Họ tên" value="{{ old('name') }}">
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text bg-white border-end-0" style="color:#FF750F;"><i class="bi bi-envelope-at"></i></span>
            <input type="email" class="form-control border-start-0" name="email" required placeholder="Email" value="{{ old('email') }}">
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text bg-white border-end-0" style="color:#FF750F;"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control border-start-0" name="password" required placeholder="Mật khẩu">
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text bg-white border-end-0" style="color:#FF750F;"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control border-start-0" name="password_confirmation" required placeholder="Nhập lại mật khẩu">
          </div>
          <button type="submit" class="btn w-100 fw-bold d-flex align-items-center justify-content-center gap-2" style="background:#FF750F; color:white; border-radius:8px; font-size:1.1em; box-shadow:0 2px 8px #ff750f33;">
            <i class="bi bi-person-plus"></i> Đăng ký
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Hiển thị lại modal đăng ký nếu có lỗi validate
  @if ($errors->any() && session('showRegisterModal'))
    document.addEventListener('DOMContentLoaded', function() {
      var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
      registerModal.show();
    });
  @endif
</script>

<!-- Modal Quên mật khẩu -->
<div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:18px; box-shadow:0 8px 32px #ff750f33; background:linear-gradient(120deg,#fffbe9 0%,#ffe5b4 100%);">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="forgotModalLabel" style="color:#FF750F;">
          <i class="bi bi-key"></i> Quên mật khẩu
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0">
        <form id="forgotForm" method="POST" action="{{ route('password.email') }}">
          @csrf
          <div class="mb-3 input-group">
            <span class="input-group-text bg-white border-end-0" style="color:#FF750F;"><i class="bi bi-envelope-at"></i></span>
            <input type="email" class="form-control border-start-0" id="forgotEmail" name="email" required autocomplete="username" placeholder="Email">
          </div>
          <button type="submit" class="btn w-100 fw-bold d-flex align-items-center justify-content-center gap-2" style="background:#FF750F; color:white; border-radius:8px; font-size:1.1em; box-shadow:0 2px 8px #ff750f33;">
            <i class="bi bi-send"></i> Gửi liên kết đặt lại mật khẩu
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// Hiện dropdown khi focus/gõ vào input, ẩn khi blur hoặc click ngoài
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('mainSearchInput');
    const dropdown = document.getElementById('search-featured-dropdown');
    if(searchInput && dropdown) {
        searchInput.addEventListener('focus', function() {
            dropdown.style.display = 'block';
        });
        searchInput.addEventListener('input', function() {
            dropdown.style.display = this.value.trim() === '' ? 'block' : 'none';
        });
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target) && e.target !== searchInput) {
                dropdown.style.display = 'none';
            }
        });
    }
});
</script> 