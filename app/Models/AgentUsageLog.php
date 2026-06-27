<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentUsageLog extends Model
{
    protected $fillable = ['user_id', 'agent_id', 'tokens_input', 'tokens_output'];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
