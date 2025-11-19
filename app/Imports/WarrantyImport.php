<?php

namespace App\Imports;

use App\Models\Warranty;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
 

class WarrantyImport implements ToModel, WithHeadingRow, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    private int $successCount = 0;
    private int $errorCount = 0;
    private array $errorsBag = [];

    public function model(array $row)
    {
        try {
            $get = function (array $keys) use ($row) {
                foreach ($keys as $k) {
                    if (array_key_exists($k, $row) && filled($row[$k])) {
                        return trim((string) $row[$k]);
                    }
                }
                return null;
            };

            // Hỗ trợ nhiều tên cột khác nhau
            $serial = $get(['SERI', 'seri', 'Số seri', 'SỐ SERI', 'SỐ SERI (SN)', 'so_seri', 'serial', 'serial_number']);
            $customerName = $get(['CÔNG TY', 'cong_ty', 'Công ty', 'Tên khách hàng', 'ten_khach_hang', 'customer_name']);
            $productName = $get(['Tên sản phẩm', 'ten_san_pham']);
            $phone = $get(['Số điện thoại', 'so_dien_thoai', 'Điện thoại']);
            $email = $get(['Email', 'email']);
            $address = $get(['Địa chỉ', 'dia_chi']);
            $dateInput = $get(['NGÀY', 'ngay', 'Ngày', 'Ngày mua', 'ngay_mua', 'Ngày bắt đầu bảo hành', 'ngay_bat_dau_bao_hanh']);
            $periodMonthsInput = $get(['Bảo hành', 'bao_hanh', 'Thời hạn (tháng)']);
            $notes = $get(['Ghi chú', 'ghi_chu']);
            
            // Bỏ qua cột Số lượng - không xử lý

            // Chỉ cần số seri là bắt buộc
            if (empty($serial)) {
                $this->errorCount++;
                $this->errorsBag[] = 'Thiếu Số seri';
                return null;
            }

            // Kiểm tra xem serial đã tồn tại chưa
            if (Warranty::where('serial_number', $serial)->exists()) {
                $this->errorCount++;
                $this->errorsBag[] = "Số seri {$serial} đã tồn tại";
                return null;
            }

            $productId = null;
            if ($productName) {
                $product = Product::firstOrCreate(
                    ['name' => $productName],
                    [
                        'slug' => Str::slug($productName),
                        'category_id' => 56,
                        'price' => 0,
                        'status' => 1,
                    ]
                );
                $productId = $product->id;
            }

            // Parse ngày với format dd/mm/yyyy
            $parseDate = function ($value) {
                if (!$value) return null;
                if (is_numeric($value)) {
                    // Excel serial date
                    return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
                }
                // Ưu tiên format dd/mm/yyyy
                foreach (['d/m/Y', 'd-m-Y', 'd.m.Y', 'Y-m-d', 'Y/m/d'] as $fmt) {
                    try { 
                        $date = Carbon::createFromFormat($fmt, str_replace(['.', '-'], ['/', '/'], (string)$value));
                        if ($date) return $date;
                    } catch (\Throwable $e) {}
                }
                try { return Carbon::parse($value); } catch (\Throwable $e) { return null; }
            };

            // Nếu có ngày từ file, dùng làm cả purchase_date và warranty_start_date
            $purchaseDate = $parseDate($dateInput) ?? now();
            $startDate = $purchaseDate; // Cùng 1 ngày như yêu cầu
            
            // Thời hạn bảo hành luôn là 12 tháng
            $periodMonths = 12;
            $endDate = (clone $startDate)->addMonths($periodMonths);

            // Tự động sinh mã hóa đơn
            $invoiceNumber = 'HD' . date('Ymd') . str_pad(Warranty::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            $warranty = Warranty::create([
                'serial_number' => $serial,
                'product_id' => $productId,
                'customer_name' => $customerName,
                'customer_phone' => $phone,
                'customer_email' => $email,
                'customer_address' => $address,
                'purchase_date' => $purchaseDate->toDateString(),
                'warranty_start_date' => $startDate->toDateString(),
                'warranty_end_date' => $endDate->toDateString(),
                'warranty_period_months' => $periodMonths,
                'invoice_number' => $invoiceNumber,
                'notes' => $notes,
                'status' => $endDate->isFuture() ? 'active' : 'expired',
            ]);

            // Log status change
            $warranty->statuses()->create([
                'status' => 'created',
                'notes' => 'Tạo bảo hành từ import',
                'changed_by' => 'admin'
            ]);

            $this->successCount++;
            return $warranty;
        } catch (\Throwable $e) {
            $this->errorCount++;
            $this->errorsBag[] = $e->getMessage();
            return null;
        }
    }

    public function rules(): array
    {
        return [
            '*.SERI' => 'required',
            '*.Số seri' => 'required',
        ];
    }

    public function getSuccessCount(): int { return $this->successCount; }
    public function getErrorCount(): int { return $this->errorCount; }
    public function getErrors(): array { return $this->errorsBag; }
}


