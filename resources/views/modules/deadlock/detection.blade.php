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
            <div class="p-4 rounded-xl mb-6 flex items-start gap-3 {{ $results['is_deadlocked'] ? 'bg-red-50 border border-red-100' : 'bg-green-50 border border-green-100' }}">
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
            <div class="mb-6">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Các tiến trình gây tắc nghẽn</h4>
                <div class="flex flex-wrap gap-2 font-mono font-bold text-red-600">
                    @foreach($results['deadlocked_processes'] as $process)
                        <span class="bg-red-50 px-3 py-1.5 rounded-xl border border-red-200">{{ $process }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        @else
            <div class="text-center italic text-slate-400 py-8">Đang chờ lệnh quét hệ thống...</div>
        @endif
    </div>
</div>