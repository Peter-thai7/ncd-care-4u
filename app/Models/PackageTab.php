<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PackageTab extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_package_tabs';

    protected $fillable = [
        'disease_package_id', 'title', 'tab_type', 'sort_order', 'is_active'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    // ความสัมพันธ์: แท็บนี้เป็นของแพ็กเกจไหน
    public function package()
    {
        return $this->belongsTo(DiseasePackage::class, 'disease_package_id');
    }

    // ความสัมพันธ์: แท็บ 1 มีได้หลายคำถาม
    public function questions()
    {
        return $this->hasMany(FormQuestion::class, 'package_tab_id')->orderBy('sort_order');
    }
}