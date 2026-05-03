<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-6 shadow-sm">
    <h2 class="font-h2 text-h2 text-on-surface mb-4">Memory Configuration</h2>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
        <div class="col-span-1 md:col-span-5">
            <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">Reference String (Comma Separated)</label>
            <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-on-surface font-mono-data focus:ring-primary focus:border-primary" type="text" value="7,0,1,2,0,3,0,4,2,3,0,3,2,1,2,0,1,7,0,1"/>
        </div>
        <div class="col-span-1 md:col-span-2">
            <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">Frames</label>
            <input class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-on-surface focus:ring-primary focus:border-primary" type="number" value="3"/>
        </div>
        <div class="col-span-1 md:col-span-2">
            <label class="block font-label-caps text-label-caps text-on-surface-variant mb-2">Algorithm</label>
            <select class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-2 text-on-surface focus:ring-primary focus:border-primary">
                <option>FIFO</option>
                <option>OPT</option>
                <option>LRU</option>
            </select>
        </div>
        <div class="col-span-1 md:col-span-3 flex gap-2 justify-end">
            <button class="bg-primary text-white px-4 py-2 rounded-lg font-body-sm text-body-sm font-medium hover:bg-primary-container transition-colors flex items-center gap-2 w-full justify-center">
                <span class="material-symbols-outlined text-sm">memory</span> Simulate
            </button>
        </div>
    </div>
</div>