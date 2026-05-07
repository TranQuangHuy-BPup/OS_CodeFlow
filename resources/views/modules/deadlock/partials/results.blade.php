<div class="anim-fade-in" style="animation-delay: 0.3s">
    @if($algorithm == 'detection')
        {{-- Gọi file giao diện hiển thị kết quả Phát hiện Deadlock --}}
        @include('modules.deadlock.detection')
    @elseif($algorithm == 'banker')
        {{-- Sau này bạn làm thuật toán Banker thì include ở đây --}}
        @include('modules.deadlock.bankers')
    @elseif($algorithm == 'recovery')
        @include('modules.deadlock.recovery')
    @endif
</div>