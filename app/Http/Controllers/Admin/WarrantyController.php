<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warranty;
use App\Models\WarrantyClaim;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WarrantyImport;
 



class WarrantyController extends Controller
{
    public function index(Request $request)
    {
        $query = Warranty::with(['product', 'claims']);
        
        // Tìm kiếm theo số seri
        if ($request->filled('serial_search')) {
            $serialSearch = $request->serial_search;
            $query->where('serial_number', 'LIKE', "%{$serialSearch}%");
        }
        
        $warranties = $query->orderByDesc('created_at')->paginate(20);
        
        // Tính toán stats từ toàn bộ dữ liệu (không phân trang)
        $statsQuery = Warranty::query();
        if ($request->filled('serial_search')) {
            $statsQuery->where('serial_number', 'LIKE', "%{$request->serial_search}%");
        }
        
        $stats = [
            'total' => $statsQuery->count(),
            'active' => (clone $statsQuery)->where('status', 'active')
                ->where('warranty_end_date', '>=', now()->toDateString())
                ->count(),
            'expired' => (clone $statsQuery)->where('status', 'expired')->count(),
        ];
        
        return view('admin.warranties.index', compact('warranties', 'stats'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.warranties.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'serial_number' => 'required|string|unique:warranties,serial_number|max:255',
            'product_id' => 'nullable|exists:products,id',
            'new_product_name' => 'nullable|string|max:255',
            'new_product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string|max:500',
            'purchase_date' => 'required|date',
            'warranty_start_date' => 'required|date|after_or_equal:purchase_date',
            'warranty_period_months' => 'required|integer|min:1|max:60',
            'invoice_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Xử lý sản phẩm mới nếu có
        $productId = $data['product_id'];
        if (empty($productId) && !empty($data['new_product_name'])) {
            // Tạo sản phẩm mới
            $product = Product::create([
                'name' => $data['new_product_name'],
                'category_id' => 56, // Danh mục "MÁY CHẤM CÔNG - KIỂM SOÁT CỬA" (ID thực tế trong DB)
                'slug' => Str::slug($data['new_product_name']),
                'description' => 'Sản phẩm được tạo từ bảo hành',
                'price' => 0,
                'status' => 1 // 1: hiển thị, 0: ẩn
            ]);

            // Xử lý ảnh sản phẩm nếu có
            if ($request->hasFile('new_product_image')) {
                $image = $request->file('new_product_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $imageName);
                $product->update(['image' => $imageName]);
            }

            $productId = $product->id;
        }

        // Tự động sinh mã hóa đơn nếu không có
        if (empty($data['invoice_number'])) {
            $data['invoice_number'] = 'HD' . date('Ymd') . str_pad(Warranty::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        }

        // Tính ngày kết thúc bảo hành
        $data['warranty_end_date'] = \Carbon\Carbon::parse($data['warranty_start_date'])
            ->addMonths((int)$data['warranty_period_months'])
            ->toDateString();

        // Tự động xác định trạng thái bảo hành
        $data['status'] = $data['warranty_end_date'] >= now()->toDateString() ? 'active' : 'expired';

        // Cập nhật product_id (có thể null nếu không chọn sản phẩm)
        $data['product_id'] = $productId ?? null;

        $warranty = Warranty::create($data);

        // Log status change
        $warranty->statuses()->create([
            'status' => 'created',
            'notes' => 'Tạo bảo hành mới',
            'changed_by' => 'admin'
        ]);

        return redirect()->route('admin.warranties.index')
            ->with('success', 'Bảo hành đã được tạo thành công!');
    }

    public function show(Warranty $warranty)
    {
        $warranty->load(['product', 'claims' => function($query) {
            $query->orderByDesc('created_at');
        }, 'statuses' => function($query) {
            $query->orderByDesc('created_at');
        }]);
        
        return view('admin.warranties.show', compact('warranty'));
    }

    public function edit(Warranty $warranty)
    {
        $products = Product::all();
        return view('admin.warranties.edit', compact('warranty', 'products'));
    }

    public function update(Request $request, Warranty $warranty)
    {
        $data = $request->validate([
            'serial_number' => 'required|string|max:255|unique:warranties,serial_number,' . $warranty->id,
            'product_id' => 'nullable|exists:products,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string|max:500',
            'purchase_date' => 'required|date',
            'warranty_start_date' => 'required|date|after_or_equal:purchase_date',
            'warranty_period_months' => 'required|integer|min:1|max:60',
            'invoice_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Tự động sinh mã hóa đơn nếu không có
        if (empty($data['invoice_number'])) {
            $data['invoice_number'] = 'HD' . date('Ymd') . str_pad(Warranty::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);
        }

        // Tính ngày kết thúc bảo hành
        $data['warranty_end_date'] = \Carbon\Carbon::parse($data['warranty_start_date'])
            ->addMonths((int)$data['warranty_period_months'])
            ->toDateString();

        // Tự động xác định trạng thái bảo hành
        $data['status'] = $data['warranty_end_date'] >= now()->toDateString() ? 'active' : 'expired';

        $oldStatus = $warranty->status;
        $warranty->update($data);

        // Log status change nếu có thay đổi
        if ($oldStatus !== $data['status']) {
            $warranty->statuses()->create([
                'status' => $data['status'],
                'notes' => 'Cập nhật trạng thái bảo hành',
                'changed_by' => 'admin'
            ]);
        }

        return redirect()->route('admin.warranties.index')
            ->with('success', 'Bảo hành đã được cập nhật thành công!');
    }

    public function destroy(Warranty $warranty)
    {
        $warranty->delete();
        return redirect()->route('admin.warranties.index')
            ->with('success', 'Bảo hành đã được xóa thành công!');
    }

    // Quản lý yêu cầu bảo hành
    public function claims()
    {
        try {
            $claims = WarrantyClaim::with(['warranty.product'])
                ->orderByDesc('created_at')
                ->paginate(20);
                
            return view('admin.warranties.claims', compact('claims'));
        } catch (\Exception $e) {
            return "Lỗi: " . $e->getMessage();
        }
    }

    public function updateClaimStatus(Request $request, WarrantyClaim $claim)
    {
        $request->validate([
            'claim_status' => 'required|in:pending,approved,rejected,in_progress,completed',
            'admin_notes' => 'nullable|string|max:1000',
            'estimated_completion_date' => 'nullable|date|after:today',
            'repair_cost' => 'nullable|numeric|min:0',
            'technician_name' => 'nullable|string|max:255'
        ]);

        $claim->update([
            'claim_status' => $request->claim_status,
            'admin_notes' => $request->admin_notes,
            'estimated_completion_date' => $request->estimated_completion_date,
            'repair_cost' => $request->repair_cost,
            'technician_name' => $request->technician_name
        ]);

        // Log status change
        $claim->updateStatus($request->claim_status, $request->admin_notes, 'admin');

        return back()->with('success', 'Trạng thái yêu cầu bảo hành đã được cập nhật!');
    }

    // Export danh sách bảo hành ra Excel (array exporter đơn giản)
    public function exportExcel()
    {
        $warranties = Warranty::with('product')->orderByDesc('created_at')->get();
        $data = [];
        $data[] = [
            'ID','Số seri','Tên sản phẩm','Tên khách hàng','Số điện thoại','Email','Địa chỉ','Ngày mua','Ngày bắt đầu bảo hành','Ngày kết thúc bảo hành','Thời hạn (tháng)','Trạng thái','Số hóa đơn','Ghi chú','Ngày tạo'
        ];
        foreach ($warranties as $w) {
            $format = function ($dt, $fmt = 'd/m/Y') {
                return $dt ? \Carbon\Carbon::parse($dt)->format($fmt) : '';
            };
            $end = $w->warranty_end_date ? \Carbon\Carbon::parse($w->warranty_end_date) : null;
            $statusText = $end && $end->endOfDay()->gte(now()) ? 'Còn bảo hành' : 'Hết hạn';

            $data[] = [
                $w->id,
                $w->serial_number,
                optional($w->product)->name,
                $w->customer_name,
                $w->customer_phone,
                $w->customer_email,
                $w->customer_address,
                $format($w->purchase_date),
                $format($w->warranty_start_date),
                $format($w->warranty_end_date),
                $w->warranty_period_months,
                $statusText,
                $w->invoice_number,
                $w->notes,
                $format($w->created_at, 'd/m/Y H:i'),
            ];
        }
        return Excel::download(new \App\Exports\SimpleArrayExport($data), 'danh_sach_bao_hanh.xlsx');
    }

    // Import Excel bảo hành
    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        $import = new WarrantyImport();
        Excel::import($import, $request->file('file'));
        $msg = "Import xong. Thành công: {$import->getSuccessCount()}, Lỗi: {$import->getErrorCount()}";
        if ($import->getErrorCount() > 0) {
            $msg .= ' (xem log/lỗi chi tiết nếu cần)';
        }
        return back()->with('success', $msg);
    }

    // Xóa tất cả bảo hành
    public function destroyAll(Request $request)
    {
        // Xác nhận lại bằng text để đảm bảo an toàn
        $confirmText = $request->input('confirm_text');
        
        if ($confirmText !== 'XÓA TẤT CẢ') {
            return back()->with('error', 'Vui lòng nhập chính xác "XÓA TẤT CẢ" để xác nhận!');
        }

        try {
            $count = Warranty::count();
            
            // Xóa tất cả dữ liệu liên quan trước
            \DB::table('warranty_statuses')->delete();
            \DB::table('warranty_claims')->delete();
            
            // Xóa tất cả bảo hành
            Warranty::query()->delete();
            
            return redirect()->route('admin.warranties.index')
                ->with('success', "Đã xóa thành công {$count} bảo hành và tất cả dữ liệu liên quan!");
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }


}
