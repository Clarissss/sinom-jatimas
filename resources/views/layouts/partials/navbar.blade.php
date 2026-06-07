<nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Page Title --}}
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-800 tracking-tight">
                    @yield('page-title', 'Dashboard')
                </h1>
            </div>

            {{-- Navbar Sebelah Kanan --}}
            <div class="flex items-center space-x-4">
                @auth
                    {{-- Chat Notification --}}
                    <div class="relative" x-data="{ openChat: false }">
                        <button @click="openChat = !openChat"
                            class="relative w-11 h-11 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-500 hover:text-[#DD3517] hover:border-[#DD3517]/20 hover:bg-orange-50 transition-all duration-300">
                            <i class="fa-solid fa-comments text-lg"></i>
                            <span id="nav-chat-badge"
                                class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1 rounded-full bg-red-500 text-white text-[10px] font-black flex items-center justify-center border-2 border-white {{ $unreadCount > 0 ? '' : 'hidden' }}">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        </button>

                        {{-- Dropdown Chat --}}
                        <div x-show="openChat" @click.away="openChat = false" x-transition
                            class="absolute right-0 mt-3 w-96 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden z-50"
                            style="display: none;">

                            {{-- Header Chat --}}
                            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-black uppercase tracking-widest text-gray-900">
                                            Chat Notifications
                                        </h3>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] mt-1">
                                            Pesan belum dibaca
                                        </p>
                                    </div>
                                    <div
                                        class="w-9 h-9 rounded-2xl bg-orange-50 text-[#DD3517] flex items-center justify-center">
                                        <i class="fa-solid fa-comments"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Content Chat --}}
                            <div id="nav-chat-dropdown" class="max-h-[420px] overflow-y-auto">
                                {{-- General Chat Notifications --}}
                                @foreach($unreadConversations as $conversationId => $messages)
                                    @php
                                        $message = $messages->first();
                                        $conversation = $message->conversation;
                                    @endphp
                                    <a href="{{ auth()->user()->isAdmin() ? route('admin.conversations.show', $conversation) : route('chat.general') }}"
                                        class="flex items-start gap-4 px-6 py-5 hover:bg-gray-50 transition-all border-b border-gray-50">
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-blue-500 text-white flex items-center justify-center font-black text-sm flex-shrink-0">
                                            <i class="fa-solid fa-headset"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-3">
                                                <h4 class="text-sm font-black text-gray-900 truncate uppercase">
                                                    Chat Support
                                                </h4>
                                                <span class="text-[10px] text-gray-400 font-bold whitespace-nowrap">
                                                    {{ $message->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 truncate">
                                                {{ $message->sender->name }}:
                                                {{ $message->message ?? 'Mengirim file' }}
                                            </p>
                                            <div class="mt-3 flex items-center justify-between">
                                                <span
                                                    class="text-[10px] uppercase tracking-widest text-gray-400 font-black">
                                                    {{ $messages->count() }} pesan baru
                                                </span>
                                                <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                                {{-- Project Chat Notifications --}}
                                @foreach($unreadChats as $projectId => $messages)
                                    @php
                                        $message = $messages->first();
                                        $project = $message->project;
                                    @endphp
                                    <a href="{{ route('chat.index', $project) }}"
                                        class="flex items-start gap-4 px-6 py-5 hover:bg-gray-50 transition-all border-b border-gray-50">
                                        <div
                                            class="w-12 h-12 rounded-2xl bg-[#DD3517] text-white flex items-center justify-center font-black text-sm flex-shrink-0">
                                            {{ strtoupper(substr($project->name, 0, 2)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-3">
                                                <h4 class="text-sm font-black text-gray-900 truncate uppercase">
                                                    {{ $project->name }}
                                                </h4>
                                                <span class="text-[10px] text-gray-400 font-bold whitespace-nowrap">
                                                    {{ $message->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 truncate">
                                                {{ $message->sender->name }}:
                                                {{ $message->message ?? 'Mengirim file' }}
                                            </p>
                                            <div class="mt-3 flex items-center justify-between">
                                                <span
                                                    class="text-[10px] uppercase tracking-widest text-gray-400 font-black">
                                                    {{ $messages->count() }} pesan baru
                                                </span>
                                                <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                                @if($unreadConversations->isEmpty() && $unreadChats->isEmpty())
                                    <div id="nav-chat-empty" class="p-12 text-center">
                                        <div
                                            class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-5">
                                            <i class="fa-solid fa-comments text-3xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">
                                            Tidak Ada Pesan
                                        </h3>
                                        <p class="text-xs text-gray-400 uppercase tracking-widest mt-2">
                                            Semua chat sudah dibaca
                                        </p>
                                    </div>
                                @else
                                    <div id="nav-chat-empty" class="p-12 text-center hidden">
                                        <div
                                            class="w-20 h-20 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-5">
                                            <i class="fa-solid fa-comments text-3xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">
                                            Tidak Ada Pesan
                                        </h3>
                                        <p class="text-xs text-gray-400 uppercase tracking-widest mt-2">
                                            Semua chat sudah dibaca
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- User Menu --}}
                    <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                        <button @click="open = !open"
                            class="flex items-center space-x-3 focus:outline-none rounded-lg p-2 hover:bg-gray-100 transition-colors"
                            aria-expanded="false" aria-haspopup="true" :aria-expanded="open.toString()">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-primary-200 shadow-md"
                                aria-hidden="true">
                                <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <i class="fa-solid fa-chevron-down text-gray-400 text-sm transition-transform"
                                :class="{ 'rotate-180': open }"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-100"
                            style="display: none;" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                            {{-- User Info Header --}}
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full overflow-hidden border border-gray-200">
                                        <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->name }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Menu Items --}}
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary-600 transition-colors"
                                role="menuitem">
                                <i class="fa-regular fa-user w-4 mr-3 text-gray-400"></i>
                                Profil
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <button onclick="document.getElementById('logout-form').submit()"
                                class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                role="menuitem">
                                <i class="fa-solid fa-arrow-right-from-bracket w-4 mr-3"></i>
                                Keluar
                            </button>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    @auth
    <script>
    (function() {
        const badge = document.getElementById('nav-chat-badge');
        const dropdown = document.getElementById('nav-chat-dropdown');
        const emptyState = document.getElementById('nav-chat-empty');
        const chatBtn = badge?.closest('button');
        let lastCount = parseInt(badge?.textContent) || 0;

        function updateBadge(count) {
            if (!badge) return;
            lastCount = count;
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
                badge.textContent = '0';
            }
        }

        function renderItem(item, isProject) {
            const iconBg = isProject ? 'bg-[#DD3517]' : 'bg-blue-500';
            const iconContent = isProject
                ? (item.project_name || 'Chat Proyek').substring(0, 2).toUpperCase()
                : '<i class="fa-solid fa-headset"></i>';
            const title = isProject ? (item.project_name || 'Chat Proyek') : 'Chat Support';
            return `
                <a href="${item.url}" class="flex items-start gap-4 px-6 py-5 hover:bg-gray-50 transition-all border-b border-gray-50 animate-fade-in">
                    <div class="w-12 h-12 rounded-2xl ${iconBg} text-white flex items-center justify-center font-black text-sm flex-shrink-0">
                        ${iconContent}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-3">
                            <h4 class="text-sm font-black text-gray-900 truncate uppercase">${title}</h4>
                            <span class="text-[10px] text-gray-400 font-bold whitespace-nowrap">${item.time}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 truncate">${item.sender_name}: ${item.preview}</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-[10px] uppercase tracking-widest text-gray-400 font-black">${item.count} pesan baru</span>
                            <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                        </div>
                    </div>
                </a>
            `;
        }

        function renderDropdown(data) {
            if (!dropdown) return;
            let html = '';
            data.unread_conversations.forEach(item => {
                html += renderItem(item, false);
            });
            data.unread_chats.forEach(item => {
                html += renderItem(item, true);
            });
            if (html === '') {
                dropdown.innerHTML = '';
                if (emptyState) emptyState.classList.remove('hidden');
            } else {
                dropdown.innerHTML = html;
                if (emptyState) emptyState.classList.add('hidden');
            }
        }

        async function fetchNotifications(updateDropdown = false) {
            try {
                const res = await fetch('{{ route('notifications.unread') }}', {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) return;
                const data = await res.json();
                updateBadge(data.count);
                if (updateDropdown) {
                    renderDropdown(data);
                }
            } catch (e) {
                // Silently fail
            }
        }

        // Polling badge count setiap 10 detik (tanpa re-render dropdown)
        setInterval(() => fetchNotifications(false), 10000);

        // Saat tombol notifikasi diklik, fetch data terbaru + render dropdown
        if (chatBtn) {
            chatBtn.addEventListener('click', () => fetchNotifications(true));
        }
    })();
    </script>
    @endauth
</nav>
