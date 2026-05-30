<div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.06)] mb-8 transition-all duration-500 hover:shadow-lg anim-fade-in">
    <form action="{{ route('deadlock.simulate', ['algorithm' => 'banker']) }}" method="POST" id="deadlock-form">
        @csrf
        
        {{-- 1. NHẬP VECTOR AVAILABLE (Tài nguyên sẵn có) --}}
        <div class="mb-8 relative">
            <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4 flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">inventory_2</span>
                    Available Resources (Số tài nguyên sẵn có)
                </span>
                <div class="flex gap-2">
                    <button type="button" id="btn-remove-resource" class="hidden text-xs font-bold text-red-500 hover:text-red-700 flex items-center gap-1 transition-all active:scale-95 bg-red-50 px-3 py-1.5 rounded-lg">
                        <span class="material-symbols-outlined text-sm">remove</span> Bớt Tài Nguyên
                    </button>
                    <button type="button" id="btn-add-resource" class="text-xs font-bold text-primary hover:text-primary-dark flex items-center gap-1 transition-all active:scale-95 bg-primary/10 px-3 py-1.5 rounded-lg">
                        <span class="material-symbols-outlined text-sm">add</span> Thêm Tài Nguyên
                    </button>
                </div>
            </h4>
            <div id="available-container" class="flex flex-wrap gap-4 bg-slate-50 p-5 rounded-xl border border-slate-100">
                @foreach(['A', 'B', 'C'] as $res)
                <div class="flex flex-col items-center gap-1 group anim-pop-in">
                    <span class="text-[11px] font-black text-primary group-hover:scale-110 transition-all resource-label">{{ $res }}</span>
                    <input type="number" name="available[]" value="0" min="0" 
                           class="w-14 h-10 text-center rounded-lg border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-mono font-medium">
                </div>
                @endforeach
            </div>
        </div>

        {{-- 2. NHẬP MA TRẬN (DẠNG CARD LAYOUT TỐI ƯU UX) --}}
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4 border-b border-slate-100 pb-4">
                <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">view_agenda</span>
                    Process Matrix
                </h4>
                <button type="button" id="btn-add-process" 
                        class="text-sm font-bold text-white bg-slate-800 hover:bg-slate-700 px-4 py-2 rounded-lg flex items-center gap-2 transition-all active:scale-95 shadow-md">
                    <span class="material-symbols-outlined text-sm">add_circle</span> Thêm tiến trình
                </button>
            </div>

            {{-- Chứa các Card Tiến trình --}}
            <div id="process-list" class="space-y-4">
                {{-- Card P1 Mặc định --}}
                <div class="process-card bg-white border border-slate-200 rounded-xl p-5 shadow-sm relative row-anim hover:border-primary/30 transition-colors">
                    <div class="absolute top-4 right-4">
                        <button type="button" class="text-slate-300 hover:text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-all" onclick="removeRow(this)">
                            <span class="material-symbols-outlined text-xl">delete</span>
                        </button>
                    </div>
                    
                    <h5 class="font-black text-lg text-slate-700 mb-4 flex items-center gap-2">
                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-lg">P1</span>
                    </h5>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Cột Allocation --}}
                        <div class="bg-slate-50/50 p-4 rounded-lg border border-slate-100">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 block">Allocation Matrix</span>
                            <div class="flex flex-wrap gap-3 allocation-inputs">
                                @foreach(['A', 'B', 'C'] as $res)
                                <div class="flex flex-col items-center gap-1 group">
                                    <span class="text-[10px] font-bold text-slate-400 resource-label">{{ $res }}</span>
                                    <input type="number" name="allocation[0][]" value="0" min="0" class="w-14 h-9 text-center rounded-lg border-slate-200 text-sm focus:ring-primary focus:border-primary font-mono shadow-sm">
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Cột Max --}}
                        <div class="bg-slate-50/50 p-4 rounded-lg border border-slate-100">
                            <span class="text-xs font-bold uppercase tracking-wider mb-3 block text-tertiary">
                                Max Matrix
                            </span>
                            <div class="flex flex-wrap gap-3 max-inputs">
                                @foreach(['A', 'B', 'C'] as $res)
                                <div class="flex flex-col items-center gap-1 group">
                                    <span class="text-[10px] font-bold text-slate-400 resource-label">{{ $res }}</span>
                                    <input type="number" name="max[0][]" value="0" min="0" class="w-14 h-9 text-center rounded-lg border-slate-200 text-sm font-bold font-mono shadow-sm text-tertiary focus:ring-tertiary focus:border-tertiary">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- NÚT ĐIỀU KHIỂN --}}
        <div class="flex justify-end pt-6 border-t border-slate-100 mt-8">
            <button type="submit" class="btn-simulate bg-primary text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 transition-all flex items-center gap-3 text-lg">
                <span class="material-symbols-outlined btn-icon text-2xl">analytics</span>
                <span>Chạy mô phỏng BANKER</span>
            </button>
        </div>
    </form>
</div>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .anim-fade-in { animation: fadeIn 0.5s ease forwards; }
    
    @keyframes slideRow { from { opacity: 0; transform: translateY(-10px) scale(0.98); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .row-anim { animation: slideRow 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    
    @keyframes popIn { 0% { transform: scale(0.5); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    .anim-pop-in { animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
    
    .btn-simulate:hover .btn-icon { transform: rotate(180deg); transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
</style>

<script>
    let resourceCount = 3;

    function updateRemoveButton() {
        const btnRemove = document.getElementById('btn-remove-resource');
        if(resourceCount > 3) btnRemove.classList.remove('hidden');
        else btnRemove.classList.add('hidden');
    }

    // THÊM TÀI NGUYÊN (CỘT)
    document.getElementById('btn-add-resource').addEventListener('click', function() {
        if (resourceCount >= 10) { alert('Tối đa 10 loại tài nguyên thôi nhé!'); return; }
        
        resourceCount++;
        const resName = String.fromCharCode(64 + resourceCount); // 65 là A
        
        // 1. Thêm vào Available
        const availContainer = document.getElementById('available-container');
        availContainer.insertAdjacentHTML('beforeend', `
            <div class="flex flex-col items-center gap-1 group anim-pop-in">
                <span class="text-[11px] font-black text-primary group-hover:scale-110 transition-all resource-label">${resName}</span>
                <input type="number" name="available[]" value="0" min="0" class="w-14 h-10 text-center rounded-lg border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-mono font-medium">
            </div>
        `);

        // 2. Thêm input vào mỗi khối Allocation và Max của từng Process
        document.querySelectorAll('.process-card').forEach((card) => {
            const firstInput = card.querySelector('.allocation-inputs input');
            const match = firstInput.name.match(/\[(\d+)\]/);
            const rowIndex = match ? match[1] : Date.now();

            const allocDiv = card.querySelector('.allocation-inputs');
            allocDiv.insertAdjacentHTML('beforeend', `
                <div class="flex flex-col items-center gap-1 group anim-pop-in">
                    <span class="text-[10px] font-bold text-slate-400 resource-label">${resName}</span>
                    <input type="number" name="allocation[${rowIndex}][]" value="0" min="0" class="w-14 h-9 text-center rounded-lg border-slate-200 text-sm focus:ring-primary focus:border-primary font-mono shadow-sm">
                </div>
            `);

            const maxDiv = card.querySelector('.max-inputs');
            maxDiv.insertAdjacentHTML('beforeend', `
                <div class="flex flex-col items-center gap-1 group anim-pop-in">
                    <span class="text-[10px] font-bold text-slate-400 resource-label">${resName}</span>
                    <input type="number" name="max[${rowIndex}][]" value="0" min="0" class="w-14 h-9 text-center rounded-lg border-slate-200 text-sm font-bold font-mono shadow-sm text-tertiary focus:ring-tertiary focus:border-tertiary anim-pop-in">
                </div>
            `);
        });

        updateRemoveButton();
    });

    // BỚT TÀI NGUYÊN
    document.getElementById('btn-remove-resource').addEventListener('click', function() {
        if (resourceCount <= 3) return;
        
        document.getElementById('available-container').lastElementChild.remove();
        
        document.querySelectorAll('.process-card').forEach((card) => {
            card.querySelector('.allocation-inputs').lastElementChild.remove();
            card.querySelector('.max-inputs').lastElementChild.remove();
        });

        resourceCount--;
        updateRemoveButton();
    });

    // THÊM TIẾN TRÌNH (CARD MỚI)
    document.getElementById('btn-add-process').addEventListener('click', function() {
        const processList = document.getElementById('process-list');
        const cards = processList.querySelectorAll('.process-card');
        
        let maxPid = 0;
        cards.forEach(card => {
            const pidNum = parseInt(card.querySelector('h5 span').innerText.replace('P', ''));
            if (pidNum > maxPid) maxPid = pidNum;
        });
        const nextId = maxPid + 1;
        const index = Date.now();

        let allocInputs = '';
        let maxInputsHtml = '';
        for(let i=0; i<resourceCount; i++) {
            const resName = String.fromCharCode(65 + i);
            allocInputs += `
                <div class="flex flex-col items-center gap-1 group">
                    <span class="text-[10px] font-bold text-slate-400 resource-label">${resName}</span>
                    <input type="number" name="allocation[${index}][]" value="0" min="0" class="w-14 h-9 text-center rounded-lg border-slate-200 text-sm focus:ring-primary focus:border-primary font-mono shadow-sm">
                </div>`;
            maxInputsHtml += `
                <div class="flex flex-col items-center gap-1 group">
                    <span class="text-[10px] font-bold text-slate-400 resource-label">${resName}</span>
                    <input type="number" name="max[${index}][]" value="0" min="0" class="w-14 h-9 text-center rounded-lg border-slate-200 text-sm font-bold font-mono shadow-sm text-tertiary focus:ring-tertiary focus:border-tertiary">
                </div>`;
        }

        const newCard = document.createElement('div');
        newCard.className = "process-card bg-white border border-slate-200 rounded-xl p-5 shadow-sm relative row-anim hover:border-primary/30 transition-colors";
        newCard.innerHTML = `
            <div class="absolute top-4 right-4">
                <button type="button" class="text-slate-300 hover:text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-all" onclick="removeRow(this)">
                    <span class="material-symbols-outlined text-xl">delete</span>
                </button>
            </div>
            <h5 class="font-black text-lg text-slate-700 mb-4 flex items-center gap-2">
                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-lg">P${nextId}</span>
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50/50 p-4 rounded-lg border border-slate-100">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 block">Allocation Matrix</span>
                    <div class="flex flex-wrap gap-3 allocation-inputs">${allocInputs}</div>
                </div>
                <div class="bg-slate-50/50 p-4 rounded-lg border border-slate-100">
                    <span class="text-xs font-bold uppercase tracking-wider mb-3 block text-tertiary">Max Matrix</span>
                    <div class="flex flex-wrap gap-3 max-inputs">${maxInputsHtml}</div>
                </div>
            </div>
        `;
        processList.appendChild(newCard);
    });

    function removeRow(btn) {
        const card = btn.closest('.process-card');
        card.style.opacity = '0';
        card.style.transform = 'scale(0.95)';
        card.style.transition = 'all 0.3s ease';
        setTimeout(() => card.remove(), 300);
    }
</script>