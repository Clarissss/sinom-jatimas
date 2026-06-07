@extends('layouts.app')

@section('title', 'Live Chat Proyek')
@section('page-title', 'Live Chat Proyek')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Live Chat Proyek</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola chat real-time dengan klien per proyek</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                    Live
                </span>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="p-4 bg-gray-50 border-b border-gray-100">
            <form action="{{ route('admin.project-chats.index') }}" method="GET" class="flex gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari proyek..."
                           class="w-full border-gray-200 rounded-lg text-sm px-4 py-2 focus:ring-[#DD3517] focus:border-[#DD3517]">
                </div>
                <div class="w-48">
                    <select name="client_id" class="w-full border-gray-200 rounded-lg text-sm px-4 py-2 focus:ring-[#DD3517] focus:border-[#DD3517]">
                        <option value="">Semua Klien</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>
            </form>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($projects as $project)
                @php
                    $latestMessage = $project->chatMessages->first();
                    $unreadCount = \App\Models\ChatMessage::where('project_id', $project->id)
                        ->where('sender_id', '!=', auth()->id())
                        ->where('is_read', false)
                        ->count();
                @endphp
                <a href="{{ route('chat.index', $project) }}"
                   class="flex items-center p-4 hover:bg-gray-50 transition-colors group">
                    <div class="relative flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-bold text-lg shadow-sm border-2 border-white">
                            {{ strtoupper(substr($project->name, 0, 1)) }}
                        </div>
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </div>

                    <div class="ml-4 flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 truncate">
                                {{ $project->name }}
                            </h3>
                            <span class="text-xs text-gray-400">
                                {{ $latestMessage?->created_at->diffForHumans() ?? $project->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 truncate mt-0.5">
                            @if($latestMessage)
                                {{ $latestMessage->sender_id === auth()->id() ? 'Anda: ' : '' }}
                                {{ $latestMessage->message ?? 'Mengirim file' }}
                            @else
                                Belum ada pesan
                            @endif
                        </p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                @if($project->status === 'in_progress') bg-blue-100 text-blue-800
                                @elseif($project->status === 'completed') bg-green-100 text-green-800
                                @elseif($project->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                <i class="fa-solid fa-user mr-1 text-[10px]"></i> {{ $project->client->name }}
                            </span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                Progress {{ $project->progress_percentage }}%
                            </span>
                        </div>
                    </div>

                    <div class="ml-4 text-gray-400 group-hover:text-gray-600">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </a>
            @empty
                <div class="text-center py-12">
                    <div class="text-gray-300 mb-3">
                        <i class="fa-solid fa-building text-5xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Belum ada proyek</p>
                    <p class="text-sm text-gray-400 mt-1">Proyek yang aktif akan muncul di sini</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
