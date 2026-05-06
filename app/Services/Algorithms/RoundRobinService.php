<?php

namespace App\Services\Algorithms;

class RoundRobinService
{
    /**
     * Preemptive Round Robin scheduling.
     *
     * @param  array<int, array{pid:string, arrival:int, burst:int, priority?:int}>  $processes
     * @return array{results: array<int, array<string, mixed>>, gantt: array<int, array{pid:string,start:int,end:int}>}
     */
    public function simulate(array $processes, int $quantum = 2): array
    {
        $quantum = max(1, (int) $quantum);

        foreach ($processes as $i => &$p) {
            $p['_i'] = $i;
            $p['arrival'] = (int) ($p['arrival'] ?? 0);
            $p['burst'] = max(0, (int) ($p['burst'] ?? 0));
            $p['pid'] = (string) ($p['pid'] ?? ('P' . ($i + 1)));
        }
        unset($p);

        // Sort by arrival for feeding ready queue.
        $sorted = $processes;
        usort($sorted, fn($a, $b) => ($a['arrival'] <=> $b['arrival']) ?: ($a['_i'] <=> $b['_i']));

        $n = count($sorted);
        $remaining = [];
        $firstStart = [];
        $completion = [];
        foreach ($sorted as $p) $remaining[$p['pid']] = $p['burst'];

        $time = 0;
        $idx = 0;
        $queue = [];
        $gantt = [];

        $enqueueArrivalsUpTo = function ($t) use (&$idx, $n, $sorted, &$queue) {
            while ($idx < $n && $sorted[$idx]['arrival'] <= $t) {
                $queue[] = $sorted[$idx]['pid'];
                $idx++;
            }
        };

        // Start time at first arrival (or 0).
        if ($n > 0) $time = min(0, (int) $sorted[0]['arrival']);
        $enqueueArrivalsUpTo($time);

        while (count($completion) < $n) {
            if (!$queue) {
                // CPU idle until next arrival.
                $nextArrival = $idx < $n ? (int) $sorted[$idx]['arrival'] : $time;
                if ($nextArrival > $time) $gantt[] = ['pid' => 'IDLE', 'start' => $time, 'end' => $nextArrival];
                $time = max($time, $nextArrival);
                $enqueueArrivalsUpTo($time);
                continue;
            }

            $pid = array_shift($queue);
            if (($remaining[$pid] ?? 0) <= 0) {
                // Already finished due to duplicates in queue.
                continue;
            }

            if (!isset($firstStart[$pid])) $firstStart[$pid] = $time;

            $slice = min($quantum, $remaining[$pid]);
            $start = $time;
            $end = $time + $slice;
            $gantt[] = ['pid' => $pid, 'start' => $start, 'end' => $end];

            $time = $end;
            $remaining[$pid] -= $slice;

            // Add any new arrivals during this slice.
            $enqueueArrivalsUpTo($time);

            if ($remaining[$pid] > 0) {
                $queue[] = $pid;
            } else {
                $completion[$pid] = $time;
            }
        }

        // Build results in original input order.
        $byPidInput = [];
        foreach ($processes as $p) $byPidInput[$p['pid']] = $p;

        $results = [];
        foreach ($processes as $p) {
            $pid = $p['pid'];
            $arr = (int) $p['arrival'];
            $burst = (int) $p['burst'];
            $comp = (int) ($completion[$pid] ?? 0);
            $tat = $comp - $arr;
            $wait = $tat - $burst;
            $resp = ((int) ($firstStart[$pid] ?? $arr)) - $arr;

            $results[] = [
                'pid' => $pid,
                'arrival' => $arr,
                'cpu' => $burst,
                'completion' => $comp,
                'waiting_time' => $wait,
                'turnaround' => $tat,
                'response' => $resp,
            ];
        }

        return [
            'results' => $results,
            'gantt' => $this->mergeGantt($gantt),
        ];
    }

    /**
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

