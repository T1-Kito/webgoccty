<!-- Banner Slider (SwiperJS) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .banner-swiper {
        width: 100%; /* giữ nguyên 100% để không lan ra ngoài */
        max-width: 100%; /* giữ nguyên max-width 100% */
        margin-left: 0; /* không margin âm */
        border-radius: 18px; /* tăng bo góc */
        overflow: hidden;
        box-shadow: 0 12px 40px #007BFF50; /* tăng shadow */
        margin-bottom: 40px; /* tăng margin bottom */
        background: linear-gradient(90deg, #FFFFFF 0%, #F1F1F1 100%);
    }
    /* Cố định chiều cao theo slide, ảnh fit vào không bị cắt */
    .swiper-slide {
        height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent; /* không hiện viền nền */
    }
    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* phủ kín khung */
        object-position: center center;
        display: block;
        border-radius: 18px;
        box-shadow: 0 6px 30px 0 #007BFF40; /* tăng shadow */
        transition: transform 0.7s cubic-bezier(.22,1,.36,1), box-shadow 0.4s;
        background: transparent;
    }
    .swiper-slide-active img {
        transform: scale(1.04);
        box-shadow: 0 8px 32px 0 #007BFF44;
        animation: flashGlow 3s infinite;
    }
    
    @keyframes flashGlow {
        0% {
            box-shadow: 0 8px 32px 0 #007BFF44;
            filter: brightness(1);
        }
        25% {
            box-shadow: 0 8px 32px 0 #00B89466, 0 0 20px #00B894;
            filter: brightness(1.1);
        }
        50% {
            box-shadow: 0 8px 32px 0 #FF6B6B66, 0 0 25px #FF6B6B;
            filter: brightness(1.05);
        }
        75% {
            box-shadow: 0 8px 32px 0 #4ECDC466, 0 0 20px #4ECDC4;
            filter: brightness(1.1);
        }
        100% {
            box-shadow: 0 8px 32px 0 #007BFF44;
            filter: brightness(1);
        }
    }
    
    .banner-swiper {
        animation: float 4s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-8px);
        }
    }
    .swiper-pagination-bullet-active {
        background: #00B894;
    }
    .swiper-button-next, .swiper-button-prev {
        color: #007BFF;
    }
    @media (max-width: 991px) {
        .banner-swiper {
            width: 100%;
            margin-left: 0;
            max-width: 100%;
        }
        .swiper-slide { height: 350px; }
    }
    @media (max-width: 768px) {
        .banner-swiper {
            width: 100%;
            margin-left: 0;
            max-width: 100%;
        }
        .swiper-slide { height: 300px; }
    }
    @media (max-width: 600px) {
        .banner-swiper {
            width: 100%;
            margin-left: 0;
            max-width: 100%;
        }
        .swiper-slide { height: 250px; }
    }
</style>
<div class="banner-swiper">
    <div class="swiper">
        <div class="swiper-wrapper">
            @php
                $dbBanners = \App\Models\Banner::active()->orderBy('sort_order')->get();
            @endphp
            @if($dbBanners->count())
                @foreach($dbBanners as $b)
                    <div class="swiper-slide">
                        @if($b->link_url)
                            <a href="{{ $b->link_url }}" target="_blank" rel="noopener">
                                <img src="{{ $b->image_url }}" alt="{{ $b->title ?? 'Banner' }}">
                            </a>
                        @else
                            <img src="{{ $b->image_url }}" alt="{{ $b->title ?? 'Banner' }}">
                        @endif
                    </div>
                @endforeach
            @else
                <div class="swiper-slide"><img src="{{ asset('images/banner1.jpg') }}" alt="Banner 1"></div>
                <div class="swiper-slide"><img src="{{ asset('images/banner2.jpg') }}" alt="Banner 2"></div>
                <div class="swiper-slide"><img src="{{ asset('images/banner3.jpg') }}" alt="Banner 3"></div>
                <div class="swiper-slide"><img src="{{ asset('images/banner4.jpg') }}" alt="Banner 4"></div>
            @endif
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        effect: 'creative',
        creativeEffect: {
            prev: {
                shadow: true,
                translate: [0, 0, -400],
                scale: 0.92,
            },
            next: {
                translate: [0, 0, -400],
                scale: 0.92,
            },
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
