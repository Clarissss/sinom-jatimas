<aside
    class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-primary-800 to-primary-900 text-white z-40 flex flex-col shadow-2xl"
    x-data="{ showNavReminder: false, targetUrl: '' }">
    
    <div class="flex-1 overflow-y-auto">
        {{-- Logo --}}
        <div class="p-8 text-center">
            <a href="{{ route('client.dashboard') }}" class="flex flex-col items-center group">
                <div
                    class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-xl mb-4 transition-transform group-hover:scale-105">
                    <i class="fa-solid fa-building text-primary-600 text-2xl"></i>
                </div>
                <div class="space-y-1">
                    <h2 class="text-sm font-black tracking-[0.2em] uppercase">
                        SINOM JATI MAS
                    </h2>
                    <p class="text-[10px] font-medium text-primary-300 uppercase tracking-widest">
                        User Portal
                    </p>
                </div>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="px-6 space-y-2">

            @php
                $navItems = [
                    ['route' => 'client.dashboard', 'icon' => 'fa-th-large', 'label' => 'Dashboard'],
                    ['route' => 'chat.general', 'icon' => 'fa-comments', 'label' => 'Chat Support'],
                    ['route' => 'client.documents.index', 'icon' => 'fa-file-lines', 'label' => 'Dokumen'],
                    ['route' => 'client.invoices.index', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Invoice'],
                    [
                        'route' => 'client.daily-reports.index',
                        'icon' => 'fa-clipboard-list',
                        'label' => 'Laporan Harian',
                        'trigger_modal' => true // Penanda khusus untuk memicu modal pengingat
                    ],
                ];
            @endphp

            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   {{-- Logika Intersepsi Klik Khusus Menu Laporan Harian --}}
                   @if(isset($item['trigger_modal']) && $item['trigger_modal'])
                       @click.prevent="targetUrl = '{{ route($item['route']) }}'; showNavReminder = true"
                   @endif
                    class="flex items-center space-x-4 px-4 py-3.5 rounded-2xl transition-all duration-300 group
               {{ request()->routeIs($item['route'] . '*') ? 'bg-white/10 text-white border border-white/10' : 'text-primary-100 hover:bg-white/5' }}">

                    <i class="fa-solid {{ $item['icon'] }} w-5 text-center text-sm
                {{ request()->routeIs($item['route'] . '*') ? 'text-white' : 'text-primary-400 group-hover:text-white' }}"></i>

                    <span class="text-sm font-semibold tracking-wide">
                        {{ $item['label'] }}
                    </span>
                </a>
            @endforeach
        </nav>
    </div>

    {{-- Bottom User --}}
    <div class="p-6 bg-primary-900/50 backdrop-blur-md border-t border-white/5">
        <div
            class="bg-white/5 rounded-[2rem] p-3 border border-white/10 shadow-inner flex items-center justify-between group transition-all hover:bg-white/10">
            <div class="flex items-center space-x-3 overflow-hidden">
                <div class="relative flex-shrink-0">
                    <div
                        class="w-11 h-11 rounded-2xl bg-[#DD3517] flex items-center justify-center text-lg font-bold text-white shadow-lg border border-white/20">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div
                        class="absolute -bottom-1 -right-1 w-4 h-4 bg-[#4ADE80] border-[3px] border-primary-900 rounded-full">
                    </div>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-white truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-[10px] text-primary-300 truncate font-medium uppercase tracking-tighter">
                        USER
                    </p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}"
                class="p-2 rounded-2xl bg-white/5 text-primary-300 hover:text-white hover:bg-white/20 transition-all">
                <i class="fa-solid fa-gear text-xs transition-transform group-hover:rotate-90 duration-500"></i>
            </a>
        </div>
    </div>

    {{-- POPUP MODAL REMINDER (Terpicu setiap klik menu Laporan Harian) --}}
    <div x-show="showNavReminder" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         style="display: none;">
        
        <div class="bg-white rounded-[2.5rem] w-full max-w-md p-8 shadow-2xl border border-gray-100 text-center" @click.away="showNavReminder = false">
            <div class="w-16 h-16 bg-orange-50 text-[#DD3517] rounded-2xl flex items-center justify-center mx-auto mb-5 border border-orange-100 shadow-sm">
                <i class="fa-solid fa-bell fa-bounce text-xl"></i>
            </div>
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter mb-2">Konfirmasi Laporan</h3>
            <p class="text-xs text-gray-500 font-medium leading-relaxed mb-6 px-2">
                Yth. Klien, sebelum memeriksa daftar, pastikan Anda melakukan konfirmasi <span class="text-[#DD3517] font-bold">"Terima Laporan"</span> pada berkas hari-hari sebelumnya demi mendukung kelancaran progress pengerjaan proyek.
            </p>
            <div class="flex flex-col space-y-2">
                <a :href="targetUrl" class="w-full bg-gray-900 text-white p-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#DD3517] transition-all text-center shadow-md">
                    Saya Mengerti & Lanjutkan
                </a>
                <button type="button" @click="showNavReminder = false" class="w-full bg-gray-100 text-gray-500 p-3 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">
                    Kembali
                </button>
            </div>
        </div>
    </div>
</aside>