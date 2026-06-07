<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ExerciseLibrary extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'sp4u_exercise_libraries';

    protected $fillable = [
        'name',
        'description',
        'category',
        'video_url',
        'video_path',
        'thumbnail_path',
        'duration_minutes',
        'difficulty_level',
        'calories_burned',
        'instructions',
        'precautions',
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
        'calories_burned' => 'decimal:2',
        'sort_order' => 'integer',
        'duration_minutes' => 'integer',
    ];

    /**
     * หมวดหมู่ท่าบริหาร
     */
    public static function getCategories(): array
    {
        return [
            'stretching' => 'ยืดเส้นยืดกล้ามเนื้อ',
            'aerobic' => 'แอโรบิก/คาร์ดิโอ',
            'physiotherapy' => 'กายภาพบำบัด',
            'yoga' => 'โยคะ/พัฒนาจิต',
            'walking_running' => 'เดิน/วิ่ง',
            'strength' => 'เสริมกล้ามเนื้อ',
            'balance' => 'ทรงตัว/สมดุล',
            'breathing' => 'หายใจ/ผ่อนคลาย',
        ];
    }

    /**
     * ระดับความยาก
     */
    public static function getDifficultyLevels(): array
    {
        return [
            'easy' => 'ง่าย (เริ่มต้น)',
            'medium' => 'ปานกลาง',
            'hard' => 'ยาก (ขั้นสูง)',
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
            'joint_pain' => 'ปวดข้อ/ข้อเสื่อม',
            'back_pain' => 'ปวดหลัง',
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
                'name', 'category', 'difficulty_level', 'is_active', 'sort_order'
            ])
            ->logOnlyDirty()
            ->useLogName('exercise_library')
            ->setDescriptionForEvent(fn(string $eventName) => "ท่าบริหาร '{$this->name}' ถูก{$this->getEventDescription($eventName)}");
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
