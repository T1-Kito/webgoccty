@extends('layouts.admin')

@section('title', 'Tạo phiếu bảo hành')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-file-earmark-plus"></i> Tạo phiếu bảo hành
            </h1>
            <p class="text-muted">Tạo phiếu bảo hành - sửa chữa mới</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.repair-forms.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin phiếu bảo hành</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.repair-forms.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Thông tin bảo hành -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Thông tin bảo hành</h5>
                        
                        <div class="mb-3">
                            <label for="warranty_id" class="form-label fw-bold">Bảo hành <span class="text-danger">*</span></label>
                            <select name="warranty_id" id="warranty_id" class="form-select" required>
                                <option value="">Chọn bảo hành...</option>
                                @foreach($warranties as $warranty)
                                    <option value="{{ $warranty->id }}" 
                                            data-customer="{{ $warranty->customer_name }}"
                                            data-phone="{{ $warranty->customer_phone }}"
                                            data-email="{{ $warranty->customer_email }}"
                                            data-product="{{ $warranty->product->name }}"
                                            data-serial="{{ $warranty->serial_number }}"
                                            data-purchase="{{ $warranty->purchase_date->format('Y-m-d') }}">
                                        {{ $warranty->serial_number }} - {{ $warranty->product->name }} ({{ $warranty->customer_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="warranty_claim_id" class="form-label fw-bold">Yêu cầu bảo hành (nếu có)</label>
                            <select name="warranty_claim_id" id="warranty_claim_id" class="form-select">
                                <option value="">Không có yêu cầu...</option>
                                @foreach($warrantyClaims as $claim)
                                    <option value="{{ $claim->id }}">
                                        {{ $claim->claim_number }} - {{ $claim->warranty->serial_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Thông tin khách hàng -->
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Thông tin khách hàng</h5>
                        
                        <div class="mb-3">
                            <label for="customer_company" class="form-label fw-bold">Tên công ty <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customer_company" name="customer_company" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_person" class="form-label fw-bold">Người liên hệ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_phone" class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="alternate_contact" class="form-label fw-bold">Người liên hệ khác</label>
                            <input type="text" class="form-control" id="alternate_contact" name="alternate_contact">
                        </div>

                        <div class="mb-3">
                            <label for="alternate_phone" class="form-label fw-bold">SĐT khác</label>
                            <input type="text" class="form-control" id="alternate_phone" name="alternate_phone">
                        </div>

                        <div class="mb-3">
                            <label for="purchase_date" class="form-label fw-bold">Ngày mua <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="purchase_date" name="purchase_date" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company_phone" class="form-label fw-bold">Điện thoại công ty</label>
                            <input type="text" class="form-control" id="company_phone" name="company_phone">
                        </div>

                        <div class="mb-3">
                            <label for="fax" class="form-label fw-bold">Fax</label>
                            <input type="text" class="form-control" id="fax" name="fax">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3 text-primary">Thông tin thiết bị</h5>
                        
                        <div class="mb-3">
                            <label for="equipment_name" class="form-label fw-bold">Tên thiết bị <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="equipment_name" name="equipment_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="error_status" class="form-label fw-bold">Tình trạng lỗi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="error_status" name="error_status" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="serial_numbers" class="form-label fw-bold">Số seri <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="serial_numbers" name="serial_numbers" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="warranty_status" class="form-label fw-bold">Trạng thái bảo hành <span class="text-danger">*</span></label>
                            <select name="warranty_status" id="warranty_status" class="form-select" required>
                                <option value="under_warranty">Còn bảo hành</option>
                                <option value="out_of_warranty">Hết bảo hành</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="employee_count" class="form-label fw-bold">Số nhân viên</label>
                            <input type="number" class="form-control" id="employee_count" name="employee_count" min="1">
                        </div>

                        <div class="mb-3">
                            <label for="repair_time_required" class="form-label fw-bold">Thời gian sửa chữa cần thiết <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="repair_time_required" name="repair_time_required" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="estimated_return_date" class="form-label fw-bold">Ngày dự kiến trả</label>
                            <input type="date" class="form-control" id="estimated_return_date" name="estimated_return_date">
                        </div>

                        <div class="mb-3">
                            <label for="received_by" class="form-label fw-bold">Người tiếp nhận <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="received_by" name="received_by" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="received_date" class="form-label fw-bold">Ngày tiếp nhận <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="received_date" name="received_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Trạng thái phiếu <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="draft">Nháp</option>
                                <option value="submitted">Đã gửi</option>
                                <option value="in_progress">Đang xử lý</option>
                                <option value="completed">Hoàn thành</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label fw-bold">Ghi chú</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.repair-forms.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Hủy
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Tạo phiếu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Auto-fill form when warranty is selected
    $('#warranty_id').change(function() {
        var selectedOption = $(this).find('option:selected');
        if (selectedOption.val()) {
            $('#customer_company').val(selectedOption.data('customer'));
            $('#contact_person').val(selectedOption.data('customer'));
            $('#contact_phone').val(selectedOption.data('phone'));
            $('#email').val(selectedOption.data('email'));
            $('#equipment_name').val(selectedOption.data('product'));
            $('#serial_numbers').val(selectedOption.data('serial'));
            $('#purchase_date').val(selectedOption.data('purchase'));
        }
    });

    // Set default received date to today
    $('#received_date').val(new Date().toISOString().split('T')[0]);
});
</script>
@endsection 