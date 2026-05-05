<?php

namespace App\Services\Cpu;

class RoundRobinService
{
    public function execute($data)
    {
        // Chí Tài code logic tính toán Round Robin thật ở đây
        // Lấy Time Quantum: $quantum = $data['time_quantum'] ?? 2;
        // ...

        return [
            'process_table' => [],
            'gantt_chart' => [],
            'avg_waiting' => 0,
            'avg_turnaround' => 0
        ];
    }
}