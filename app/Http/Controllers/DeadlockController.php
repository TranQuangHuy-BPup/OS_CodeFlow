<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Algorithms\BankersService;
use App\Services\Algorithms\DetectionService;
use App\Services\Algorithms\RecoveryService;

class DeadlockController extends Controller
{
    public function show($algorithm)
    {
        if (!view()->exists('modules.deadlock.deadlock_main')) {
            abort(404);
        }

        return view('modules.deadlock.deadlock_main', [
            'algorithm' => $algorithm,
            'results' => null,
        ]);
    }

    public function simulate(Request $request, $algorithm)
    {
        if (!view()->exists('modules.deadlock.deadlock_main')) {
            abort(404);
        }

        $results = []; 

        switch ($algorithm) {
            case 'banker': {
                // 1. Banker dùng ma trận MAX
                $availableRaw = $request->input('available', []);
                $allocationRaw = $request->input('allocation', []);
                $maxRaw = $request->input('max', []);

                $allocationRaw = array_values($allocationRaw);
                $maxRaw = array_values($maxRaw);

                $data = [
                    'available' => array_map('intval', $availableRaw),
                    'allocation' => array_map(function($process) {
                        return array_map('intval', $process);
                    }, $allocationRaw),
                    'max' => array_map(function($process) {
                        return array_map('intval', $process);
                    }, $maxRaw)
                ];

                $results = (new BankersService())->execute($data);
                break;
            }

            case 'recovery':
            case 'detection': {
                // 2. Recovery và Detection dùng chung ma trận REQUEST (Thay vì Max)
                $availableRaw = $request->input('available', []);
                $allocationRaw = $request->input('allocation', []);
                $requestRaw = $request->input('request', []); // Lấy key 'request' từ form

                $allocationRaw = array_values($allocationRaw);
                $requestRaw = array_values($requestRaw);

                $data = [
                    'available' => array_map('intval', $availableRaw),
                    'allocation' => array_map(function($process) {
                        return array_map('intval', $process);
                    }, $allocationRaw),
                    'request' => array_map(function($process) {
                        return array_map('intval', $process);
                    }, $requestRaw) // Truyền mảng 'request' vào $data
                ];

                if ($algorithm === 'recovery') {
                    $results = (new RecoveryService())->execute($data);
                } else {
                    $results = (new DetectionService())->execute($data); // Nếu bạn có làm Detection
                }
                break;
            }

            default:
                $results = []; 
                break;
        }

        return view('modules.deadlock.deadlock_main', [
            'algorithm' => $algorithm,
            'results' => $results,
        ]);
    }
}