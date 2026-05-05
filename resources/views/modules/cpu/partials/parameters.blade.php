{{-- Sửa $algorithm thành $algo ở dòng x-data --}}
<div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-8" x-data="{ algo: '{{ $algo ?? 'fcfs' }}' }">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
        <div class="md:col-span-1">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Algorithm</label>
            
            {{-- SỬA ĐƯỜNG DẪN Ở DÒNG @change NÀY TRỞ THÀNH DẤU CHẤM HỎI --}}
            <select x-model="algo" @change="window.location.href = '/cpu?algorithm=' + algo" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-slate-700 font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                <option value="fcfs">FCFS</option>
                <option value="sjf_srtf">SJF / SRTF</option>
                <option value="priority">Priority</option>
                <option value="round_robin">Round Robin</option>
            </select>
        </div>
        
        <!-- Các phần khác giữ nguyên -->
    </div>
</div>