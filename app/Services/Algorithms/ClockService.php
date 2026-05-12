<?php

namespace App\Services\Algorithms;

class ClockService
{
    public function execute(array $data): array
    {
        $referenceString = $data['reference_string'] ?? '';
        $frameCount = (int) ($data['num_frames'] ?? 3);

        $pages = array_values(array_filter(array_map('trim', explode(',', $referenceString)), fn($value) => $value !== ''));
        
        $frames = [];     // Circular buffer chứa các trang
        $useBits = [];    // Chứa 'use bit' tương ứng với từng frame
        $history = [];
        $faults = 0;
        $pointer = 0;     // Con trỏ (kim đồng hồ)

        foreach ($pages as $page) {
            $status = 'H';

            $pageIndex = array_search($page, $frames);

            if ($pageIndex !== false) {
                // PAGE HIT: Trang được tham chiếu -> set use bit = 1
                $useBits[$pageIndex] = 1;
            } else {
                // PAGE FAULT: Không có trong RAM
                $status = 'F';
                $faults++;

                if (count($frames) < $frameCount) {
                    // RAM còn trống -> Nạp vào, set use bit = 1, di chuyển con trỏ
                    $frames[] = $page;
                    $useBits[] = 1;
                    $pointer = ($pointer + 1) % $frameCount;
                } else {
                    // RAM đầy -> Con trỏ quét tìm use bit == 0
                    while (true) {
                        if ($useBits[$pointer] == 0) {
                            // Tìm thấy -> Thay thế trang, set use bit = 1, di chuyển con trỏ
                            $frames[$pointer] = $page;
                            $useBits[$pointer] = 1;
                            $pointer = ($pointer + 1) % $frameCount;
                            break;
                        } else {
                            // Cấp cơ hội thứ hai: reset use bit về 0 và đi tiếp
                            $useBits[$pointer] = 0;
                            $pointer = ($pointer + 1) % $frameCount;
                        }
                    }
                }
            }

            // Chuẩn bị mảng frame để hiển thị ra UI
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