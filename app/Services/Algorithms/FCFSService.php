<?php

namespace App\Services\Algorithms;

class FCFSService
{
    /**
     * @param  array<int, array{pid:string, arrival:int, burst:int, priority?:int}>  $processes
     * @return array{results: array<int, array<string, mixed>>, gantt: array<int, array{pid:string,start:int,end:int}>}
     */
    public function simulate(array $processes): array
    {
        // Keep stable input order for tie-breaks.
        foreach ($processes as $i => &$p) {
            $p['_i'] = $i;
            $p['arrival'] = (int) ($p['arrival'] ?? 0);
            $p['burst'] = (int) ($p['burst'] ?? 0);
            $p['pid'] = (string) ($p['pid'] ?? ('P' . ($i + 1)));
        }
        unset($p);

        usort($processes, function ($a, $b) {
            if ($a['arrival'] !== $b['arrival']) return $a['arrival'] <=> $b['arrival'];
            return $a['_i'] <=> $b['_i'];
        });

        $time = 0;
        $gantt = [];
        $results = [];

        foreach ($processes as $p) {
            $arrival = $p['arrival'];
            $burst = max(0, $p['burst']);

            if ($time < $arrival) {
                $gantt[] = ['pid' => 'IDLE', 'start' => $time, 'end' => $arrival];
                $time = $arrival;
            }

            $start = $time;
            $end = $time + $burst;

            if ($burst > 0) {
                $gantt[] = ['pid' => $p['pid'], 'start' => $start, 'end' => $end];
            }

            $completion = $end;
            $turnaround = $completion - $arrival;
            $waiting = $turnaround - $burst;
            $response = $waiting; // Non-preemptive FCFS: response == waiting

            $results[] = [
                'pid' => $p['pid'],
                'arrival' => $arrival,
                'cpu' => $burst,
                'completion' => $completion,
                'waiting_time' => $waiting,
                'turnaround' => $turnaround,
                'response' => $response,
            ];

            $time = $end;
        }

        // Sort results back to original input order for stable UI.
        $byPid = [];
        foreach ($results as $r) $byPid[$r['pid']] = $r;
        $resultsOrdered = [];
        foreach ($processes as $p) {
            $pid = $p['pid'];
            if (isset($byPid[$pid])) $resultsOrdered[] = $byPid[$pid];
        }

        return [
            'results' => $resultsOrdered,
            'gantt' => $this->mergeGantt($gantt),
        ];
    }

    /**
     * Merge adjacent segments with same pid.
     *
     * @param  array<int, array{pid:string,start:int,end:int}>  $segments
     * @return array<int, array{pid:string,start:int,end:int}>
     */
    private function mergeGantt(array $segments): array
    {
        $out = [];
        foreach ($segments as $seg) {
            if ($seg['end'] <= $seg['start']) continue;
            $lastIdx = count($out) - 1;
            if ($lastIdx >= 0 && $out[$lastIdx]['pid'] === $seg['pid'] && $out[$lastIdx]['end'] === $seg['start']) {
                $out[$lastIdx]['end'] = $seg['end'];
            } else {
                $out[] = $seg;
            }
        }
        return $out;
    }
}