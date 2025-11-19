@extends('layouts.admin')

@section('title', 'Thêm bảo hành mới')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-plus-circle"></i> Thêm bảo hành mới
            </h1>
            <p class="text-muted">Tạo thông tin bảo hành cho sản phẩm</p>
        </div>
        <a href="{{ route('admin.warranties.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin bảo hành</h6>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.warranties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                                                    <div class="mb-3">
                                        <label for="serial_number" class="form-label fw-bold">Số seri (SN) *</label>
                                        <input type="text" 
                                               class="form-control @error('serial_number') is-invalid @enderror" 
                                               id="serial_number" 
                                               name="serial_number" 
                                               value="{{ old('serial_number') }}" 
                                               placeholder="Ví dụ: SN123456789"
                                               required>
                                        <small class="text-info">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Số seri sẽ được tự động điền khi chọn sản phẩm có sẵn, bạn có thể sửa đổi nếu cần. 
                                        </small>
                                        @error('serial_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Sản phẩm *</label>
                                    <div class="d-flex gap-2 mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleProductSelect()">
                                            <i class="bi bi-list-check"></i> Chọn sản phẩm có sẵn
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="toggleProductInput()">
                                            <i class="bi bi-plus-circle"></i> Tạo sản phẩm mới
                                        </button>
                                    </div>
                                    
                                    <!-- Phần chọn sản phẩm có sẵn -->
                                    <div id="product-select-section">
                                        <select class="form-select select2-product @error('product_id') is-invalid @enderror" 
                                                id="product_id" 
                                                name="product_id" 
                                                required>
                                            <option value="">Tìm kiếm sản phẩm...</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" 
                                                        {{ old('product_id') == $product->id ? 'selected' : '' }}
                                                        data-serial="{{ $product->serial_number ?? '' }}"
                                                        data-category="{{ $product->category->name ?? '' }}">
                                                    {{ $product->name }} 
                                                    @if($product->serial_number)
                                                        (SN: {{ $product->serial_number }})
                                                    @endif
                                                    @if($product->category)
                                                        - {{ $product->category->name }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">
                                            <i class="bi bi-search"></i> Gõ để tìm kiếm theo tên, số seri hoặc danh mục
                                        </small>
                                    </div>
                                    
                                    <!-- Phần tạo sản phẩm mới -->
                                    <div id="product-create-section" style="display: none;">
                                        <input type="text" 
                                               class="form-control @error('new_product_name') is-invalid @enderror" 
                                               id="new_product_name" 
                                               name="new_product_name" 
                                               value="{{ old('new_product_name') }}" 
                                               placeholder="Tên sản phẩm mới">
                                        @error('new_product_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <input type="file" 
                                                   class="form-control @error('new_product_image') is-invalid @enderror" 
                                                   id="new_product_image" 
                                                   name="new_product_image" 
                                                   accept="image/*">
                                            <small class="text-muted">Ảnh sản phẩm (tùy chọn)</small>
                                        </div>
                                    </div>
                                    
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label fw-bold">Tên khách hàng *</label>
                                    <input type="text" 
                                           class="form-control @error('customer_name') is-invalid @enderror" 
                                           id="customer_name" 
                                           name="customer_name" 
                                           value="{{ old('customer_name') }}" 
                                           required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label fw-bold">Số điện thoại</label>
                                    <input type="text" 
                                           class="form-control @error('customer_phone') is-invalid @enderror" 
                                           id="customer_phone" 
                                           name="customer_phone" 
                                           value="{{ old('customer_phone') }}">
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="customer_email" class="form-label fw-bold">Email</label>
                            <input type="email" 
                                   class="form-control @error('customer_email') is-invalid @enderror" 
                                   id="customer_email" 
                                   name="customer_email" 
                                   value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_address" class="form-label fw-bold">Địa chỉ</label>
                            <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                      id="customer_address" 
                                      name="customer_address" 
                                      rows="2">{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="purchase_date" class="form-label fw-bold">Ngày mua *</label>
                                    <input type="date" 
                                           class="form-control @error('purchase_date') is-invalid @enderror" 
                                           id="purchase_date" 
                                           name="purchase_date" 
                                           value="{{ old('purchase_date') }}" 
                                           required>
                                    @error('purchase_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="warranty_start_date" class="form-label fw-bold">Ngày bắt đầu bảo hành *</label>
                                    <input type="date" 
                                           class="form-control @error('warranty_start_date') is-invalid @enderror" 
                                           id="warranty_start_date" 
                                           name="warranty_start_date" 
                                           value="{{ old('warranty_start_date') }}" 
                                           required>
                                    @error('warranty_start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="warranty_period_months" class="form-label fw-bold">Thời hạn bảo hành (tháng) *</label>
                                    <input type="number" 
                                           class="form-control @error('warranty_period_months') is-invalid @enderror" 
                                           id="warranty_period_months" 
                                           name="warranty_period_months" 
                                           value="{{ old('warranty_period_months', 12) }}" 
                                           min="1" 
                                           max="60" 
                                           required>
                                    @error('warranty_period_months')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="invoice_number" class="form-label fw-bold">Mã hóa đơn</label>
                            <input type="text" 
                                   class="form-control @error('invoice_number') is-invalid @enderror" 
                                   id="invoice_number" 
                                   name="invoice_number" 
                                   value="{{ old('invoice_number') }}"
                                   placeholder="Để trống để tự động sinh mã">
                            <small class="text-muted">Để trống để hệ thống tự động sinh mã hóa đơn</small>
                            @error('invoice_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Lưu ý:</strong> Trạng thái bảo hành sẽ được tự động xác định dựa trên ngày kết thúc bảo hành.
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label fw-bold">Ghi chú</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Tạo bảo hành
                            </button>
                            <a href="{{ route('admin.warranties.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hướng dẫn</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold text-primary">
                            <i class="bi bi-info-circle"></i> Lưu ý quan trọng
                        </h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                Số seri phải là duy nhất
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                Ngày bắt đầu bảo hành ≥ ngày mua
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                Thời hạn bảo hành: 1-60 tháng
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check text-success me-2"></i>
                                Hệ thống tự tính ngày kết thúc
                            </li>
                        </ul>
                    </div>

                    <div class="alert alert-info">
                        <h6 class="fw-bold">
                            <i class="bi bi-lightbulb"></i> Mẹo
                        </h6>
                        <p class="mb-0">
                            Sau khi tạo bảo hành, khách hàng có thể tra cứu online bằng số seri để xem thông tin và tạo yêu cầu bảo hành.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Document ready, checking jQuery...');
    
    // Kiểm tra jQuery đã load chưa
    if (typeof $ === 'undefined') {
        console.error('jQuery not loaded!');
        return;
    }
    
    console.log('jQuery loaded, initializing Select2...');
    
    // Khởi tạo Select2 cho dropdown sản phẩm
    $('.select2-product').select2({
        theme: 'bootstrap-5',
        placeholder: 'Tìm kiếm sản phẩm...',
        allowClear: true,
        width: '100%',
        language: 'vi',
        minimumInputLength: 0,
        templateResult: formatProductOption,
        templateSelection: formatProductSelection
    }).on('select2:open', function() {
        console.log('Select2 opened');
        // Focus vào search box khi mở dropdown
        setTimeout(function() {
            $('.select2-search__field').focus();
        }, 100);
    });

    // Format hiển thị trong dropdown
    function formatProductOption(product) {
        if (!product.id) return product.text;
        
        var $option = $(product.element);
        var serial = $option.data('serial');
        var category = $option.data('category');
        
        var $result = $('<div class="d-flex flex-column">');
        $result.append('<strong>' + product.text + '</strong>');
        
        if (serial) {
            $result.append('<small class="text-muted">Số seri: ' + serial + '</small>');
        }
        if (category) {
            $result.append('<small class="text-info">Danh mục: ' + category + '</small>');
        }
        
        return $result;
    }

    // Format hiển thị khi đã chọn
    function formatProductSelection(product) {
        if (!product.id) return product.text;
        return product.text;
    }

    // Tự động điền số seri khi chọn sản phẩm
    $('.select2-product').on('select2:select', function(e) {
        var selectedOption = $(e.params.data.element);
        var serialNumber = selectedOption.data('serial');
        
        if (serialNumber) {
            // Điền số seri vào field "Số seri (SN)"
            document.getElementById('serial_number').value = serialNumber;
            console.log('Đã tự động điền số seri:', serialNumber);
        }
    });

    // Đồng bộ số seri khi sửa trong field
    document.getElementById('serial_number').addEventListener('input', function() {
        var newSerialNumber = this.value;
        var selectedProductId = document.getElementById('product_id').value;
        
        if (selectedProductId && newSerialNumber) {
            // Cập nhật data-serial của option đang được chọn
            var selectedOption = document.querySelector('#product_id option[value="' + selectedProductId + '"]');
            if (selectedOption) {
                selectedOption.setAttribute('data-serial', newSerialNumber);
                console.log('Đã cập nhật số seri trong dropdown:', newSerialNumber);
            }
        }
    });

    // Toggle giữa chọn sản phẩm có sẵn và tạo mới
    window.toggleProductInput = function() {
        document.getElementById('product-select-section').style.display = 'none';
        document.getElementById('product-create-section').style.display = 'block';
        document.getElementById('product_id').removeAttribute('required');
        document.getElementById('new_product_name').setAttribute('required', 'required');
    };
    
    window.toggleProductSelect = function() {
        document.getElementById('product-select-section').style.display = 'block';
        document.getElementById('product-create-section').style.display = 'none';
        document.getElementById('product_id').setAttribute('required', 'required');
        document.getElementById('new_product_name').removeAttribute('required');
    };
    
    // Auto-calculate warranty end date
    const warrantyStartDate = document.getElementById('warranty_start_date');
    const warrantyPeriod = document.getElementById('warranty_period_months');
    
    function calculateEndDate() {
        if (warrantyStartDate.value && warrantyPeriod.value) {
            const startDate = new Date(warrantyStartDate.value);
            const endDate = new Date(startDate);
            endDate.setMonth(endDate.getMonth() + parseInt(warrantyPeriod.value));
            
            // Display calculated end date
            const endDateStr = endDate.toISOString().split('T')[0];
            console.log('Ngày kết thúc bảo hành sẽ là:', endDateStr);
        }
    }
    
    warrantyStartDate.addEventListener('change', calculateEndDate);
    warrantyPeriod.addEventListener('change', calculateEndDate);
});
</script>
@endsection 