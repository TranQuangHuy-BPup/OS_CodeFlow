<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CPUController;
use App\Http\Controllers\DeadlockController;
use App\Http\Controllers\PageReplacementController;


#Route::get('/', function () {
#   return view('layouts.app');
#});

Route::get('/', [CPUController::class, 'show'])->defaults('algorithm', 'fcfs');

Route::get('/cpu', [CPUController::class, 'show'])->defaults('algorithm', 'fcfs')->name('cpu');

// Nếu muốn nhảy thẳng vào từng thuật toán cụ thể
Route::get('/cpu/{algorithm}', [CPUController::class, 'show'])->name('cpu.algorithm');
Route::post('/cpu/{algorithm}', [CPUController::class, 'simulate'])->name('cpu.simulate');

Route::get('/deadlock', [DeadlockController::class, 'index'])->name('deadlock');

Route::get('/page-replacement', [PageReplacementController::class, 'index'])->name('page_replacement');

// http://127.0.0.1:8000/ui-kit
Route::get('/ui-kit', function () {
    return view('layouts.ui_kit'); 
});