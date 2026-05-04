<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Default home redirect (fallback untuk middleware guest)
Route::get('/home', function () {
    return auth()->user()?->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('client.dashboard');
})->middleware('auth')->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'show'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'store'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Client Routes
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/projects/{project}', [\App\Http\Controllers\Client\ProjectController::class, 'show'])->name('projects.show');
    Route::get('/documents', [\App\Http\Controllers\Client\DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{project}/{document}/download', [\App\Http\Controllers\Client\DocumentController::class, 'download'])->name('documents.download');
    Route::get('/invoices', [\App\Http\Controllers\Client\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [\App\Http\Controllers\Client\InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/download', [\App\Http\Controllers\Client\InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('/daily-reports', [\App\Http\Controllers\Client\DailyReportController::class, 'index'])->name('daily-reports.index');
    Route::get('/daily-reports/{project}', [\App\Http\Controllers\Client\DailyReportController::class, 'show'])->name('daily-reports.show');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Projects
    Route::resource('projects', \App\Http\Controllers\Admin\ProjectController::class);
    Route::post('/projects/{project}/progress', [\App\Http\Controllers\Admin\ProjectProgressController::class, 'store'])->name('projects.progress.store');
    Route::patch('/projects/{project}/progress', [\App\Http\Controllers\Admin\ProjectProgressController::class, 'updateProgress'])->name('projects.progress.update');
    Route::delete('/projects/{project}/progress/{progress}', [\App\Http\Controllers\Admin\ProjectProgressController::class, 'destroy'])->name('projects.progress.destroy');
    
    // Daily Reports
    Route::resource('daily-reports', \App\Http\Controllers\Admin\DailyReportController::class);
    
    // Documents
    Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class);
    Route::get('/documents/{document}/download', [\App\Http\Controllers\Admin\DocumentController::class, 'download'])->name('documents.download');
    
    // Invoices
    Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class);
    Route::get('/invoices/{invoice}/download', [\App\Http\Controllers\Admin\InvoiceController::class, 'download'])->name('invoices.download');
    Route::post('/invoices/{invoice}/send', [\App\Http\Controllers\Admin\InvoiceController::class, 'send'])->name('invoices.send');
    Route::post('/invoices/{invoice}/mark-paid', [\App\Http\Controllers\Admin\InvoiceController::class, 'markAsPaid'])->name('invoices.mark-paid');
    
    // Users (Clients)
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
    // Activity Logs
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{activity_log}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::delete('/activity-logs/{activity_log}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/photo', [\App\Http\Controllers\ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

// Chat Routes (Both roles)
Route::middleware('auth')->group(function () {
    Route::get('/projects/{project}/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/projects/{project}/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/projects/{project}/chat/unread', [ChatController::class, 'unreadCount'])->name('chat.unread');
    Route::get('/chat/download/{message}', [ChatController::class, 'download'])->name('chat.download');
});

// Test broadcast (admin only) - Remove in production
Route::get('/test-broadcast/{project}', function($projectId) {
    if (!auth()->user()?->isAdmin()) {
        abort(403, 'Unauthorized');
    }
    
    $testMessage = [
        'id' => 999,
        'message' => 'TEST BROADCAST from server',
        'file_path' => null,
        'file_name' => null,
        'file_type' => null,
        'file_size' => null,
        'sender' => [
            'id' => 1,
            'name' => 'System Test',
            'role' => 'admin',
        ],
        'created_at' => now()->toIso8601String(),
    ];
    
    broadcast(new \App\Events\MessageSent((object)$testMessage))->toOthers();
    
    return 'Broadcast sent to project.' . $projectId;
})->middleware(['auth', 'role:admin']);
