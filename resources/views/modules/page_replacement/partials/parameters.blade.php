<div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-slate-100">
    <div class="flex items-center gap-3 mb-6">
        <div class="p-3 bg-blue-50 rounded-xl shadow-inner">
            <span class="material-symbols-outlined text-blue-600 text-2xl">settings_input_component</span>
        </div>
        <h3 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-indigo-600">
            Cấu hình tham số - Thuật toán {{ strtoupper($algorithm) }}
        </h3>
    </div>

    <form id="simulation-form" action="{{ route('page-replacement.simulate', ['algorithm' => $algorithm]) }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-2 group">
                <label class="text-sm font-bold text-slate-600 uppercase tracking-wider group-hover:text-blue-600 transition-colors">Chuỗi tham chiếu (Reference String)</label>
                <input type="text" name="reference_string" 
                    value="{{ request('reference_string', '7, 0, 1, 2, 0, 3, 0, 4, 2, 3, 0, 3, 2, 1, 2, 0, 1, 7, 0, 1') }}" 
                    class="w-full p-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-blue-500 rounded-xl outline-none transition-all duration-300 shadow-sm hover:shadow-md text-lg font-mono">
                <p class="text-xs text-slate-400 italic font-medium mt-1">* Các số cách nhau bằng dấu phẩy</p>
            </div>

            <div class="space-y-2 group">
                <label class="text-sm font-bold text-slate-600 uppercase tracking-wider group-hover:text-blue-600 transition-colors">Số khung trang (Frames)</label>
                <input type="number" name="num_frames" min="1" max="10" 
                    value="{{ request('num_frames', 3) }}"
                    class="w-full p-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-blue-500 rounded-xl outline-none transition-all duration-300 shadow-sm hover:shadow-md text-lg font-mono text-center">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" id="submit-btn" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-blue-300/50 hover:shadow-blue-400/50 transform hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                <span id="btn-icon" class="material-symbols-outlined animate-pulse">play_circle</span>
                <span id="btn-text">Chạy mô phỏng {{ strtoupper($algorithm) }}</span>
            </button>
        </div>
    </form>
</div>

<script>
    // Xử lý đổi giao diện nút khi bấm gửi form
    document.getElementById('simulation-form').onsubmit = function() {
        const btn = document.getElementById('submit-btn');
        const icon = document.getElementById('btn-icon');
        const text = document.getElementById('btn-text');

        // Khóa nút để tránh click spam
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        
        // Đổi hiệu ứng đang xử lý
        icon.classList.add('animate-spin');
        icon.classList.remove('animate-pulse');
        icon.innerText = 'sync';
        text.innerText = 'Đang xử lý...';
    };
</script>