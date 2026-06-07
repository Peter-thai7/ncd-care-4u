<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserPackage extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_user_packages';

    protected $fillable = [
        'user_id', 
        'disease_package_id', 
        'unlocked_by_user_id', 
        'is_active', 
        'unlocked_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'unlocked_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logExcept(['created_at', 'updated_at']);
    }

    // ความสัมพันธ์: แพ็กเกจนี้เป็นของคนไข้คนไหน
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ความสัมพันธ์: แพ็กเกจนี้คือโรคอะไร
    public function diseasePackage()
    {
        return $this->belongsTo(DiseasePackage::class, 'disease_package_id');
    }

    // ความสัมพันธ์: ใครเป็นคน Unlock แพ็กเกจนี้ให้
    public function unlockedBy()
    {
        return $this->belongsTo(User::class, 'unlocked_by_user_id');
    }

    // ความสัมพันธ์: แพ็กเกจที่คนไข้ได้รับ มีประวัติการบันทึกสุขภาพยังไงบ้าง
    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class, 'user_package_id');
    }
}