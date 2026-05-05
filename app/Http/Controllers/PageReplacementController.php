<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PageReplacement\FIFOService;
use App\Services\PageReplacement\LRUService;
use App\Services\PageReplacement\OPTService;

class PageReplacementController extends Controller
{
    // Chỉ làm nhiệm vụ hiển thị trang trắng ban đầu
    public function index()
    {
        return view('modules.page_replacement.page_replacement_main');
    }

    // Làm nhiệm vụ xử lý logic khi bấm nút "Mô phỏng"
    public function simulate(Request $request)
    {
        $algo = $request->input('algo', 'fifo');
        $refString = (string) $request->input('ref_string', '');
        $frames = (int) $request->input('frames', 3);

        switch ($algo) {
            case 'lru':
                $service = new LRUService();
                break;
            case 'opt':
                $service = new OPTService();
                break;
            default:
                $service = new FIFOService();
                break;
        }

        $results = $service->simulate($refString, $frames);

        // Trả về lại chính view đó kèm kết quả
        return view('modules.page_replacement.page_replacement_main', compact('results'));
    }
}