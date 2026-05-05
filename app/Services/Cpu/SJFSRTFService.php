<?php

namespace App\Services\Cpu;

class SJFSRTFService
{
    public function execute($data)
    {
        // Quang Huy code logic tính toán SJF/SRTF thật ở đây
        // Nhớ phân biệt $data['is_preemptive'] nếu có
        // ...

        return [
            'process_table' => [],
            'gantt_chart' => [],
            'avg_waiting' => 0,
            'avg_turnaround' => 0
        ];
    }
}