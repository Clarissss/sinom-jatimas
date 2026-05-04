<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Display the chat interface for a project.
     */
    public function index(Project $project): View|JsonResponse
    {
        $this->authorizeAccess($project);

        $messages = ChatMessage::with('sender')
            ->where('project_id', $project->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        ChatMessage::where('project_id', $project->id)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json($messages);
        }

        return view('chat.index', compact('project', 'messages'));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorizeAccess($project);

        // Debug: log request info
        Log::info('Chat store request', [
            'has_file' => $request->hasFile('file'),
            'message' => $request->input('message'),
            'content_type' => $request->header('Content-Type'),
        ]);

        try {
            $validated = $request->validate([
                'message' => ['nullable', 'string', 'max:2000'],
                'file' => ['nullable', 'file', 'max:10240'], // Max 10MB
            ]);
        } catch (\Exception $e) {
            Log::error('Validation failed: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 422);
        }

        // Validate that either message or file must exist
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
            
            Log::info('Uploading file', [
                'name' => $fileName,
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);
            
            try {
                $filePath = $file->store('chat-files', 'private');
                Log::info('File stored at: ' . $filePath);
            } catch (\Exception $e) {
                Log::error('File store failed: ' . $e->getMessage());
                return response()->json(['error' => 'Gagal menyimpan file: ' . $e->getMessage()], 500);
            }
            
            $fileSize = $file->getSize();
            
            // Detect file type
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
            'project_id' => $project->id,
            'sender_id' => auth()->id(),
            'message' => $validated['message'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'is_read' => false,
        ]);

        $message->load('sender');

        try {
            broadcast(new MessageSent($message))->toOthers();
            Log::info('Broadcast sent for message: ' . $message->id);
        } catch (\Exception $e) {
            Log::error('Broadcast failed: ' . $e->getMessage());
        }

        // Reload to ensure all data is fresh
        $message->refresh()->load('sender');
        
        $response = [
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
        ];
        
        Log::info('Message response:', $response);
        
        return response()->json($response);
    }

    public function download(ChatMessage $message)
    {
        $this->authorizeAccess($message->project);

        if (!$message->file_path || !Storage::disk('private')->exists($message->file_path)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('private')->download($message->file_path, $message->file_name);
    }

    public function unreadCount(Project $project)
    {
        $this->authorizeAccess($project);

        $count = ChatMessage::where('project_id', $project->id)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    protected function authorizeAccess(Project $project)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isClient() && $project->client_id === $user->id) {
            return true;
        }

        abort(403, 'Akses ditolak.');
    }
}
