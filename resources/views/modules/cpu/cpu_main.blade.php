@extends('layouts.app')

@section('content')
    <div class="space-y-8 pb-12">
        {{-- Khối 1: Cấu hình thuật toán --}}
        @include('modules.cpu.partials.parameters')

        {{-- Khối 2: Bảng nhập liệu đầy đủ (UX: Nhập xong mới chạy) --}}
        @include('modules.cpu.partials.ready_queue')

        {{-- Khối 3: Minh họa Gantt Chart (UX: Trực quan hóa tiến trình) --}}
        @include('modules.cpu.partials.gantt_chart')

        {{-- Khối 4: Bảng kết quả 8 cột thống nhất --}}
        <div id="algorithm-results" x-transition>
            {{-- ĐỔI THÀNH $algo Ở 2 DÒNG DƯỚI ĐÂY --}}
            @if(isset($algo))
                @include('modules.cpu.' . $algo)
            @endif
        </div>
    </div>
@endsection