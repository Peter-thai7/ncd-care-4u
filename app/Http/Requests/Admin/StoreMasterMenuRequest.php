<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('System Admin');
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'category'          => ['required', 'string', 'max:100'],
            'calories'          => ['nullable', 'numeric', 'min:0', 'max:99999'],
            'protein'           => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'carbs'             => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'fat'               => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'fiber'             => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'sodium'            => ['nullable', 'numeric', 'min:0', 'max:9999'],
            'image'             => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'instructions'      => ['nullable', 'string'],
            'ingredients'       => ['nullable', 'string'],
            'preparation_time'  => ['nullable', 'integer', 'min:0', 'max:999'],
            'serving_size'      => ['nullable', 'string', 'max:100'],
            'difficulty_level'  => ['nullable', 'string', 'in:easy,medium,hard'],
            'suitable_for'      => ['nullable', 'array'],
            'suitable_for.*'    => ['string', 'in:diabetes,hypertension,hyperlipidemia,obesity,kidney_disease,heart_disease'],
            'tags'              => ['nullable', 'array'],
            'tags.*'            => ['string', 'max:50'],
            'is_active'         => ['boolean'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'กรุณาระบุชื่อเมนูอาหาร',
            'name.max'               => 'ชื่อเมนูต้องไม่เกิน 255 ตัวอักษร',
            'category.required'      => 'กรุณาเลือกหมวดหมู่',
            'calories.numeric'       => 'แคลอรี่ต้องเป็นตัวเลข',
            'calories.min'           => 'แคลอรี่ต้องไม่ติดลบ',
            'protein.numeric'        => 'โปรตีนต้องเป็นตัวเลข',
            'carbs.numeric'          => 'คาร์โบไฮเดรตต้องเป็นตัวเลข',
            'fat.numeric'            => 'ไขมันต้องเป็นตัวเลข',
            'image.image'            => 'ไฟล์ต้องเป็นรูปภาพเท่านั้น',
            'image.mimes'            => 'รองรับเฉพาะไฟล์ JPEG, PNG, WebP',
            'image.max'              => 'ขนาดไฟล์ต้องไม่เกิน 2MB',
            'difficulty_level.in'    => 'ระดับความยากไม่ถูกต้อง',
            'suitable_for.array'     => 'ข้อมูลโรคที่เหมาะสมไม่ถูกต้อง',
        ];
    }
}
