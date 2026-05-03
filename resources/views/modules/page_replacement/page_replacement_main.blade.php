@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        {{-- Gọi bảng cấu hình --}}
        @include('modules.page_replacement.partials.parameters')

        {{-- Gọi bảng trực quan hóa bộ nhớ --}}
        @include('modules.page_replacement.partials.visualization')
    </div>
@endsection