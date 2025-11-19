@extends('layouts.user')

@section('title', 'Kết quả tra cứu bảo hành - VIKHANG')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="fw-bold mb-3" style="color:#007BFF; font-size:2.2em;">
                    <i class="bi bi-shield-check"></i> Kết quả tra cứu bảo hành
                </h1>
                <p class="text-muted" style="font-size:1.1em;">
                    Số seri: <strong>{{ $serialNumber }}</strong>
                </p>
            </div>

            <!-- Search Again Button -->
            <div class="text-center mb-4">
                <a href="{{ route('warranty.check') }}" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Tra cứu khác
                </a>
            </div>

            @if(session('error'))
                <!-- Error Message -->
                <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-3" style="font-size:1.5em;"></i>
                        <div>
                            <h5 class="fw-bold mb-1">Không tìm thấy thông tin bảo hành</h5>
                            <p class="mb-0">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="card border-0 shadow-sm mt-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-primary">
                            <i class="bi bi-question-circle"></i> Cần hỗ trợ?
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-telephone text-success me-3" style="font-size:1.5em;"></i>
                                    <div>
                                        <strong>Gọi điện:</strong><br>
                                        <span class="text-muted">0909 123 456</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-envelope text-info me-3" style="font-size:1.5em;"></i>
                                    <div>
                                        <strong>Email:</strong><br>
                                        <span class="text-muted">support@vikhang.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($warranty))
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm" style="border-radius: 15px;">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Warranty Information -->
                <div class="card border-0 shadow-lg mb-4" style="border-radius: 20px;">
                    <div class="card-header bg-primary text-white p-4" style="border-radius: 20px 20px 0 0;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="fw-bold mb-1">
                                    <i class="bi bi-info-circle"></i> Thông tin bảo hành
                                </h4>
                                <p class="mb-0 opacity-75">Sản phẩm: {{ $warranty->product->name }}</p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $warranty->warranty_status_color }} fs-6 px-3 py-2">
                                    {{ $warranty->warranty_status_text }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-bold text-muted">Số seri:</label>
                                    <p class="mb-0 fs-5">{{ $warranty->serial_number }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold text-muted">Khách hàng:</label>
                                    <p class="mb-0 fs-5">{{ $warranty->customer_name }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold text-muted">Số điện thoại:</label>
                                    <p class="mb-0 fs-5">{{ $warranty->customer_phone }}</p>
                                </div>
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
                            </div>
                        </div>

                        @if($warranty->is_expired)
                            <div class="alert alert-danger border-0 mt-3" style="border-radius: 12px;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-x-circle text-danger me-3" style="font-size:1.5em;"></i>
                                    <div>
                                        <strong>{{ $warranty->expired_time_text }}</strong>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-success border-0 mt-3" style="border-radius: 12px;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock text-success me-3" style="font-size:1.5em;"></i>
                                    <div>
                                        <strong>{{ $warranty->remaining_time_text }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Warranty Claims -->
                @if($warranty->claims->count() > 0)
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-light p-3" style="border-radius: 15px 15px 0 0;">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-list-check"></i> Lịch sử yêu cầu bảo hành
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @foreach($warranty->claims as $claim)
                        <div class="border-bottom p-3 {{ $loop->last ? '' : 'border-bottom' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-{{ $claim->status_color }} me-2">
                                            {{ $claim->status_text }}
                                        </span>
                                        <strong>{{ $claim->claim_number }}</strong>
                                    </div>
                                    <p class="mb-1"><strong>Ngày yêu cầu:</strong> {{ $claim->claim_date->format('d/m/Y') }}</p>
                                    <p class="mb-1"><strong>Mô tả lỗi:</strong> {{ Str::limit($claim->issue_description, 100) }}</p>
                                    @if($claim->admin_notes)
                                        <p class="mb-0 text-muted"><strong>Ghi chú:</strong> {{ Str::limit($claim->admin_notes, 100) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Create New Claim -->
                @if($warranty->canClaimWarranty())
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-warning text-dark p-3" style="border-radius: 15px 15px 0 0;">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-plus-circle"></i> Tạo yêu cầu bảo hành mới
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('warranty.claim') }}" method="POST">
                            @csrf
                            <input type="hidden" name="warranty_id" value="{{ $warranty->id }}">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Họ tên *</label>
                                        <input type="text" class="form-control" name="customer_name" value="{{ $warranty->customer_name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Số điện thoại *</label>
                                        <input type="text" class="form-control" name="customer_phone" value="{{ $warranty->customer_phone }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control" name="customer_email" value="{{ $warranty->customer_email }}">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mô tả lỗi *</label>
                                <textarea class="form-control" name="issue_description" rows="3" placeholder="Mô tả chi tiết lỗi gặp phải..." required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Khiếu nại của khách hàng *</label>
                                <textarea class="form-control" name="customer_complaint" rows="3" placeholder="Mô tả khiếu nại..." required></textarea>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning btn-lg fw-bold" style="border-radius: 12px;">
                                    <i class="bi bi-send"></i> Gửi yêu cầu bảo hành
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-warning border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle me-3" style="font-size:1.5em;"></i>
                        <div>
                            <h5 class="fw-bold mb-1">Không thể tạo yêu cầu bảo hành</h5>
                            <p class="mb-0">Bảo hành đã hết hạn hoặc không còn hiệu lực.</p>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.badge {
    font-size: 0.9em !important;
}
</style>
@endsection 