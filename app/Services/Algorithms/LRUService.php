<?php

namespace App\Services\Algorithms;

class LRUService
{
    public function execute(array $data): array
    {
        $referenceString = $data['reference_string'] ?? '';
        $frameCount = (int) ($data['num_frames'] ?? 3);

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
                    $lruIndex = 0;
                    $oldestUse = PHP_INT_MAX;

                    foreach ($frames as $frameIndex => $framePage) {
                        $lastUsed = -1;
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