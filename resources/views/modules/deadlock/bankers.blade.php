{{-- 1. HIỂN THỊ AVAILABLE RESOURCES (TÀI NGUYÊN SẴN CÓ) --}}
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

{{-- 2. BẢNG MA TRẬN NEED --}}
@if(!empty($results['need_matrix']))
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6" x-transition>
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-sm font-black tracking-tight text-slate-800 uppercase flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-500">calculate</span> 
            Ma trận Need (Nhu cầu còn lại)
        </h3>
    </div>
    <div class="p-6 overflow-x-auto">
        <table class="w-full text-center border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                    <th class="p-3 border border-slate-200 font-bold">Tiến trình</th>
                    <th class="p-3 border border-slate-200 font-bold text-blue-600">A</th>
                    <th class="p-3 border border-slate-200 font-bold text-blue-600">B</th>
                    <th class="p-3 border border-slate-200 font-bold text-blue-600">C</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 font-mono text-sm">
                @foreach($results['need_matrix'] as $i => $row)
                    <tr>
                        <td class="p-3 border border-slate-200 font-bold bg-slate-50">P{{ $i + 1 }}</td>
                        @foreach($row as $val)
                            <td class="p-3 border border-slate-200">{{ $val }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ========================================== --}}
{{-- 3. KẾT QUẢ BANKER'S ALGORITHM (TRÁNH DEADLOCK) --}}
{{-- ========================================== --}}
@if(isset($algorithm) && $algorithm === 'banker')
<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden" x-transition x-data="{ selectedSeq: 0 }">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-black tracking-tight text-slate-800 uppercase flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">verified_user</span> 
            Phân tích trạng thái hệ thống (Banker)
        </h3>
    </div>
    
    <div class="p-6">
        @if(isset($results) && !empty($results))
            {{-- Thông báo trạng thái Banker --}}
            <div class="p-4 rounded-xl mb-6 flex items-start gap-3 {{ $results['is_safe'] ? 'bg-green-50 border border-green-100' : 'bg-red-50 border border-red-100' }}">
                <span class="material-symbols-outlined {{ $results['is_safe'] ? 'text-green-600' : 'text-red-600' }}">
                    {{ $results['is_safe'] ? 'check_circle' : 'warning' }}
                </span>
                <div>
                    <h4 class="font-bold {{ $results['is_safe'] ? 'text-green-800' : 'text-red-800' }}">
                        {{ $results['is_safe'] ? 'Hệ thống ở trạng thái AN TOÀN (Safe State)' : 'Hệ thống ở trạng thái NGUY HIỂM (Unsafe State)' }}
                    </h4>
                </div>
            </div>

            {{-- HIỂN THỊ TẤT CẢ CHUỖI AN TOÀN KÈM CLICK TƯƠNG TÁC --}}
            @if($results['is_safe'] && !empty($results['all_safe_sequences']))
            <div class="mb-6 flex gap-6">
                <div class="w-1/2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 flex justify-between">
                        <span>Tất cả các chuỗi an toàn</span>
                        <span class="text-blue-600 font-bold">{{ count($results['all_safe_sequences']) }} chuỗi</span>
                    </h4>
                    
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 h-64 overflow-y-auto shadow-inner">
                        <div class="grid grid-cols-1 gap-2">
                            @foreach($results['all_safe_sequences'] as $index => $item)
                                <div @click="selectedSeq = {{ $index }}"
                                     :class="selectedSeq === {{ $index }} ? 'border-blue-500 bg-blue-50 shadow-md ring-1 ring-blue-500' : 'border-slate-200 bg-white hover:border-blue-300'"
                                     class="cursor-pointer flex items-center p-3 rounded-lg border font-mono text-sm transition-all duration-200">
                                    
                                    <span :class="selectedSeq === {{ $index }} ? 'bg-blue-500 text-white' : 'bg-slate-100 text-slate-500'" 
                                          class="text-[10px] px-1.5 py-0.5 rounded mr-3 font-sans font-bold transition-colors">
                                        #{{ $index + 1 }}
                                    </span>
                                    
                                    <div class="flex items-center gap-2 font-bold" :class="selectedSeq === {{ $index }} ? 'text-blue-700' : 'text-slate-600'">
                                        @foreach($item['sequence'] as $process)
                                            <span>{{ $process }}</span>
                                            @if(!$loop->last)
                                                <span class="material-symbols-outlined text-[12px]" :class="selectedSeq === {{ $index }} ? 'text-blue-400' : 'text-slate-300'">arrow_forward</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="w-1/2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 text-right">
                        Nhật ký chi tiết (Step Log)
                    </h4>
                    
                    <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm h-64 overflow-y-auto relative">
                        @foreach($results['all_safe_sequences'] as $index => $item)
                            <ul x-show="selectedSeq === {{ $index }}" x-transition.opacity style="display: none;" class="space-y-3 font-mono text-sm">
                                @foreach($item['log'] as $stepIndex => $log)
                                    <li class="flex items-start gap-3 p-2 rounded-lg text-slate-700 bg-slate-50 border border-slate-100">
                                        <span class="bg-white text-slate-500 font-bold px-2 py-0.5 rounded text-[10px] mt-0.5 border border-slate-200 whitespace-nowrap">
                                            BƯỚC {{ $stepIndex + 1 }}
                                        </span>
                                        <span class="leading-relaxed">{{ $log }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            {{-- Step Log khi bị Unsafe --}}
            @if(!$results['is_safe'] && !empty($results['step_log']))
            <div class="mt-6 border-t border-slate-200 pt-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Nhật ký chi tiết</h4>
                <div class="bg-white border border-slate-200 rounded-xl p-2 shadow-sm">
                    <ul class="space-y-1 font-mono text-sm">
                        @foreach($results['step_log'] as $index => $log)
                            @php $isError = $loop->last; @endphp
                            <li class="flex items-start gap-3 p-2 rounded-lg {{ $isError ? 'bg-red-50 text-red-700 font-bold border border-red-100' : 'text-slate-700' }}">
                                <span class="bg-slate-100 text-slate-500 font-bold px-2 py-0.5 rounded text-[10px] mt-0.5 border border-slate-200">
                                    BƯỚC {{ $index + 1 }}
                                </span>
                                <span class="leading-relaxed">{{ $log }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        @else
            <div class="text-center italic text-slate-400 py-12">Đang chờ lệnh mô phỏng thuật toán Banker...</div>
        @endif
    </div>
</div>
@endif

