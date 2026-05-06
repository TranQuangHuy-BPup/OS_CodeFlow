<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden" x-transition>
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-black tracking-tight text-slate-800 uppercase flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">verified_user</span> 
            Kết quả: Banker's Algorithm
        </h3>
    </div>
    <div class="p-6">
        @if(isset($results))
            {{-- Trạng thái Hệ thống --}}
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

            {{-- Safe Sequence --}}
            @if($results['is_safe'])
            <div class="mb-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Chuỗi an toàn (Safe Sequence)</h4>
                <div class="flex flex-wrap gap-2 font-mono font-bold text-primary">
                    @foreach($results['safe_sequence'] as $process)
                        <span class="bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200">{{ $process }}</span>
                        @if(!$loop->last)
                            <span class="text-slate-400 flex items-center material-symbols-outlined">arrow_right_alt</span>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
            
            {{-- Hòa có thể in Step Log ở đây... --}}
        @else
            <div class="text-center italic text-slate-400 py-8">Đang chờ lệnh mô phỏng thuật toán...</div>
        @endif
    </div>
</div>