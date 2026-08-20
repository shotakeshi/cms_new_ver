<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class ActivityLog extends Model
{
    protected $fillable = [
        'admin_id',
        'action',
        'module',
        'subject_type',
        'subject_id',
        'properties',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    protected $appends = [
        'agent_info',
        'log_time',
    ];

    public function getAgentInfoAttribute(): array
    {
        if (!$this->user_agent) {
            return [];
        }

        $agent = new Agent();
        $agent->setUserAgent($this->user_agent);

        return [
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->isDesktop() ? 'Desktop' :
                ($agent->isTablet() ? 'Tablet' : 'Mobile'),
        ];
    }

    public function getLogTimeAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
