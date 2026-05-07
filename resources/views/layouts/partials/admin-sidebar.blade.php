<aside class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-primary-800 to-primary-900 text-white z-40 flex flex-col shadow-2xl" aria-label="Admin sidebar">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="flex-1 overflow-y-auto">
        {{-- Logo Section --}}
        <div class="p-8 text-center">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center group">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-xl mb-4 transition-transform group-hover:scale-105">
                    <i class="fa-solid fa-building text-primary-600 text-2xl"></i>
                </div>
                <div class="space-y-1">
                    <h2 class="text-sm font-black tracking-[0.2em] uppercase">SINOM JATI MAS</h2>
                    <p class="text-[10px] font-medium text-primary-300 uppercase tracking-widest">Admin Portal</p>
                </div>
            </a>
        </div>
        
        {{-- Navigation --}}
        <nav class="px-6 space-y-2">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard', 'icon' => 'fa-th-large', 'label' => 'Dashboard'],
                    ['route' => 'admin.projects.index', 'icon' => 'fa-building-user', 'label' => 'Proyek'],
                    ['route' => 'admin.daily-reports.index', 'icon' => 'fa-clipboard-list', 'label' => 'Laporan Harian'],
                    ['route' => 'admin.documents.index', 'icon' => 'fa-file-lines', 'label' => 'Dokumen'],
                    ['route' => 'admin.invoices.index', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Invoice'],
                    ['route' => 'admin.users.index', 'icon' => 'fa-users', 'label' => 'Data Klien'],
                    
                    // PENAMBAHAN MENU LAYANAN & COMPRO
                    ['route' => 'admin.services.index', 'icon' => 'fa-screwdriver-wrench', 'label' => 'Layanan'],
                    ['route' => 'admin.company-profile.index', 'icon' => 'fa-id-card', 'label' => 'Profil Perusahaan'],
                    
                    ['route' => 'admin.activity-logs.index', 'icon' => 'fa-clock-rotate-left', 'label' => 'Activity Log'],
                ];
            @endphp

            @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}" 
               class="flex items-center space-x-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group
               {{ request()->routeIs($item['route'] . '*') ? 'bg-white/10 text-white border border-white/10' : 'text-primary-100 hover:bg-white/5' }}">
                <i class="fa-solid {{ $item['icon'] }} w-5 text-center text-sm {{ request()->routeIs($item['route'] . '*') ? 'text-white' : 'text-primary-400 group-hover:text-white' }}"></i>
                <span class="text-sm font-semibold tracking-wide">{{ $item['label'] }}</span>
            </a>
            @endforeach
        </nav>
    </div>

    {{-- Bagian Bawah: User Profile --}}
    <div class="p-6 bg-primary-900/50 backdrop-blur-md border-t border-white/5">
        <div class="bg-white/5 rounded-[2rem] p-3 border border-white/10 shadow-inner flex items-center justify-between group transition-all hover:bg-white/10">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="relative flex-shrink-0">
                    <div class="w-11 h-11 rounded-2xl bg-[#DD3517] flex items-center justify-center text-lg font-bold text-white shadow-lg border border-white/20">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-[#4ADE80] border-[3px] border-primary-900 rounded-full"></div>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-primary-300 truncate font-medium uppercase tracking-tighter">{{ auth()->user()->role }}</p>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="p-2 rounded-2xl bg-white/5 text-primary-300 hover:text-white hover:bg-white/20 transition-all">
                <i class="fa-solid fa-gear text-xs transition-transform group-hover:rotate-90 duration-500"></i>
            </a>
        </div>
    </div>
</aside>