<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PointRule extends Model
{
    use LogsActivity;

    protected $table = 'sp4u_point_rules';

    protected $fillable = [
        'name', 'code', 'point_value', 'max_per_day', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }
}