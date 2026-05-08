<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Algorithms\FCFSService;
use App\Services\Algorithms\SJFService;
use App\Services\Algorithms\SRTFService;
use App\Services\Algorithms\PriorityService;
use App\Services\Algorithms\RoundRobinService;

class CPUController extends Controller
{
    public function show($algorithm)
    {
        if (!view()->exists("modules.cpu.$algorithm")) {
            abort(404);
        }

        return view('modules.cpu.cpu_main', [
            'algorithm' => $algorithm,
            'results' => null,
            'processesJson' => '[]',
            'quantum' => 2,
        ]);
    }

    public function simulate(Request $request, $algorithm)
    {
        if (!view()->exists("modules.cpu.$algorithm")) {
            abort(404);
        }

        $processesJson = (string) $request->input('processes_json', '[]');
        $quantum = (int) $request->input('quantum', 2);

        $decoded = json_decode($processesJson, true);
        $processes = is_array($decoded) ? $decoded : [];

        $normalized = [];
        foreach ($processes as $i => $p) {
            if (!is_array($p)) continue;
            $arrival = (int) ($p['arrival'] ?? 0);
            $burst = (int) ($p['burst'] ?? 0);
            $priority = (int) ($p['priority'] ?? 0);
            $normalized[] = [
                'pid' => (string) ($p['pid'] ?? ('P' . ($i + 1))),
                'arrival' => max(0, $arrival),
                'burst' => max(0, $burst),
                'priority' => max(0, $priority),
            ];
        }

        $results = [];
        $gantt = [];

        switch ($algorithm) {
            case 'fcfs': {
                $out = (new FCFSService())->simulate($normalized);
                $results = $out['results'] ?? [];
                $gantt = $out['gantt'] ?? [];
                break;
            }
            case 'sjf': {
                $out = (new SJFService())->simulate($normalized);
                $results = $out['results'] ?? [];
                $gantt = $out['gantt'] ?? [];
                break;
            }
            case 'srtf': {
                $out = (new SRTFService())->simulate($normalized);
                $results = $out['results'] ?? [];
                $gantt = $out['gantt'] ?? [];
                break;
            }
            case 'priority': {
                $out = (new PriorityService())->simulate($normalized);
                $results = $out['results'] ?? [];
                $gantt = $out['gantt'] ?? [];
                break;
            }
            case 'round_robin': {
                $out = (new RoundRobinService())->simulate($normalized, $quantum > 0 ? $quantum : 2);
                $results = $out['results'] ?? [];
                $gantt = $out['gantt'] ?? [];
                break;
            }
            default: {
                // Fallback: render input as-is (no simulation)
                $results = array_map(function ($p) {
                    return [
                        'pid' => $p['pid'],
                        'arrival' => $p['arrival'],
                        'cpu' => $p['burst'],
                        'completion' => null,
                        'waiting_time' => 0,
                        'turnaround' => null,
                        'response' => null,
                    ];
                }, $normalized);
                $gantt = [];
                break;
            }
        }

        return view('modules.cpu.cpu_main', [
            'algorithm' => $algorithm,
            'results' => $results,
            'gantt' => $gantt,
            'processesJson' => json_encode($normalized, JSON_UNESCAPED_UNICODE),
            'quantum' => $quantum > 0 ? $quantum : 2,
        ]);
    }
}
