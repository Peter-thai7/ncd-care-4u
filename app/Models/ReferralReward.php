<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ReferralReward extends Model
{
    use LogsActivity;

    protected $table = 'sp4u_referral_rewards';

    protected $fillable = [
        'referrer_user_id', 'referred_user_id', 'points_awarded', 'status', 'awarded_at'
    ];

    protected $casts = [
        'awarded_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_user_id');
    }

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}