<!-- <div class="overflow-x-auto border border-slate-100 rounded-xl">
    <table class="w-full text-center border-collapse">
        @if(isset($results))
            <tbody>
                {{-- Dòng Chuỗi tham chiếu --}}
                <tr class="bg-slate-50/50">
                    <td class="p-4 border-b border-r border-slate-100 font-bold text-slate-500 text-left w-32 text-xs uppercase tracking-widest">Ref String</td>
                    @foreach($results['history'] as $step)
                        <td class="p-4 border-b border-slate-100 font-bold text-slate-900 bg-blue-50/30">{{ $step['page'] }}</td>
                    @endforeach
                </tr>

                {{-- Các dòng Frame --}}
                @for($i = 0; $i < request('frames', 3); $i++)
                    <tr>
                        <td class="p-4 border-b border-r border-slate-100 font-bold text-slate-500 text-left text-xs uppercase">Frame {{ $i + 1 }}</td>
                        @foreach($results['history'] as $step)
                            @php $val = $step['frames'][$i] ?? '-'; @endphp
                            <td class="p-4 border-b border-slate-100 font-mono {{ $val !== '-' ? 'text-blue-600 font-bold' : 'text-slate-300' }}">
                                {{ $val }}
                            </td>
                        @endforeach
                    </tr>
                @endfor

                {{-- Dòng Trạng thái --}}
                <tr>
                    <td class="p-4 border-r border-slate-100 font-bold text-slate-500 text-left text-xs uppercase">Status</td>
                    @foreach($results['history'] as $step)
                        <td class="p-4 border-slate-100">
                            @if($step['status'] == 'F')
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 font-bold text-xs">F</span>
                            @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold text-xs">H</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            </tbody>
        @else
            {{-- Trạng thái CHƯA CHẠY MÔ PHỎNG --}}
            <tbody>
                <tr>
                    <td class="p-12 text-center bg-slate-50/30">
                        <div class="flex flex-col items-center justify-center gap-2 text-slate-400">
                            <span class="material-symbols-outlined text-4xl opacity-40">memory</span>
                            <span class="italic">Đang chờ lệnh mô phỏng thuật toán...</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        @endif
    </table>
</div>

{{-- Chỉ hiển thị Thống kê khi có dữ liệu --}}
@if(isset($results))
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Tổng Page Faults</p>
        <span class="text-2xl font-black text-red-500">{{ $results['total_faults'] }}</span>
    </div>
    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Tổng Page Hits</p>
        <span class="text-2xl font-black text-green-500">{{ $results['total_hits'] }}</span>
    </div>
    <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Tỷ lệ lỗi (Fault Rate)</p>
        <span class="text-2xl font-black text-slate-700">{{ count($results['history']) > 0 ? round(($results['total_faults'] / count($results['history'])) * 100, 2) : 0 }}%</span>
    </div>
</div>
@endif -->