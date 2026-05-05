<?php
namespace App\Services\PageReplacement;

class LRUService
{
    public function simulate(string $referenceString, int $frameCount): array
    {
        $pages = array_values(array_filter(array_map('trim', explode(',', $referenceString)), fn($value) => $value !== ''));
        
        $frames = [];
        $history = [];
        $faults = 0;

        foreach ($pages as $currentIndex => $page) {
            $status = 'H';

            if (!in_array($page, $frames)) {
                $status = 'F';
                $faults++;

                if (count($frames) < $frameCount) {
                    $frames[] = $page;
                } else {
                    // Tìm trang ít được sử dụng gần đây nhất (LRU)
                    $lruIndex = 0;
                    $oldestUse = PHP_INT_MAX;

                    foreach ($frames as $frameIndex => $framePage) {
                        $lastUsed = -1;
                        // Quét ngược về quá khứ
                        for ($j = $currentIndex - 1; $j >= 0; $j--) {
                            if ($pages[$j] === $framePage) {
                                $lastUsed = $j;
                                break;
                            }
                        }

                        if ($lastUsed < $oldestUse) {
                            $oldestUse = $lastUsed;
                            $lruIndex = $frameIndex;
                        }
                    }
                    
                    // Thay thế trang
                    $frames[$lruIndex] = $page;
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
?>