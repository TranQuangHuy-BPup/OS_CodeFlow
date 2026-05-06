<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden" x-transition>
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-black tracking-tight text-slate-800 uppercase flex items-center gap-2">
            <span class="material-symbols-outlined text-burgundy">build_circle</span> 
            Kế hoạch: Deadlock Recovery
        </h3>
    </div>
    <div class="p-6">
        @if(isset($results))
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-100 mb-6 flex items-start gap-3">
                <span class="material-symbols-outlined text-blue-600">lightbulb</span>
                <div>
                    <h4 class="font-bold text-blue-800">Đề xuất giải quyết (Recovery Suggestion)</h4>
                    <p class="text-sm text-blue-700 font-mono mt-2 bg-white/50 p-2 rounded border border-blue-100">
                        {{ $results['recovery_suggestion'] ?? 'Không có đề xuất' }}
                    </p>
                </div>
            </div>
        @else
            <div class="text-center italic text-slate-400 py-8">Đang tính toán phương án phục hồi...</div>
        @endif
    </div>
</div>