{{-- KẾT QUẢ RECOVERY ALGORITHM (PHỤC HỒI DEADLOCK) --}}
@if(isset($results) && !empty($results))
{{-- HIỂN THỊ AVAILABLE RESOURCES BAN ĐẦU --}}
    @if(request()->has('available'))
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6" x-transition>
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <h3 class="text-sm font-black tracking-tight text-slate-800 uppercase flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-500">inventory_2</span> 
                Available Resources (Tài nguyên sẵn có ban đầu)
            </h3>
        </div>
        <div class="p-6 bg-white">
            <div class="flex flex-wrap gap-4">
                @php
                    $available = request()->input('available');
                    $labels = ['A', 'B', 'C', 'D', 'E', 'F']; 
                @endphp
                @foreach($available as $index => $val)
                    <div class="flex-1 min-w-[120px] bg-slate-50 border border-slate-200 rounded-xl p-4 text-center shadow-sm">
                        <div class="text-xs font-bold text-blue-600 uppercase mb-1">
                            Loại {{ $labels[$index] ?? 'R'.($index+1) }}
                        </div>
                        <div class="text-2xl font-mono font-black text-slate-800">
                            {{ $val }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mt-6" x-transition>
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-black tracking-tight text-slate-800 uppercase flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">healing</span> 
            Kết quả Phục hồi Deadlock
        </h3>
    </div>
    
    <div class="p-6">
        @if(isset($results['original_deadlocked']) && $results['original_deadlocked'])
            {{-- Khối thông báo ĐÃ CÓ Deadlock và ĐÃ Phục hồi --}}
            <div class="p-4 rounded-xl mb-6 flex items-start gap-3 bg-orange-50 border border-orange-200">
                <span class="material-symbols-outlined text-orange-600">crisis_alert</span>
                <div>
                    <h4 class="font-bold text-orange-800">Phát hiện bế tắc (Deadlock Detected)</h4>
                    <p class="text-sm text-orange-700 mt-1">Hệ thống đã tự động chạy cơ chế chấm dứt tiến trình để phục hồi.</p>
                </div>
            </div>

            {{-- Các tiến trình đã bị "kill" --}}
            <div class="mb-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Các tiến trình bị chấm dứt (Victims)</h4>
                <div class="flex flex-wrap gap-2 font-mono font-bold text-red-600">
                    @foreach($results['terminated_processes'] as $victim)
                        <span class="bg-red-50 px-3 py-1.5 rounded-xl border border-red-200 line-through">{{ $victim }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Available Resources sau khi phục hồi --}}
            <div class="mb-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Tài nguyên được giải phóng (Final Available)</h4>
                <div class="flex gap-2">
                    @foreach($results['final_available'] as $val)
                        <span class="bg-green-50 text-green-700 px-4 py-2 rounded-lg border border-green-200 font-mono font-bold text-lg">
                            {{ $val }}
                        </span>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Khối thông báo KHÔNG CÓ Deadlock --}}
            <div class="p-4 rounded-xl mb-6 flex items-start gap-3 bg-green-50 border border-green-200">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <div>
                    <h4 class="font-bold text-green-800">Không phát hiện bế tắc</h4>
                    <p class="text-sm text-green-700 mt-1">Các tiến trình hiện tại đều có thể hoàn thành với tài nguyên sẵn có.</p>
                </div>
            </div>
        @endif
        
        {{-- Nhật ký thực thi quá trình Kill Process --}}
        @if(!empty($results['step_log']))
        <div class="mt-6 border-t border-slate-200 pt-6">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Nhật ký xử lý hệ thống</h4>
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 shadow-inner">
                <ul class="space-y-3 font-mono text-sm text-slate-700">
                    @foreach($results['step_log'] as $index => $log)
                        <li class="flex items-start gap-3">
                            <span class="text-slate-400 mt-0.5">▶</span>
                            <span class="leading-relaxed {!! strpos($log, 'CHẤM DỨT') !== false ? 'text-red-600 font-bold' : '' !!}">
                                {{ $log }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>
@endif