<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AgentSkill extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon'];

    public function agents(): BelongsToMany
    {
        return $this->belongsToMany(Agent::class, 'agent_agent_skill');
    }
}
