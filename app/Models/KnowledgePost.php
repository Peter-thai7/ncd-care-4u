<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class KnowledgePost extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_knowledge_posts';

    protected $fillable = [
        'title', 'slug', 'content_type', 'body', 'featured_image_path', 
        'file_path', 'video_url', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logExcept(['created_at', 'updated_at']);
    }

    // ความสัมพันธ์: บทความนี้ถูกมอบหมายให้คนไข้คนไหนบ้าง
    public function assignments()
    {
        return $this->hasMany(KnowledgeAssignment::class, 'knowledge_post_id');
    }
}