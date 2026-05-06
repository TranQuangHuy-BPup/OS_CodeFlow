<?php

namespace App\Services\Algorithms;

class FIFOService
{
    public function execute(array $data): array
    {
        // Lấy dữ liệu từ mảng $data chung
        $referenceString = $data['reference_string'] ?? '';
        $frameCount = (int) ($data['num_frames'] ?? 3);

        $pages = array_values(array_filter(array_map('trim', explode(',', $referenceString)), fn($value) => $value !== ''));
        
        $frames = [];
        $history = [];
        $faults = 0;
        $queue = []; 

        foreach ($pages as $page) {
            $status = 'H'; 

            if (!in_array($page, $frames)) {
                $status = 'F'; 
                $faults++;

                if (count($frames) < $frameCount) {
                    $frames[] = $page;
                    $queue[] = $page;
                } else {
                    $oldest = array_shift($queue);
                    $index = array_search($oldest, $frames);
                    $frames[$index] = $page;
                    $queue[] = $page;
                }
            }

            $stepFrames = $frames;
            while (count($stepFrames) < $frameCount) {
                $stepFrames[] = '-';
            }

            $history[] = [
                'page' => $page,
                'frames' => $stepFrames,
                'status' => $status
            ];
        }

        return [
            'history' => $history,
            'total_faults' => $faults,
            'total_hits' => count($pages) - $faults,
        ];
    }
}