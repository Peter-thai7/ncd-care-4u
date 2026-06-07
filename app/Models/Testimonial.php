<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Testimonial extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_testimonials';

    protected $fillable = [
        'user_id', 'reviewer_name', 'reviewer_photo_path', 'quote', 
        'rating', 'status', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logExcept(['created_at', 'updated_at']);
    }

    // ความสัมพันธ์: รีวิวนี้เป็นของคนไข้คนไหน (อาจเป็น null ถ้าแอดมินเพิ่มเอง)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}