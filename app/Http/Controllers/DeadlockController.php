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
        // Thêm dòng check view tồn tại giống hệt bên CPU
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

        $results = []; // Khởi tạo mảng rỗng y chang bên CPU

        // Xài switch-case y hệt CPUController
        switch ($algorithm) {
            case 'banker': {
                $results = (new BankersService())->execute($request->all());
                break;
            }
            case 'detection': {
                $results = (new DetectionService())->execute($request->all());
                break;
            }
            case 'recovery': {
                $results = (new RecoveryService())->execute($request->all());
                break;
            }
            default: {
                // Fallback y chang CPU
                $results = []; 
                break;
            }
        }

        return view('modules.deadlock.deadlock_main', [
            'algorithm' => $algorithm,
            'results' => $results,
        ]);
    }
}