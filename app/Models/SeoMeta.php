<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SeoMeta extends Model
{
    use LogsActivity; // ไม่มี SoftDeletes

    protected $table = 'sp4u_seo_metas';

    protected $fillable = [
        'page_identifier', 'meta_title', 'meta_description', 'keywords', 'og_image_path'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty();
    }
}