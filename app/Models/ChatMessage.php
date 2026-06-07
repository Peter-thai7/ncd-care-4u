<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ChatMessage extends Model
{
    use LogsActivity; // ไม่มี SoftDeletes เพราะข้อความแชทแก้ไข/ลบ ไม่ควรหายไปแบบ soft

    protected $table = 'sp4u_chat_messages';

    protected $fillable = [
        'chat_thread_id', 'sender_user_id', 'message_type', 
        'body', 'file_path', 'is_read', 'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    // ความสัมพันธ์: ข้อความนี้อยู่ในห้องแชทไหน
    public function thread()
    {
        return $this->belongsTo(ChatThread::class, 'chat_thread_id');
    }

    // ความสัมพันธ์: ใครเป็นคนส่งข้อความ (ถ้าเป็นระบบ/Bot จะเป็น null)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }
}