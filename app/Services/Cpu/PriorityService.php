<?php

namespace App\Services\Cpu;

class PriorityService
{
    public function execute($data)
    {
        // Hòa code logic tính toán Priority thật ở đây
        // ...

        return [
            'process_table' => [],
            'gantt_chart' => [],
            'avg_waiting' => 0,
            'avg_turnaround' => 0
        ];
    }
}