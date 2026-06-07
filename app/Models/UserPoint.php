<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserPoint extends Model
{
    use LogsActivity;

    protected $table = 'sp4u_user_points';

    protected $fillable = [
        'user_id', 'total_points', 'total_earned'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}