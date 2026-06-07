<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserRewardClaim extends Model
{
    use LogsActivity;

    protected $table = 'sp4u_user_reward_claims';

    protected $fillable = [
        'user_id', 'reward_tier_id', 'points_spent', 'status', 'claimed_at'
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rewardTier()
    {
        return $this->belongsTo(RewardTier::class, 'reward_tier_id');
    }
}