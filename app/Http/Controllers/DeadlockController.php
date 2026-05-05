<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Deadlock\BankersService;
use App\Services\Deadlock\DetectionService;
use App\Services\Deadlock\RecoveryService;

// ============================================================================
// KHU VỰC CẤM - TEAM DEV TUYỆT ĐỐI KHÔNG ĐỤNG VÀO
// ============================================================================
class DeadlockController extends Controller
{
    // 1. Hàm để hiển thị giao diện mặc định
    public function index(Request $request)
    {
        // Lấy thuật toán từ URL (vd: /deadlock?algorithm=detection)
        // Mặc định nếu không có thì là 'bankers'
        $algo = $request->query('algorithm', 'bankers');

        // Truyền biến $algo ra ngoài View
        return view('modules.deadlock.deadlock_main', compact('algo'));
    }

    // 2. HÀM XỬ LÝ ĐỘNG (FACTORY PATTERN) - TẤT CẢ GỌI VÀO ĐÂY
    public function simulate(Request $request)
    {
        // Lấy tên thuật toán từ form gửi lên (bankers, detection, recovery)
        $algo = $request->input('algorithm');

        // Khởi tạo Service tương ứng dựa vào tham số $algo
        $service = match ($algo) {
            'bankers' => new BankersService(),
            'detection' => new DetectionService(),
            'recovery' => new RecoveryService(),
            default => throw new \Exception('Thuật toán không hợp lệ: ' . $algo),
        };

        // Bắt buộc các file Service (của Chí Tài, Quang Huy, Đức Huy) 
        // ĐỀU PHẢI CÓ 1 hàm tên là execute() nhận vào $data và trả về mảng kết quả
        $results = $service->execute($request->all());

        // Trả kết quả về lại View chính, kèm theo tên thuật toán để load đúng file HTML
        return view('modules.deadlock.deadlock_main', compact('results', 'algo'));
    }

// ============================================================================
// HẾT KHU VỰC CẤM - TỪ ĐÂY TRỞ XUỐNG TEAM DEV CÓ THỂ MỞ COMMENT ĐỂ TEST
// ============================================================================

    // ------------------------------------------------------------------------
    // [CHÍ TÀI] - THUẬT TOÁN BANKER (BANKER's ALGORITHM)
    // ------------------------------------------------------------------------
    // Hướng dẫn:
    // 1. Mở file: App\Services\Deadlock\BankersService.php
    // 2. Viết thuật toán vào hàm execute($data).
    // 3. $data chứa mảng Allocation, Max, Available.
    // 4. Return về mảng có cấu trúc:
    //    return [
    //        'is_safe' => true/false,
    //        'safe_sequence' => ['P1', 'P3', ...],
    //        'step_log' => ['Bước 1...', 'Bước 2...']
    //    ];
    //
    // public function calculateBankers(Request $request, BankersService $service)
    // {
    //      // Nếu muốn test riêng, mở comment hàm này và tạo route tương ứng
    // }

    // ------------------------------------------------------------------------
    // [QUANG HUY] - THUẬT TOÁN PHÁT HIỆN TẮC NGHẼN (DEADLOCK DETECTION)
    // ------------------------------------------------------------------------
    // Hướng dẫn:
    // 1. Mở file: App\Services\Deadlock\DetectionService.php
    // 2. Viết thuật toán vào hàm execute($data).
    // 3. $data chứa mảng Allocation, Request, Available.
    // 4. Return về mảng có cấu trúc:
    //    return [
    //        'is_deadlocked' => true/false,
    //        'deadlocked_processes' => ['P2', 'P4', ...],
    //        'step_log' => ['Bước 1...', 'Bước 2...']
    //    ];
    //
    // public function calculateDetection(Request $request, DetectionService $service)
    // {
    //      // Nếu muốn test riêng, mở comment hàm này và tạo route tương ứng
    // }

    // ------------------------------------------------------------------------
    // [ĐỨC HUY] - THUẬT TOÁN PHỤC HỒI TẮC NGHẼN (DEADLOCK RECOVERY)
    // ------------------------------------------------------------------------
    // Hướng dẫn:
    // 1. Mở file: App\Services\Deadlock\RecoveryService.php
    // 2. Viết thuật toán vào hàm execute($data).
    // 3. Xác định Process nào nên bị Terminate hoặc Preempt tài nguyên.
    // 4. Return về mảng có cấu trúc:
    //    return [
    //        'recovery_suggestion' => 'Nên Terminate Process P2',
    //        'step_log' => ['Lý do chọn P2...', 'Tài nguyên thu hồi...']
    //    ];
    //
    // public function calculateRecovery(Request $request, RecoveryService $service)
    // {
    //      // Nếu muốn test riêng, mở comment hàm này và tạo route tương ứng
    // }
}