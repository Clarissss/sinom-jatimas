@extends('layouts.app')

@section('title', 'Chat Support')
@section('page-title', 'Live Chat')

@section('content')
<div class="h-[calc(100vh-180px)] flex flex-col bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden animate-fade-in">
    {{-- Chat Header --}}
    <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-primary-50 to-secondary-50">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">Customer Service</h3>
                <p class="text-xs text-gray-500 flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    Admin • Online
                </p>
            </div>
        </div>
        <a href="{{ route('client.dashboard') }}" 
           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-white rounded-lg transition-all border border-transparent hover:border-gray-200">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    {{-- Messages Area --}}
    <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50" role="log" aria-live="polite" aria-label="Chat messages">
        @forelse($messages as $message)
            <div class="message-item {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}" 
                 data-message-id="{{ $message->id }}"
                 data-file-type="{{ $message->file_type }}"
                 data-file-name="{{ $message->file_name }}">
                
                @if($message->sender_id !== auth()->id())
                    <div class="avatar" aria-hidden="true">
                        <img src="{{ $message->sender->photo_url }}" alt="{{ $message->sender->name }}">
                    </div>
                @endif
                
                <div class="message-bubble {{ $message->sender_id === auth()->id() ? 'bg-gradient text-white' : 'bg-white' }}">
                    @if($message->sender_id !== auth()->id())
                        <p class="sender-name">{{ $message->sender->name }}</p>
                    @endif
                    
                    @if($message->message)
                        <p class="message-text">{!! nl2br(e($message->message)) !!}</p>
                    @endif
                    
                    @if($message->file_path)
                        @if($message->file_type === 'image')
                            <div class="file-preview-image">
                                <a href="{{ route('chat.general.download', $message) }}" target="_blank" rel="noopener noreferrer">
                                    <img src="{{ route('chat.general.download', $message) }}" alt="{{ $message->file_name }}" loading="lazy">
                                </a>
                            </div>
                        @else
                            <a href="{{ route('chat.general.download', $message) }}" class="file-download">
                                <div class="file-icon" aria-hidden="true">
                                    @if($message->file_type === 'pdf')
                                        <i class="fa-solid fa-file-pdf text-2xl text-red-500"></i>
                                    @else
                                        <i class="fa-solid fa-file-lines text-2xl text-blue-500"></i>
                                    @endif
                                </div>
                                <div class="file-info">
                                    <p class="file-name">{{ $message->file_name }}</p>
                                    <p class="file-meta">{{ $message->file_type === 'pdf' ? 'PDF' : 'Dokumen' }} • {{ number_format($message->file_size / 1024, 1) }} KB</p>
                                </div>
                                <div class="download-icon" aria-hidden="true">
                                    <i class="fa-solid fa-download text-gray-500"></i>
                                </div>
                            </a>
                        @endif
                    @endif
                    
                    <p class="message-time {{ $message->sender_id === auth()->id() ? 'text-right' : '' }}">
                        {{ $message->created_at->format('H:i') }}
                        @if($message->sender_id === auth()->id() && $message->is_read)
                            <span class="read-status" title="Dibaca">
                                <i class="fa-solid fa-check-double text-xs"></i>
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon" aria-hidden="true">
                    <i class="fa-regular fa-comments text-6xl text-gray-300"></i>
                </div>
                <p class="text-gray-500 font-medium">Belum ada pesan</p>
                <p class="empty-sub">Mulai percakapan dengan mengirim pesan atau file</p>
            </div>
        @endforelse
        <div id="messages-end" aria-hidden="true"></div>
    </div>

    {{-- Input Area --}}
    <div class="p-4 bg-white border-t border-gray-200">
        <form id="chat-form" class="chat-form" enctype="multipart/form-data" x-data="{ sending: false }">
            @csrf
            
            <label for="file-input" class="btn-attach" title="Upload file (maksimal 10MB)" aria-label="Upload file">
                <i class="fa-solid fa-paperclip text-lg"></i>
            </label>
            <input type="file" id="file-input" name="file" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.txt" aria-label="Pilih file">
            
            <textarea id="message-input" 
                      name="message" 
                      placeholder="Tulis pesan..." 
                      rows="1"
                      aria-label="Pesan"
                      oninput="this.style.height = ''; this.style.height = Math.min(this.scrollHeight, 102) + 'px'"></textarea>
            
            <button type="submit" 
                    class="btn-send" 
                    id="send-btn"
                    :disabled="sending"
                    :class="{ 'opacity-50 cursor-not-allowed': sending }"
                    aria-label="Kirim pesan">
                <i x-show="!sending" class="fa-solid fa-paper-plane"></i>
                <i x-show="sending" class="fa-solid fa-circle-notch fa-spin" style="display: none;"></i>
            </button>
        </form>
        
        <div id="file-preview" class="file-preview hidden">
            <span class="file-preview-icon" aria-hidden="true">
                <i class="fa-regular fa-file text-gray-500"></i>
            </span>
            <span id="file-preview-name" class="text-sm text-gray-700 font-medium"></span>
            <span id="file-preview-size" class="text-xs text-gray-500"></span>
            <button type="button" id="remove-file" class="btn-remove" aria-label="Hapus file">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
</div>

<style>
#messages-container { -ms-overflow-style: none; scrollbar-width: none; }
#messages-container::-webkit-scrollbar { display: none; }
.message-item { display: flex; align-items: flex-end; gap: 8px; max-width: 80%; animation: messageSlide 0.3s ease-out; }
@keyframes messageSlide { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.message-item.sent { margin-left: auto; justify-content: flex-end; }
.message-item.received { margin-right: auto; }
.avatar { width: 36px; height: 36px; border-radius: 50%; overflow: hidden; flex-shrink: 0; border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.avatar img { width: 100%; height: 100%; object-fit: cover; }
.message-bubble { padding: 12px 16px; border-radius: 16px; max-width: 100%; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
.message-bubble.bg-gradient { background: linear-gradient(135deg, #dc2626, #ea580c); color: white; border-bottom-right-radius: 4px; }
.message-bubble.bg-white { background: white; border: 1px solid #e5e7eb; border-bottom-left-radius: 4px; }
.sender-name { font-size: 12px; font-weight: 600; color: #dc2626; margin-bottom: 4px; }
.message-text { font-size: 14px; line-height: 1.5; word-wrap: break-word; }
.message-time { font-size: 11px; margin-top: 4px; opacity: 0.7; }
.read-status { margin-left: 4px; }
.file-preview-image { margin-top: 8px; border-radius: 8px; overflow: hidden; max-width: 250px; }
.file-preview-image img { width: 100%; height: auto; display: block; cursor: pointer; transition: opacity 0.2s; }
.file-preview-image img:hover { opacity: 0.9; }
.file-download { display: flex; align-items: center; gap: 12px; margin-top: 8px; padding: 10px 12px; background: rgba(0,0,0,0.05); border-radius: 8px; text-decoration: none; color: inherit; transition: background 0.2s; }
.file-download:hover { background: rgba(0,0,0,0.1); }
.file-icon { flex-shrink: 0; }
.file-info { flex: 1; min-width: 0; }
.file-name { font-size: 13px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.file-meta { font-size: 11px; opacity: 0.7; }
.download-icon { flex-shrink: 0; }
.empty-state { text-align: center; padding: 40px; color: #9ca3af; }
.empty-icon { margin-bottom: 12px; }
.empty-sub { font-size: 13px; margin-top: 4px; }
.chat-form { display: flex; align-items: flex-end; gap: 8px; }
.btn-attach { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; border-radius: 50%; color: #6b7280; transition: all 0.2s; flex-shrink: 0; }
.btn-attach:hover { background: #f3f4f6; color: #dc2626; }
#message-input { flex: 1; border: 1px solid #e5e7eb; border-radius: 20px; padding: 10px 16px; font-size: 14px; line-height: 1.5; resize: none; min-height: 58px; max-height: 102px; outline: none; transition: border-color 0.2s, box-shadow 0.2s; }
#message-input:focus { border-color: #dc2626; box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1); }
.btn-send { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #dc2626, #ea580c); color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: transform 0.2s, box-shadow 0.2s; flex-shrink: 0; }
.btn-send:hover:not(:disabled) { transform: scale(1.05); box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3); }
.btn-send:disabled { opacity: 0.5; cursor: not-allowed; }
.file-preview { display: flex; align-items: center; gap: 8px; margin-top: 8px; padding: 8px 12px; background: #f3f4f6; border-radius: 8px; font-size: 13px; }
.file-preview.hidden { display: none; }
.btn-remove { margin-left: auto; background: none; border: none; cursor: pointer; padding: 4px 8px; color: #6b7280; border-radius: 4px; transition: all 0.2s; }
.btn-remove:hover { color: #dc2626; background: rgba(220, 38, 38, 0.1); }
</style>
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

    const chatApp = {
        conversationId: {{ $conversation->id }},
        currentUserId: {{ auth()->id() }},
        
        init() {
            this.scrollToBottom();
            this.setupWebSocket();
            this.setupForm();
        },
        
        scrollToBottom() {
            const container = document.getElementById('messages-container');
            if (container) container.scrollTop = container.scrollHeight;
        },
        
        setupWebSocket() {
            const channel = window.Echo.channel('conversation.' + this.conversationId);
            
            channel.subscription
                .bind('pusher:subscription_succeeded', () => {
                    console.log('Subscribed to conversation.' + this.conversationId);
                })
                .bind('pusher:subscription_error', (err) => {
                    console.error('Subscription error:', err);
                });
            
            channel.listen('.message.sent', (data) => {
                if (data.sender.id !== this.currentUserId) {
                    this.addMessage(data);
                    this.playNotificationSound();
                }
            });
        },
        
        playNotificationSound() {
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmFgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');
            audio.volume = 0.3;
            audio.play().catch(() => {});
        },
        
        setupForm() {
            const form = document.getElementById('chat-form');
            const input = document.getElementById('message-input');
            const fileInput = document.getElementById('file-input');
            const filePreview = document.getElementById('file-preview');
            const removeBtn = document.getElementById('remove-file');
            const sendBtn = document.getElementById('send-btn');
            
            let selectedFile = null;
            
            fileInput.addEventListener('change', (e) => {
                if (e.target.files[0]) {
                    selectedFile = e.target.files[0];
                    if (selectedFile.size > 10 * 1024 * 1024) {
                        alert('File terlalu besar! Maksimal 10MB');
                        selectedFile = null;
                        fileInput.value = '';
                        return;
                    }
                    document.getElementById('file-preview-name').textContent = selectedFile.name;
                    document.getElementById('file-preview-size').textContent = (selectedFile.size / 1024).toFixed(1) + ' KB';
                    filePreview.classList.remove('hidden');
                }
            });
            
            removeBtn.addEventListener('click', () => {
                selectedFile = null;
                fileInput.value = '';
                filePreview.classList.add('hidden');
            });
            
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const text = input.value.trim();
                if (!text && !selectedFile) return;
                
                sendBtn.disabled = true;
                
                const formData = new FormData();
                formData.append('message', text);
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                if (!csrfToken) {
                    alert('Sesi telah berakhir. Silakan refresh halaman.');
                    sendBtn.disabled = false;
                    return;
                }
                formData.append('_token', csrfToken);
                
                if (selectedFile) {
                    formData.append('file', selectedFile, selectedFile.name);
                }
                
                input.value = '';
                input.style.height = '58px';
                input.rows = 1;
                fileInput.value = '';
                filePreview.classList.add('hidden');
                
                try {
                    const res = await fetch(`/chat/general/${this.conversationId}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });
                    
                    if (res.ok) {
                        const data = await res.json();
                        this.addMessage(data);
                        selectedFile = null;
                    } else if (res.status === 419) {
                        alert('Sesi telah berakhir. Silakan refresh halaman (F5).');
                    } else {
                        const error = await res.text();
                        console.error('Server error:', error);
                        alert('Gagal mengirim pesan. Silakan coba lagi.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Error koneksi. Cek internet Anda.');
                } finally {
                    sendBtn.disabled = false;
                }
            });
            
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    form.dispatchEvent(new Event('submit'));
                }
            });
        },
        
        addMessage(data) {
            if (document.querySelector(`[data-message-id="${data.id}"]`)) return;
            
            const container = document.getElementById('messages-container');
            const isMe = data.sender.id === this.currentUserId;
            
            let fileHtml = '';
            if (data.file_path) {
                const url = `/chat/general/download/${data.id}`;
                if (data.file_type === 'image') {
                    fileHtml = `<div class="file-preview-image"><a href="${url}" target="_blank" rel="noopener noreferrer"><img src="${url}" alt="${data.file_name}" loading="lazy"></a></div>`;
                } else {
                    const iconClass = data.file_type === 'pdf' ? 'fa-file-pdf text-red-500' : 'fa-file-lines text-blue-500';
                    fileHtml = `<a href="${url}" class="file-download"><div class="file-icon"><i class="fa-solid ${iconClass} text-2xl"></i></div><div class="file-info"><p class="file-name">${data.file_name}</p><p class="file-meta">${data.file_type === 'pdf' ? 'PDF' : 'Dokumen'} • ${(data.file_size / 1024).toFixed(1)} KB</p></div><div class="download-icon"><i class="fa-solid fa-download text-gray-500"></i></div></a>`;
                }
            }
            
            const time = new Date(data.created_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});
            
            const avatarHtml = isMe ? '' : `<div class="avatar"><img src="${data.sender.photo_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.sender.name) + '&background=dc2626&color=fff&size=128'}" alt="${data.sender.name}"></div>`;
            
            const html = isMe ? `
                <div class="message-item sent" data-message-id="${data.id}">
                    <div class="message-bubble bg-gradient">
                        ${data.message ? `<p class="message-text">${this.formatMessage(data.message)}</p>` : ''}
                        ${fileHtml}
                        <p class="message-time text-right">${time}</p>
                    </div>
                </div>
            ` : `
                <div class="message-item received" data-message-id="${data.id}">
                    ${avatarHtml}
                    <div class="message-bubble bg-white">
                        <p class="sender-name">${this.escapeHtml(data.sender.name)}</p>
                        ${data.message ? `<p class="message-text">${this.formatMessage(data.message)}</p>` : ''}
                        ${fileHtml}
                        <p class="message-time">${time}</p>
                    </div>
                </div>
            `;
            
            const empty = container.querySelector('.empty-state');
            if (empty) empty.remove();
            
            const end = document.getElementById('messages-end');
            end.insertAdjacentHTML('beforebegin', html);
            
            this.scrollToBottom();
        },
        
        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        },
        
        formatMessage(text) {
            return this.escapeHtml(text).replace(/\n/g, '<br>');
        }
    };
    
    chatApp.init();
</script>
@endpush
