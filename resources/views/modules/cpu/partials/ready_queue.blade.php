<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
        <h3>Process Queue</h3>
        <button type="button" @click="addProcess()" class="text-primary font-bold text-sm flex items-center gap-1 hover:text-blue-700 transition-colors">Add Process</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-white border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">PID</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Arrival</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Burst</th>
                    <th
                        class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right"
                        x-show="algo === 'priority'"
                        x-cloak
                    >Priority</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center w-20">Actions</th>
                </tr>
            </thead>
            <tbody class="font-mono text-sm text-slate-700">

                <template x-for="(p, index) in processes" :key="index">
                    <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">

                        <!-- PID -->
                        <td class="px-6 py-4 font-bold text-primary">
                            <input x-model="p.pid" class="w-16 border rounded px-2 py-1">
                        </td>

                        <!-- Arrival -->
                        <td class="px-6 py-4 text-right">
                            <input
                                type="number"
                                min="0"
                                step="1"
                                inputmode="numeric"
                                x-model.number="p.arrival"
                                @input="p.arrival = Math.max(0, Number($event.target.value || 0))"
                                @keydown.prevent="['-','e','E','+'].includes($event.key)"
                                class="w-16 border rounded px-2 py-1 text-right">
                        </td>

                        <!-- Burst -->
                        <td class="px-6 py-4 text-right font-bold text-slate-900">
                            <input
                                type="number"
                                min="0"
                                step="1"
                                inputmode="numeric"
                                x-model.number="p.burst"
                                @input="p.burst = Math.max(0, Number($event.target.value || 0))"
                                @keydown.prevent="['-','e','E','+'].includes($event.key)"
                                class="w-16 border rounded px-2 py-1 text-right">
                        </td>

                        <!-- Priority -->
                        <td class="px-6 py-4 text-right" x-show="algo === 'priority'" x-cloak>
                            <input
                                type="number"
                                min="0"
                                step="1"
                                inputmode="numeric"
                                x-model.number="p.priority"
                                @input="p.priority = Math.max(0, Number($event.target.value || 0))"
                                @keydown.prevent="['-','e','E','+'].includes($event.key)"
                                class="w-16 border rounded px-2 py-1 text-right">
                        </td>

                        <!-- Delete -->
                        <td class="px-6 py-4 text-center">
                            <button @click="removeProcess(index)" class="text-red-500 hover:text-red-700">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </td>

                    </tr>
                </template>

            </tbody>
        </table>
    </div>
</div>