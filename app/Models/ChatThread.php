<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ChatThread extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_chat_threads';

    protected $fillable = [
        'user_id', 'assigned_to_user_id', 'subject', 'status', 
        'priority', 'channel', 'line_user_id', 'last_replied_at'
    ];

    protected $casts = [
        'last_replied_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    // ความสัมพันธ์: ห้องแชทนี้เป็นของคนไข้คนไหน
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ความสัมพันธ์: ใครเป็นแอดมิน/หมอ ที่รับเรื่องดูแล
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    // ความสัมพันธ์: ห้องแชทนี้มีข้อความอะไรบ้าง
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_thread_id');
    }
}