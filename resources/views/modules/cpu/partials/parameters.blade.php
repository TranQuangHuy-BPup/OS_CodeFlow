<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm"
    x-data="{ algo: '{{ $algorithm }}' }">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
        {{-- Algorithm --}}
        <div class="md:col-span-1">
            <label class="block font-label-caps text-on-surface-variant mb-2">Algorithm</label>
            <select x-model="algo" @change="window.location.href = '/cpu/' + algo"
                class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                <option value="fcfs">FCFS</option>
                <option value="sjf_srtf">SJF / SRTF</option>
                <option value="priority">Priority</option>
                <option value="round_robin">Round Robin</option>
            </select>
        </div>

        {{-- Quantum Time (Chỉ hiện khi chọn RR) --}}
        <div class="md:col-span-1" x-show="algo === 'round_robin'" x-cloak x-transition>
            <label class="block font-label-caps text-on-surface-variant mb-2">Time Quantum</label>
            <input type="number" class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2.5" value="2">
        </div>

        {{-- Action Buttons (Cố định vị trí bên phải) --}}
        <div class="col-span-1 md:col-start-3 md:col-span-2 flex gap-3 justify-end">
            <button class="bg-primary text-white px-4 py-2.5 rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined">play_arrow</span> Simulate
            </button>
            <button @click="window.location.reload()"
                class="bg-surface border border-outline-variant text-on-surface px-4 py-2.5 rounded-lg font-medium hover:bg-surface-variant transition-all flex items-center gap-2">
                <span class="material-symbols-outlined">restart_alt</span> Reset
            </button>
        </div>
    </div>
</div>