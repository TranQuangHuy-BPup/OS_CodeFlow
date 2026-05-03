<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeadlockController extends Controller
{
    public function index()
    {
        // Gọi file giao diện tổng của Deadlock
        return view('modules.deadlock.deadlock_main');
    }
}