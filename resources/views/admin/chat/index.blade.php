@extends('layouts.app')

@section('title', 'Percakapan Customer')
@section('page-title', 'Percakapan Customer')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Percakapan Customer</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola chat pra-penjualan dengan calon klien</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    Live
                </span>
            </div>
        </div>

        <div class="divide-y divide-gray-100" id="conversations-list">
            @forelse($conversations as $conversation)
                @php
                    $latestMessage = $conversation->latestMessage;
                    $unreadCount = \App\Models\ChatMessage::where('conversation_id', $conversation->id)
                        ->where('sender_id', '!=', auth()->id())
                        ->where('is_read', false)
                        ->count();
                @endphp
                <a href="{{ route('admin.conversations.show', $conversation) }}" 
                   id="conversation-{{ $conversation->id }}"
                   class="flex items-center p-4 hover:bg-gray-50 transition-colors group"
                   data-conversation-id="{{ $conversation->id }}">
                    <div class="relative flex-shrink-0">
                        <img src="{{ $conversation->user->photo_url }}" 
                             alt="{{ $conversation->user->name }}"
                             class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm"
                             data-user-photo>
                        <span class="unread-badge absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center {{ $unreadCount > 0 ? '' : 'hidden' }}">
                            {{ $unreadCount }}
                        </span>
                    </div>
                    
                    <div class="ml-4 flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 truncate" data-user-name>
                                {{ $conversation->user->name }}
                            </h3>
                            <span class="text-xs text-gray-400" data-timestamp>
                                {{ $latestMessage?->created_at->diffForHumans() ?? $conversation->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 truncate mt-0.5" data-last-message>
                            @if($latestMessage)
                                {{ $latestMessage->sender_id === auth()->id() ? 'Anda: ' : '' }}
                                {{ $latestMessage->message ?? 'Mengirim file' }}
                            @else
                                Belum ada pesan
                            @endif
                        </p>
                        <div class="flex items-center gap-2 mt-1" data-badges>
                            @if($conversation->status === 'converted')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fa-solid fa-check-circle mr-1"></i>
                                    Dikonversi ke Project
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 status-badge">
                                    Aktif
                                </span>
                            @endif
                            @if($conversation->admin_id === null)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 assign-badge">
                                    Belum ditangani
                                </span>
                            @elseif($conversation->admin_id === auth()->id())
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 assign-badge">
                                    Ditangani Anda
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="ml-4 text-gray-400 group-hover:text-gray-600">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </a>
            @empty
                <div id="empty-conversations" class="text-center py-12">
                    <div class="text-gray-300 mb-3">
                        <i class="fa-regular fa-comments text-5xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada percakapan</p>
                    <p class="text-sm text-gray-400 mt-1">Percakapan dari customer akan muncul di sini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>
<script>
    window.Pusher = Pusher;
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'local-key',
        wsHost: 'localhost',
        wsPort: 8080,
        forceTLS: false,
        disableStats: true,
        enabledTransports: ['ws'],
        cluster: 'mt1',
    });

    const conversationsApp = {
        currentUserId: {{ auth()->id() }},
        
        init() {
            this.setupWebSocket();
        },
        
        setupWebSocket() {
            const channel = window.Echo.channel('admin.conversations');
            
            channel.subscription
                .bind('pusher:subscription_succeeded', () => {
                    console.log('Subscribed to admin.conversations');
                })
                .bind('pusher:subscription_error', (err) => {
                    console.error('Subscription error:', err);
                });
            
            channel.listen('.conversation.updated', (data) => {
                console.log('Conversation updated:', data);
                // Jika conversation sudah dikonversi ke project, hapus dari daftar
                if (data.conversation.status === 'converted') {
                    const existing = document.getElementById('conversation-' + data.conversation.id);
                    if (existing) existing.remove();
                    return;
                }
                this.updateOrPrependConversation(data.conversation);
                this.playNotificationSound();
            });
        },
        
        playNotificationSound() {
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmFgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');
            audio.volume = 0.3;
            audio.play().catch(() => {});
        },
        
        updateOrPrependConversation(conv) {
            const existing = document.getElementById('conversation-' + conv.id);
            const list = document.getElementById('conversations-list');
            
            // Remove empty state if exists
            const empty = document.getElementById('empty-conversations');
            if (empty) empty.remove();
            
            const latestMessage = conv.latest_message;
            const messageText = latestMessage 
                ? (latestMessage.sender_id === this.currentUserId ? 'Anda: ' : '') + (latestMessage.message || 'Mengirim file')
                : 'Belum ada pesan';
            
            const timeText = latestMessage 
                ? this.timeAgo(new Date(latestMessage.created_at))
                : this.timeAgo(new Date(conv.created_at));
            
            const statusBadges = conv.status === 'converted' 
                ? `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800"><i class="fa-solid fa-check-circle mr-1"></i>Dikonversi ke Project</span>`
                : `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 status-badge">Aktif</span>`;
            
            let assignBadge = '';
            if (conv.admin_id === null) {
                assignBadge = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 assign-badge">Belum ditangani</span>`;
            } else if (conv.admin_id === this.currentUserId) {
                assignBadge = `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 assign-badge">Ditangani Anda</span>`;
            }
            
            const html = `
                <a href="/admin/conversations/${conv.id}" 
                   id="conversation-${conv.id}"
                   class="flex items-center p-4 hover:bg-gray-50 transition-colors group bg-orange-50"
                   data-conversation-id="${conv.id}">
                    <div class="relative flex-shrink-0">
                        <img src="${conv.user.photo_url}" 
                             alt="${conv.user.name}"
                             class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm"
                             data-user-photo>
                        <span class="unread-badge absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                            1
                        </span>
                    </div>
                    
                    <div class="ml-4 flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 truncate" data-user-name>
                                ${this.escapeHtml(conv.user.name)}
                            </h3>
                            <span class="text-xs text-gray-400" data-timestamp>${timeText}</span>
                        </div>
                        <p class="text-sm text-gray-500 truncate mt-0.5" data-last-message>${this.escapeHtml(messageText)}</p>
                        <div class="flex items-center gap-2 mt-1" data-badges>
                            ${statusBadges}
                            ${assignBadge}
                        </div>
                    </div>
                    
                    <div class="ml-4 text-gray-400 group-hover:text-gray-600">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </a>
            `;
            
            if (existing) {
                // Update existing: remove old, prepend new
                existing.remove();
                list.insertAdjacentHTML('afterbegin', html);
                
                // Flash highlight
                const newEl = document.getElementById('conversation-' + conv.id);
                setTimeout(() => newEl.classList.remove('bg-orange-50'), 2000);
            } else {
                // Prepend new conversation
                list.insertAdjacentHTML('afterbegin', html);
            }
        },
        
        timeAgo(date) {
            const seconds = Math.floor((new Date() - date) / 1000);
            let interval = seconds / 31536000;
            if (interval > 1) return Math.floor(interval) + ' tahun yang lalu';
            interval = seconds / 2592000;
            if (interval > 1) return Math.floor(interval) + ' bulan yang lalu';
            interval = seconds / 86400;
            if (interval > 1) return Math.floor(interval) + ' hari yang lalu';
            interval = seconds / 3600;
            if (interval > 1) return Math.floor(interval) + ' jam yang lalu';
            interval = seconds / 60;
            if (interval > 1) return Math.floor(interval) + ' menit yang lalu';
            if (seconds < 10) return 'baru saja';
            return Math.floor(seconds) + ' detik yang lalu';
        },
        
        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    };
    
    conversationsApp.init();
</script>
@endpush
