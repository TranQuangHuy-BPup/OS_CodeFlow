<?php

namespace App\Services\Algorithms;

class DetectionService
{
    public function execute(array $data): array
    {
        $allocation = array_values($data['allocation'] ?? []);
        $request = array_values($data['request'] ?? []);
        $available = $data['available'] ?? [];
        
        $n = count($allocation);
        $m = count($available);
        
        $work = $available;
        $finish = [];
        
        // Nếu Allocation = 0, coi như tiến trình đó đã xong
        for ($i = 0; $i < $n; $i++) {
            $isZero = true;
            for ($j = 0; $j < $m; $j++) {
                if ($allocation[$i][$j] > 0) { $isZero = false; break; }
            }
            $finish[$i] = $isZero;
        }

        $stepLog = [];
        $changed = true;
        while ($changed) {
            $changed = false;
            for ($i = 0; $i < $n; $i++) {
                if (!$finish[$i]) {
                    $canGrant = true;
                    for ($j = 0; $j < $m; $j++) {
                        if ($request[$i][$j] > $work[$j]) { $canGrant = false; break; }
                    }

                    if ($canGrant) {
                        for ($j = 0; $j < $m; $j++) { $work[$j] += $allocation[$i][$j]; }
                        $finish[$i] = true;
                        $changed = true;
                        $stepLog[] = "P" . ($i + 1) . " được cấp tài nguyên và hoàn thành.";
                    }
                }
            }
        }

        $deadlockedProcesses = [];
        for ($i = 0; $i < $n; $i++) {
            if (!$finish[$i]) $deadlockedProcesses[] = "P" . ($i + 1);
        }

        return [
            'is_deadlocked' => !empty($deadlockedProcesses),
            'deadlocked_processes' => $deadlockedProcesses,
            'step_log' => $stepLog
        ];
    }
}