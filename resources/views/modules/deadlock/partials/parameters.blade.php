<div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm relative z-10">
    <h2 class="font-h2 text-h2 text-primary mb-2 flex items-center gap-2">
        <span class="material-symbols-outlined">account_tree</span> System State Setup
    </h2>
    <p class="text-on-surface-variant font-body-sm text-body-sm mb-6">Configure the Banker's Algorithm parameters (Processes and Resource Types).</p>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
        <div>
            <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">Processes (n)</label>
            <input class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2.5 text-on-surface focus:ring-2 focus:ring-primary/20 outline-none transition-all" type="number" value="3" min="1" max="10"/>
        </div>
        <div>
            <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">Resource Types (m)</label>
            <input class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2.5 text-on-surface focus:ring-2 focus:ring-primary/20 outline-none transition-all" type="number" value="3" min="1" max="10"/>
        </div>
        
        <div class="col-span-1 md:col-span-2 flex gap-3 justify-end">
            <button class="bg-primary text-white px-6 py-2.5 rounded-lg font-bold hover:opacity-90 active:scale-95 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">settings_suggest</span> Generate Matrix
            </button>
            <button class="bg-surface border border-outline-variant text-on-surface px-4 py-2.5 rounded-lg font-medium hover:bg-surface-variant transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">refresh</span> Reset
            </button>
        </div>
    </div>
</div>