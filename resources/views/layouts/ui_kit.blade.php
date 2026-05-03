@extends('layouts.app') {{-- Gọi bộ khung có chứa Tailwind và Font của Duy --}}

@section('content')
    <div class="space-y-12 p-8 bg-surface">
        <h1 class="font-h1 text-h1 text-primary border-b pb-4">CodeFlow UI Kit (v1.0)</h1>

        {{-- 
    CODEFLOW UI KIT - COMPONENT LIBRARY 
    Dành cho: Đức Huy, Quang Huy, Hòa, Chí Tài
    Quy định: Copy đúng class, không tự chế CSS mới.
--}}

<div class="space-y-12 p-8 bg-surface">
    <h1 class="font-h1 text-h1 text-primary border-b pb-4">CodeFlow UI Kit (v1.0)</h1>

    <!-- 1. READY QUEUE VISUALIZER (Pillar 1) -->
    <section class="space-y-4">
        <h2 class="font-h2 text-h2 text-on-surface">1. Ready Queue Visualizer</h2>
        <p class="text-body-sm text-secondary">Sử dụng để hiển thị các tiến trình đang chờ trong hàng đợi.</p>
        <div class="flex flex-wrap gap-2 p-4 bg-white border border-outline-variant rounded-xl shadow-sm">
            {{-- Mẫu một tiến trình trong hàng đợi --}}
            <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md border border-blue-200 font-mono-data text-xs font-bold shadow-sm animate-pulse">
                <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                P1 (Rem: 5ms)
            </div>
            <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-md border border-slate-200 font-mono-data text-xs">
                P2
            </div>
            <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-md border border-slate-200 font-mono-data text-xs">
                P3
            </div>
        </div>
    </section>

    <!-- 2. LOGIC LOG PANEL (Pillar 2) -->
    <section class="space-y-4">
        <h2 class="font-h2 text-h2 text-on-surface">2. Logic Log (Terminal Style)</h2>
        <p class="text-body-sm text-secondary">Hiển thị lịch sử giải thích thuật toán theo thời gian thực.</p>
        <div class="bg-slate-900 rounded-xl p-4 font-mono-data text-xs leading-relaxed shadow-lg max-h-48 overflow-y-auto border-t-4 border-primary">
            <p class="text-green-400 mb-1">[t=0ms]: Hệ thống khởi tạo. Nạp P1, P2 vào hàng đợi.</p>
            <p class="text-slate-300 mb-1">[t=0ms]: <span class="text-blue-400">Action:</span> CPU chọn P1 (FCFS).</p>
            <p class="text-slate-500 mb-1">[t=5ms]: P1 hoàn thành. Giải phóng tài nguyên.</p>
            <p class="text-yellow-400 mb-1">[t=5ms]: <span class="text-white">Decision:</span> Chọn P2 từ Ready Queue.</p>
        </div>
    </section>

    <!-- 3. ACADEMIC METRICS TABLE -->
    <section class="space-y-4">
        <h2 class="font-h2 text-h2 text-on-surface">3. Execution Metrics Table</h2>
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-container sticky top-0 border-b border-outline-variant">
                    <tr>
                        <th class="px-4 py-3 font-label-caps text-label-caps text-primary">PID</th>
                        <th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant text-right">Completion</th>
                        <th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant text-right">Waiting</th>
                        <th class="px-4 py-3 font-label-caps text-label-caps text-on-surface-variant text-right">Turnaround</th>
                    </tr>
                </thead>
                <tbody class="font-mono-data text-mono-data">
                    <tr class="border-b border-outline-variant hover:bg-surface-container-low transition-colors">
                        <td class="px-4 py-3 font-bold text-primary">P1</td>
                        <td class="px-4 py-3 text-right">10</td>
                        <td class="px-4 py-3 text-right text-error font-bold">5</td>
                        <td class="px-4 py-3 text-right text-tertiary">15</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- 4. ACADEMIC FORMULAS (LaTeX) -->
    <section class="space-y-4">
        <h2 class="font-h2 text-h2 text-on-surface">4. Academic Formulas</h2>
        <div class="p-6 bg-blue-50 border border-blue-100 rounded-xl space-y-2">
            <p class="text-label-caps text-blue-800 mb-2">Công thức tính toán:</p>
            <div class="text-body-base text-blue-900">
                $T_{at} = C_t - A_t$ <span class="text-blue-600 text-xs ml-4">(Turnaround Time)</span>
            </div>
            <div class="text-body-base text-blue-900">
                $W_t = T_{at} - B_t$ <span class="text-blue-600 text-xs ml-4">(Waiting Time)</span>
            </div>
        </div>
    </section>
</div>
        
    </div>
@endsection