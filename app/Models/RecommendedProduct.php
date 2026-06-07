<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RecommendedProduct extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'sp4u_recommended_products';

    protected $fillable = [
        'name', 'slug', 'description', 'image_path', 'normal_price', 
        'member_price', 'affiliate_url', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'normal_price' => 'decimal:2',
        'member_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnlyDirty()->logExcept(['created_at', 'updated_at']);
    }
}