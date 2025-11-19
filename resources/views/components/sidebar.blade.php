<aside class="bg-white shadow-sm rounded-3 p-2 mb-4" style="min-width:180px; max-width:240px; border:1.5px solid #F1F1F1;">
    <div class="fw-bold mb-2 px-2 pt-2 pb-1 text-uppercase" style="font-size:0.92em; color:var(--brand-secondary); letter-spacing:0.5px;">Danh mục sản phẩm</div>
    <ul class="nav flex-column category-sidebar">
        @php
            $iconMap = [
                'máy chấm công' => 'bi-fingerprint',
                'kiểm soát cửa' => 'bi-door-closed',
                'hệ thống pos' => 'bi-cash-stack',
                'camera' => 'bi-camera-video',
                'phụ kiện' => 'bi-headphones',
                'đồng hồ' => 'bi-watch',
                'âm thanh' => 'bi-mic',
                'tivi' => 'bi-tv',
                'laptop' => 'bi-laptop',
                'pc' => 'bi-pc-display',
                'khuyến mãi' => 'bi-gift',
            ];
            if (!function_exists('renderMenuTree')) {
                function renderMenuTree($categories, $iconMap, $level = 0) {
                    foreach($categories as $cat) {
                        $icon = 'bi-grid-3x3-gap-fill';
                        foreach($iconMap as $key => $val) {
                            if(Str::of(Str::lower($cat->name))->contains($key)) {
                                $icon = $val;
                                break;
                            }
                        }
                        echo '<li class="nav-item mb-1 category-parent" style="position:relative;">';
                        echo '<a href="'.route('category.show', $cat->slug).'" class="nav-link d-flex align-items-center py-2 px-2 rounded-2 small fw-semibold category-link" style="font-size:1.02em;">';
                        if($level == 0) echo '<i class="bi '.$icon.' me-2" style="color:var(--brand-secondary); font-size:1.25em; min-width: 1.5em;"></i> ';
                        echo $cat->name;
                        if($cat->children && $cat->children->count()) {
                            echo '<i class="bi bi-chevron-down ms-auto" style="color:var(--brand-secondary); font-size:0.9em;"></i>';
                        }
                        echo '</a>';
                        if($cat->children && $cat->children->count()) {
                            echo '<ul class="nav flex-column category-submenu ps-4 mt-1" style="background:transparent; box-shadow:none; display:none; position:static;">';
                            renderMenuTree($cat->children, $iconMap, $level+1);
                            echo '</ul>';
                        }
                        echo '</li>';
                    }
                }
            }
            renderMenuTree($categories, $iconMap);
        @endphp
    </ul>
    <hr>
    <a href="{{ route('orders.index') }}" class="d-flex align-items-center gap-2 px-2 py-2 mt-2 rounded-2 fw-semibold" style="color:var(--brand-secondary); font-size:1.04em; text-decoration:none;">
        <i class="bi bi-clock-history" style="font-size:1.2em;"></i> Lịch sử đơn hàng
    </a>
    <style>
        .category-sidebar .category-link {
            color: var(--brand-secondary);
            transition: background 0.15s, color 0.15s;
        }
        .category-sidebar .category-link:hover {
            background: #F1F1F1;
            color: var(--brand-primary);
        }
        .category-sidebar .nav-link.active, .category-sidebar .nav-link:active {
            background: #F1F1F1;
            color: var(--brand-primary);
        }
        /* Ẩn submenu mặc định, chỉ hiện khi hover cha, xổ dọc xuống dưới */
        .category-parent > .category-submenu {
            display: none;
        }
        .category-parent:hover > .category-submenu {
            display: block !important;
            position: static !important;
            box-shadow: none !important;
            background: transparent !important;
        }
    </style>
</aside> 