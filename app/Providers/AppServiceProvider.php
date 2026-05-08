<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ChatMessage;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {

            $unreadCount = 0;
            $unreadChats = collect();

            if (auth()->check()) {

                $messages = \App\Models\ChatMessage::with(['project', 'sender'])
                    ->where('sender_id', '!=', auth()->id())
                    ->where('is_read', false)
                    ->latest()
                    ->get();

                $unreadCount = $messages->count();

                $unreadChats = $messages->groupBy('project_id');
            }

            $view->with([
                'unreadCount' => $unreadCount,
                'unreadChats' => $unreadChats,
            ]);
        });
    }
}
