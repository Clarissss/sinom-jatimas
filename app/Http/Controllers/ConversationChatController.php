<?php

namespace App\Http\Controllers;

use App\Events\ConversationUpdated;
use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\Project;
use App\Services\ChatEncryptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ConversationChatController extends Controller
{
    /**
     * Client: Show the general chat interface.
     * Auto-creates a conversation if none exists.
     */
    public function clientChat(): View|JsonResponse|RedirectResponse
    {
        $user = auth()->user();

        // Jika client sudah pernah deal dan punya project dari convert conversation,
        // langsung arahkan ke room chat projectnya
        $convertedConversation = Conversation::where('user_id', $user->id)
            ->where('status', 'converted')
            ->whereNotNull('project_id')
            ->latest()
            ->first();

        if ($convertedConversation) {
            return redirect()->route('chat.index', $convertedConversation->project);
        }

        $conversation = Conversation::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'active'],
            [
                'admin_id' => null,
                'subject' => 'Percakapan baru',
            ]
        );

        // Notify admins about new conversation
        if ($conversation->wasRecentlyCreated) {
            try {
                broadcast(new ConversationUpdated($conversation))->toOthers();
            } catch (\Exception $e) {
                Log::error('Broadcast ConversationUpdated failed: ' . $e->getMessage());
            }
        }

        $messages = $conversation->messages()
            ->with('sender')
            ->notArchived()
            ->get();

        // Mark messages as read
        ChatMessage::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json($messages);
        }

        return view('chat.general', compact('conversation', 'messages'));
    }

    /**
     * Admin: List all active conversations.
     */
    public function adminIndex(): View
    {
        // Ambil user_id yang sudah punya conversation converted (sudah deal & punya project)
        $convertedUserIds = Conversation::where('status', 'converted')
            ->whereNotNull('project_id')
            ->pluck('user_id');

        // Hanya tampilkan active conversation dari user yang belum pernah convert
        $conversations = Conversation::with(['user', 'admin', 'latestMessage'])
            ->where('status', 'active')
            ->whereNotIn('user_id', $convertedUserIds)
            ->orderByDesc('last_message_at')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.chat.index', compact('conversations'));
    }

    /**
     * Admin: Show chat for a specific conversation.
     */
    public function adminChat(Conversation $conversation): View|JsonResponse|RedirectResponse
    {
        $this->authorizeAdmin();

        // Jika conversation sudah dikonversi ke project, arahkan ke room chat project
        if ($conversation->isConverted() && $conversation->project_id) {
            return redirect()->route('chat.index', $conversation->project);
        }

        // Auto-assign admin if not assigned
        if ($conversation->admin_id === null) {
            $conversation->update(['admin_id' => auth()->id()]);
        }

        $messages = $conversation->messages()
            ->with('sender')
            ->notArchived()
            ->get();

        // Mark messages as read
        ChatMessage::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json($messages);
        }

        return view('admin.chat.show', compact('conversation', 'messages'));
    }

    /**
     * Store a new message in a conversation.
     */
    public function store(Request $request, Conversation $conversation)
    {
        $user = auth()->user();

        // Authorization
        if ($user->isClient() && $conversation->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($user->isAdmin() && $conversation->admin_id !== null && $conversation->admin_id !== $user->id) {
            // Allow any admin to take over unassigned conversations
            if ($conversation->admin_id === null) {
                $conversation->update(['admin_id' => $user->id]);
            }
        }

        try {
            $validated = $request->validate([
                'message' => ['nullable', 'string', 'max:2000'],
                'file' => ['nullable', 'file', 'max:10240'],
            ]);
        } catch (\Exception $e) {
            Log::error('Validation failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 422);
        }

        if (empty($validated['message']) && !$request->hasFile('file')) {
            return response()->json(['error' => 'Pesan atau file harus diisi'], 422);
        }

        $filePath = null;
        $fileName = null;
        $fileType = null;
        $fileSize = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            try {
                $filePath = $file->store('chat-files', 'private');
            } catch (\Exception $e) {
                Log::error('File store failed: ' . $e->getMessage());
                return response()->json(['error' => 'Gagal menyimpan file: ' . $e->getMessage()], 500);
            }

            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            if (str_starts_with($mimeType, 'image/')) {
                $fileType = 'image';
            } elseif ($mimeType === 'application/pdf') {
                $fileType = 'pdf';
            } else {
                $fileType = 'document';
            }
        }

        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $validated['message'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'is_read' => false,
        ]);

        $conversation->update(['last_message_at' => now()]);

        $message->load('sender');

        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            Log::error('Broadcast failed: ' . $e->getMessage());
        }

        // Notify admins that a conversation has been updated
        try {
            broadcast(new ConversationUpdated($conversation))->toOthers();
        } catch (\Exception $e) {
            Log::error('Broadcast ConversationUpdated failed: ' . $e->getMessage());
        }

        $message->refresh()->load('sender');

        return response()->json([
            'id' => $message->id,
            'message' => $message->message,
            'file_path' => $message->file_path,
            'file_name' => $message->file_name,
            'file_type' => $message->file_type,
            'file_size' => $message->file_size,
            'sender' => [
                'id' => $message->sender->id,
                'name' => $message->sender->name,
                'role' => $message->sender->role,
                'photo_url' => $message->sender->photo_url,
            ],
            'created_at' => $message->created_at->toIso8601String(),
        ]);
    }

    /**
     * Download a file from a conversation message.
     */
    public function download(ChatMessage $message)
    {
        if (!$message->conversation_id) {
            abort(404);
        }

        $user = auth()->user();

        if ($user->isClient() && $message->conversation->user_id !== $user->id) {
            abort(403);
        }

        if (!$message->file_path || !Storage::disk('private')->exists($message->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('private')->download($message->file_path, $message->file_name);
    }

    /**
     * Get unread count for the current user's conversations.
     */
    public function unreadCount(): JsonResponse
    {
        $user = auth()->user();

        $query = ChatMessage::where('is_read', false)
            ->where('sender_id', '!=', $user->id)
            ->whereNotNull('conversation_id');

        if ($user->isClient()) {
            $query->whereHas('conversation', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        return response()->json(['count' => $query->count()]);
    }

    /**
     * Get full unread notifications data for navbar (project + conversation).
     */
    public function unreadNotifications(): JsonResponse
    {
        $user = auth()->user();

        // Project-based unread messages
        $projectQuery = ChatMessage::with(['project', 'sender'])
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->whereNotNull('project_id');

        if ($user->isClient()) {
            $projectQuery->whereHas('project', function ($q) use ($user) {
                $q->where('client_id', $user->id);
            });
        }

        $projectMessages = $projectQuery->latest()->get();

        // Conversation-based unread messages
        $conversationQuery = ChatMessage::with(['conversation.user', 'sender'])
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->whereNotNull('conversation_id');

        if ($user->isClient()) {
            $conversationQuery->whereHas('conversation', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $conversationMessages = $conversationQuery->latest()->get();

        return response()->json([
            'count' => $projectMessages->count() + $conversationMessages->count(),
            'unread_chats' => $projectMessages->groupBy('project_id')->map(function ($messages) {
                $first = $messages->first();
                return [
                    'project_id' => $first->project_id,
                    'project_name' => $first->project?->name,
                    'count' => $messages->count(),
                    'sender_name' => $first->sender?->name,
                    'preview' => $first->message ?? 'Mengirim file',
                    'time' => $first->created_at->diffForHumans(),
                    'url' => route('chat.index', $first->project),
                ];
            })->values(),
            'unread_conversations' => $conversationMessages->groupBy('conversation_id')->map(function ($messages) {
                $first = $messages->first();
                return [
                    'conversation_id' => $first->conversation_id,
                    'count' => $messages->count(),
                    'sender_name' => $first->sender?->name,
                    'preview' => $first->message ?? 'Mengirim file',
                    'time' => $first->created_at->diffForHumans(),
                    'url' => auth()->user()->isAdmin()
                        ? route('admin.conversations.show', $first->conversation)
                        : route('chat.general'),
                ];
            })->values(),
        ]);
    }

    /**
     * Convert an active conversation to a project.
     */
    public function convertToProject(Request $request, Conversation $conversation)
    {
        $this->authorizeAdmin();

        if ($conversation->isConverted()) {
            return response()->json(['error' => 'Percakapan sudah dikonversi ke project.'], 422);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'contract_value' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'client_id' => $conversation->user_id,
            'location' => $validated['location'] ?? null,
            'contract_value' => $validated['contract_value'] ?? 0,
            'description' => $validated['description'] ?? null,
            'status' => 'in_progress',
            'progress_percentage' => 0,
        ]);

        $conversation->update([
            'status' => 'converted',
            'project_id' => $project->id,
        ]);

        // Re-encrypt all conversation messages with the new project key
        $messages = ChatMessage::where('conversation_id', $conversation->id)->get();
        $encryption = app(ChatEncryptionService::class);

        foreach ($messages as $message) {
            $rawEncrypted = $message->getAttributes()['content_encrypted'] ?? null;

            if (!empty($rawEncrypted)) {
                try {
                    // Decrypt using the old conversation key
                    $plaintext = $encryption->decrypt($rawEncrypted, 'conv:' . $conversation->id);
                    // Re-encrypt using the new project key
                    $newEncrypted = $encryption->encrypt($plaintext, $project->id);

                    ChatMessage::where('id', $message->id)->update([
                        'project_id' => $project->id,
                        'content_encrypted' => $newEncrypted,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to re-encrypt message during convertToProject', [
                        'message_id' => $message->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            } else {
                // No encrypted content to migrate, just update the foreign key
                ChatMessage::where('id', $message->id)->update(['project_id' => $project->id]);
            }
        }

        return response()->json([
            'message' => 'Project berhasil dibuat.',
            'project' => $project,
            'redirect_url' => route('admin.projects.show', $project),
        ]);
    }

    protected function authorizeAdmin(): void
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }
    }
}
