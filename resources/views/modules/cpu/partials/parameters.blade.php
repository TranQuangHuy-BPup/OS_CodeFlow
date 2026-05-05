<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
        <div class="md:col-span-1">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Algorithm</label>
            <select x-model="algo" @change="window.location.href = '/cpu/' + algo" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                <option value="fcfs">FCFS</option>
                <option value="sjf_srtf">SJF / SRTF</option>
                <option value="priority">Priority</option>
                <option value="round_robin">Round Robin</option>
            </select>
        </div>
        {{-- Quantum Time (Chỉ hiện khi chọn RR) --}}
        <div class="md:col-span-1" x-show="algo === 'round_robin'" x-cloak>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Time Quantum</label>
            <input
                type="number"
                min="1"
                step="1"
                x-model.number="quantum"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 font-mono focus:ring-2 focus:ring-primary/20 outline-none transition-all"
            >
        </div>
        {{-- Action Buttons (Cố định vị trí bên phải) --}}
        <div class="col-span-1 md:col-start-3 md:col-span-2 flex gap-3 justify-end">
            <button
                type="submit"
                class="bg-primary text-white px-6 py-2.5 rounded-xl font-bold">
                Simulate
            </button>
            <button @click="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 px-6 py-2.5 rounded-xl font-bold hover:bg-slate-50 active:scale-95 transition-all flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-base">restart_alt</span> Reset
            </button>
        </div>
    </div>
</div>

