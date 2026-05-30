@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    {{-- 1. TIÊU ĐỀ BÀI TOÁN --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Deadlock Analysis</h1>
        <p class="text-slate-500 mt-2">Mô phỏng chiến lược xử lý bế tắc tài nguyên trong Hệ điều hành</p>
    </div>

    {{-- 2. THANH MENU ĐIỀU HƯỚNG CỦA RIÊNG DEADLOCK --}}
    <div class="flex space-x-2 bg-slate-200/50 p-1 rounded-xl w-fit mb-8">
        <a href="{{ route('deadlock.algorithm', ['algorithm' => 'banker']) }}" 
           class="px-6 py-2.5 rounded-lg text-sm font-bold transition-all {{ $algorithm == 'banker' ? 'bg-white text-primary shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
            Banker's Algorithm
        </a>
    </div>

    {{-- 3. GỌI FORM NHẬP LIỆU (parameters.blade.php) --}}
    {{-- Truyền biến $algorithm vào partial để form action biết đường mà gửi data đi --}}
    @include('modules.deadlock.partials.parameters', ['algorithm' => $algorithm])

    {{-- 4. GỌI BẢNG MA TRẬN & KẾT QUẢ (Chỉ hiện khi có data trả về từ Controller) --}}
    @if(isset($results) && !empty($results))
        <div class="mt-8">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Kết quả phân tích:</h2>
            
            {{-- Chỗ này gọi file của Hòa làm (Render Ma trận) --}}
            @include('modules.deadlock.partials.matrices')

            {{-- Chỗ này gọi file hiển thị thông báo Safe/Unsafe hoặc Deadlocked --}}
            @include('modules.deadlock.partials.results')
        </div>
    @endif

</div>
@endsection