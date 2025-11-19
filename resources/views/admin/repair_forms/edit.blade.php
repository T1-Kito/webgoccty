@extends('layouts.admin')

@section('title', 'Sửa phiếu bảo hành')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-pencil"></i> Sửa phiếu bảo hành
            </h1>
            <p class="text-muted">Số phiếu: <strong>{{ $repairForm->form_number }}</strong></p>
        </div>
        <a href="{{ route('admin.repair-forms.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin phiếu bảo hành</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.repair-forms.update', $repairForm) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Thông tin bảo hành -->
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-primary mb-3">Thông tin bảo hành</h6>
                        
                        <div class="mb-3">
                            <label for="warranty_id" class="form-label">Bảo hành <span class="text-danger">*</span></label>
                            <select name="warranty_id" id="warranty_id" class="form-select" required>
                                <option value="">Chọn bảo hành</option>
                                @foreach($warranties as $warranty)
                                    <option value="{{ $warranty->id }}" 
                                        {{ $repairForm->warranty_id == $warranty->id ? 'selected' : '' }}
                                        data-customer="{{ $warranty->customer_name }}"
                                        data-phone="{{ $warranty->customer_phone }}"
                                        data-email="{{ $warranty->customer_email }}"
                                        data-product="{{ $warranty->product->name ?? '' }}"
                                        data-serial="{{ $warranty->serial_number }}"
                                        data-purchase="{{ $warranty->purchase_date->format('Y-m-d') }}">
                                        {{ $warranty->serial_number }}@if($warranty->product) - {{ $warranty->product->name }}@endif@if($warranty->customer_name) ({{ $warranty->customer_name }})@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="warranty_claim_id" class="form-label">Yêu cầu bảo hành</label>
                            <select name="warranty_claim_id" id="warranty_claim_id" class="form-select">
                                <option value="">Chọn yêu cầu bảo hành (nếu có)</option>
                                @foreach($warrantyClaims as $claim)
                                    <option value="{{ $claim->id }}" {{ $repairForm->warranty_claim_id == $claim->id ? 'selected' : '' }}>
                                        {{ $claim->claim_number }}@if($claim->warranty->product) - {{ $claim->warranty->product->name }}@endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Thông tin khách hàng -->
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-primary mb-3">Thông tin khách hàng</h6>
                        
                        <div class="mb-3">
                            <label for="customer_company" class="form-label">Tên công ty <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customer_company" name="customer_company" 
                                   value="{{ old('customer_company', $repairForm->customer_company) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_person" class="form-label">Người liên hệ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" 
                                   value="{{ old('contact_person', $repairForm->contact_person) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                   value="{{ old('contact_phone', $repairForm->contact_phone) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="alternate_contact" class="form-label">Người liên hệ khác</label>
                            <input type="text" class="form-control" id="alternate_contact" name="alternate_contact" 
                                   value="{{ old('alternate_contact', $repairForm->alternate_contact) }}">
                        </div>

                        <div class="mb-3">
                            <label for="alternate_phone" class="form-label">SĐT khác</label>
                            <input type="text" class="form-control" id="alternate_phone" name="alternate_phone" 
                                   value="{{ old('alternate_phone', $repairForm->alternate_phone) }}">
                        </div>

                        <div class="mb-3">
                            <label for="purchase_date" class="form-label">Ngày mua <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="purchase_date" name="purchase_date" 
                                   value="{{ old('purchase_date', $repairForm->purchase_date->format('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company_phone" class="form-label">Điện thoại công ty</label>
                            <input type="text" class="form-control" id="company_phone" name="company_phone" 
                                   value="{{ old('company_phone', $repairForm->company_phone) }}">
                        </div>

                        

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email', $repairForm->email) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Thông tin thiết bị -->
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-primary mb-3">Thông tin thiết bị</h6>
                        
                        <div class="mb-3">
                            <label for="equipment_name" class="form-label">Tên thiết bị <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="equipment_name" name="equipment_name" 
                                   value="{{ old('equipment_name', $repairForm->equipment_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="error_status" class="form-label">Tình trạng lỗi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="error_status" name="error_status" rows="3" required>{{ old('error_status', $repairForm->error_status) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="includes_adapter" name="includes_adapter" value="1" {{ $repairForm->includes_adapter ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="includes_adapter">
                                    Kèm adapter
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="accessories" class="form-label fw-bold">Phụ kiện kèm theo</label>
                            <input type="text" class="form-control" id="accessories" name="accessories" value="{{ old('accessories', $repairForm->accessories) }}" placeholder="Nhập phụ kiện kèm theo (nếu có)">
                        </div>

                        <div class="mb-3">
                            <label for="serial_numbers" class="form-label">Số seri <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="serial_numbers" name="serial_numbers" 
                                   value="{{ old('serial_numbers', $repairForm->serial_numbers) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="warranty_status" class="form-label">Trạng thái bảo hành <span class="text-danger">*</span></label>
                            <select name="warranty_status" id="warranty_status" class="form-select" required>
                                <option value="under_warranty" {{ $repairForm->warranty_status == 'under_warranty' ? 'selected' : '' }}>Còn bảo hành</option>
                                <option value="out_of_warranty" {{ $repairForm->warranty_status == 'out_of_warranty' ? 'selected' : '' }}>Hết bảo hành</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="employee_count" class="form-label">Số nhân viên sử dụng</label>
                            <input type="number" class="form-control" id="employee_count" name="employee_count" 
                                   value="{{ old('employee_count', $repairForm->employee_count) }}" min="1">
                        </div>

                        <div class="mb-3">
                            <label for="repair_time_required" class="form-label">Thời gian sửa chữa cần thiết <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="repair_time_required" name="repair_time_required" 
                                   value="{{ old('repair_time_required', $repairForm->repair_time_required) }}" 
                                   placeholder="VD: 5-7 ngày" required>
                        </div>

                        <div class="mb-3">
                            <label for="estimated_return_date" class="form-label">Ngày dự kiến trả</label>
                            <input type="date" class="form-control" id="estimated_return_date" name="estimated_return_date" 
                                   value="{{ old('estimated_return_date', $repairForm->estimated_return_date ? $repairForm->estimated_return_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="received_date" class="form-label">Ngày tiếp nhận <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="received_date" name="received_date" 
                                   value="{{ old('received_date', $repairForm->received_date->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="draft" {{ $repairForm->status == 'draft' ? 'selected' : '' }}>Nháp</option>
                                <option value="submitted" {{ $repairForm->status == 'submitted' ? 'selected' : '' }}>Đã gửi</option>
                                <option value="in_progress" {{ $repairForm->status == 'in_progress' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="completed" {{ $repairForm->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $repairForm->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Cập nhật phiếu
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
});
</script>
@endsection 