@extends('layouts.admin')

@section('title', 'Quản lý bảo hành')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0" style="color: #2c3e50; font-weight: 700;">
                <i class="bi bi-shield-check me-2" style="color: #3498db;"></i> Quản lý bảo hành
            </h1>
            <p class="text-muted mb-0" style="font-size: 1.1em;">Quản lý thông tin bảo hành sản phẩm</p>
        </div>
        <div class="d-flex gap-3">
            <a href="{{ route('admin.warranties.create') }}" class="btn btn-primary" style="border-radius: 12px; padding: 12px 24px; font-weight: 600; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);">
                <i class="bi bi-plus-circle me-2"></i> Thêm bảo hành
            </a>
            <a href="{{ route('admin.warranties.exportExcel') }}" class="btn btn-success" style="border-radius: 12px; padding: 12px 24px; font-weight: 600; box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);">
                <i class="bi bi-download me-2"></i> Xuất Excel
            </a>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal" style="border-radius: 12px; padding: 12px 24px; font-weight: 600; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);">
                <i class="bi bi-upload me-2"></i> Import Excel
            </button>
            



        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 mb-1" style="font-size: 0.9em; font-weight: 600;">TỔNG BẢO HÀNH</div>
                            <div class="h3 mb-0 font-weight-bold">{{ $warranties->total() }}</div>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-shield-check" style="font-size: 2.5em;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; box-shadow: 0 8px 25px rgba(240, 147, 251, 0.3);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 mb-1" style="font-size: 0.9em; font-weight: 600;">CÒN HIỆU LỰC</div>
                            <div class="h3 mb-0 font-weight-bold">
                                {{ $warranties->where('status', 'active')->where('warranty_end_date', '>=', now()->toDateString())->count() }}
                            </div>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-check-circle" style="font-size: 2.5em;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 mb-1" style="font-size: 0.9em; font-weight: 600;">HẾT HẠN</div>
                            <div class="h3 mb-0 font-weight-bold">
                                {{ $warranties->where('status', 'expired')->count() }}
                            </div>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-exclamation-triangle" style="font-size: 2.5em;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100" style="border: none; border-radius: 16px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; box-shadow: 0 8px 25px rgba(67, 233, 123, 0.3);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 mb-1" style="font-size: 0.9em; font-weight: 600;">YÊU CẦU MỚI</div>
                            <div class="h3 mb-0 font-weight-bold">
                                {{ \App\Models\WarrantyClaim::where('claim_status', 'pending')->count() }}
                            </div>
                        </div>
                        <div class="text-white-50">
                            <i class="bi bi-clock" style="font-size: 2.5em;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="card shadow mb-4" style="border: none; border-radius: 16px; overflow: hidden;">
        <div class="card-header py-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
            <h6 class="m-0 font-weight-bold" style="font-size: 1.2em;">Danh sách bảo hành</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.warranties.claims') }}" class="btn btn-sm" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px;">
                    <i class="bi bi-list-check me-1"></i> Yêu cầu bảo hành
                </a>
            </div>
        </div>
        
        <!-- Search Form -->
        <div class="card-body" style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
            <form action="{{ route('admin.warranties.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="serial_search" class="form-label fw-bold" style="color: #495057;">Tìm kiếm theo số seri:</label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               id="serial_search" 
                               name="serial_search" 
                               value="{{ request('serial_search') }}"
                               placeholder="Nhập số seri cần tìm..."
                               style="border-radius: 12px 0 0 12px; border: 2px solid #e9ecef; padding: 12px 16px; font-size: 1em;">
                        <button class="btn" 
                                type="submit" 
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 0 12px 12px 0; padding: 12px 20px; font-weight: 600;">
                            <i class="bi bi-search me-1"></i> Tìm kiếm
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.warranties.index') }}" class="btn btn-outline-secondary w-100" style="border-radius: 12px; padding: 12px; font-weight: 600;">
                        <i class="bi bi-arrow-clockwise me-1"></i> Làm mới
                    </a>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(request('serial_search'))
                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="bi bi-search me-2"></i>
                    <strong>Kết quả tìm kiếm:</strong> Tìm thấy {{ $warranties->total() }} bảo hành cho số seri "{{ request('serial_search') }}"
                    <a href="{{ route('admin.warranties.index') }}" class="btn btn-sm btn-light ms-2" style="border-radius: 8px;">
                        <i class="bi bi-x-circle me-1"></i> Xóa tìm kiếm
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0" style="border: none;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <th style="border: none; padding: 16px 12px; font-weight: 700; color: #495057;">ID</th>
                            <th style="border: none; padding: 16px 12px; font-weight: 700; color: #495057;">Số seri</th>
                            <th style="border: none; padding: 16px 12px; font-weight: 700; color: #495057;">Sản phẩm</th>
                            <th style="border: none; padding: 16px 12px; font-weight: 700; color: #495057;">Khách hàng</th>
                            <th style="border: none; padding: 16px 12px; font-weight: 700; color: #495057;">Ngày mua</th>
                            <th style="border: none; padding: 16px 12px; font-weight: 700; color: #495057;">Hết hạn</th>
                            <th style="border: none; padding: 16px 12px; font-weight: 700; color: #495057;">Trạng thái</th>
                            <th style="border: none; padding: 16px 12px; font-weight: 700; color: #495057;">Yêu cầu</th>
                            <th style="border: none; padding: 16px 12px; font-weight: 700; color: #495057;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($warranties as $warranty)
                        <tr style="border-bottom: 1px solid #f1f3f4; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='white'">
                            <td style="border: none; padding: 16px 12px; font-weight: 600; color: #6c757d;">{{ $warranty->id }}</td>
                            <td style="border: none; padding: 16px 12px;">
                                <div class="d-flex flex-column">
                                    <strong style="color: #2c3e50; font-size: 1.1em;">{{ $warranty->serial_number }}</strong>
                                    @if($warranty->invoice_number)
                                        <small class="text-muted" style="font-size: 0.9em;">Mã HĐ: {{ $warranty->invoice_number }}</small>
                                    @endif
                                </div>
                            </td>
                            <td style="border: none; padding: 16px 12px;">
                                <div class="d-flex align-items-center w-100">
                                    @if($warranty->product->image)
                                        <img src="{{ asset('images/products/' . $warranty->product->image) }}" 
                                             alt="{{ $warranty->product->name }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 12px; margin-right: 12px; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                    @endif
                                    <div class="flex-grow-1">
                                        <strong style="color: #2c3e50; font-size: 1.1em;">{{ $warranty->product->name }}</strong>
                                        <br><small class="text-muted" style="font-size: 0.9em;">{{ $warranty->product->category->name ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td style="border: none; padding: 16px 12px;">
                                <div class="d-flex flex-column">
                                    <strong style="color: #2c3e50; font-size: 1.1em;">{{ $warranty->customer_name }}</strong>
                                    <small class="text-muted" style="font-size: 0.9em;">{{ $warranty->customer_phone }}</small>
                                    @if($warranty->customer_email)
                                        <small class="text-muted" style="font-size: 0.9em;">{{ $warranty->customer_email }}</small>
                                    @endif
                                </div>
                            </td>
                            <td style="border: none; padding: 16px 12px; font-weight: 600; color: #495057;">{{ $warranty->purchase_date->format('d/m/Y') }}</td>
                            <td style="border: none; padding: 16px 12px;">
                                <div class="d-flex flex-column">
                                    <span style="font-weight: 600; color: #495057;">{{ $warranty->warranty_end_date->format('d/m/Y') }}</span>
                                    @if($warranty->is_expired)
                                        <small class="text-danger" style="font-weight: 600;">{{ $warranty->expired_time_text }}</small>
                                    @else
                                        <small class="text-success" style="font-weight: 600;">{{ $warranty->remaining_time_text }}</small>
                                    @endif
                                </div>
                            </td>
                            <td style="border: none; padding: 16px 12px;">
                                <span class="badge" style="background: {{ $warranty->warranty_status_color == 'success' ? 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)' : ($warranty->warranty_status_color == 'danger' ? 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)') }}; color: white; border-radius: 20px; padding: 8px 16px; font-weight: 600; font-size: 0.9em;">
                                    {{ $warranty->warranty_status_text }}
                                </span>
                            </td>
                            <td style="border: none; padding: 16px 12px;">
                                @php $pendingClaims = $warranty->claims->where('claim_status', 'pending')->count(); @endphp
                                @if($pendingClaims > 0)
                                    <span class="badge" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; border-radius: 20px; padding: 8px 16px; font-weight: 600; font-size: 0.9em;">{{ $pendingClaims }} chờ xử lý</span>
                                @else
                                    <span class="badge" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; border-radius: 20px; padding: 8px 16px; font-weight: 600; font-size: 0.9em;">{{ $warranty->claims->count() }} yêu cầu</span>
                                @endif
                            </td>
                            <td style="border: none; padding: 16px 12px;">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.warranties.show', $warranty) }}" 
                                       class="btn btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px; font-weight: 600; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);" title="Xem chi tiết">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.warranties.edit', $warranty) }}" 
                                       class="btn btn-sm" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px; font-weight: 600; box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.warranties.destroy', $warranty) }}" 
                                          method="POST" class="d-inline" 
                                          onsubmit="return confirm('Bạn có chắc muốn xóa bảo hành này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; border: none; border-radius: 8px; padding: 8px 12px; font-weight: 600; box-shadow: 0 4px 12px rgba(250, 112, 154, 0.3);" title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $warranties->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 16px 16px 0 0;">
                <h5 class="modal-title fw-bold" id="importModalLabel">
                    <i class="bi bi-upload me-2"></i> Import Excel Bảo Hành
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.warranties.importExcel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Chọn file (.xlsx, .xls)</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i> Import
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

 

<script>
$(document).ready(function() {
    // Auto focus vào ô tìm kiếm khi có giá trị
    if ($('#serial_search').val()) {
        $('#serial_search').focus();
    }
    
    // Clear search khi nhấn Escape
    $(document).keyup(function(e) {
        if (e.key === "Escape") {
            window.location.href = "{{ route('admin.warranties.index') }}";
        }
    });
    
    // DataTable với tùy chỉnh cho tìm kiếm
    $('#dataTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
        },
        "pageLength": 25,
        "order": [[0, "desc"]],
        "searching": false, // Tắt tìm kiếm của DataTable vì đã có form tìm kiếm riêng
        "info": false // Ẩn thông tin "Showing X to Y of Z entries"
    });
});
</script>
@endsection 