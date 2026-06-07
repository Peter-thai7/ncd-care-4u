<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PointTransaction extends Model
{
    use LogsActivity;

    protected $table = 'sp4u_point_transactions';

    protected $fillable = [
        'user_id', 'point_rule_id', 'amount', 'balance_after', 'type', 'description'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pointRule()
    {
        return $this->belongsTo(PointRule::class, 'point_rule_id');
    }
}