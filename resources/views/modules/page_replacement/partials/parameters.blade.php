<div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 bg-primary/10 rounded-lg">
            <span class="material-symbols-outlined text-primary">edit_note</span>
        </div>
        <h3 class="text-xl font-bold text-slate-800">Cấu hình thông số hệ thống</h3>
    </div>

    <form action="{{ route('deadlock.simulate', ['algorithm' => $algorithm]) }}" method="POST">
        @csrf

        {{-- 1. NHẬP SỐ LƯỢNG CƠ BẢN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-600 uppercase tracking-wider">Số lượng Tiến trình (Processes)</label>
                <input type="number" name="num_processes" min="1" max="10" value="5"
                    class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-primary focus:border-primary transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-600 uppercase tracking-wider">Số lượng Tài nguyên (Resources)</label>
                <input type="number" name="num_resources" min="1" max="10" value="3"
                    class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-primary focus:border-primary transition-all">
            </div>
        </div>

        {{-- 2. KHU VỰC NHẬP MA TRẬN (Dùng JavaScript để render bảng động) --}}
        <div class="space-y-6">
            {{-- Ma trận Allocation - Thuật toán nào cũng cần --}}
            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                <h4 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    Ma trận Allocation (Đã cấp phát)
                </h4>
                <div id="allocation-matrix-container" class="overflow-x-auto">
                    </div>
            </div>

            {{-- Ma trận thay đổi tùy theo thuật toán --}}
            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                <h4 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                    @if($algorithm == 'banker')
                        Ma trận Max (Yêu cầu tối đa)
                    @else
                        Ma trận Request (Yêu cầu hiện tại)
                    @endif
                </h4>
                <div id="dynamic-matrix-container" class="overflow-x-auto">
                    </div>
            </div>

            {{-- Vector Available --}}
            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                <h4 class="font-bold text-slate-700 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    Vector Available (Tài nguyên đang rảnh)
                </h4>
                <div id="available-vector-container" class="flex gap-4">
                    </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined">play_arrow</span>
                Bắt đầu mô phỏng {{ strtoupper($algorithm) }}
            </button>
        </div>
    </form>
</div>