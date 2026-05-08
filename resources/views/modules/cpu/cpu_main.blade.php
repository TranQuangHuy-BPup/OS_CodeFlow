@extends('layouts.app')

@section('content')
    <div
        class="space-y-8 pb-12"
        x-data="cpuSimForm({
            algorithm: @js($algorithm ?? 'fcfs'),
            processesJson: @js($processesJson ?? '[]'),
            quantum: @js($quantum ?? 2),
        })"
    >
        <form method="POST" action="{{ route('cpu.simulate', ['algorithm' => $algorithm ?? 'fcfs']) }}" class="space-y-8">
            @csrf

            <input type="hidden" name="processes_json" :value="JSON.stringify(processes)">
            <input type="hidden" name="quantum" :value="quantum">

            {{-- Khối 1: Cấu hình thuật toán --}}
            @include('modules.cpu.partials.parameters')

            {{-- Khối 2: Bảng nhập liệu đầy đủ (UX: Nhập xong mới chạy) --}}
            @include('modules.cpu.partials.ready_queue')
        </form>

        {{-- Khối 3: Minh họa Gantt Chart (UX: Trực quan hóa tiến trình) --}}
        @include('modules.cpu.partials.gantt_chart')

        {{-- Khối 4: Bảng kết quả 8 cột thống nhất (UX: Đối chiếu thông số) --}}
        <div id="algorithm-results" x-transition>
            @if(isset($algorithm))
                @include('modules.cpu.' . $algorithm)
            @endif
        </div>
    </div>

    <script>
        function cpuSimForm({ algorithm, processesJson, quantum }) {
            let parsed = [];
            try {
                parsed = JSON.parse(processesJson || '[]') || [];
            } catch (e) {
                parsed = [];
            }

            const normalizeProcess = (p, index) => ({
                pid: String(p?.pid ?? `P${index + 1}`),
                arrival: Math.max(0, Number.isFinite(Number(p?.arrival)) ? Number(p.arrival) : 0),
                burst: Math.max(0, Number.isFinite(Number(p?.burst)) ? Number(p.burst) : 0),
                priority: Math.max(0, Number.isFinite(Number(p?.priority)) ? Number(p.priority) : 0),
            });

            const initial = Array.isArray(parsed) ? parsed.map(normalizeProcess) : [];

            return {
                algo: algorithm,
                quantum: Number.isFinite(Number(quantum)) ? Number(quantum) : 2,
                processes: initial.length ? initial : [normalizeProcess({}, 0)],

                addProcess() {
                    this.processes.push(
                        normalizeProcess({ pid: `P${this.processes.length + 1}` }, this.processes.length)
                    );
                },

                removeProcess(index) {
                    this.processes.splice(index, 1);
                    if (this.processes.length === 0) this.addProcess();
                },
            };
        }
    </script>
@endsection