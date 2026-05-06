<?php

namespace App\Services\Algorithms;

class OPTService
{
    public function execute(array $data): array
    {
        $referenceString = $data['reference_string'] ?? '';
        $frameCount = (int) ($data['num_frames'] ?? 3);

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
                    $optIndex = 0;
                    $farthestUse = -1;

                    foreach ($frames as $frameIndex => $framePage) {
                        $nextUse = PHP_INT_MAX;
                        for ($j = $currentIndex + 1; $j < $totalSequence; $j++) {
                            if ($pages[$j] === $framePage) {
                                $nextUse = $j;
                                break;
                            }
                        }

                        if ($nextUse === PHP_INT_MAX) {
                            $optIndex = $frameIndex;
                            break; 
                        }

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