<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>CodeFlow OS Simulator</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    {{-- Tách riêng 2 link Font để trình duyệt không bị lỗi parse --}}
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    {{-- Config Tailwind CSS --}}
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#004ac6", // Electric Blue
                        surface: "#faf8ff",
                        "on-surface": "#191b23",
                        "outline-variant": "#c3c6d7",
                        "surface-container-lowest": "#ffffff",
                    },
                    fontFamily: {
                        // Set Be Vietnam Pro làm font mặc định cho toàn bộ trang
                        sans: ['"Be Vietnam Pro"', 'sans-serif'],
                        "mono-data": ["ui-monospace", "SFMono-Regular", "Menlo", "Monaco", "Consolas"],
                    }
                }
            }
        }
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

{{-- Thêm font-sans và antialiased để chữ mượt và nét hơn --}}

<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen flex">

    {{-- 1. SIDEBAR --}}
    <nav class="fixed left-0 top-0 h-full flex flex-col pt-16 z-40 bg-slate-50/90 backdrop-blur-md text-blue-600 h-screen w-64 border-r border-slate-200 shadow-[4px_0_24px_rgba(0,0,0,0.02)] hidden md:flex transition-all duration-300 ease-in-out">
        <div class="px-6 mb-8">
            {{-- Tiêu đề Sidebar: Đậm, viết hoa, dãn chữ --}}
            <h2 class="text-primary font-black text-2xl uppercase tracking-widest">ALGORITHMS</h2>
            <p class="text-slate-500 font-medium text-xs mt-1 uppercase tracking-wider">Simulation Modules</p>
        </div>

        <ul class="flex flex-col flex-1 mt-2">
            {{-- Nút CPU --}}
            <li>
                <a href="{{ route('cpu') }}" class="flex items-center gap-3 px-6 py-3.5 text-sm font-bold uppercase tracking-wider {{ request()->routeIs('cpu*') ? 'bg-white text-primary border-r-4 border-primary shadow-sm' : 'text-slate-500 hover:bg-slate-200 hover:text-slate-700' }} transition-all w-full text-left">
                    <span class="material-symbols-outlined">speed</span>
                    CPU Scheduling
                </a>
            </li>

            {{-- Nút Deadlock --}}
            <li>
                <a href="{{ route('deadlock') }}" class="flex items-center gap-3 px-6 py-3.5 text-sm font-bold uppercase tracking-wider {{ request()->routeIs('deadlock*') ? 'bg-white text-primary border-r-4 border-primary shadow-sm' : 'text-slate-500 hover:bg-slate-200 hover:text-slate-700' }} transition-all w-full text-left">
                    <span class="material-symbols-outlined">lock_person</span>
                    Deadlock
                </a>
            </li>

            {{-- Nút Page Replacement --}}
            <li>
                <a href="{{ route('page_replacement') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('page_replacement*') ? 'bg-white text-primary border-r-4 border-primary shadow-sm' : 'text-slate-600 hover:bg-slate-200' }} transition-all w-full text-left">
                    <span class="material-symbols-outlined">find_in_page</span>
                    Page Replacement
                </a>
            </li>
        </ul>
        </ul>

        {{-- Linh vật Con Vịt trong khung tròn --}}
        <div class="p-6 mt-auto z-10 relative">
            <div class="w-24 h-25 rounded-full overflow-hidden border-[3px] border-primary shadow-lg bg-white">
                <img src="https://i.pinimg.com/736x/66/27/5a/66275a82fb12a398a14bd5895dfe3859.jpg" alt="Duck Mascot" class="w-full h-full object-cover object-center scale-110">
            </div>
        </div>
    </nav>

    {{-- 2. MAIN CONTENT AREA --}}
    <div class="flex-1 flex flex-col min-h-screen md:ml-64 w-full md:w-[calc(100%-16rem)] relative">

        {{-- Header --}}
        <header class="bg-white/80 backdrop-blur-md text-primary font-medium text-lg tracking-tighter border-b border-slate-200 shadow-sm flex justify-between items-center px-8 py-4 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                {{-- Tiêu đề Header: Dày, đen, ép khoảng cách chữ (tracking-tight) --}}
                <span class="text-2xl font-black tracking-tight text-slate-900">CodeFlow OS Simulator</span>
            </div>
            <div class="flex items-center gap-3">
                <button class="text-slate-500 hover:text-primary hover:bg-slate-100 p-2 rounded-full flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined">help_outline</span>
                </button>
                <button class="text-slate-500 hover:text-primary hover:bg-slate-100 p-2 rounded-full flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined">settings</span>
                </button>
            </div>
        </header>

        {{-- Main Canvas --}}
        <main class="flex-1 p-6 md:p-10 w-full mx-auto max-w-6xl">

            {{-- Mobile Tabs Navigation (Chỉ hiện trên mobile, ẩn trên PC) --}}
            <div class="md:hidden flex overflow-x-auto border-b border-slate-200 mb-6 gap-6 scrollbar-hide">
                {{-- Tab CPU Scheduling --}}
                <a href="{{ route('cpu') }}"
                    class="pb-3 px-1 whitespace-nowrap font-bold uppercase tracking-wider text-sm transition-colors border-b-2 {{ request()->routeIs('cpu*') ? 'text-primary border-primary' : 'text-slate-500 border-transparent hover:text-slate-700' }}">
                    CPU Scheduling
                </a>

                {{-- Tab Deadlock --}}
                <a href="{{ route('deadlock') }}"
                    class="pb-3 px-1 whitespace-nowrap font-bold uppercase tracking-wider text-sm transition-colors border-b-2 {{ request()->routeIs('deadlock*') ? 'text-primary border-primary' : 'text-slate-500 border-transparent hover:text-slate-700' }}">
                    Deadlock
                </a>

                {{-- Tab Page Replacement --}}
                <a href="{{ route('page_replacement') }}"
                    class="pb-3 px-1 whitespace-nowrap font-bold uppercase tracking-wider text-sm transition-colors border-b-2 {{ request()->routeIs('page_replacement*') ? 'text-primary border-primary' : 'text-slate-500 border-transparent hover:text-slate-700' }}">
                    Page Replacement
                </a>
            </div>

            @yield('content')
        </main>
    </div>

</body>

</html>