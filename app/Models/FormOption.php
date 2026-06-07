<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FormOption extends Model
{
    use LogsActivity; // ไม่มี SoftDeletes เพราะเป็นตัวเลือกย่อย

    protected $table = 'sp4u_form_options';

    protected $fillable = [
        'form_question_id', 'option_text', 'option_value', 'alert_level', 'sort_order'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    // ความสัมพันธ์: ตัวเลือกนี้เป็นของคำถามไหน
    public function question()
    {
        return $this->belongsTo(FormQuestion::class, 'form_question_id');
    }
}