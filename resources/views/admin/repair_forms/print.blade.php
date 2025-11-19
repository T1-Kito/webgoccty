<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Bảo Hành - {{ $repairForm->form_number }}</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
        }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background: white;
            line-height: 1.35;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 0.3px solid #000;
            background: #fff;
        }
        .main-table td, .main-table th {
            border: 0.3px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }
        .main-table .section-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            background: #f0f0f0;
            padding: 4px 6px;
            text-align: left;
        }
        .main-table .note-text {
            font-style: italic;
            font-size: 11px;
            padding: 2px 6px;
        }
        .main-table .important-note {
            color: red;
            font-weight: bold;
            text-align: center;
            padding: 4px 0;
            font-size: 11px;
        }
        .main-table .label {
            background: #f0f0f0;
            white-space: nowrap;
            font-size: 12px;
            font-weight: normal;
        }
        .main-table .label-small {
            font-size: 10.5px;
            font-weight: normal;
            font-style: italic;
            color: #333;
        }
        .main-table .bold {
            font-weight: bold;
        }
        .main-table .center {
            text-align: center;
        }
        .main-table .small {
            font-size: 10.5px;
        }
        .main-table .h-60 { height: 36px; }
        
        /* Mặt sau styles */
        .policy-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .policy-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .policy-section {
            margin-bottom: 10px;
        }
        .section-title {
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .policy-text {
            text-align: justify;
            margin-bottom: 8px;
            font-size: 9px;
        }
        .bullet-point {
            margin-left: 15px;
            margin-bottom: 5px;
            font-size: 9px;
        }
        .bullet-point:before {
            content: "• ";
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- MẶT TRƯỚC - PHIẾU BẢO HÀNH -->
    <div class="front-page">
        <!-- Tiêu đề ngoài bảng -->
        <div style="text-align:center; font-size:22px; font-weight:bold; margin-bottom:8px;">
          BẢO HÀNH - SỬA CHỮA<br>THIẾT BỊ VÀ SẢN PHẨM
        </div>
        <!-- Ngày tháng ngoài bảng, căn phải -->
        <div style="text-align:right; font-style:italic; margin-bottom:4px;">
          Tp HCM, Ngày {{ $repairForm->received_date->format('d') }}...Tháng...{{ $repairForm->received_date->format('m') }}...năm...{{ $repairForm->received_date->format('Y') }}...
        </div>
        <table class="main-table">
            <tr>
                <td colspan="2" class="section-title">THÔNG TIN VỀ DOANH NGHIỆP/NGƯỜI SỬ DỤNG <span class="small">(Khách hàng bắt buộc phải điền đầy đủ thông tin và ô có dấu (*)</span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Tên cơ quan, tổ chức hoặc cá nhân* <span class="label-small">(viết in hoa):</span></span> {{ strtoupper($repairForm->customer_company) }}</td>
            </tr>
            <tr>
                <td><span class="label">Người liên lạc chính(*):</span> {{ $repairForm->contact_person }}</td>
                <td><span class="label">Số điện thoại:</span> {{ $repairForm->contact_phone }}</td>
            </tr>
            <tr>
                <td><span class="label">Người liên lạc dự phòng:</span> {{ $repairForm->alternate_contact ?: 'Không' }}</td>
                <td><span class="label">Số điện thoại:</span> {{ $repairForm->alternate_phone ?: 'Không' }}</td>
            </tr>
            <tr>
                <td><span class="label">Ngày mua hàng:</span> {{ $repairForm->purchase_date ? $repairForm->purchase_date->format('d/m/Y') : '' }}</td>
                <td><span class="label">Email:</span> {{ $repairForm->email ?: '' }}</td>
            </tr>
            <tr>
                <td><span class="label">Điện thoại C.ty(*):</span> {{ $repairForm->company_phone ?: 'Không' }}</td>
                <td><span class="label">Ghi chú:</span> {{ $repairForm->notes ?: '' }}</td>
            </tr>
            
            <!-- Phần thiết bị và dữ liệu -->
            <tr>
                <td class="section-title">THIẾT BỊ KHI BÀN GIAO CHO VI KHANG</td>
                <td class="section-title">MÁY CÒN DỮ LIỆU CHẤM CÔNG & THÔNG TIN NHÂN VIÊN</td>
            </tr>
            <tr>
                <td><span class="label">Tên thiết bị(*):</span> {{ $repairForm->equipment_name }}</td>
                <td><span class="label-small">(Nếu cần yêu cầu ngoại lệ, ghi rõ nội dung tại đây)</span><br><span class="bold">TRẢ MÁY KHÁCH NGÀY {{ $repairForm->return_date ? $repairForm->return_date->format('d/m/Y') : '___/___/____' }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Tình trạng báo lỗi được:</span> {{ $repairForm->error_status }}<br><span class="bold">{{ $repairForm->includes_adapter ? 'KÈM ADAPTER' : 'KHÔNG KÈM ADAPTER' }}</span></td>
                <td></td>
            </tr>
            <tr>
                <td><span class="label">SERIAL No.*:</span> {!! nl2br(e($repairForm->serial_numbers)) !!}</td>
                <td><span class="label">Số lượng nhân viên sử dụng:</span> {{ $repairForm->employee_count ?: '' }}</td>
            </tr>
            <tr>
                <td><span class="label">Trạng thái bảo hành:</span> <span class="bold">{{ $repairForm->warranty_status == 'under_warranty' ? 'Còn bảo hành' : 'Hết bảo hành' }}</span></td>
                <td><span class="label">Phụ kiện kèm theo:</span> {{ $repairForm->accessories ?: 'Không có' }}</td>
            </tr>
            
            <!-- Phần tiếp nhận và yêu cầu -->
            <tr>
                <td class="section-title">THÔNG TIN TIẾP NHẬN BỞI VI KHANG</td>
                <td class="section-title">CÁC YÊU CẦU TRÊN ĐƯỢC HỖ TRỢ HOẶC GIẢI QUYẾT</td>
            </tr>
            <tr>
                <td>
                    <div><span class="label">Thời gian bảo hành/ sửa chữa cần:</span> {{ $repairForm->repair_time_required }}</div>
                    <div><span class="label">Người tiếp nhận:</span> {{ $repairForm->received_by }}</div>
                    <div><span class="label">Thời gian trả bảo hành dự kiến:</span> {{ $repairForm->estimated_return_date ? $repairForm->estimated_return_date->format('d/m/Y') : '' }}</div>
                    <div><span class="label">Ngày tiếp nhận:</span> {{ $repairForm->received_date->format('d/m/Y') }}</div>
                </td>
                <td>
                    <div class="label-small">(Nếu có, hoặc cần kiểm tra ghi rõ nội dung tại đây)</div>
                </td>
            </tr>
            
            <tr>
                <td colspan="2" style="text-align: center; padding: 4px 0; font-size: 11px;">Khách hàng lưu ý đọc kỹ thông tin mặt sau giấy này về chính sách nhận trả bảo hành/ sửa chữa</td>
            </tr>
            
            <!-- Phần chữ ký tích hợp vào bảng chính -->
            <tr>
                <td colspan="2">
                    <table style="width: 100%; border-collapse: collapse; border: none;">
                        <tr>
                            <td class="center label" style="height: 50px; border: 0.3px solid #000; padding: 4px 6px;">Khách hàng</td>
                            <td class="center label" style="height: 50px; border: 0.3px solid #000; padding: 4px 6px;">Người tiếp nhận thiết bị/sản phẩm</td>
                            <td class="center label" style="height: 50px; border: 0.3px solid #000; padding: 4px 6px;">Phụ trách dịch vụ khách hàng</td>
                        </tr>
                        <tr>
                            <td class="center h-60" style="border: 0.3px solid #000; padding: 4px 6px;">{{ $repairForm->contact_person }}</td>
                            <td class="center h-60" style="border: 0.3px solid #000; padding: 4px 6px;">{{ $repairForm->received_by }}</td>
                            <td class="center h-60" style="border: 0.3px solid #000; padding: 4px 6px;">{{ $repairForm->service_representative ?: 'Vi Khang' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- MẶT SAU - CHÍNH SÁCH BẢO HÀNH -->
    <div class="page-break"></div>
    <div class="policy-container">
        <div class="policy-title">CHÍNH SÁCH BẢO HÀNH</div>
        
        <div class="policy-section">
            <div class="policy-text">
                Vi Khang cung cấp bảo hành phần cứng có giới hạn một (1) năm cho tất cả các sản phẩm Vi Khang phân phối, để ủy quyền cho khách hàng của Vi Khang như sau:
            </div>
            <div class="bullet-point">
                Vi Khang bảo đảm tất cả các sản phẩm phần cứng không có lỗi sản xuất. Nó cũng đảm bảo sản phẩm phần cứng mang nhãn hiệu Vi Khang phân phối ủy quyền hay độc quyền này chống lại các khiếm khuyết về vật liệu và tay nghề dẫn đến sai lệch vật liệu so với thông số kỹ thuật Vi Khang được công bố hoặc thông số kỹ thuật tùy chỉnh cho khách hàng cụ thể đó (lỗi hệ thống phần cứng).
            </div>
            <div class="bullet-point">
                Nếu phát sinh lỗi phần cứng và nhận được yêu cầu hợp lệ trong thời hạn Bảo hành, Vi Khang sẽ sửa chữa hoặc thay thế phần cứng sản phẩm đó trong vòng 15 ngày làm việc kể từ khi nhận được phần cứng bị lỗi. Sản phẩm phần cứng phải được chuyển đến Vi Khang và chi phí vận chuyển phải được trả trước và Vi Khang không chịu trách nhiệm cho bất kỳ loại chi phí vận chuyển nào.
            </div>
            <div class="bullet-point">
                Trong trường hợp sửa chữa / thay thế bất kỳ bộ phận nào của thiết bị, bảo hành này sau đó sẽ tiếp tục và chỉ còn hiệu lực trong thời gian bảo hành chưa hết hạn hoặc 60 ngày, tùy theo mức nào cao hơn. Thời gian thực hiện để sửa chữa và quá cảnh, cho dù theo bảo hành hay cách khác, sẽ không được loại trừ khỏi thời hạn bảo hành.
            </div>
        </div>

        <div class="policy-section">
            <div class="section-title">Ngày bắt đầu bảo hành:</div>
            <div class="bullet-point">
                Tất cả các bảo hành Vi Khang có hiệu lực kể từ ngày Hóa đơn thương mại hoặc Hóa đơn thuế hoặc 30 ngày kể từ ngày giao hàng, tùy theo trường hợp nào xảy ra trước. Tất cả các yêu cầu bảo hành phải được gửi trước ngày hết hạn của thời hạn bảo hành.
            </div>
        </div>

        <div class="policy-section">
            <div class="section-title">Bảo hành:</div>
            <div class="bullet-point">
                Bảo hành này sẽ chỉ được duy trì khi sử dụng đúng phần cứng Vi Khang và không được áp dụng: Nếu phần cứng đã được sửa đổi mà không có sự chấp thuận bằng văn bản của Vi Khang.
            </div>
            <div class="bullet-point">
                Nếu số serial phần cứng/thiết bị/sản phẩm đã bị xóa / thay đổi.
            </div>
            <div class="bullet-point">
                Nếu (các) sản phẩm đã bị hư hỏng hoặc suy yếu theo bất kỳ cách nào, bao gồm nhưng không giới hạn ở sét, điện áp bất thường, nước hoặc thiệt hại nguy hiểm. Bảo hành này thay cho tất cả các quyền, điều kiện và bảo hành khác.
            </div>
            <div class="bullet-point">
                Vi Khang không bảo đảm hoặc đại diện, dù thể hiện hay ngụ ý, liên quan đến các sản phẩm hoặc tài liệu của mình, bao gồm chất lượng, hiệu suất, khả năng của người bán hoặc sự phù hợp cho một mục đích cụ thể.
            </div>
            <div class="bullet-point">
                Trong mọi trường hợp, Vi Khang sẽ không chịu trách nhiệm cho các thiệt hại trực tiếp, gián tiếp, đặc biệt, ngẫu nhiên hoặc do hậu quả phát sinh từ việc sử dụng hoặc không thể sử dụng các sản phẩm hoặc tài liệu của chúng tôi, ngay cả khi được thông báo về khả năng thiệt hại đó.
            </div>
            <div class="bullet-point">
                Vi Khang không chịu trách nhiệm cho bất kỳ chi phí nào, bao gồm, nhưng không giới hạn ở những chi phí phát sinh do lợi nhuận hoặc doanh thu bị mất, mất dữ liệu, chi phí thua lỗ.
            </div>
            <div class="bullet-point">
                Vi Khang cũng sẽ không chịu trách nhiệm cho bất kỳ thương tích cá nhân hoặc tử vong nào do việc sử dụng các sản phẩm của chúng tôi, trực tiếp hoặc gián tiếp.
            </div>
        </div>

        <div class="policy-section">
            <div class="section-title">Yêu cầu bảo hành:</div>
            <div class="bullet-point">
                Dưới đây là thông tin và quy trình do Vi Khang đưa ra để xử lý sửa chữa các sản phẩm phần cứng tuân theo các điều khoản của Chính sách bảo hành của Vi Khang.
            </div>
        </div>

        <div class="policy-section">
            <div class="section-title">Sửa chữa bảo hành sản phẩm:</div>
            <div class="policy-text">
                Tất cả các sản phẩm đem lại để sửa chữa trong thời gian bảo hành sẽ được sửa chữa hoặc trao đổi miễn phí được cung cấp:
            </div>
            <div class="bullet-point">
                (Các) sản phẩm được đem lại cho Công ty trong thời gian bảo hành.
            </div>
            <div class="bullet-point">
                Với điều kiện Vi Khang, kiểm tra các sản phẩm đem lại rằng lỗi không phải là do tai nạn, sử dụng sai, bỏ bê, thay đổi, hư hỏng nước, hư hỏng do sét, hư hỏng do điện áp hoặc sử dụng không đúng cách.
            </div>
            <div class="bullet-point">
                Không bảo hành sửa chữa hoặc trao đổi sản phẩm. Các sản phẩm được đem lại để sửa chữa chỉ có sẵn cho các thiết bị vẫn đang được sản xuất, nhưng không dành cho các sản phẩm đã ngừng sản xuất và với điều kiện là chi phí sửa chữa không vượt quá chi phí thay thế. Trong trường hợp một sản phẩm không thể sửa chữa, nó sẽ được trả lại cho khách hàng bằng chi phí của họ nêu chi tiết lý do cho hành động này. Đối với các sửa chữa ngoài bảo hành, phí đặt cọc tối thiểu tiêu chuẩn cho mỗi đơn vị sẽ được tính như quy định trong biểu giá trong tài liệu này. Nhân viên Vi Khang sẽ gửi cho khách hàng báo giá về chi phí của các bộ phận cần thay thế và sau đó sẽ tìm kiếm ủy quyền bằng văn bản và số đơn đặt hàng để tiến hành sửa chữa trước khi sửa chữa hoàn tất.
            </div>
        </div>

        <div class="policy-section">
            <div class="section-title">Thủ tục trả lại sản phẩm để sửa chữa:</div>
            <div class="bullet-point">
                Trước khi đem lại bất kỳ sản phẩm nào để sửa chữa, khách hàng phải hoàn thành Báo cáo lỗi sửa chữa thu được từ Vi Khang hoặc báo cáo lỗi tự tạo từ chính khách hàng. Chúng tôi sẽ không chấp nhận nhận lại bất kỳ sản phẩm nào để sửa chữa mà không có mẫu này. Biểu mẫu này phải có phần giải thích chi tiết về lỗi bao gồm cả trường hợp và môi trường xảy ra lỗi. Một khoản phí phát hiện lỗi bổ sung sẽ được áp dụng nếu biểu mẫu Báo cáo lỗi sửa chữa lỗi không được gửi cùng với việc sửa chữa.
            </div>
        </div>

        <div class="policy-section">
            <div class="section-title">Vận chuyển hàng:</div>
            <div class="bullet-point">
                Sản phẩm phần cứng phải được chuyển đến và từ văn phòng Vi Khang và chi phí vận chuyển phải được thanh toán trước và không thuộc trách nhiệm của Vi Khang.
            </div>
        </div>

        <div class="policy-section">
            <div class="section-title">Bảo hiểm:</div>
            <div class="bullet-point">
                Khách hàng cần đảm bảo rằng lô hàng được bảo hiểm chính xác trong khi vận chuyển đến các văn phòng Vi Khang. Vi Khang không chịu trách nhiệm về mất mát hoặc thiệt hại cho sản phẩm trong quá trình vận chuyển.
            </div>
        </div>

        <div class="policy-section">
            <div class="section-title">Thanh lý sản phẩm:</div>
            <div class="policy-text">
                Biên nhận thiết bị có giá trị trong vòng 90 ngày kể từ khi công ty Vi Khang ký nhận thiết bị. Sau khoảng thời gian này nếu khách hàng không đến nhận lại thiết bị thì xem như khách hàng đồng ý bỏ tài sản này, công ty Vi Khang sẽ thực hiện các thủ tục thanh lý.
            </div>
        </div>
    </div>
    
    <button class="print-button no-print" onclick="window.print()">
        🖨️ In Phiếu
    </button>
    <a href="{{ route('admin.repair-forms.show', $repairForm) }}" class="return-button no-print">
        ← Quay lại
    </a>
</body>
</html> 