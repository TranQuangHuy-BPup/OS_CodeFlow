<?php

namespace App\Services\Algorithms;

class BankersService
{
    public function execute(array $data): array
    {
        $allocation = $data['allocation'] ?? [];
        $max = $data['max'] ?? [];
        $available = $data['available'] ?? [];
        
        $n = count($allocation);
        if ($n === 0) return ['is_safe' => true, 'safe_sequence' => [], 'all_safe_sequences' => [], 'step_log' => ['Không có dữ liệu']];
        $m = count($available);

        $need = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $m; $j++) {
                $need[$i][$j] = ($max[$i][$j] ?? 0) - ($allocation[$i][$j] ?? 0);
            }
        }

        $finish = array_fill(0, $n, false);
        $work = $available;
        $safeSequence = [];
        $stepLog = [];

        // 1. Chạy vòng lặp chuẩn để bắt lỗi Unsafe
        while (count($safeSequence) < $n) {
            $found = false;
            for ($i = 0; $i < $n; $i++) {
                if (!$finish[$i]) {
                    $canAllocate = true;
                    for ($j = 0; $j < $m; $j++) {
                        if ($need[$i][$j] > $work[$j]) {
                            $canAllocate = false; break;
                        }
                    }

                    if ($canAllocate) {
                        for ($j = 0; $j < $m; $j++) $work[$j] += $allocation[$i][$j];
                        $finish[$i] = true;
                        $safeSequence[] = "P" . ($i + 1);
                        $found = true;
                        $stepLog[] = "Tiến trình P" . ($i + 1) . " hoàn thành. Work mới: [" . implode(', ', $work) . "]";
                    }
                }
            }
            
            if (!$found) {
                $unfinished = [];
                for ($k = 0; $k < $n; $k++) {
                    if (!$finish[$k]) $unfinished[] = "P" . ($k + 1);
                }
                $stepLog[] = "BẾ TẮC: Tài nguyên hiện có (Work = [" . implode(', ', $work) . "]) KHÔNG ĐỦ để cấp phát cho Need của bất kỳ tiến trình nào đang chờ (" . implode(', ', $unfinished) . ").";
                break;
            }
        }

        $isSafe = count($safeSequence) === $n;
        
        // 2. Tìm TẤT CẢ các chuỗi và LOG tương ứng bằng đệ quy
        $allSafeSequences = [];
        if ($isSafe) {
            $initialWork = $available;
            $initialFinish = array_fill(0, $n, false);
            $this->findAllSafeSequences($initialWork, $initialFinish, [], [], $allSafeSequences, $n, $m, $need, $allocation);
        }

        return [
            'is_safe' => $isSafe,
            'safe_sequence' => $safeSequence,
            'all_safe_sequences' => $allSafeSequences, // Mảng mới chứa cả sequence và log
            'step_log' => $stepLog,
            'need_matrix' => $need
        ];
    }

    private function findAllSafeSequences($work, $finish, $currentSeq, $currentLog, &$allSeqs, $n, $m, $need, $allocation) 
    {
        if (count($currentSeq) === $n) {
            $allSeqs[] = [
                'sequence' => $currentSeq,
                'log' => $currentLog
            ];
            return;
        }

        for ($i = 0; $i < $n; $i++) {
            if (!$finish[$i]) {
                $canAllocate = true;
                for ($j = 0; $j < $m; $j++) {
                    if ($need[$i][$j] > $work[$j]) {
                        $canAllocate = false; break;
                    }
                }

                if ($canAllocate) {
                    $finish[$i] = true;
                    for ($j = 0; $j < $m; $j++) $work[$j] += $allocation[$i][$j];
                    $currentSeq[] = "P" . ($i + 1);
                    $currentLog[] = "Tiến trình P" . ($i + 1) . " hoàn thành. Work mới: [" . implode(', ', $work) . "]";

                    $this->findAllSafeSequences($work, $finish, $currentSeq, $currentLog, $allSeqs, $n, $m, $need, $allocation);

                    // Quay lui
                    $finish[$i] = false;
                    for ($j = 0; $j < $m; $j++) $work[$j] -= $allocation[$i][$j];
                    array_pop($currentSeq);
                    array_pop($currentLog);
                }
            }
        }
    }
}