<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BonusEvent extends Model
{
    use LogsActivity;

    protected $table = 'sp4u_bonus_events';

    protected $fillable = [
        'name', 'description', 'event_type', 'bonus_points', 
        'starts_at', 'ends_at', 'is_active'
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

    public function participants()
    {
        return $this->hasMany(BonusEventUser::class, 'bonus_event_id');
    }
}