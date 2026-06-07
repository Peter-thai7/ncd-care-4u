<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FormQuestion extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_form_questions';

    protected $fillable = [
        'package_tab_id', 'question_text', 'input_type', 'configuration', 'unit', 'is_required', 'sort_order'
    ];

    // แปลงข้อมูล JSON ในฐานข้อมูลให้เป็น Array อัตโนมัติใน PHP
    protected $casts = [
        'configuration' => 'array',
        'is_required' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    // ความสัมพันธ์: คำถามนี้อยู่ในแท็บไหน
    public function tab()
    {
        return $this->belongsTo(PackageTab::class, 'package_tab_id');
    }

    // ความสัมพันธ์: คำถาม 1 มีได้หลายตัวเลือก (Radio/Checkbox)
    public function options()
    {
        return $this->hasMany(FormOption::class, 'form_question_id')->orderBy('sort_order');
    }
}