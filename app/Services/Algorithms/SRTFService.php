<?php

namespace App\Services\Algorithms;

class SRTFService
{
    /**
     * SRTF (Shortest Remaining Time First) - preemptive SJF.
     * Time is simulated in 1-unit steps (integer arrival/burst).
     *
     * @param  array<int, array{pid:string, arrival:int, burst:int, priority?:int}>  $processes
     * @return array{results: array<int, array<string, mixed>>, gantt: array<int, array{pid:string,start:int,end:int}>}
     */
    public function simulate(array $processes): array
    {
        foreach ($processes as $i => &$p) {
            $p['_i'] = $i;
            $p['arrival'] = max(0, (int) ($p['arrival'] ?? 0));
            $p['burst'] = max(0, (int) ($p['burst'] ?? 0));
            $p['pid'] = (string) ($p['pid'] ?? ('P' . ($i + 1)));
        }
        unset($p);

        $procs = $processes;
        usort($procs, fn($a, $b) => ($a['arrival'] <=> $b['arrival']) ?: ($a['_i'] <=> $b['_i']));

        $remaining = [];
        $firstStart = [];
        $completion = [];
        foreach ($procs as $p) {
            $remaining[$p['pid']] = $p['burst'];
        }

        $time = 0;
        $gantt = [];
        $finished = 0;
        $n = count($procs);

        while ($finished < $n) {
            $available = [];
            foreach ($procs as $p) {
                $pid = $p['pid'];
                if (isset($completion[$pid])) continue;
                if ($p['arrival'] <= $time && ($remaining[$pid] ?? 0) > 0) {
                    $available[] = $p;
                }
            }

            if (!$available) {
                $next = null;
                foreach ($procs as $p) {
                    $pid = $p['pid'];
                    if (isset($completion[$pid])) continue;
                    if ($p['arrival'] > $time) $next = $next === null ? $p['arrival'] : min($next, $p['arrival']);
                }
                $next = $next ?? ($time + 1);
                $gantt[] = ['pid' => 'IDLE', 'start' => $time, 'end' => $next];
                $time = $next;
                continue;
            }

            usort($available, function ($a, $b) use ($remaining) {
                $ra = $remaining[$a['pid']] ?? 0;
                $rb = $remaining[$b['pid']] ?? 0;
                if ($ra !== $rb) return $ra <=> $rb;
                if ($a['arrival'] !== $b['arrival']) return $a['arrival'] <=> $b['arrival'];
                return $a['_i'] <=> $b['_i'];
            });

            $p = $available[0];
            $pid = $p['pid'];
            if (!isset($firstStart[$pid])) $firstStart[$pid] = $time;

            $gantt[] = ['pid' => $pid, 'start' => $time, 'end' => $time + 1];
            $remaining[$pid] -= 1;
            $time += 1;

            if ($remaining[$pid] <= 0) {
                $completion[$pid] = $time;
                $finished++;
            }
        }

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

