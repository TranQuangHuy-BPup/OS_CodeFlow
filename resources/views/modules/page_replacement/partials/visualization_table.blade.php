@if(isset($results) && !empty($results))

<style>
    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .anim-slide-up { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

    @keyframes popIn {
        0% { opacity: 0; transform: scale(0.5); }
        70% { transform: scale(1.15); }
        100% { opacity: 1; transform: scale(1); }
    }
    .anim-pop { 
        opacity: 0; 
        animation: popIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; 
    }
    
    /* ĐÃ SỬA: Đổi cursor thành default (chuột bình thường), bỏ dấu cộng */
    .table-col-hover:hover { background-color: #f1f5f9; cursor: default; }
</style>

<div id="results-section" data-total-pages="{{ count($results['history']) }}" class="mt-8 bg-white rounded-2xl p-8 shadow-xl border border-slate-100 anim-slide-up">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-green-50 rounded-xl shadow-inner">
                <span class="material-symbols-outlined text-green-600 text-2xl">view_timeline</span>
            </div>
            <h3 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">
                Kết quả mô phỏng bảng thay thế trang
            </h3>
        </div>
        
        <div class="flex gap-4">
            <div class="bg-red-50 text-red-600 px-5 py-3 rounded-xl font-black border-2 border-red-200 shadow-sm flex items-center gap-2 anim-pop" style="animation-delay: 0.2s">
                <span class="material-symbols-outlined">error</span>
                Page Faults: <span class="text-2xl">{{ $results['total_faults'] }}</span>
            </div>
            <div class="bg-green-50 text-green-600 px-5 py-3 rounded-xl font-black border-2 border-green-200 shadow-sm flex items-center gap-2 anim-pop" style="animation-delay: 0.4s">
                <span class="material-symbols-outlined">check_circle</span>
                Page Hits: <span class="text-2xl">{{ $results['total_hits'] }}</span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto pb-6 custom-scrollbar">
        {{-- ĐÃ SỬA: Thêm class 'select-none' để chống click nháy nháy bôi đen văn bản --}}
        <table class="w-full text-center border-collapse select-none">
            <thead>
                <tr>
                    <th class="p-4 bg-slate-800 text-white font-bold rounded-tl-xl w-32 shadow-md">Reference</th>
                    @foreach($results['history'] as $step)
                        <th class="p-4 bg-slate-100 border-b-4 border-blue-500 font-black text-xl text-slate-800 min-w-[3.5rem] shadow-sm table-col-hover transition-colors">
                            {{ $step['page'] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php $frameCount = count($results['history'][0]['frames']); @endphp

                @for($i = 0; $i < $frameCount; $i++)
                    <tr>
                        <td class="p-4 bg-slate-50 border-r border-b border-slate-200 font-bold text-slate-600 shadow-sm">Frame {{ $i + 1 }}</td>
                        @foreach($results['history'] as $step)
                            <td class="p-4 border-b border-r border-slate-100 text-slate-800 font-bold text-lg table-col-hover transition-colors">
                                {{ $step['frames'][$i] !== '-' ? $step['frames'][$i] : '' }}
                            </td>
                        @endforeach
                    </tr>
                @endfor

                <tr>
                    <td class="p-4 bg-slate-800 text-white font-bold rounded-bl-xl shadow-md">Trạng thái</td>
                    @foreach($results['history'] as $step)
                        @php $delay = ($loop->index * 0.1) + 0.3; @endphp
                        
                        @if($step['status'] == 'F')
                            <td class="p-4 border border-red-200 bg-red-50 relative overflow-hidden">
                                <div class="anim-pop text-red-600 font-black text-xl flex justify-center items-center h-full" {!! 'style="animation-delay: '.$delay.'s"' !!}>
                                    F
                                </div>
                            </td>
                        @else
                            <td class="p-4 border border-green-200 bg-green-50 relative overflow-hidden">
                                <div class="anim-pop text-green-600 font-black text-xl flex justify-center items-center h-full" {!! 'style="animation-delay: '.$delay.'s"' !!}>
                                    H
                                </div>
                            </td>
                        @endif
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resultsSection = document.getElementById('results-section');
        
        if (resultsSection) {
            setTimeout(() => {
                resultsSection.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }, 100);

            const totalPages = parseInt(resultsSection.dataset.totalPages || 0, 10);
            const lockTime = (totalPages * 100) + 1000; 

            resultsSection.style.pointerEvents = 'none'; 
            
            setTimeout(() => {
                resultsSection.style.pointerEvents = 'auto';
            }, lockTime);
        }
    });
</script>
@endif