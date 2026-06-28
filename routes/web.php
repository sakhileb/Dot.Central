<?php

use App\Http\Controllers\Auth\EcosystemAuthController;
use Illuminate\Support\Facades\Route;


Route::get('/auth/ecosystem', [EcosystemAuthController::class, 'handle'])->name('ecosystem.auth');
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $totalAgents        = \App\Models\Agent::count();
        $activeAgents       = \App\Models\Agent::where('is_active', true)->count();
        $totalConversations = \App\Models\Conversation::where('user_id', auth()->id())->count();
        $totalMessages      = \App\Models\Message::whereHas(
            'conversation', fn ($q) => $q->where('user_id', auth()->id())
        )->count();
        $totalTokens        = \App\Models\AgentUsageLog::where('user_id', auth()->id())
            ->selectRaw('COALESCE(SUM(tokens_input + tokens_output), 0) as total')
            ->value('total') ?? 0;
        $totalSkills        = \App\Models\AgentSkill::count();
        $agents             = \App\Models\Agent::withCount('conversations')->latest()->get();
        $skills             = \App\Models\AgentSkill::withCount('agents')->get();

        return view('dashboard', compact(
            'totalAgents', 'activeAgents', 'totalConversations', 'totalMessages',
            'totalTokens', 'totalSkills', 'agents', 'skills'
        ));
    })->name('dashboard');
});
