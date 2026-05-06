<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Algorithms\FIFOService;
use App\Services\Algorithms\OPTService;
use App\Services\Algorithms\LRUService;

class PageReplacementController extends Controller
{
    public function show($algorithm)
    {
        // Kiểm tra view tồn tại để tránh lỗi hệ thống
        if (!view()->exists('modules.page_replacement.page_replacement_main')) {
            abort(404);
        }

        return view('modules.page_replacement.page_replacement_main', [
            'algorithm' => $algorithm,
            'results'   => null,
        ]);
    }

    public function simulate(Request $request, $algorithm)
    {
        if (!view()->exists('modules.page_replacement.page_replacement_main')) {
            abort(404);
        }

        $results = [];

        // Sử dụng switch-case đồng bộ với CPUController
        switch ($algorithm) {
            case 'fifo': {
                $results = (new FIFOService())->execute($request->all());
                break;
            }
            case 'opt': {
                $results = (new OPTService())->execute($request->all());
                break;
            }
            case 'lru': {
                $results = (new LRUService())->execute($request->all());
                break;
            }
            default: {
                $results = [];
                break;
            }
        }

        return view('modules.page_replacement.page_replacement_main', [
            'algorithm' => $algorithm,
            'results'   => $results,
        ]);
    }
}