<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciseLibraryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('system-admin');
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'category'          => ['required', 'string', 'max:100'],
            'video_url'         => ['nullable', 'url', 'max:500'],
            'video_file'        => ['nullable', 'file', 'mimes:mp4,webm', 'max:51200'],
            'thumbnail'         => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'remove_thumbnail'  => ['nullable', 'boolean'],
            'remove_video'      => ['nullable', 'boolean'],
            'duration_minutes'  => ['nullable', 'integer', 'min:1', 'max:999'],
            'difficulty_level'  => ['nullable', 'string', 'in:easy,medium,hard'],
            'calories_burned'   => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'instructions'      => ['nullable', 'string'],
            'precautions'       => ['nullable', 'string'],
            'suitable_for'      => ['nullable', 'array'],
            'suitable_for.*'    => ['string', 'in:diabetes,hypertension,hyperlipidemia,obesity,kidney_disease,heart_disease,joint_pain,back_pain'],
            'tags'              => ['nullable', 'array'],
            'tags.*'            => ['string', 'max:50'],
            'is_active'         => ['boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'กรุณาระบุชื่อท่าบริหาร',
            'category.required'      => 'กรุณาเลือกหมวดหมู่',
            'video_url.url'          => 'URL วิดีโอไม่ถูกต้อง',
            'thumbnail.image'        => 'ไฟล์ต้องเป็นรูปภาพเท่านั้น',
            'thumbnail.max'          => 'ขนาดไฟล์ต้องไม่เกิน 2MB',
            'difficulty_level.in'    => 'ระดับความยากไม่ถูกต้อง',
        ];
    }
}
