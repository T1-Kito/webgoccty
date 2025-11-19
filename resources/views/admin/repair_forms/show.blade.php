@extends('layouts.admin')

@section('title', 'Chi tiết phiếu bảo hành')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-file-earmark-text"></i> Chi tiết phiếu bảo hành
            </h1>
            <p class="text-muted">Số phiếu: <strong>{{ $repairForm->form_number }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.repair-forms.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
            <a href="{{ route('admin.repair-forms.exportWord', $repairForm) }}" class="btn btn-primary" target="_blank">
                <i class="bi bi-printer"></i> In Phiếu
            </a>
            <a href="{{ route('admin.repair-forms.edit', $repairForm) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Sửa
            </a>
            <form action="{{ route('admin.repair-forms.destroy', $repairForm) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phiếu này?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Xóa
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Thông tin phiếu -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin phiếu bảo hành</h6>
                    <span class="badge bg-{{ $repairForm->status_color }} fs-6">
                        {{ $repairForm->status_text }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Số phiếu:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->form_number }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Ngày tạo:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Tên công ty:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->customer_company }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Người liên hệ:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->contact_person }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Số điện thoại:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->contact_phone }}</p>
                            </div>
                            @if($repairForm->alternate_contact)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Người liên hệ khác:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->alternate_contact }}</p>
                            </div>
                            @endif
                            @if($repairForm->alternate_phone)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">SĐT khác:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->alternate_phone }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Ngày mua:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->purchase_date->format('d/m/Y') }}</p>
                            </div>
                            @if($repairForm->company_phone)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Điện thoại công ty:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->company_phone }}</p>
                            </div>
                            @endif
                            @if($repairForm->fax)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Fax:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->fax }}</p>
                            </div>
                            @endif
                            @if($repairForm->email)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Email:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->email }}</p>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Ngày tiếp nhận:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->received_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Người tiếp nhận:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->received_by }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin thiết bị -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin thiết bị</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Tên thiết bị:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->equipment_name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Số seri:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->serial_numbers }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Tình trạng lỗi:</label>
                                <p class="mb-0">{{ $repairForm->error_status }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Trạng thái bảo hành:</label>
                                <span class="badge bg-{{ $repairForm->warranty_status == 'under_warranty' ? 'success' : 'danger' }} fs-6">
                                    {{ $repairForm->warranty_status_text }}
                                </span>
                            </div>
                            @if($repairForm->employee_count)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Số nhân viên:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->employee_count }}</p>
                            </div>
                            @endif
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Thời gian sửa chữa cần thiết:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->repair_time_required }}</p>
                            </div>
                            @if($repairForm->estimated_return_date)
                            <div class="mb-3">
                                <label class="fw-bold text-muted">Ngày dự kiến trả:</label>
                                <p class="mb-0 fs-5">{{ $repairForm->estimated_return_date->format('d/m/Y') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($repairForm->notes)
            <!-- Ghi chú -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ghi chú</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $repairForm->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Thông tin bảo hành liên quan -->
            @if($repairForm->warranty)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin bảo hành</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Số seri:</label>
                        <p class="mb-0">{{ $repairForm->warranty->serial_number }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Sản phẩm:</label>
                        <p class="mb-0">{{ $repairForm->warranty->product->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Khách hàng:</label>
                        <p class="mb-0">{{ $repairForm->warranty->customer_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Trạng thái:</label>
                        <span class="badge bg-{{ $repairForm->warranty->warranty_status_color }}">
                            {{ $repairForm->warranty->warranty_status_text }}
                        </span>
                    </div>
                    <a href="{{ route('admin.warranties.show', $repairForm->warranty) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye"></i> Xem chi tiết
                    </a>
                </div>
            </div>
            @endif

            <!-- Thông tin yêu cầu bảo hành -->
            @if($repairForm->warrantyClaim)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Yêu cầu bảo hành</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Số yêu cầu:</label>
                        <p class="mb-0">{{ $repairForm->warrantyClaim->claim_number }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Ngày yêu cầu:</label>
                        <p class="mb-0">{{ $repairForm->warrantyClaim->claim_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-muted">Trạng thái:</label>
                        <span class="badge bg-{{ $repairForm->warrantyClaim->status_color }}">
                            {{ $repairForm->warrantyClaim->status_text }}
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Lịch sử cập nhật -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lịch sử cập nhật</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Tạo lúc:</small>
                        <p class="mb-0">{{ $repairForm->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($repairForm->updated_at != $repairForm->created_at)
                    <div class="mb-3">
                        <small class="text-muted">Cập nhật lúc:</small>
                        <p class="mb-0">{{ $repairForm->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 