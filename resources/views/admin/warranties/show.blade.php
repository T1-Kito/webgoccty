@extends('layouts.admin')

@section('title', 'Chi tiết bảo hành')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-eye"></i> Chi tiết bảo hành
            </h1>
            <p class="text-muted">Số seri: <strong>{{ $warranty->serial_number }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.repair-forms.createFromWarranty', $warranty) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-text"></i> Tạo phiếu bảo hành
            </a>
            <a href="{{ route('admin.warranties.edit', $warranty) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Sửa
            </a>
            <a href="{{ route('admin.warranties.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Warranty Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin bảo hành</h6>
                    <span class="badge bg-{{ $warranty->warranty_status_color }} fs-6">
                        {{ $warranty->warranty_status_text }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Số seri:</label>
                                <p class="mb-0 fs-5">{{ $warranty->serial_number }}</p>
                            </div>
                            @if($warranty->product)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Sản phẩm:</label>
                                <div class="d-flex align-items-center">
                                    @if($warranty->product->image)
                                        <img src="{{ asset('images/products/' . $warranty->product->image) }}" 
                                             alt="{{ $warranty->product->name }}" 
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; margin-right: 10px;">
                                    @endif
                                    <div>
                                        <p class="mb-0 fs-5">{{ $warranty->product->name }}</p>
                                        <small class="text-muted">{{ $warranty->product->category->name ?? '' }}</small>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($warranty->customer_name)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Khách hàng:</label>
                                <p class="mb-0 fs-5">{{ $warranty->customer_name }}</p>
                            </div>
                            @endif
                            @if($warranty->customer_phone)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Số điện thoại:</label>
                                <p class="mb-0 fs-5">{{ $warranty->customer_phone }}</p>
                            </div>
                            @endif
                            @if($warranty->customer_email)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Email:</label>
                                <p class="mb-0 fs-5">{{ $warranty->customer_email }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Ngày mua:</label>
                                <p class="mb-0 fs-5">{{ $warranty->purchase_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Bắt đầu bảo hành:</label>
                                <p class="mb-0 fs-5">{{ $warranty->warranty_start_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Kết thúc bảo hành:</label>
                                <p class="mb-0 fs-5">{{ $warranty->warranty_end_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Thời hạn:</label>
                                <p class="mb-0 fs-5">{{ $warranty->warranty_period_months }} tháng</p>
                            </div>
                            @if($warranty->invoice_number)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Mã hóa đơn:</label>
                                <p class="mb-0 fs-5">{{ $warranty->invoice_number }}</p>
                            </div>
                            @endif

                        </div>
                    </div>

                    @if($warranty->customer_address)
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Địa chỉ:</label>
                        <p class="mb-0">{{ $warranty->customer_address }}</p>
                    </div>
                    @endif

                    @if($warranty->notes)
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Ghi chú:</label>
                        <p class="mb-0">{{ $warranty->notes }}</p>
                    </div>
                    @endif

                    @if($warranty->is_expired)
                        <div class="alert alert-danger">
                            <i class="bi bi-x-circle"></i> {{ $warranty->expired_time_text }}
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="bi bi-clock"></i> {{ $warranty->remaining_time_text }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Warranty Claims -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Lịch sử yêu cầu bảo hành</h6>
                    <span class="badge bg-secondary">{{ $warranty->claims->count() }} yêu cầu</span>
                </div>
                <div class="card-body">
                    @if($warranty->claims->count() > 0)
                        @foreach($warranty->claims as $claim)
                        <div class="border-bottom pb-3 mb-3 {{ $loop->last ? 'border-bottom-0 pb-0 mb-0' : '' }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">
                                        <span class="badge bg-{{ $claim->status_color }} me-2">
                                            {{ $claim->status_text }}
                                        </span>
                                        {{ $claim->claim_number }}
                                    </h6>
                                    <small class="text-muted">Ngày yêu cầu: {{ $claim->claim_date->format('d/m/Y') }}</small>
                                </div>
                                @if($claim->is_overdue)
                                    <span class="badge bg-danger">Quá hạn {{ $claim->days_overdue }} ngày</span>
                                @endif
                            </div>
                            
                            <div class="mb-2">
                                <strong>Mô tả lỗi:</strong>
                                <p class="mb-1">{{ $claim->issue_description }}</p>
                            </div>
                            
                            <div class="mb-2">
                                <strong>Khiếu nại khách hàng:</strong>
                                <p class="mb-1">{{ $claim->customer_complaint }}</p>
                            </div>
                            
                            @if($claim->admin_notes)
                            <div class="mb-2">
                                <strong>Ghi chú admin:</strong>
                                <p class="mb-1">{{ $claim->admin_notes }}</p>
                            </div>
                            @endif
                            
                            @if($claim->repair_notes)
                            <div class="mb-2">
                                <strong>Ghi chú sửa chữa:</strong>
                                <p class="mb-1">{{ $claim->repair_notes }}</p>
                            </div>
                            @endif
                            
                            <div class="row">
                                @if($claim->estimated_completion_date)
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Dự kiến hoàn thành:</strong> {{ $claim->estimated_completion_date->format('d/m/Y') }}
                                    </small>
                                </div>
                                @endif
                                @if($claim->actual_completion_date)
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Hoàn thành thực tế:</strong> {{ $claim->actual_completion_date->format('d/m/Y') }}
                                    </small>
                                </div>
                                @endif
                            </div>
                            
                            @if($claim->repair_cost)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <strong>Chi phí sửa chữa:</strong> {{ number_format($claim->repair_cost, 0, ',', '.') }}đ
                                </small>
                            </div>
                            @endif
                            
                            @if($claim->technician_name)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <strong>Kỹ thuật viên:</strong> {{ $claim->technician_name }}
                                </small>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">Chưa có yêu cầu bảo hành nào.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Status History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lịch sử trạng thái</h6>
                </div>
                <div class="card-body">
                    @if($warranty->statuses->count() > 0)
                        @foreach($warranty->statuses as $status)
                        <div class="border-bottom pb-2 mb-2 {{ $loop->last ? 'border-bottom-0 pb-0 mb-0' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $status->status }}</strong>
                                    @if($status->notes)
                                        <p class="mb-1 small">{{ $status->notes }}</p>
                                    @endif
                                    <small class="text-muted">{{ $status->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <small class="text-muted">{{ $status->changed_by }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">Chưa có lịch sử thay đổi.</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thao tác nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.warranties.claims') }}" class="btn btn-outline-info">
                            <i class="bi bi-list-check"></i> Xem tất cả yêu cầu
                        </a>
                        @if($warranty->canClaimWarranty())
                            <button class="btn btn-outline-success" onclick="alert('Tính năng đang phát triển')">
                                <i class="bi bi-plus-circle"></i> Tạo yêu cầu mới
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 