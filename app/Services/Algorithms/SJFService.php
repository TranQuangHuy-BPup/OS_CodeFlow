<?php

namespace App\Services\Algorithms;

class SJFService
{
    /**
     * SJF (Shortest Job First) - non-preemptive.
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

        $done = [];
        $firstStart = [];
        $completion = [];
        $gantt = [];

        $time = 0;
        $n = count($procs);

        while (count($done) < $n) {
            $available = [];
            foreach ($procs as $p) {
                $pid = $p['pid'];
                if (isset($done[$pid])) continue;
                if ($p['arrival'] <= $time && $p['burst'] > 0) $available[] = $p;
                if ($p['arrival'] <= $time && $p['burst'] === 0) {
                    // Burst=0 completes immediately at current time (or arrival if CPU idle before time).
                    if (!isset($firstStart[$pid])) $firstStart[$pid] = $time;
                    $completion[$pid] = $time;
                    $done[$pid] = true;
                }
            }

            if (count($done) >= $n) break;

            if (!$available) {
                $next = null;
                foreach ($procs as $p) {
                    $pid = $p['pid'];
                    if (isset($done[$pid])) continue;
                    if ($p['arrival'] > $time) $next = $next === null ? $p['arrival'] : min($next, $p['arrival']);
                }
                $next = $next ?? ($time + 1);
                if ($next > $time) $gantt[] = ['pid' => 'IDLE', 'start' => $time, 'end' => $next];
                $time = $next;
                continue;
            }

            usort($available, function ($a, $b) {
                if ($a['burst'] !== $b['burst']) return $a['burst'] <=> $b['burst'];
                if ($a['arrival'] !== $b['arrival']) return $a['arrival'] <=> $b['arrival'];
                return $a['_i'] <=> $b['_i'];
            });

            $p = $available[0];
            $pid = $p['pid'];
            if (!isset($firstStart[$pid])) $firstStart[$pid] = $time;

            $start = $time;
            $end = $time + (int) $p['burst'];
            $gantt[] = ['pid' => $pid, 'start' => $start, 'end' => $end];
            $time = $end;

            $completion[$pid] = $time;
            $done[$pid] = true;
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

