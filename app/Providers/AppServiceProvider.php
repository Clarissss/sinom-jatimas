<?php

namespace App\Providers;

use App\Models\ChatMessage;
use App\Models\CompanyProfile;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(
            ['layouts.public', 'partials.public.navbar', 'partials.public.footer', 'partials.public.cta-banner'],
            function ($view) {
                if (! array_key_exists('companyProfile', $view->getData())) {
                    $view->with('companyProfile', CompanyProfile::first());
                }
            }
        );

        View::composer('*', function ($view) {

            $unreadCount = 0;
            $unreadChats = collect();
            $unreadConversations = collect();

            if (auth()->check()) {
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

                // Conversation-based unread messages (general chat)
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

                $unreadCount = $projectMessages->count() + $conversationMessages->count();
                $unreadChats = $projectMessages->groupBy('project_id');
                $unreadConversations = $conversationMessages->groupBy('conversation_id');
            }

            $view->with([
                'unreadCount' => $unreadCount,
                'unreadChats' => $unreadChats,
                'unreadConversations' => $unreadConversations,
            ]);
        });
    }
}
