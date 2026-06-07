<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DiseasePackage extends Model
{
    use SoftDeletes, LogsActivity;

    // บังคับใช้ชื่อตาราง sp4u_ ตาม Brief
    protected $table = 'sp4u_disease_packages';

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'color_code', 'is_active'
    ];

    // ตั้งค่า Spatie Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logExcept(['created_at', 'updated_at']);
    }

    // ความสัมพันธ์: แพ็กเกจ 1 มีได้หลายแท็บ
    public function tabs()
    {
        return $this->hasMany(PackageTab::class, 'disease_package_id')->orderBy('sort_order');
    }
}