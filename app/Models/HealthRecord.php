<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class HealthRecord extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_health_records';

    protected $fillable = [
        'user_package_id', 
        'package_tab_id', 
        'entered_by_user_id', 
        'recorded_at', 
        'overall_alert_level', 
        'notes'
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    // ความสัมพันธ์: ประวัตินี้อยู่ในแพ็กเกจของคนไข้คนไหน
    public function userPackage()
    {
        return $this->belongsTo(UserPackage::class, 'user_package_id');
    }

    // ความสัมพันธ์: ประวัตินี้กรอกในแท็บไหน
    public function packageTab()
    {
        return $this->belongsTo(PackageTab::class, 'package_tab_id');
    }

    // ความสัมพันธ์: ใครเป็นคนกรอกข้อมูล (หมอ/พยาบาล/คนไข้) -> สำคัญมากสำหรับระบบ Collaborative
    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by_user_id');
    }

    // ความสัมพันธ์: ประวัติ 1 ครั้ง มีคำตอบแต่ละข้อ (Entries) อะไรบ้าง
    public function entries()
    {
        return $this->hasMany(HealthRecordEntry::class, 'health_record_id');
    }
}