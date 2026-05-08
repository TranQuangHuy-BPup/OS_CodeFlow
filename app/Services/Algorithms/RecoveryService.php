<?php

namespace App\Services\Algorithms;

class RecoveryService
{
    public function execute(array $data): array
    {
        $allocation = $data['allocation'] ?? [];
        // SỬA LỖI Ở ĐÂY: Lấy trực tiếp Request từ form, không dùng phép trừ Max - Allocation nữa
        $request = $data['request'] ?? []; 
        $available = $data['available'] ?? [];
        
        $n = count($allocation);
        if ($n === 0) return ['error' => 'Không có dữ liệu'];
        $m = count($available);

        $currentAvailable = $available;
        $currentAllocation = $allocation;
        $terminatedProcesses = [];
        $stepLog = [];

        // Vòng lặp Phục hồi: Lặp lại cho đến khi không còn Deadlock
        while (true) {
            // 1. Chạy thuật toán Phát hiện Deadlock
            $detectionResult = $this->detectDeadlock($currentAllocation, $request, $currentAvailable, $n, $m);

            if (!$detectionResult['is_deadlocked']) {
                if (count($terminatedProcesses) === 0) {
                    $stepLog[] = "Trạng thái: Hệ thống KHÔNG CÓ DEADLOCK. Không cần thực hiện phục hồi.";
                } else {
                    $stepLog[] = "Trạng thái: Hệ thống ĐÃ HẾT DEADLOCK. Phục hồi thành công!";
                }
                break;
            }

            // 2. Nếu có Deadlock, chọn một tiến trình làm "nạn nhân" để chấm dứt
            // Chiến lược: Chọn tiến trình đầu tiên trong danh sách đang bị kẹt
            $deadlockedProcessIndexes = $detectionResult['deadlocked_processes'];
            $victim = $deadlockedProcessIndexes[0]; 
            
            $deadlockedNames = array_map(function($p) { return "P" . ($p + 1); }, $deadlockedProcessIndexes);
            $stepLog[] = "Phát hiện Deadlock tại các tiến trình: " . implode(', ', $deadlockedNames) . ".";

            // 3. Chấm dứt tiến trình và thu hồi tài nguyên
            $freedResources = $currentAllocation[$victim];
            for ($j = 0; $j < $m; $j++) {
                $currentAvailable[$j] += $freedResources[$j];
                $currentAllocation[$victim][$j] = 0; // Trả Allocation về 0
                $request[$victim][$j] = 0;           // Trả Request về 0
            }

            $terminatedProcesses[] = "P" . ($victim + 1);
            $stepLog[] = "-> CHẤM DỨT tiến trình P" . ($victim + 1) . ". Thu hồi tài nguyên: [" . implode(', ', $freedResources) . "]. Available mới: [" . implode(', ', $currentAvailable) . "].";
        }

        return [
            'original_deadlocked' => count($terminatedProcesses) > 0,
            'terminated_processes' => $terminatedProcesses,
            'final_available' => $currentAvailable,
            'step_log' => $stepLog
        ];
    }

    /**
     * Thuật toán Phát hiện Deadlock (Deadlock Detection Algorithm)
     */
    private function detectDeadlock($allocation, $request, $available, $n, $m)
    {
        $work = $available;
        $finish = array_fill(0, $n, false);

        // Khởi tạo Finish = true cho các tiến trình không giữ tài nguyên (Allocation = 0)
        for ($i = 0; $i < $n; $i++) {
            $isAllocZero = true;
            for ($j = 0; $j < $m; $j++) {
                if (($allocation[$i][$j] ?? 0) > 0) {
                    $isAllocZero = false;
                    break;
                }
            }
            if ($isAllocZero) $finish[$i] = true;
        }

        // Tìm tiến trình có thể hoàn thành
        $found = true;
        while ($found) {
            $found = false;
            for ($i = 0; $i < $n; $i++) {
                if (!$finish[$i]) {
                    $canGrant = true;
                    for ($j = 0; $j < $m; $j++) {
                        if (($request[$i][$j] ?? 0) > $work[$j]) {
                            $canGrant = false;
                            break;
                        }
                    }

                    if ($canGrant) {
                        for ($j = 0; $j < $m; $j++) {
                            $work[$j] += $allocation[$i][$j] ?? 0;
                        }
                        $finish[$i] = true;
                        $found = true;
                    }
                }
            }
        }

        // Kiểm tra xem có tiến trình nào bị kẹt không
        $deadlocked = [];
        for ($i = 0; $i < $n; $i++) {
            if (!$finish[$i]) {
                $deadlocked[] = $i;
            }
        }

        return [
            'is_deadlocked' => count($deadlocked) > 0,
            'deadlocked_processes' => $deadlocked
        ];
    }
}