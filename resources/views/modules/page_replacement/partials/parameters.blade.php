{{-- resources/views/modules/page_replacement/partials/parameters.blade.php --}}
<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-8" x-data="{ algo: '{{ request('algo', 'fifo') }}' }">
    <!-- <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4">Cấu hình bộ nhớ</h3> -->

    <form action="{{ route('page-replacement.simulate') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
        @csrf
        <!-- <div class="md:col-span-5">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Chuỗi tham chiếu (Reference String)</label>
            <input type="text" name="ref_string" value="{{ request('ref_string', '7,0,1,2,0,3,0,4,2,3,0,3,2,1,2,0,1,7,0,1') }}"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 outline-none focus:ring-2 focus:ring-primary/20 transition-all font-mono text-sm">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Số khung trang</label>
            <input type="number" name="frames" min="1" max="10" value="{{ request('frames', 3) }}"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 outline-none focus:ring-2 focus:ring-primary/20 transition-all">
        </div> -->

        <div class="md:col-span-3">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">ALGORITHMS</label>
            {{-- Tự động chuyển trang khi chọn thuật toán khác --}}
            <select name="algo" x-model="algo" @change="window.location.href = '/page-replacement?algo=' + algo + '&ref_string={{ request('ref_string') }}&frames={{ request('frames') }}'"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 font-medium outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                <option value="fifo">FIFO (First-In-First-Out)</option>
                <option value="lru">LRU (Least Recently Used)</option>
                <option value="opt">OPT (Optimal)</option>
            </select>
        </div>

        <!-- <div class="md:col-span-2">
            <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl flex items-center justify-center gap-2 transition-all active:scale-95">
                <span class="material-symbols-outlined text-sm">play_arrow</span> Mô phỏng
            </button>
        </div> -->
    </form>
</div>