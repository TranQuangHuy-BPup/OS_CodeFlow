<?php
namespace App\Services\PageReplacement;

class OPTService
{
    public function simulate(string $referenceString, int $frameCount): array
    {
        $pages = array_values(array_filter(array_map('trim', explode(',', $referenceString)), fn($value) => $value !== ''));
        
        $frames = [];
        $history = [];
        $faults = 0;
        $totalSequence = count($pages);

        foreach ($pages as $currentIndex => $page) {
            $status = 'H';

            if (!in_array($page, $frames)) {
                $status = 'F';
                $faults++;

                if (count($frames) < $frameCount) {
                    $frames[] = $page;
                } else {
                    // Tìm trang tối ưu để thay thế (nhìn về tương lai)
                    $optIndex = 0;
                    $farthestUse = -1;

                    foreach ($frames as $frameIndex => $framePage) {
                        $nextUse = PHP_INT_MAX;
                        
                        // Quét tới tương lai
                        for ($j = $currentIndex + 1; $j < $totalSequence; $j++) {
                            if ($pages[$j] === $framePage) {
                                $nextUse = $j;
                                break;
                            }
                        }

                        // Nếu trang này không bao giờ được dùng lại nữa -> Thay thế luôn
                        if ($nextUse === PHP_INT_MAX) {
                            $optIndex = $frameIndex;
                            break; 
                        }

                        // Nếu dùng lại nhưng xa nhất -> Đánh dấu để thay thế
                        if ($nextUse > $farthestUse) {
                            $farthestUse = $nextUse;
                            $optIndex = $frameIndex;
                        }
                    }
                    
                    $frames[$optIndex] = $page;
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