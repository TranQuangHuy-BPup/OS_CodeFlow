<?php
namespace App\Services\PageReplacement;

class FIFOService
{
    public function simulate(string $referenceString, int $frameCount): array
    {
        // Lọc chuỗi: tách bằng dấu phẩy, bỏ khoảng trắng, xóa các giá trị rỗng
        $pages = array_values(array_filter(array_map('trim', explode(',', $referenceString)), fn($value) => $value !== ''));
        
        $frames = [];
        $history = [];
        $faults = 0;
        $queue = []; // Hàng đợi FIFO

        foreach ($pages as $page) {
            $status = 'H'; // Mặc định là Hit

            if (!in_array($page, $frames)) {
                $status = 'F'; // Xảy ra Page Fault
                $faults++;

                if (count($frames) < $frameCount) {
                    $frames[] = $page;
                    $queue[] = $page;
                } else {
                    // Xóa phần tử cũ nhất khỏi hàng đợi và thay thế trong frames
                    $oldest = array_shift($queue);
                    $index = array_search($oldest, $frames);
                    $frames[$index] = $page;
                    $queue[] = $page;
                }
            }

            // Chuẩn hóa mảng frame để render View (điền '-' vào chỗ trống)
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
?>