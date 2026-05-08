<div class="bg-white p-6 rounded-xl shadow-sm border border-outline-variant" x-transition>
    <h3 class="font-h3 text-on-primary-container mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined">analytics</span>
        Result: {{ strtoupper(str_replace('_', ' ', $algorithm)) }}
    </h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse border border-outline-variant rounded-lg">
            <thead class="bg-surface-container font-label-caps text-[11px] text-on-surface-variant">
                <tr>
                    <th class="px-3 py-3 border border-outline-variant">PID</th>
                    <th class="px-3 py-3 border border-outline-variant text-right">Arrival</th>
                    <th class="px-3 py-3 border border-outline-variant text-right">Burst</th>
                    <th class="px-3 py-3 border border-outline-variant text-right text-primary font-bold">Completion</th>
                    <th class="px-3 py-3 border border-outline-variant text-right text-error font-bold">Waiting</th>
                    <th class="px-3 py-3 border border-outline-variant text-right text-tertiary font-bold">Turnaround</th>
                    <th class="px-3 py-3 border border-outline-variant text-right">Response</th>
                </tr>
            </thead>
            <tbody class="font-mono-data text-sm">
                @if(isset($results))
                    @foreach($results as $res)
                        <tr class="hover:bg-primary-fixed/5 transition-colors">
                            <td class="px-3 py-3 border border-outline-variant font-bold text-primary">{{ $res['pid'] }}</td>
                            <td class="px-3 py-3 border border-outline-variant text-right">{{ $res['arrival'] ?? '--' }}</td>
                            <td class="px-3 py-3 border border-outline-variant text-right">{{ $res['cpu'] ?? '--' }}</td>
                            <td class="px-3 py-3 border border-outline-variant text-right font-bold text-primary">{{ $res['completion'] ?? '--' }}</td>
                            <td class="px-3 py-3 border border-outline-variant text-right text-error font-bold">{{ $res['waiting_time'] }}</td>
                            <td class="px-3 py-3 border border-outline-variant text-right text-tertiary font-bold">{{ $res['turnaround'] ?? '--' }}</td>
                            <td class="px-3 py-3 border border-outline-variant text-right">{{ $res['response'] ?? '--' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center italic text-on-surface-variant">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-4xl opacity-20">leaderboard</span>
                                Đang chờ lệnh mô phỏng thuật toán...
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

