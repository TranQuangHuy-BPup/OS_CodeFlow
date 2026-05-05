<?php

namespace App\Services\Algorithms;

class PriorityService
{
    /**
     * Non-preemptive Priority scheduling.
     * Assumption: smaller priority value = higher priority.
     *
     * @param  array<int, array{pid:string, arrival:int, burst:int, priority?:int}>  $processes
     * @return array{results: array<int, array<string, mixed>>, gantt: array<int, array{pid:string,start:int,end:int}>}
     */
    public function simulate(array $processes): array
    {
        foreach ($processes as $i => &$p) {
            $p['_i'] = $i;
            $p['arrival'] = (int) ($p['arrival'] ?? 0);
            $p['burst'] = max(0, (int) ($p['burst'] ?? 0));
            $p['priority'] = (int) ($p['priority'] ?? 0);
            $p['pid'] = (string) ($p['pid'] ?? ('P' . ($i + 1)));
        }
        unset($p);

        $time = 0;
        $done = [];
        $n = count($processes);
        $gantt = [];
        $resultsByPid = [];

        while (count($done) < $n) {
            $available = [];
            foreach ($processes as $p) {
                if (isset($done[$p['_i']])) continue;
                if ($p['arrival'] <= $time) $available[] = $p;
            }

            if (!$available) {
                $nextArrival = null;
                foreach ($processes as $p) {
                    if (isset($done[$p['_i']])) continue;
                    $nextArrival = $nextArrival === null ? $p['arrival'] : min($nextArrival, $p['arrival']);
                }
                $nextArrival = $nextArrival ?? $time;
                if ($nextArrival > $time) $gantt[] = ['pid' => 'IDLE', 'start' => $time, 'end' => $nextArrival];
                $time = max($time, $nextArrival);
                continue;
            }

            usort($available, function ($a, $b) {
                if ($a['priority'] !== $b['priority']) return $a['priority'] <=> $b['priority'];
                if ($a['arrival'] !== $b['arrival']) return $a['arrival'] <=> $b['arrival'];
                return $a['_i'] <=> $b['_i'];
            });

            $p = $available[0];
            $start = $time;
            $end = $time + $p['burst'];
            if ($p['burst'] > 0) $gantt[] = ['pid' => $p['pid'], 'start' => $start, 'end' => $end];

            $completion = $end;
            $turnaround = $completion - $p['arrival'];
            $waiting = $turnaround - $p['burst'];
            $response = $waiting;

            $resultsByPid[$p['pid']] = [
                'pid' => $p['pid'],
                'arrival' => $p['arrival'],
                'cpu' => $p['burst'],
                'completion' => $completion,
                'waiting_time' => $waiting,
                'turnaround' => $turnaround,
                'response' => $response,
            ];

            $done[$p['_i']] = true;
            $time = $end;
        }

        $results = [];
        foreach ($processes as $p) {
            $pid = $p['pid'];
            if (isset($resultsByPid[$pid])) $results[] = $resultsByPid[$pid];
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

