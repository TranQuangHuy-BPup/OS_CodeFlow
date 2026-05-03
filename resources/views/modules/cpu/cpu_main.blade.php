@extends('layouts.app')

@section('content')
    <div class="space-y-8 pb-12">
        {{-- Khối 1: Cấu hình thuật toán --}}
        @include('modules.cpu.partials.parameters')

        {{-- Khối 2: Bảng nhập liệu đầy đủ (UX: Nhập xong mới chạy) --}}
        @include('modules.cpu.partials.ready_queue')

        {{-- Khối 3: Minh họa Gantt Chart (UX: Trực quan hóa tiến trình) --}}
        @include('modules.cpu.partials.gantt_chart')

        {{-- Khối 4: Bảng kết quả 8 cột thống nhất (UX: Đối chiếu thông số) --}}
        <div id="algorithm-results" x-transition>
            @if(isset($algorithm))
                @include('modules.cpu.' . $algorithm)
            @endif
        </div>
    </div>
@endsection