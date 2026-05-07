@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Page Replacement</h1>
        <p class="text-slate-500 mt-2">Mô phỏng các thuật toán thay thế trang trong quản lý bộ nhớ RAM</p>
    </div>

    {{-- Menu chọn thuật toán --}}
    <div class="flex space-x-2 bg-slate-200/50 p-1 rounded-xl w-fit mb-8">
        <a href="{{ route('page-replacement.algorithm', ['algorithm' => 'fifo']) }}" 
           class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all {{ $algorithm == 'fifo' ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            FIFO
        </a>
        <a href="{{ route('page-replacement.algorithm', ['algorithm' => 'opt']) }}" 
           class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all {{ $algorithm == 'opt' ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            OPT (Optimal)
        </a>
        <a href="{{ route('page-replacement.algorithm', ['algorithm' => 'lru']) }}" 
           class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all {{ $algorithm == 'lru' ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            LRU
        </a>
    </div>

    {{-- Form nhập liệu --}}
    @include('modules.page_replacement.partials.parameters', ['algorithm' => $algorithm])

    {{-- Kết quả mô phỏng --}}
    @if(isset($results))
        <div class="mt-8">
            {{-- Đã sửa ở đây --}}
            @include('modules.page_replacement.partials.visualization_table')
        </div>
    @endif

</div>
@endsection