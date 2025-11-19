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

            $serial = $get(['Số seri', 'SỐ SERI', 'SỐ SERI (SN)', 'so_seri', 'serial', 'serial_number']);
            $customerName = $get(['Tên khách hàng', 'ten_khach_hang']);
            $productName = $get(['Tên sản phẩm', 'ten_san_pham']);
            $phone = $get(['Số điện thoại', 'so_dien_thoai', 'Điện thoại']);
            $email = $get(['Email', 'email']);
            $address = $get(['Địa chỉ', 'dia_chi']);
            $purchaseDateInput = $get(['Ngày mua', 'ngay_mua']);
            $startDateInput = $get(['Ngày bắt đầu bảo hành', 'ngay_bat_dau_bao_hanh']);
            $periodMonthsInput = $get(['Bảo hành', 'bao_hanh', 'Thời hạn (tháng)']);
            $notes = $get(['Ghi chú', 'ghi_chu']);

            if (empty($serial) || empty($customerName)) {
                $this->errorCount++;
                $this->errorsBag[] = 'Thiếu Số seri hoặc Tên khách hàng';
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

            $parseDate = function ($value) {
                if (!$value) return null;
                if (is_numeric($value)) {
                    // Excel serial date
                    return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
                }
                foreach (['d/m/Y', 'd-m-Y', 'Y-m-d'] as $fmt) {
                    try { return Carbon::createFromFormat($fmt, str_replace('.', '/', (string)$value)); } catch (\Throwable $e) {}
                }
                try { return Carbon::parse($value); } catch (\Throwable $e) { return null; }
            };

            $purchaseDate = $parseDate($purchaseDateInput) ?? now();
            $startDate = $parseDate($startDateInput) ?? $purchaseDate;
            $periodMonths = (int)($periodMonthsInput ?: 12);
            $endDate = (clone $startDate)->addMonths($periodMonths);

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
                'invoice_number' => null,
                'notes' => $notes,
                'status' => $endDate->isFuture() ? 'active' : 'expired',
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
            '*.Số seri' => 'required',
        ];
    }

    public function getSuccessCount(): int { return $this->successCount; }
    public function getErrorCount(): int { return $this->errorCount; }
    public function getErrors(): array { return $this->errorsBag; }
}


