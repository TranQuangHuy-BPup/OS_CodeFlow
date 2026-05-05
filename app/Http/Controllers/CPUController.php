<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Cpu\FCFSService;
use App\Services\Cpu\SJFSRTFService;
use App\Services\Cpu\PriorityService;
use App\Services\Cpu\RoundRobinService;

// ============================================================================
// KHU VỰC CỦA NGỌC DUY (TRƯỞNG NHÓM) - TEAM DEV TUYỆT ĐỐI KHÔNG ĐỤNG VÀO
// ============================================================================
class CPUController extends Controller
{
    // 1. Hàm để hiển thị giao diện mặc định (Load tab bằng AlpineJS)
    public function index(Request $request)
    {
        // Lấy thuật toán từ URL (vd: /cpu?algorithm=sjf_srtf)
        // Mặc định nếu không có thì là 'fcfs'
        $algo = $request->query('algorithm', 'fcfs');

        return view('modules.cpu.cpu_main', compact('algo'));
    }

    // 2. HÀM XỬ LÝ ĐỘNG (FACTORY PATTERN) - TẤT CẢ GỌI VÀO ĐÂY
    public function simulate(Request $request)
    {
        // Lấy tên thuật toán từ form gửi lên
        $algo = $request->input('algorithm');

        // Khởi tạo Service tương ứng dựa vào tham số $algo
        $service = match ($algo) {
            'fcfs' => new FCFSService(),
            'sjf_srtf' => new SJFSRTFService(),
            'priority' => new PriorityService(),
            'round_robin' => new RoundRobinService(),
            default => throw new \Exception('Thuật toán không hợp lệ: ' . $algo),
        };

        // Bắt buộc các file Service đều phải có hàm execute() trả về mảng kết quả
        $results = $service->execute($request->all());

        // Trả kết quả về lại View chính, kèm theo tên thuật toán để load đúng tab
        return view('modules.cpu.cpu_main', compact('results', 'algo'));
    }

// ============================================================================
// HẾT KHU VỰC CẤM - TỪ ĐÂY TRỞ XUỐNG TEAM DEV MỞ RA XEM HƯỚNG DẪN CODE
// ============================================================================

    // ------------------------------------------------------------------------
    // [ĐỨC HUY] - THUẬT TOÁN FCFS
    // ------------------------------------------------------------------------
    // 1. Mở file: App\Services\Cpu\FCFSService.php
    // 2. Viết thuật toán vào hàm execute($data).
    // 3. Return về mảng có cấu trúc:
    //    return [
    //        'process_table' => [
    //            ['pid' => 'P1', 'arrival' => 0, 'burst' => 5, 'completion' => 5, 'waiting' => 0, 'turnaround' => 5],
    //            ...
    //        ],
    //        'gantt_chart' => [
    //            ['pid' => 'P1', 'start' => 0, 'end' => 5],
    //            ...
    //        ],
    //        'avg_waiting' => 2.5,
    //        'avg_turnaround' => 4.2
    //    ];

    // ------------------------------------------------------------------------
    // [QUANG HUY] - THUẬT TOÁN SJF & SRTF
    // ------------------------------------------------------------------------
    // 1. Mở file: App\Services\Cpu\SJFSRTFService.php
    // 2. Viết thuật toán vào hàm execute($data). Nhớ check biến xem user chọn Preemptive (SRTF) hay Non-Preemptive (SJF).
    // 3. Cấu trúc return y hệt như của FCFS ở trên.

    // ------------------------------------------------------------------------
    // [HÒA] - THUẬT TOÁN PRIORITY
    // ------------------------------------------------------------------------
    // 1. Mở file: App\Services\Cpu\PriorityService.php
    // 2. Viết thuật toán vào hàm execute($data). Nhớ xử lý cột Priority (Ưu tiên).
    // 3. Cấu trúc return y hệt như của FCFS ở trên.

    // ------------------------------------------------------------------------
    // [CHÍ TÀI] - THUẬT TOÁN ROUND ROBIN
    // ------------------------------------------------------------------------
    // 1. Mở file: App\Services\Cpu\RoundRobinService.php
    // 2. Viết thuật toán vào hàm execute($data). Nhớ lấy biến Time Quantum (q) từ $data.
    // 3. Cấu trúc return y hệt như của FCFS ở trên.
}