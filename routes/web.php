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

// Nếu người dùng gõ '/deadlock', tự động gán mặc định là thuật toán 'banker' (Tránh bế tắc)
Route::get('/deadlock', [DeadlockController::class, 'show'])->defaults('algorithm', 'banker')->name('deadlock');

// Nếu muốn nhảy thẳng vào từng thuật toán cụ thể
Route::get('/deadlock/{algorithm}', [DeadlockController::class, 'show'])->name('deadlock.algorithm');
Route::post('/deadlock/{algorithm}', [DeadlockController::class, 'simulate'])->name('deadlock.simulate');

// Nếu người dùng gõ '/page-replacement', tự động gán mặc định là 'fifo'
Route::get('/page-replacement', [PageReplacementController::class, 'show'])->defaults('algorithm', 'fifo')->name('page-replacement');

// Nếu muốn nhảy thẳng vào từng thuật toán cụ thể
Route::get('/page-replacement/{algorithm}', [PageReplacementController::class, 'show'])->name('page-replacement.algorithm');
Route::post('/page-replacement/{algorithm}', [PageReplacementController::class, 'simulate'])->name('page-replacement.simulate');
