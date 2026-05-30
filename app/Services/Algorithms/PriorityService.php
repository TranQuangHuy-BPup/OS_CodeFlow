<?php

namespace App\Services\Algorithms;

class PriorityService
{
    /**
     * @param  array<int, array{pid:string, arrival:int, burst:int, priority?:int}>  $processes
     * @param  string $mode 'non_preemptive' hoặc 'preemptive'
     */
    public function simulate(array $processes, string $mode = 'non_preemptive'): array
    {
        // Chuẩn hóa dữ liệu đầu vào
        foreach ($processes as $i => &$p) {
            $p['_i'] = $i;
            $p['arrival'] = (int) ($p['arrival'] ?? 0);
            $p['burst'] = max(0, (int) ($p['burst'] ?? 0));
            $p['remaining'] = $p['burst']; // Dùng cho Preemptive
            $p['priority'] = (int) ($p['priority'] ?? 0);
            $p['pid'] = (string) ($p['pid'] ?? ('P' . ($i + 1)));
        }
        unset($p);

        if ($mode === 'preemptive') {
            return $this->simulatePreemptive($processes);
        }

        return $this->simulateNonPreemptive($processes);
    }

    /**
     * Chế độ Non-Preemptive (Độc quyền - Chạy một mạch đến khi xong)
     */
    private function simulateNonPreemptive(array $processes): array
    {
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

        return $this->formatOutput($processes, $resultsByPid, $gantt);
    }

    /**
     * Chế độ Preemptive (Trưng dụng - Xét lại Priority mỗi khi có tiến trình mới đến)
     */
    private function simulatePreemptive(array $processes): array
    {
        $time = 0;
        $completed = 0;
        $n = count($processes);
        $gantt = [];
        $resultsByPid = [];
        $firstStart = []; // Mảng theo dõi lần chạy đầu tiên để tính Response Time

        // FIX LỖI 500: Xử lý trước các tiến trình có burst = 0 để tránh lặp vô hạn
        foreach ($processes as $idx => $p) {
            if ($p['burst'] == 0) {
                $completed++;
                $resultsByPid[$p['pid']] = [
                    'pid' => $p['pid'],
                    'arrival' => $p['arrival'],
                    'cpu' => 0,
                    'completion' => $p['arrival'],
                    'waiting_time' => 0,
                    'turnaround' => 0,
                    'response' => 0,
                ];
            }
        }

        while ($completed < $n) {
            $available = [];
            foreach ($processes as $p) {
                if ($p['remaining'] > 0 && $p['arrival'] <= $time) {
                    $available[] = $p;
                }
            }

            // Nếu không có tiến trình nào, nhảy thời gian đến tiến trình tiếp theo
            if (!$available) {
                $nextArrival = null;
                foreach ($processes as $p) {
                    if ($p['remaining'] > 0) {
                        $nextArrival = $nextArrival === null ? $p['arrival'] : min($nextArrival, $p['arrival']);
                    }
                }
                
                // Lớp bảo vệ an toàn chống lặp vô hạn
                if ($nextArrival === null) break;

                $gantt[] = ['pid' => 'IDLE', 'start' => $time, 'end' => $nextArrival];
                $time = $nextArrival;
                continue;
            }

            // Chọn tiến trình có độ ưu tiên cao nhất (số nhỏ nhất)
            usort($available, function ($a, $b) {
                if ($a['priority'] !== $b['priority']) return $a['priority'] <=> $b['priority'];
                if ($a['arrival'] !== $b['arrival']) return $a['arrival'] <=> $b['arrival'];
                return $a['_i'] <=> $b['_i'];
            });

            $selected = $available[0];
            $pid = $selected['pid'];

            // Ghi nhận lần bắt đầu tiên để tính Response Time
            if (!isset($firstStart[$pid])) {
                $firstStart[$pid] = $time;
            }

            // Chạy 1 đơn vị thời gian
            $gantt[] = ['pid' => $pid, 'start' => $time, 'end' => $time + 1];

            // Cập nhật trạng thái tiến trình
            $idx = $selected['_i'];
            $processes[$idx]['remaining']--;
            $time++;

            // Nếu tiến trình chạy xong
            if ($processes[$idx]['remaining'] === 0) {
                $completed++;
                $completion = $time;
                $turnaround = $completion - $selected['arrival'];
                $waiting = $turnaround - $selected['burst'];
                $response = $firstStart[$pid] - $selected['arrival'];

                $resultsByPid[$pid] = [
                    'pid' => $pid,
                    'arrival' => $selected['arrival'],
                    'cpu' => $selected['burst'],
                    'completion' => $completion,
                    'waiting_time' => max(0, $waiting),
                    'turnaround' => max(0, $turnaround),
                    'response' => max(0, $response),
                ];
            }
        }

        return $this->formatOutput($processes, $resultsByPid, $gantt);
    }

    /**
     * Hàm map kết quả chung
     */
    private function formatOutput(array $processes, array $resultsByPid, array $gantt): array
    {
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