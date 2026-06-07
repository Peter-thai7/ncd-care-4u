<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BonusEventUser extends Model
{
    use LogsActivity;

    protected $table = 'sp4u_bonus_event_user';

    protected $fillable = [
        'bonus_event_id', 'user_id', 'is_completed', 'completed_at'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    public function bonusEvent()
    {
        return $this->belongsTo(BonusEvent::class, 'bonus_event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}