<div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 bg-primary/10 rounded-lg">
            <span class="material-symbols-outlined text-primary">settings_input_component</span>
        </div>
        <h3 class="text-xl font-bold text-slate-800">Cấu hình tham số</h3>
    </div>

    <form action="{{ route('page-replacement.simulate', ['algorithm' => $algorithm]) }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Nhập Reference String --}}
            <div class="md:col-span-2 space-y-2">
                <label class="text-sm font-bold text-slate-600 uppercase tracking-wider">Chuỗi tham chiếu (Reference String)</label>
                <input type="text" name="reference_string" placeholder="Ví dụ: 7, 0, 1, 2, 0, 3, 0, 4, 2..." 
                    class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-primary focus:border-primary transition-all">
                <p class="text-xs text-slate-400 italic">* Các số cách nhau bằng dấu phẩy</p>
            </div>

            {{-- Nhập số Frame --}}
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-600 uppercase tracking-wider">Số khung trang (Frames)</label>
                <input type="number" name="num_frames" min="1" max="7" value="3"
                    class="w-full bg-slate-50 border-slate-200 rounded-xl focus:ring-primary focus:border-primary transition-all">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined">analytics</span>
                Chạy mô phỏng {{ strtoupper($algorithm) }}
            </button>
        </div>
    </form>
</div>