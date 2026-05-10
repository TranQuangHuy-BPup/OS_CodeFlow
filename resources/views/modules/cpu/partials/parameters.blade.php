<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-8 anim-fade-in">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
        <div class="md:col-span-1">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Algorithm</label>
            <select x-model="algo" @change="window.location.href = '/cpu/' + algo" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                <option value="fcfs">FCFS</option>
                <option value="sjf">SJF</option>
                <option value="srtf">SRTF</option>
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
                class="bg-primary text-white px-6 py-2.5 rounded-xl font-bold shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/25"
            >
                Simulate
            </button>
            <button
                type="button"
                @click="resetForm()"
                class="bg-white border border-slate-200 text-slate-600 px-6 py-2.5 rounded-xl font-bold shadow-sm hover:bg-slate-50 hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 active:scale-95 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-400/20 flex items-center gap-2"
            >
                <span class="material-symbols-outlined text-base">restart_alt</span> Reset
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .anim-fade-in { animation: fadeIn 0.5s ease forwards; }
    
    @keyframes slideRow { from { opacity: 0; transform: translateX(-15px); } to { opacity: 1; transform: translateX(0); } }
    .row-anim { animation: slideRow 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    
    @keyframes scaleIn { from { transform: scaleX(0); opacity: 0; } to { transform: scaleX(1); opacity: 1; } }
    .anim-scale-in { animation: scaleIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; transform-origin: left; opacity: 0; }
</style>