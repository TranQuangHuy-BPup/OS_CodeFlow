@extends('layouts.app')

@section('content')
    <div class="w-full max-w-6xl mx-auto space-y-8 pb-12">
        {{-- Khối 1: Form nhập liệu và chọn thuật toán --}}
        @include('modules.page_replacement.partials.parameters')

        {{-- Khối 2: Luôn hiển thị khung kết quả --}}
        <div id="page-replacement-results" x-transition>
            @include('modules.page_replacement.' . request('algo', 'fifo'))
        </div>
    </div>
@endsection