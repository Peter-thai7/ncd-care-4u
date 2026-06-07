<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RewardTier extends Model
{
    use LogsActivity;

    protected $table = 'sp4u_reward_tiers';

    protected $fillable = [
        'reward_campaign_id', 'title', 'description', 'image_path', 
        'required_points', 'stock_quantity', 'sort_order'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    public function campaign()
    {
        return $this->belongsTo(RewardCampaign::class, 'reward_campaign_id');
    }

    public function claims()
    {
        return $this->hasMany(UserRewardClaim::class, 'reward_tier_id');
    }
}