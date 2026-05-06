<?php

namespace App\Services\Algorithms;

class RecoveryService
{
    public function execute(array $data): array
    {
        // Giả sử nhận kết quả từ DetectionService để xử lý phục hồi
        $deadlockedProcesses = $data['deadlocked_processes'] ?? [];
        
        if (empty($deadlockedProcesses)) {
            return ['recovery_suggestion' => 'Hệ thống không bế tắc.', 'step_log' => []];
        }

        // Chiến lược đơn giản: Hủy tiến trình đầu tiên trong danh sách bế tắc
        $victim = $deadlockedProcesses[0];
        
        return [
            'recovery_suggestion' => "Giải pháp: Buộc dừng (Terminate) tiến trình " . $victim,
            'step_log' => [
                "Phát hiện bế tắc tại: " . implode(', ', $deadlockedProcesses),
                "Đang tính toán chi phí phục hồi...",
                "Chọn " . $victim . " làm victim để giải phóng tài nguyên."
            ]
        ];
    }
}