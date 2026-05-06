<div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.06)] mb-8">
    {{-- FORM GỬI DATA LÊN CONTROLLER --}}
    <form action="{{ route('deadlock.simulate', ['algorithm' => $algorithm]) }}" method="POST">
    @csrf
    
    <button type="submit">Chạy mô phỏng {{ strtoupper($algorithm) }}</button>
</form>
</div>