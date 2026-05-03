<div class="bg-white p-6 rounded-xl shadow-sm border border-outline-variant relative z-10 mt-6">
    <h3 class="font-h3 text-primary mb-4 uppercase flex items-center gap-2">
        <span class="material-symbols-outlined">fact_check</span> System Safety Status
    </h3>
    
    <div class="p-6 bg-surface-container-low rounded-lg border border-outline-variant text-center">
        {{-- Trạng thái chờ --}}
        <div class="flex flex-col items-center gap-2 text-on-surface-variant italic">
            <span class="material-symbols-outlined text-4xl opacity-20">hourglass_empty</span>
            Enter values and click "Simulate" to check for Deadlock.
        </div>
        
        {{-- Khi có kết quả (Dev sẽ dùng logic Blade/JS để ẩn hiện khối này) --}}
        <div class="hidden">
            <p class="text-lg font-bold text-green-600 mb-2">System is in a SAFE state!</p>
            <p class="font-mono-data text-on-surface">Safe Sequence: <span class="bg-white px-3 py-1 rounded border border-outline-variant ml-2">P1 &rarr; P3 &rarr; P0 &rarr; P2</span></p>
        </div>
    </div>
</div>