<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LandingHeroMedia extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_landing_hero_medias';

    protected $fillable = [
        'title', 'subtitle', 'media_type', 'desktop_image_path', 
        'mobile_image_path', 'video_url', 'button_text', 'button_url', 
        'sort_order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logExcept(['created_at', 'updated_at']);
    }
}