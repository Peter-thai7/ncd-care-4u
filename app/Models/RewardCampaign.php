<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RewardCampaign extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_reward_campaigns';

    protected $fillable = [
        'name', 'description', 'image_path', 'starts_at', 'ends_at', 'is_active'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    public function tiers()
    {
        return $this->hasMany(RewardTier::class, 'reward_campaign_id');
    }
}