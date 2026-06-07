<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class KnowledgeAssignment extends Model
{
    use LogsActivity; // ไม่มี SoftDeletes

    protected $table = 'sp4u_knowledge_assignments';

    protected $fillable = [
        'knowledge_post_id', 'user_id', 'assigned_by_user_id', 'is_read', 'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }

    // ความสัมพันธ์: มอบหมายบทความไหน
    public function knowledgePost()
    {
        return $this->belongsTo(KnowledgePost::class, 'knowledge_post_id');
    }

    // ความสัมพันธ์: มอบหมายให้คนไข้คนไหน
    public function patient()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ความสัมพันธ์: ใครเป็นคนมอบหมาย
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by_user_id');
    }
}