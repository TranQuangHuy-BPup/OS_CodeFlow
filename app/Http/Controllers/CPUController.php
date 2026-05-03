<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CPUController extends Controller
{
    public function show($algorithm)
    {
        if (view()->exists("modules.cpu.$algorithm")) {
            // Tạo dữ liệu ảo để Duy test giao diện trước khi bàn giao cho Đức Huy
            $dummyResults = [
                ['pid' => 'P1', 'waiting_time' => 0],
                ['pid' => 'P2', 'waiting_time' => 5],
            ];

            return view('modules.cpu.cpu_main', [
                'algorithm' => $algorithm,
                'results' => $dummyResults
            ]);
        }
        abort(404);
    }
}
