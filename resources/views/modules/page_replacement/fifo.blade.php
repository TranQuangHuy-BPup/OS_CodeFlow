<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200" x-transition>
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-bold text-slate-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-blue-600">analytics</span>
            Kết quả thuật toán: FIFO
        </h3>
    </div>
    
    {{-- Hiển thị bảng kết quả (Sử dụng lại logic Visualization) --}}
    @include('modules.page_replacement.partials.visualization_table')
</div>