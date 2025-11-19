<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairForm;
use App\Models\Warranty;
use App\Models\WarrantyClaim;
use App\Services\PrintService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepairFormController extends Controller
{
    public function index()
    {
        $repairForms = RepairForm::with(['warranty.product', 'warrantyClaim'])
            ->orderByDesc('created_at')
            ->paginate(20);
            
        return view('admin.repair_forms.index', compact('repairForms'));
    }

    public function create()
    {
        $warranties = Warranty::with('product')->get();
        $warrantyClaims = WarrantyClaim::with('warranty.product')->get();
        
        return view('admin.repair_forms.create', compact('warranties', 'warrantyClaims'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'warranty_id' => 'required|exists:warranties,id',
            'warranty_claim_id' => 'nullable|exists:warranty_claims,id',
            'customer_company' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'alternate_contact' => 'nullable|string|max:255',
            'alternate_phone' => 'nullable|string|max:20',
            'purchase_date' => 'required|date',
            'company_phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'equipment_name' => 'required|string|max:255',
            'error_status' => 'required|string',
            'includes_adapter' => 'nullable|boolean',
            'accessories' => 'nullable|string|max:255',
            'serial_numbers' => 'required|string',
            'warranty_status' => 'required|in:under_warranty,out_of_warranty',
            'employee_count' => 'nullable|integer|min:1',
            'repair_time_required' => 'required|string|max:100',
            'estimated_return_date' => 'nullable|date',
            'received_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,submitted,in_progress,completed'
        ]);

        // Tự động điền received_by nếu không có
        if (!isset($data['received_by']) || empty($data['received_by'])) {
            $data['received_by'] = 'Vi Khang'; // Giá trị mặc định
        }
        
        $repairForm = RepairForm::create($data);

        return redirect()->route('admin.repair-forms.index')
            ->with('success', 'Phiếu bảo hành đã được tạo thành công!');
    }

    public function show(RepairForm $repairForm)
    {
        $repairForm->load(['warranty.product', 'warrantyClaim']);
        
        return view('admin.repair_forms.show', compact('repairForm'));
    }

    public function edit(RepairForm $repairForm)
    {
        $warranties = Warranty::with('product')->get();
        $warrantyClaims = WarrantyClaim::with('warranty.product')->get();
        
        return view('admin.repair_forms.edit', compact('repairForm', 'warranties', 'warrantyClaims'));
    }

    public function update(Request $request, RepairForm $repairForm)
    {
        $data = $request->validate([
            'warranty_id' => 'required|exists:warranties,id',
            'warranty_claim_id' => 'nullable|exists:warranty_claims,id',
            'customer_company' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'alternate_contact' => 'nullable|string|max:255',
            'alternate_phone' => 'nullable|string|max:20',
            'purchase_date' => 'required|date',
            'company_phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'equipment_name' => 'required|string|max:255',
            'error_status' => 'required|string',
            'includes_adapter' => 'nullable|boolean',
            'accessories' => 'nullable|string|max:255',
            'serial_numbers' => 'required|string',
            'warranty_status' => 'required|in:under_warranty,out_of_warranty',
            'employee_count' => 'nullable|integer|min:1',
            'repair_time_required' => 'required|string|max:100',
            'estimated_return_date' => 'nullable|date',
            'received_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,submitted,in_progress,completed'
        ]);

        // Tự động điền received_by nếu không có
        if (!isset($data['received_by']) || empty($data['received_by'])) {
            $data['received_by'] = 'Vi Khang'; // Giá trị mặc định
        }
        
        $repairForm->update($data);

        return redirect()->route('admin.repair-forms.index')
            ->with('success', 'Phiếu bảo hành đã được cập nhật thành công!');
    }

    public function destroy(RepairForm $repairForm)
    {
        $repairForm->delete();
        
        return redirect()->route('admin.repair-forms.index')
            ->with('success', 'Phiếu bảo hành đã được xóa thành công!');
    }

    public function exportWord(RepairForm $repairForm)
    {
        $service = new PrintService();
        $data = $service->generatePrintData($repairForm);
        
        return view('admin.repair_forms.print', compact('repairForm'));
    }

    public function printBack(RepairForm $repairForm)
    {
        return view('admin.repair_forms.print_back', compact('repairForm'));
    }

    public function createFromWarranty(Warranty $warranty)
    {
        $warrantyClaims = $warranty->claims;
        
        return view('admin.repair_forms.create_from_warranty', compact('warranty', 'warrantyClaims'));
    }

    public function createFromClaim(WarrantyClaim $warrantyClaim)
    {
        $warranty = $warrantyClaim->warranty;
        
        return view('admin.repair_forms.create_from_claim', compact('warranty', 'warrantyClaim'));
    }
}
