<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VIKHANG')</title>
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Vigilance Việt Nam JSC')">
    <meta property="og:description" content="Vigilance Việt Nam JSC - Cung cấp giải pháp công nghệ và thiết bị chuyên nghiệp">
    <meta property="og:site_name" content="Vigilance Việt Nam JSC">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'Vigilance Việt Nam JSC')">
    <meta name="twitter:description" content="Vigilance Việt Nam JSC - Cung cấp giải pháp công nghệ và thiết bị chuyên nghiệp">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom-fonts.css') }}" onerror="console.error('Failed to load custom-fonts.css')">
    <style>
        :root {
            /* Brand palette derived from logo */
            --brand-primary: #e30019; /* Vigilance red */
            --brand-secondary: #2b2f8e; /* Deep navy/purple subtitle */
            --brand-accent: #ff6f61; /* Warm accent for hovers */
            --brand-muted: #fbeaec; /* Soft red-tint background */
        }
        /* Map Bootstrap tokens to brand */
        :root {
            --bs-primary: var(--brand-primary);
            --bs-primary-rgb: 227, 0, 25;
            --bs-link-color: var(--brand-secondary);
            --bs-link-hover-color: var(--brand-primary);
        }
        /* Generic helpers */
        .text-brand { color: var(--brand-primary) !important; }
        .text-brand-secondary { color: var(--brand-secondary) !important; }
        .bg-brand { background-color: var(--brand-primary) !important; }
        .bg-brand-secondary { background-color: var(--brand-secondary) !important; }
        .border-brand { border-color: var(--brand-primary) !important; }
        .btn-brand { background: var(--brand-primary); color: #fff; border: none; }
        .btn-brand:hover { background: var(--brand-accent); color:#fff; }
    </style>
    <style>
        body { background: #FFFFFF; font-size: 0.97em; }
        .footer { background: #F1F1F1; color: var(--brand-secondary); padding: 24px 0; margin-top: 48px; }
    </style>
    <style>
        /* Floating User Button & Menu */
        #floating-user-menu-root {
            position: fixed;
            left: 32px;
            bottom: 32px;
            z-index: 9999;
            display: flex;
            flex-direction: column-reverse;
            align-items: flex-start;
        }
        
        /* Mobile optimization for floating menu */
        @media (max-width: 768px) {
            #floating-user-menu-root {
                left: 16px;
                bottom: 16px;
            }
            #floating-user-btn {
                width: 48px;
                height: 48px;
                font-size: 24px;
            }
        }
        #floating-user-btn {
            width: 56px;
            height: 56px;
            background: #00B894;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            cursor: pointer;
            color: #fff;
            font-size: 28px;
            border: 4px solid #b2ebf2;
            transition: box-shadow 0.2s;
        }
        #floating-user-btn:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        }
        #floating-user-menu {
            display: none;
            flex-direction: column;
            margin-bottom: 16px;
            animation: slideUp 0.3s;
        }
        #floating-user-menu.show {
            display: flex;
            animation: slideUp 0.3s;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        #floating-user-menu button {
            background: #7ac943;
            color: #fff;
            border: none;
            border-radius: 20px;
            margin-bottom: 10px;
            padding: 10px 24px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            transition: background 0.2s;
        }
        #floating-user-menu button:hover {
            background: #5cb85c;
        }
    </style>
        <style>
  body {
    background: #F4F6FA;
    /* font-size: 0.8em; */
  }
  /* .container, .row, .col-md-3, .col-md-9, .card, .card-title, .card-body, .fw-bold, .mb-4, .text-muted, .btn, .product-card, .product-card * {
    font-size: 0.97em !important;
  }
  .product-card .card-title {
    font-size: 1em !important;
  }
  .product-card .fw-bold {
    font-size: 1.05em !important;
  } */
  .product-card { min-height: 370px; display: flex; flex-direction: column; }
  .product-card .card-body { flex: 1 1 auto; display: flex; flex-direction: column; }
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
  
  /* Mobile optimization for product cards */
  @media (max-width: 768px) {
    .product-card-modern {
      min-height: 380px;
    }
    .product-img-wrap {
      height: 160px;
    }
    .product-img-modern {
      max-height: 140px;
    }
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
  .btn-modern-main {
    background: var(--brand-secondary);
    color: #fff;
    border-radius: 1.2rem;
    font-size: 1.04em;
    box-shadow: 0 2px 8px 0 rgba(43,47,142,0.18);
    border: none;
    padding: 0.65em 0;
    transition: background 0.18s, color 0.18s;
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
</style>
<style>
  /* XÓA html { zoom: 0.9; } để tránh lỗi mobile */
</style>
<!-- Hiệu ứng tuyết rơi Noel -->
<style>
  #snow-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 9998;
    overflow: hidden;
  }
  .snowflake {
    position: absolute;
    top: -50px;
    background-image: url('{{ asset("images/snow/snowflake.jpg") }}');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    opacity: 0.8;
    pointer-events: none;
    animation: snowfall linear;
  }
  @keyframes snowfall {
    0% {
      transform: translateY(0) translateX(0) rotate(0deg);
      opacity: 0.8;
    }
    50% {
      opacity: 0.9;
    }
    100% {
      transform: translateY(100vh) translateX(var(--drift)) rotate(720deg);
      opacity: 0.3;
    }
  }
  /* Nút tắt/bật tuyết */
  #snow-toggle {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid #e30019;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    transition: all 0.3s;
    font-size: 24px;
  }
  #snow-toggle:hover {
    background: #e30019;
    color: white;
    transform: scale(1.1);
  }
  #snow-toggle.active {
    background: #e30019;
    color: white;
  }
  @media (max-width: 768px) {
    #snow-toggle {
      width: 40px;
      height: 40px;
      top: 10px;
      right: 10px;
      font-size: 20px;
    }
  }
</style>
</head>
<body style="min-height: 100vh; display: flex; flex-direction: column; background: #F4F6FA;">
    <!-- Tạm thời comment out để test -->
    <!--
    @include('components.top-marquee')
    <!-- Desktop Header - Ẩn trên mobile -->
    <div class="d-none d-md-block">
        @include('components.header', ['featuredProducts' => $featuredProducts ?? null])
    </div>
    -->
  <main class="container py-4" style="background: #fff; border-radius: 1.5rem; box-shadow: 0 2px 24px rgba(227,0,25,0.08);">
        @yield('content')
    </main>
    <!--
    <footer class="footer mt-5" style="flex-shrink: 0;">
        @include('components.footer')
    </footer>
    -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    
    <!-- Tạm thời comment out debug script để test -->
    <!--
    <script>
    // Debug script để kiểm tra lỗi
    console.log('Script loading...');
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded successfully');
        
        // Kiểm tra Bootstrap
        if (typeof bootstrap !== 'undefined') {
            console.log('Bootstrap loaded successfully');
        } else {
            console.error('Bootstrap not loaded');
        }
        
        // Kiểm tra user dropdown
        const userDropdown = document.getElementById('userDropdown');
        if (userDropdown) {
            console.log('User dropdown found');
        } else {
            console.log('User dropdown not found');
        }
        });
    
    // Kiểm tra xem có lỗi nào không
    window.addEventListener('error', function(e) {
        console.error('JavaScript error:', e.error);
    });
    </script>
    <script>
        // Mở Zalo app trực tiếp khi bấm vào các link zalo.me/xxxx (fallback về web nếu không có app)
        document.addEventListener('click', function (e) {
            var anchor = e.target && e.target.closest('a');
            if (!anchor) return;
            var href = anchor.getAttribute('href') || '';
            if (!/zalo\.me\//i.test(href)) return;

            var match = href.match(/zalo\.me\/(\d{8,15})/i);
            if (!match) return;
            e.preventDefault();

            var phone = match[1];
            var webUrl = 'https://zalo.me/' + phone;
            var isAndroid = /Android/i.test(navigator.userAgent);
            var isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
            var isDesktop = !isAndroid && !isIOS;

            // Deep links
            var deepLinkCandidates = [
                'zalo://chat?phone=' + phone,
                'zalo://conversation?phone=' + phone,
                'zalo://msg?phone=' + phone
            ];
            var intentLink = 'intent://chat?phone=' + phone + '#Intent;scheme=zalo;package=com.zing.zalo;end';

            // Fallback sang web nếu app không bắt được
            var start = Date.now();
            var fallbackTimer = setTimeout(function () {
                // Nếu sau ~800ms vẫn ở lại trang (chưa chuyển đi), mở web
                if (Date.now() - start < 1500) {
                    if (window.open) {
                        window.open(webUrl, '_blank');
                    } else {
                        window.location.href = webUrl;
                    }
                }
            }, 900);

            try {
                if (isAndroid) {
                    window.location.href = intentLink;
                } else if (isIOS) {
                    window.location.href = deepLinkCandidates[0];
                } else if (isDesktop) {
                    // Desktop: tăng cường mở app Zalo bằng nhiều cách (Chrome/Edge/Firefox)
                    // 1) Cố gắng mở trong cùng tab
                    try { window.open(deepLinkCandidates[0], '_self'); } catch (e) {}
                    // 2) Ẩn iframe để kích hoạt custom protocol (một số trình duyệt cần cách này)
                    try {
                        var ifr = document.createElement('iframe');
                        ifr.style.display = 'none';
                        ifr.src = deepLinkCandidates[0];
                        document.body.appendChild(ifr);
                        setTimeout(function(){ if (ifr && ifr.parentNode) ifr.parentNode.removeChild(ifr); }, 1200);
                    } catch (e) {}
                    // 3) Thử thêm method/endpoint khác sau một nhịp ngắn
                    setTimeout(function(){
                        try { window.location.href = deepLinkCandidates[1]; } catch (e) {}
                    }, 250);
                }
            } catch (err) {
                clearTimeout(fallbackTimer);
                window.location.href = webUrl;
            }
        }, true);
    </script>
    -->
    @if(session('showLoginModal'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            } catch (error) {
                console.log('Modal initialization error:', error);
            }
        });
    </script>
    @endif
    <!-- Hiệu ứng tuyết rơi Noel -->
    <div id="snow-container"></div>
    <button id="snow-toggle" title="Tắt/Bật tuyết rơi">❄️</button>
    <script>
      (function() {
        const snowContainer = document.getElementById('snow-container');
        const toggleBtn = document.getElementById('snow-toggle');
        let snowActive = true;
        let snowflakes = [];
        
        // Tạo bông tuyết
        function createSnowflake() {
          if (!snowActive) return;
          
          const snowflake = document.createElement('div');
          snowflake.className = 'snowflake';
          
          // Kích thước ngẫu nhiên (20px - 50px)
          const size = Math.random() * 30 + 20;
          snowflake.style.width = size + 'px';
          snowflake.style.height = size + 'px';
          
          // Vị trí ngẫu nhiên từ trên
          snowflake.style.left = Math.random() * 100 + '%';
          
          // Tốc độ rơi ngẫu nhiên (8s - 15s)
          const fallDuration = Math.random() * 7 + 8;
          snowflake.style.animationDuration = fallDuration + 's';
          
          // Độ lệch ngang khi rơi
          const drift = (Math.random() - 0.5) * 200;
          snowflake.style.setProperty('--drift', drift + 'px');
          
          // Độ mờ ngẫu nhiên
          snowflake.style.opacity = Math.random() * 0.5 + 0.5;
          
          snowContainer.appendChild(snowflake);
          snowflakes.push(snowflake);
          
          // Xóa bông tuyết sau khi rơi xong
          setTimeout(() => {
            if (snowflake.parentNode) {
              snowflake.parentNode.removeChild(snowflake);
            }
            const index = snowflakes.indexOf(snowflake);
            if (index > -1) {
              snowflakes.splice(index, 1);
            }
          }, fallDuration * 1000);
        }
        
        // Tạo tuyết liên tục
        function startSnow() {
          if (!snowActive) return;
          createSnowflake();
          // Tạo bông tuyết mới mỗi 300-800ms
          setTimeout(startSnow, Math.random() * 500 + 300);
        }
        
        // Tắt/bật tuyết
        toggleBtn.addEventListener('click', function() {
          snowActive = !snowActive;
          toggleBtn.classList.toggle('active', snowActive);
          
          if (snowActive) {
            startSnow();
          } else {
            // Xóa tất cả bông tuyết
            snowflakes.forEach(flake => {
              if (flake.parentNode) {
                flake.parentNode.removeChild(flake);
              }
            });
            snowflakes = [];
          }
        });
        
        // Bắt đầu hiệu ứng khi trang load
        if (snowActive) {
          toggleBtn.classList.add('active');
          startSnow();
        }
      })();
    </script>
    <!-- Floating User Button & Menu -->
    <div id="floating-user-menu-root">
        <div id="floating-user-btn" onclick="toggleUserMenu()">
            <i class="bi bi-person-fill"></i>
        </div>
        <div id="floating-user-menu">
            <button onclick="openZalo('0982751075')">CSKH</button>
            <button onclick="openZalo('0982751039')">Tư vấn báo giá</button>
            <button>Bán hàng 2</button>
            <button onclick="openZalo('vigilancevn')">Kỹ thuật vigilancevn</button>
            <button onclick="openZalo('0879774476')">Gặp lỗi Khi đặt hàng</button>
        </div>
    </div>
    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('floating-user-menu');
            menu.classList.toggle('show');
        }
        // Ẩn menu khi click ra ngoài
        document.addEventListener('click', function(event) {
            const btn = document.getElementById('floating-user-btn');
            const menu = document.getElementById('floating-user-menu');
            if (!btn.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.remove('show');
            }
        });
        
        // Hàm mở Zalo với số điện thoại hoặc username
        function openZalo(phoneOrUsername) {
            var webUrl = 'https://zalo.me/' + phoneOrUsername;
            var isAndroid = /Android/i.test(navigator.userAgent);
            var isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
            var isDesktop = !isAndroid && !isIOS;

            // Deep links
            var deepLinkCandidates = [
                'zalo://chat?phone=' + phoneOrUsername,
                'zalo://conversation?phone=' + phoneOrUsername,
                'zalo://msg?phone=' + phoneOrUsername
            ];
            
            // Cho username (vigilancevn), sử dụng web URL
            if (phoneOrUsername === 'vigilancevn') {
                window.open('https://zalo.me/' + phoneOrUsername, '_blank');
                return;
            }
            
            var intentLink = 'intent://chat?phone=' + phoneOrUsername + '#Intent;scheme=zalo;package=com.zing.zalo;end';

            // Fallback sang web nếu app không bắt được
            var start = Date.now();
            var fallbackTimer = setTimeout(function () {
                // Nếu sau ~800ms vẫn ở lại trang (chưa chuyển đi), mở web
                if (Date.now() - start < 1500) {
                    if (window.open) {
                        window.open(webUrl, '_blank');
                    } else {
                        window.location.href = webUrl;
                    }
                }
            }, 900);

            try {
                if (isAndroid) {
                    window.location.href = intentLink;
                } else if (isIOS) {
                    window.location.href = deepLinkCandidates[0];
                } else if (isDesktop) {
                    // Desktop: tăng cường mở app Zalo bằng nhiều cách (Chrome/Edge/Firefox)
                    // 1) Cố gắng mở trong cùng tab
                    try { window.open(deepLinkCandidates[0], '_self'); } catch (e) {}
                    // 2) Ẩn iframe để kích hoạt custom protocol (một số trình duyệt cần cách này)
                    try {
                        var ifr = document.createElement('iframe');
                        ifr.style.display = 'none';
                        ifr.src = deepLinkCandidates[0];
                        document.body.appendChild(ifr);
                        setTimeout(function(){ if (ifr && ifr.parentNode) ifr.parentNode.removeChild(ifr); }, 1200);
                    } catch (e) {}
                    // 3) Thử thêm method/endpoint khác sau một nhịp ngắn
                    setTimeout(function(){
                        try { window.location.href = deepLinkCandidates[1]; } catch (e) {}
                    }, 250);
                }
            } catch (err) {
                clearTimeout(fallbackTimer);
                window.location.href = webUrl;
            }
        }
    </script>
{{-- Widget Chat AI Hỗ trợ tư vấn --}}
<style>
#aiChatWidgetBtn {
    position: fixed;
    bottom: 32px;
    right: 32px;
    z-index: 9999;
    background: #fff;
    border: none;
    box-shadow: 0 2px 12px rgba(0,0,0,0.18);
    border-radius: 50%;
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: box-shadow 0.2s;
}
#aiChatWidgetBtn:hover {
    box-shadow: 0 4px 24px rgba(0,0,0,0.22);
}
#aiChatWidget {
    position: fixed;
    bottom: 110px;
    right: 32px;
    z-index: 10000;
    width: 370px;
    max-width: 98vw;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    overflow: hidden;
    display: none;
    flex-direction: column;
    border: 2.5px solid #ffb300;
}
#aiChatWidget.open {
    display: flex;
}
#aiChatWidgetHeader {
    background: #ffb300;
    color: #fff;
    padding: 16px 18px 12px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 1.18em;
    font-weight: 700;
    border-bottom: 1.5px solid #ffe082;
}
#aiChatWidgetHeader img {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #fff;
}
#aiChatWidgetClose {
    margin-left: auto;
    background: none;
    border: none;
    color: #fff;
    font-size: 1.5em;
    cursor: pointer;
    opacity: 0.8;
}
#aiChatWidgetBody {
    flex: 1 1 auto;
    padding: 16px 14px 0 14px;
    background: #f8fafc;
    overflow-y: auto;
    max-height: 340px;
}
.ai-chat-msg {
    margin-bottom: 12px;
    display: flex;
    align-items: flex-end;
}
.ai-chat-msg.user { justify-content: flex-end; }
.ai-chat-msg .msg {
    max-width: 75%;
    padding: 10px 16px;
    border-radius: 16px;
    font-size: 1.08em;
    line-height: 1.5;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.ai-chat-msg.user .msg {
    background: #e3f7f3;
    color: #007bff;
    border-bottom-right-radius: 4px;
}
.ai-chat-msg.ai .msg {
    background: #fff;
    color: #222;
    border-bottom-left-radius: 4px;
    border: 1.5px solid #ffb300;
}
#aiChatWidgetFooter {
    padding: 10px 14px 14px 14px;
    background: #fff;
    border-top: 1.5px solid #ffe082;
    display: flex;
    gap: 8px;
}
#aiChatInput {
    flex: 1 1 auto;
    border-radius: 12px;
    border: 1.5px solid #e3e8f0;
    padding: 8px 12px;
    font-size: 1.08em;
    outline: none;
}
#aiChatSendBtn {
    background: #ffb300;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 8px 18px;
    font-weight: 600;
    font-size: 1.08em;
    cursor: pointer;
    transition: background 0.2s;
}
#aiChatSendBtn:hover {
    background: #ffa000;
}

/* Mobile Responsive - Chỉ CSS đơn giản */
@media (max-width: 767.98px) {
    .product-card-modern { min-height: 320px; }
    .product-img-wrap { height: 160px !important; }
    .product-img-modern { max-height: 140px !important; object-fit: contain !important; }
    .btn { font-size: 0.9em; padding: 0.5rem 1rem; }
    .card-body { padding: 0.75rem !important; }
}

@media (max-width: 575.98px) {
    .product-card-modern { min-height: 280px; }
    .product-img-wrap { height: 140px !important; }
    .product-img-modern { max-height: 120px !important; object-fit: contain !important; }
    .btn { font-size: 0.85em; padding: 0.4rem 0.8rem; }
    .card-body { padding: 0.5rem !important; }
    .product-price-main { font-size: 0.9em !important; }
    .product-price-old { font-size: 0.8em !important; }
}

/* Mobile Hover Effects */
@media (hover: hover) {
    .list-group-item:hover {
        background-color: #f8f9fa !important;
        transform: translateX(5px);
    }
    
    .hotline-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
}

/* Mobile Touch Feedback */
@media (hover: none) {
    .list-group-item:active {
        background-color: #e9ecef !important;
    }
    
    .hotline-box:active {
        transform: scale(0.98);
    }
}
</style>
<!-- Tạm thời comment out AI chat widget để test -->
<!--
<button id="aiChatWidgetBtn" title="Chat tư vấn AI">
    <img src="{{ asset('logovigilance.jpg') }}" alt="Chat AI" style="width:38px; height:38px;">
</button>
<div id="aiChatWidget">
    <div id="aiChatWidgetHeader">
        <img src="{{ asset('logovigilance.jpg') }}" alt="Logo">
        Chat với nhân viên AI VIKHANG
        <button id="aiChatWidgetClose" title="Đóng">&times;</button>
    </div>
    <div id="aiChatWidgetBody">
        <div class="ai-chat-msg ai">
            <div class="msg">Xin chào{{ Auth::check() ? ', ' . Auth::user()->name : '' }}! 👋<br>Em là trợ lý AI của VIKHANG, anh/chị cần hỗ trợ gì ạ?</div>
        </div>
    </div>
    <div id="aiChatWidgetFooter">
        <input type="text" id="aiChatInput" placeholder="Nhập tin nhắn..." autocomplete="off">
        <button id="aiChatSendBtn">Gửi</button>
    </div>
</div>
-->
<!-- Tạm thời comment out AI chat script để test -->
<!--
<script>
(function(){
    const btn = document.getElementById('aiChatWidgetBtn');
    const widget = document.getElementById('aiChatWidget');
    const closeBtn = document.getElementById('aiChatWidgetClose');
    const body = document.getElementById('aiChatWidgetBody');
    const input = document.getElementById('aiChatInput');
    const sendBtn = document.getElementById('aiChatSendBtn');
    function scrollToBottom(){ body.scrollTop = body.scrollHeight; }
    btn.onclick = function(){ widget.classList.add('open'); setTimeout(scrollToBottom, 100); };
    closeBtn.onclick = function(){ widget.classList.remove('open'); };
    function addMsg(msg, who='user'){
        const div = document.createElement('div');
        div.className = 'ai-chat-msg ' + who;
        div.innerHTML = `<div class="msg">${msg}</div>`;
        body.appendChild(div);
        scrollToBottom();
    }
    function aiReply(userMsg){
        // Demo trả lời tự động, bạn có thể tích hợp API thật nếu muốn
        let reply = '';
        if(userMsg.toLowerCase().includes('giá')) reply = 'Anh/chị vui lòng cho biết số seri (SN) hoặc tên sản phẩm để em báo giá chi tiết nhé!';
        else if(userMsg.toLowerCase().includes('bảo hành')) reply = 'Sản phẩm tại VIKHANG được bảo hành chính hãng 12 tháng, 1 đổi 1 trong 30 ngày nếu lỗi phần cứng.';
        else if(userMsg.toLowerCase().includes('giao hàng')) reply = 'Bên em giao hàng toàn quốc, nhận hàng kiểm tra rồi mới thanh toán ạ!';
        else if(userMsg.length < 3) reply = 'Anh/chị cần hỗ trợ gì ạ?';
        else reply = 'Cảm ơn anh/chị đã liên hệ! Em sẽ chuyển thông tin cho nhân viên tư vấn hỗ trợ chi tiết hơn.';
        setTimeout(()=>addMsg(reply, 'ai'), 700);
    }
    sendBtn.onclick = function(){
        const val = input.value.trim();
        if(!val) return;
        addMsg(val, 'user');
        input.value = '';
        aiReply(val);
    };
    input.addEventListener('keydown', function(e){
        if(e.key==='Enter') sendBtn.onclick();
    });
})();
</script>
-->

</body>
</html> 