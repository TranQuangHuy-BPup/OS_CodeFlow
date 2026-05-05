<div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.06)] mb-8">
    {{-- FORM GỬI DATA LÊN CONTROLLER --}}
    <form action="{{ route('deadlock.simulate') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
            
            {{-- Dropdown Chọn Thuật Toán --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Algorithm</label>
                {{-- Dùng x-model="algoTab" để nó tự động link với biến ẩn/hiện ở file main --}}
                <select x-model="algoTab" name="algorithm" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-800 font-medium shadow-inner focus:ring-2 focus:ring-primary/20 outline-none transition-all cursor-pointer">
                    <option value="bankers">Banker's Algorithm</option>
                    <option value="detection">Deadlock Detection</option>
                    <option value="recovery">Deadlock Recovery</option>
                </select>
            </div>      
        </div>
    </form>
</div>