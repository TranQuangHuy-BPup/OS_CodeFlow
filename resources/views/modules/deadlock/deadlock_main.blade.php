@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        {{-- 1. Cấu hình số Tiến trình & Tài nguyên --}}
        @include('modules.deadlock.partials.parameters')

        {{-- 2. Khu vực hiển thị các Ma trận (Allocation, Max, Need) --}}
        <div id="matrices-container">
            @include('modules.deadlock.partials.matrices')
        </div>

        {{-- 3. Kết quả chuỗi an toàn & Log hệ thống --}}
        <div id="deadlock-results">
            @include('modules.deadlock.partials.results')
        </div>
    </div>
@endsection