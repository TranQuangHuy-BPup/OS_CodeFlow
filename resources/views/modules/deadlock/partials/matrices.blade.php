<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 anim-fade-in" style="animation-delay: 0.4s">
    
    {{-- 1. Ma Trận Allocation (Dùng chung cho mọi thuật toán) --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200 bg-slate-50">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">grid_on</span> Allocation Matrix
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-center text-sm">
                <thead class="bg-slate-50/50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="p-3">PID</th>
                        {{-- SỬ DỤNG HÀM chr() CỦA PHP ĐỂ TẠO CHỮ A, B, C... --}}
                        @if(request('allocation'))
                            @foreach(request('allocation')[0] as $index => $val)
                                <th class="p-3 text-primary">{{ chr(65 + $index) }}</th>
                            @endforeach
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(request('allocation'))
                        @foreach(request('allocation') as $index => $row)
                        <tr class="row-anim border-b border-slate-100 last:border-0 hover:bg-slate-50/50 transition-colors" 
                            style="animation-fill-mode: both; animation-delay: {{ 0.4 + ($loop->iteration * 0.1) }}s">
                            <th class="p-3 bg-slate-50/30 text-slate-600">P{{ $loop->iteration }}</th>
                            @foreach($row as $val)
                                <td class="p-3">{{ $val }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- 2. Ma Trận Max (Banker) HOẶC Request (Detection/Recovery) --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200 bg-slate-50">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                @if($algorithm == 'banker')
                    <span class="material-symbols-outlined text-tertiary">apps</span> Max Matrix
                @else
                    <span class="material-symbols-outlined text-orange-500">pending_actions</span> Request Matrix
                @endif
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-center text-sm">
                <thead class="bg-slate-50/50 border-b border-slate-200 text-slate-500">
                    <tr>
                        <th class="p-3">PID</th>
                        {{-- Xử lý biến dữ liệu và màu sắc --}}
                        @php 
                            $matrixData = ($algorithm == 'banker') ? request('max') : request('request');
                            $textColor = ($algorithm == 'banker') ? 'text-tertiary' : 'text-orange-600';
                        @endphp
                        
                        {{-- Tự động sinh tiêu đề A, B, C, D... tùy số lượng cột --}}
                        @if($matrixData)
                            @foreach($matrixData[0] as $index => $val)
                                <th class="p-3 {{ $textColor }}">{{ chr(65 + $index) }}</th>
                            @endforeach
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($matrixData)
                        @foreach($matrixData as $index => $row)
                        <tr class="row-anim border-b border-slate-100 last:border-0 hover:bg-slate-50/50 transition-colors" 
                            style="animation-fill-mode: both; animation-delay: {{ 0.4 + ($loop->iteration * 0.1) }}s">
                            <th class="p-3 bg-slate-50/30 text-slate-600">P{{ $loop->iteration }}</th>
                            @foreach($row as $val)
                                <td class="p-3 font-medium {{ $textColor }}">{{ $val }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>