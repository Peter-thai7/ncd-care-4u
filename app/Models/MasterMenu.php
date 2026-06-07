<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MasterMenu extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'sp4u_master_menus';

    protected $fillable = [
        'name',
        'description',
        'category',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'sodium',
        'image_path',
        'instructions',
        'ingredients',
        'preparation_time',
        'serving_size',
        'difficulty_level',
        'suitable_for',
        'tags',
        'is_active',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'suitable_for' => 'array',
        'tags' => 'array',
        'is_active' => 'boolean',
        'calories' => 'decimal:2',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2',
        'fiber' => 'decimal:2',
        'sodium' => 'decimal:2',
        'sort_order' => 'integer',
        'preparation_time' => 'integer',
    ];

    /**
     * หมวดหมู่อาหารที่รองรับ
     */
    public static function getCategories(): array
    {
        return [
            'breakfast' => 'อาหารเช้า',
            'lunch' => 'อาหารกลางวัน',
            'dinner' => 'อาหารเย็น',
            'snack' => 'ขนมว่าง',
            'beverage' => 'เครื่องดื่ม',
            'supplement' => 'อาหารเสริม',
        ];
    }

    /**
     * ระดับความยาก
     */
    public static function getDifficultyLevels(): array
    {
        return [
            'easy' => 'ง่าย',
            'medium' => 'ปานกลาง',
            'hard' => 'ยาก',
        ];
    }

    /**
     * โรคที่เหมาะสม (NCD)
     */
    public static function getSuitableConditions(): array
    {
        return [
            'diabetes' => 'เบาหวาน',
            'hypertension' => 'ความดันโลหิตสูง',
            'hyperlipidemia' => 'ไขมันในเลือดสูง',
            'obesity' => 'อ้วน/น้ำหนักเกิน',
            'kidney_disease' => 'โรคไต',
            'heart_disease' => 'โรคหัวใจ',
        ];
    }

    /**
     * Scope: เฉพาะที่ active
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: เรียงตาม sort_order แล้วตามชื่อ
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Scope: ค้นหาตามชื่อ/รายละเอียด
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%")
              ->orWhere('category', 'LIKE', "%{$term}%");
        });
    }

    /**
     * ความสัมพันธ์: ผู้สร้าง
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * ความสัมพันธ์: ผู้แก้ไขล่าสุด
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Spatie Activity Log configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name', 'category', 'calories', 'is_active', 'sort_order'
            ])
            ->logOnlyDirty()
            ->useLogName('master_menu')
            ->setDescriptionForEvent(fn(string $eventName) => "เมนูอาหาร '{$this->name}' ถูก{$this->getEventDescription($eventName)}");
    }

    private function getEventDescription(string $event): string
    {
        return match ($event) {
            'created' => 'สร้าง',
            'updated' => 'แก้ไข',
            'deleted' => 'ลบ',
            'restored' => 'กู้คืน',
            default => $event,
        };
    }

    /**
     * Boot method - auto set created_by/updated_by
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }
}
