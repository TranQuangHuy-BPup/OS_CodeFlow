<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8 anim-fade-in" style="animation-delay: 0.2s; animation-fill-mode: both;">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="font-bold text-slate-700">Gantt Chart</h3>
    </div>
    <div class="p-6">
        @php
            $segments = $gantt ?? [];
            $total = 0;
            foreach ($segments as $s) {
                $dur = max(0, (int)($s['end'] ?? 0) - (int)($s['start'] ?? 0));
                $total += $dur;
            }
            $total = max(1, $total);
        @endphp

        @if(!empty($segments))
            <div class="space-y-4"> {{-- Tăng khoảng cách giữa thanh màu và mốc thời gian --}}
                
                {{-- 1. THANH MÀU (Tăng chiều cao bằng h-14, thêm shadow-inner) --}}
                <div class="flex w-full h-14 overflow-hidden rounded-xl border border-slate-200 bg-slate-50 shadow-inner">
                    @foreach($segments as $seg)
                        @php
                            $pid = (string)($seg['pid'] ?? '');
                            $start = (int)($seg['start'] ?? 0);
                            $end = (int)($seg['end'] ?? 0);
                            $dur = max(0, $end - $start);
                            $w = ($dur / $total) * 100;
                            $isIdle = strtoupper($pid) === 'IDLE';
                        @endphp
                        @if($dur > 0)
                            <div
                                class="{{ $isIdle ? 'bg-slate-200 text-slate-500' : 'bg-primary text-white hover:bg-blue-700 hover:shadow-lg z-10' }} flex items-center justify-center text-sm md:text-base font-black border-r border-white/30 anim-scale-in transition-all duration-300 cursor-pointer"
                                style="width: {{ $w }}%; min-width: 40px; animation-delay: {{ 0.3 + ($loop->index * 0.08) }}s;"
                                title="{{ $pid }} (Thời gian: {{ $start }} → {{ $end }})"
                            >
                                {{ $pid }}
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- 2. TRỤC THỜI GIAN (Tăng size chữ, làm đậm con số) --}}
                <div class="flex w-full text-base text-slate-500 font-mono select-none mt-2">
                    @foreach($segments as $seg)
                        @php
                            $start = (int)($seg['start'] ?? 0);
                            $end = (int)($seg['end'] ?? 0);
                            $dur = max(0, $end - $start);
                            $w = ($dur / $total) * 100;
                        @endphp
                        @if($dur > 0)
                            <div class="relative h-6 anim-fade-in" style="width: {{ $w }}%; min-width: 40px; animation-delay: {{ 0.4 + ($loop->index * 0.08) }}s; animation-fill-mode: both;">
                                @if($loop->first)
                                    <span class="absolute left-0 bottom-0 font-bold text-slate-700">{{ $start }}</span>
                                @endif
                                <span class="absolute right-0 bottom-0 font-bold text-slate-700 translate-x-1/2">{{ $end }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>
        @else
            <div class="border-2 border-dashed border-slate-200 bg-slate-50/50 rounded-xl p-8 flex items-center justify-center min-h-[140px] relative">
                <style>
                    .dot-pattern { background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 16px 16px; }
                </style>
                <div class="absolute inset-0 dot-pattern opacity-50 rounded-xl"></div>
                <p class="text-slate-400 font-medium italic z-10">Simulation pending. Await execution parameters.</p>
            </div>
        @endif
    </div>
</div>