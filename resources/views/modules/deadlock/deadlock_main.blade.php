@extends('layouts.app')

@section('content')
    {{-- Khai báo biến algoTab ở cấp cao nhất để quản lý các tab. Mặc định là thuật toán được chọn hoặc bankers --}}
    <div class="space-y-8 pb-12" x-data="{ algoTab: '{{ $algo ?? 'bankers' }}' }">
        
        {{-- Khối 1: Cấu hình hệ thống (Dropdown chọn thuật toán) --}}
        @include('modules.deadlock.partials.parameters')

        {{-- Khối 2: Phân luồng hiển thị MƯỢT MÀ bằng x-show --}}
        <div id="algorithm-content">
            
            {{-- Giao diện Banker (Chỉ hiện khi algoTab == 'bankers') --}}
            <div x-show="algoTab === 'bankers'" x-transition>
                @include('modules.deadlock.bankers')
            </div>

            {{-- Giao diện Detection (Chỉ hiện khi algoTab == 'detection') --}}
            <div x-show="algoTab === 'detection'" x-transition style="display: none;">
                @include('modules.deadlock.detection')
            </div>

            {{-- Giao diện Recovery (Chỉ hiện khi algoTab == 'recovery') --}}
            <div x-show="algoTab === 'recovery'" x-transition style="display: none;">
                @include('modules.deadlock.recovery')
            </div>

        </div>
    </div>
@endsection