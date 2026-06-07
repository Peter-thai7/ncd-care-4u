<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserGoal extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_user_goals';

    protected $fillable = [
        'user_id', 
        'disease_package_id', 
        'goal_name', 
        'metric_type', 
        'start_value', 
        'target_value', 
        'unit', 
        'start_date', 
        'target_date', 
        'status'
    ];

    protected $casts = [
        'start_value' => 'decimal:2',
        'target_value' => 'decimal:2',
        'start_date' => 'date',
        'target_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logExcept(['created_at', 'updated_at']);
    }

    // ความสัมพันธ์: เป้าหมายนี้เป็นของคนไข้คนไหน
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ความสัมพันธ์: เป้าหมายนี้ผูกกับแพ็กเกจโรคไหน (อาจไม่ผูกก็ได้)
    public function diseasePackage()
    {
        return $this->belongsTo(DiseasePackage::class, 'disease_package_id');
    }
}