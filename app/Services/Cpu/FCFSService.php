<?php

namespace App\Services\Cpu;

class FCFSService
{
    public function execute($data)
    {
        // Đức Huy code logic tính toán FCFS thật ở đây
        // ...

        // Dữ liệu giả (Mock) trả về để UI không bị lỗi trong lúc dev
        return [
            'process_table' => [
                ['pid' => 'P1', 'arrival' => 0, 'burst' => 5, 'completion' => 5, 'waiting' => 0, 'turnaround' => 5],
                ['pid' => 'P2', 'arrival' => 1, 'burst' => 3, 'completion' => 8, 'waiting' => 4, 'turnaround' => 7],
            ],
            'gantt_chart' => [
                ['pid' => 'P1', 'start' => 0, 'end' => 5],
                ['pid' => 'P2', 'start' => 5, 'end' => 8],
            ],
            'avg_waiting' => 2.0,
            'avg_turnaround' => 6.0
        ];
    }
}