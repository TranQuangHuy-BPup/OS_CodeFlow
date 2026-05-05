<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CPUController;
use App\Http\Controllers\DeadlockController;
use App\Http\Controllers\PageReplacementController;
// ==========================================
// TRANG CHỦ (Mặc định load vào CPU)
// ==========================================
Route::get('/', [CPUController::class, 'index']);

// ==========================================
// PHÂN HỆ 1: ĐỊNH THỜI CPU (CPU SCHEDULING)
// ==========================================
// Hiển thị giao diện
Route::get('/cpu', [CPUController::class, 'index'])->name('cpu');
// Gửi form tính toán
Route::post('/cpu/simulate', [CPUController::class, 'simulate'])->name('cpu.simulate');


// ==========================================
// PHÂN HỆ 2: DEADLOCK
// ==========================================
// Hiển thị giao diện
Route::get('/deadlock', [DeadlockController::class, 'index'])->name('deadlock');
// Gửi form tính toán
Route::post('/deadlock/simulate', [DeadlockController::class, 'simulate'])->name('deadlock.simulate');


// ==========================================
// PHÂN HỆ 3: THAY THẾ TRANG (PAGE REPLACEMENT)
// ==========================================
// Hiển thị giao diện
Route::get('/page-replacement', [PageReplacementController::class, 'index'])->name('page-replacement');
// Gửi form tính toán
Route::post('/page-replacement/simulate', [PageReplacementController::class, 'simulate'])->name('page-replacement.simulate');

// ==========================================
// UI KIT (DÀNH CHO THIẾT KẾ GIAO DIỆN MẪU)
// ==========================================
Route::get('/ui-kit', function () {
    return view('layouts.ui_kit'); 
});