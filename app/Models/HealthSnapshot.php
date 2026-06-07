<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class HealthSnapshot extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_health_snapshots';

    protected $fillable = [
        'user_id', 
        'entered_by_user_id', 
        'snapshot_date', 
        'weight_kg', 
        'height_cm', 
        'bmi', 
        'waist_inches', 
        'systolic_bp', 
        'diastolic_bp', 
        'fbs_mg_dl', 
        'notes'
    ];

    protected $casts = [
        'weight_kg' => 'decimal:2',
        'height_cm' => 'decimal:2',
        'bmi' => 'decimal:2',
        'waist_inches' => 'decimal:2',
        'fbs_mg_dl' => 'decimal:2',
        'snapshot_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logExcept(['created_at', 'updated_at']);
    }

    // ความสัมพันธ์: ข้อมูลสุขภาพนี้เป็นของคนไข้คนไหน
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ความสัมพันธ์: ใครเป็นคนบันทึกข้อมูล (หมอ/พยาบาล/คนไข้)
    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by_user_id');
    }
}