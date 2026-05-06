<?php

namespace App\Services\Algorithms;

class BankersService
{
    public function execute(array $data): array
    {
        $allocation = $data['allocation'] ?? [];
        $max = $data['max'] ?? [];
        $available = $data['available'] ?? [];
        
        $n = count($allocation); // Số tiến trình
        if ($n === 0) return ['is_safe' => true, 'safe_sequence' => [], 'step_log' => ['Không có dữ liệu']];
        $m = count($available);   // Số loại tài nguyên

        $need = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $m; $j++) {
                $need[$i][$j] = $max[$i][$j] - $allocation[$i][$j];
            }
        }

        $finish = array_fill(0, $n, false);
        $work = $available;
        $safeSequence = [];
        $stepLog = [];

        while (count($safeSequence) < $n) {
            $found = false;
            for ($i = 0; $i < $n; $i++) {
                if (!$finish[$i]) {
                    $canAllocate = true;
                    for ($j = 0; $j < $m; $j++) {
                        if ($need[$i][$j] > $work[$j]) {
                            $canAllocate = false;
                            break;
                        }
                    }

                    if ($canAllocate) {
                        for ($j = 0; $j < $m; $j++) {
                            $work[$j] += $allocation[$i][$j];
                        }
                        $finish[$i] = true;
                        $safeSequence[] = "P" . ($i + 1);
                        $found = true;
                        $stepLog[] = "Tiến trình P" . ($i + 1) . " hoàn thành. Work mới: [" . implode(',', $work) . "]";
                    }
                }
            }
            if (!$found) break;
        }

        $isSafe = count($safeSequence) === $n;
        return [
            'is_safe' => $isSafe,
            'safe_sequence' => $safeSequence,
            'step_log' => $stepLog,
            'need_matrix' => $need
        ];
    }
}