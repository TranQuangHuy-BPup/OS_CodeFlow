<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8 anim-fade-in" style="animation-delay: 0.2s; animation-fill-mode: both;">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3>Gantt Chart</h3>
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
            <div class="space-y-3">
                <div class="flex w-full overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
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
                                class="{{ $isIdle ? 'bg-slate-200 text-slate-600' : 'bg-primary text-white' }} flex items-center justify-center text-xs font-bold border-r border-white/40 anim-scale-in"
                                style="width: {{ $w }}%; min-width: 36px; animation-delay: {{ 0.3 + ($loop->index * 0.08) }}s;"
                                title="{{ $pid }} ({{ $start }} → {{ $end }})"
                            >
                                {{ $pid }}
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="flex w-full text-xs text-slate-500 font-mono select-none">
                    @foreach($segments as $seg)
                        @php
                            $start = (int)($seg['start'] ?? 0);
                            $end = (int)($seg['end'] ?? 0);
                            $dur = max(0, $end - $start);
                            $w = ($dur / $total) * 100;
                        @endphp
                        @if($dur > 0)
                            <div class="relative h-5 anim-fade-in" style="width: {{ $w }}%; min-width: 36px; animation-delay: {{ 0.4 + ($loop->index * 0.08) }}s; animation-fill-mode: both;">
                                @if($loop->first)
                                    <span class="absolute left-0 bottom-0">{{ $start }}</span>
                                @endif
                                <span class="absolute right-0 bottom-0">{{ $end }}</span>
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