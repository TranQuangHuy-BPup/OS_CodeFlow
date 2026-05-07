<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden" x-transition>
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-black tracking-tight text-slate-800 uppercase flex items-center gap-2">
            <span class="material-symbols-outlined text-orange-500">troubleshoot</span> 
            Kết quả: Deadlock Detection
        </h3>
    </div>
    <div class="p-6">
        @if(isset($results))
            {{-- Trạng thái Deadlock --}}
            <div class="p-4 rounded-xl mb-6 flex items-start gap-3 anim-fade-in {{ $results['is_deadlocked'] ? 'bg-red-50 border border-red-100' : 'bg-green-50 border border-green-100' }}">
                <span class="material-symbols-outlined {{ $results['is_deadlocked'] ? 'text-red-600' : 'text-green-600' }}">
                    {{ $results['is_deadlocked'] ? 'error' : 'check_circle' }}
                </span>
                <div>
                    <h4 class="font-bold {{ $results['is_deadlocked'] ? 'text-red-800' : 'text-green-800' }}">
                        {{ $results['is_deadlocked'] ? 'Phát hiện DEADLOCK trong hệ thống!' : 'Hệ thống KHÔNG BỊ Deadlock.' }}
                    </h4>
                </div>
            </div>

            {{-- Các tiến trình bị Deadlock --}}
            @if($results['is_deadlocked'])
            <div class="mb-6 anim-fade-in" style="animation-delay: 0.1s">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Các tiến trình gây tắc nghẽn</h4>
                <div class="flex flex-wrap gap-2 font-mono font-bold text-red-600">
                    @foreach($results['deadlocked_processes'] as $index => $process)
                        {{-- Hiệu ứng trượt từng cái thẻ một --}}
                        <span class="row-anim process-badge bg-red-50 px-3 py-1.5 rounded-xl border border-red-200"
                              style="animation-fill-mode: both; animation-delay: {{ 0.2 + ($index * 0.1) }}s">
                            {{ $process }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif
        @else
            <div class="text-center italic text-slate-400 py-8">Đang chờ lệnh quét hệ thống...</div>
        @endif

        {{-- Trình tự giải phóng tài nguyên --}}
        @if(isset($results['step_log']) && count($results['step_log']) > 0)
            <div class="mt-8 border-t border-slate-100 pt-6 anim-fade-in" style="animation-delay: 0.2s">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">format_list_numbered</span>
                    Trình tự giải phóng tài nguyên
                </h4>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                    <ul class="space-y-3">
                        @foreach($results['step_log'] as $index => $step)
                            {{-- Hiệu ứng trượt từng dòng text một --}}
                            <li class="row-anim step-item flex items-start gap-3 text-sm text-slate-700"
                                style="animation-fill-mode: both; animation-delay: {{ 0.3 + ($index * 0.15) }}s">
                                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                                    {{ $index + 1 }}
                                </span>
                                <span class="pt-0.5">{{ $step }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- CSS thêm vào cho các hiệu ứng Micro-interactions --}}
<style>
    /* Hiệu ứng nổi lên khi hover vào thẻ Process bị Deadlock */
    .process-badge {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-block;
    }
    .process-badge:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.2), 0 2px 4px -1px rgba(220, 38, 38, 0.1);
        background-color: rgb(254, 226, 226); /* Đỏ đậm hơn xíu */
    }

    /* Hiệu ứng trượt nhẹ sang phải khi hover vào từng dòng Log */
    .step-item {
        transition: transform 0.2s ease, color 0.2s ease;
    }
    .step-item:hover {
        transform: translateX(6px);
        color: #0f172a; /* text-slate-900 */
    }
    .step-item:hover span:first-child {
        background-color: rgb(var(--color-primary) / 0.2);
    }
</style>