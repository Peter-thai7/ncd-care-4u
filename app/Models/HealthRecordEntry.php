<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class HealthRecordEntry extends Model
{
    use LogsActivity; // ไม่มี SoftDeletes เพราะเป็นรายการคำตอบย่อย

    protected $table = 'sp4u_health_record_entries';

    protected $fillable = [
        'health_record_id', 
        'form_question_id', 
        'form_option_id', 
        'answer_text', 
        'triggered_alert_level'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    // ความสัมพันธ์: คำตอบนี้อยู่ในประวัติ (Record) ไหน
    public function healthRecord()
    {
        return $this->belongsTo(HealthRecord::class, 'health_record_id');
    }

    // ความสัมพันธ์: คำตอบนี้ตอบคำถามข้อไหน
    public function formQuestion()
    {
        return $this->belongsTo(FormQuestion::class, 'form_question_id');
    }

    // ความสัมพันธ์: คำตอบนี้เลือกตัวเลือกไหน (ถ้าเป็น Radio/Checkbox)
    public function formOption()
    {
        return $this->belongsTo(FormOption::class, 'form_option_id');
    }
}