<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Algorithms\BankersService;

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