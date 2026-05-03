<div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden mb-6">
    <div class="p-4 border-b border-outline-variant flex justify-between items-center bg-surface-bright">
        <h3 class="font-h3 text-primary flex items-center gap-2">
            <span class="material-symbols-outlined">dataset</span> Process Queue
        </h3>
        <button class="bg-primary-container text-on-primary-container px-3 py-1.5 rounded-lg text-xs font-bold hover:opacity-80 flex items-center gap-1 transition-all">
            <span class="material-symbols-outlined text-sm">add_circle</span> Add Process
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-surface-container-low border-b border-outline-variant font-label-caps text-[11px] text-on-surface-variant">
                <tr>
                    <th class="px-4 py-3">PID</th>
                    <th class="px-4 py-3 text-right">Arrival Time</th>
                    <th class="px-4 py-3 text-right">Burst Time (CPU)</th>
                    <th class="px-4 py-3 text-right">Priority</th>
                    <th class="px-4 py-3 text-center w-20">Actions</th>
                </tr>
            </thead>
            <tbody class="font-mono-data text-sm">
                <tr class="border-b border-outline-variant hover:bg-surface-container-low transition-colors">
                    <td class="px-4 py-4 font-bold text-primary">P1</td>
                    <td class="px-4 py-4 text-right">0</td>
                    <td class="px-4 py-4 text-right font-bold text-primary">5</td>
                    <td class="px-4 py-4 text-right">1</td>
                    <td class="px-4 py-4 text-center">
                        <button class="text-error hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>