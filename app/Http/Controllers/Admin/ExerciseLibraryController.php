<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExerciseLibraryRequest;
use App\Http\Requests\Admin\UpdateExerciseLibraryRequest;
use App\Models\ExerciseLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ExerciseLibraryController extends Controller
{
    /**
     * แสดงรายการท่าบริหารทั้งหมด (คลังวัสดุ)
     */
    public function index(Request $request)
    {
        $query = ExerciseLibrary::with('creator');

        // ค้นหา
        if ($search = $request->input('search')) {
            $query->search($search);
        }

        // กรองหมวดหมู่
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        // กรองสถานะ
        if ($request->has('is_active') && $request->input('is_active') !== '') {
            $query->where('is_active', $request->boolean('is_active'));
        }

        // กรองโรคที่เหมาะสม
        if ($suitable = $request->input('suitable_for')) {
            $query->whereJsonContains('suitable_for', $suitable);
        }

        // กรองระดับความยาก
        if ($difficulty = $request->input('difficulty_level')) {
            $query->where('difficulty_level', $difficulty);
        }

        $exercises = $query->ordered()
            ->paginate(15)
            ->withQueryString();

        $categories = ExerciseLibrary::getCategories();
        $conditions = ExerciseLibrary::getSuitableConditions();
        $difficulties = ExerciseLibrary::getDifficultyLevels();

        return view('admin.exercise-libraries.index', compact(
            'exercises', 'categories', 'conditions', 'difficulties'
        ));
    }

    /**
     * แสดงฟอร์มสร้างท่าบริหารใหม่
     */
    public function create()
    {
        $categories = ExerciseLibrary::getCategories();
        $conditions = ExerciseLibrary::getSuitableConditions();
        $difficulties = ExerciseLibrary::getDifficultyLevels();

        return view('admin.exercise-libraries.create', compact(
            'categories', 'conditions', 'difficulties'
        ));
    }

    /**
     * บันทึกท่าบริหารใหม่ลงฐานข้อมูล
     */
    public function store(StoreExerciseLibraryRequest $request)
    {
        $data = $request->validated();

        // จัดการอัปโหลด Thumbnail
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $this->uploadImage($request->file('thumbnail'), 'thumbnails/exercises');
        }

        // จัดการอัปโหลดวิดีโอ
        if ($request->hasFile('video_file')) {
            $data['video_path'] = $this->uploadVideo($request->file('video_file'));
        }

        // จัดการ tags
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        // ตั้งค่า default
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $exercise = ExerciseLibrary::create($data);

        return redirect()
            ->route('admin.exercise-libraries.index')
            ->with('success', "สร้างท่าบริหาร \"{$exercise->name}\" เรียบร้อยแล้ว");
    }

    /**
     * แสดงรายละเอียดท่าบริหาร
     */
    public function show(ExerciseLibrary $exerciseLibrary)
    {
        $exerciseLibrary->load('creator', 'updater');
        $categories = ExerciseLibrary::getCategories();
        $conditions = ExerciseLibrary::getSuitableConditions();
        $difficulties = ExerciseLibrary::getDifficultyLevels();

        return view('admin.exercise-libraries.show', compact(
            'exerciseLibrary', 'categories', 'conditions', 'difficulties'
        ));
    }

    /**
     * แสดงฟอร์มแก้ไขท่าบริหาร
     */
    public function edit(ExerciseLibrary $exerciseLibrary)
    {
        $categories = ExerciseLibrary::getCategories();
        $conditions = ExerciseLibrary::getSuitableConditions();
        $difficulties = ExerciseLibrary::getDifficultyLevels();

        return view('admin.exercise-libraries.edit', compact(
            'exerciseLibrary', 'categories', 'conditions', 'difficulties'
        ));
    }

    /**
     * อัปเดตท่าบริหาร
     */
    public function update(UpdateExerciseLibraryRequest $request, ExerciseLibrary $exerciseLibrary)
    {
        $data = $request->validated();

        // จัดการอัปโหลด Thumbnail ใหม่
        if ($request->hasFile('thumbnail')) {
            if ($exerciseLibrary->thumbnail_path) {
                $this->deleteFile($exerciseLibrary->thumbnail_path);
            }
            $data['thumbnail_path'] = $this->uploadImage($request->file('thumbnail'), 'thumbnails/exercises');
        }

        // ลบ Thumbnail (ถ้าเลือกลบ)
        if ($request->boolean('remove_thumbnail') && $exerciseLibrary->thumbnail_path) {
            $this->deleteFile($exerciseLibrary->thumbnail_path);
            $data['thumbnail_path'] = null;
        }

        // จัดการอัปโหลดวิดีโอใหม่
        if ($request->hasFile('video_file')) {
            if ($exerciseLibrary->video_path) {
                $this->deleteFile($exerciseLibrary->video_path);
            }
            $data['video_path'] = $this->uploadVideo($request->file('video_file'));
        }

        // ลบวิดีโอ (ถ้าเลือกลบ)
        if ($request->boolean('remove_video') && $exerciseLibrary->video_path) {
            $this->deleteFile($exerciseLibrary->video_path);
            $data['video_path'] = null;
        }

        // จัดการ tags
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        $data['is_active'] = $request->boolean('is_active');

        $exerciseLibrary->update($data);

        return redirect()
            ->route('admin.exercise-libraries.index')
            ->with('success', "อัปเดตท่าบริหาร \"{$exerciseLibrary->name}\" เรียบร้อยแล้ว");
    }

    /**
     * ลบท่าบริหาร (Soft Delete)
     */
    public function destroy(ExerciseLibrary $exerciseLibrary)
    {
        $name = $exerciseLibrary->name;
        $exerciseLibrary->delete();

        return redirect()
            ->route('admin.exercise-libraries.index')
            ->with('success', "ลบท่าบริหาร \"{$name}\" เรียบร้อยแล้ว (Soft Delete)");
    }

    /**
     * สลับสถานะ Active/Inactive (Ajax)
     */
    public function toggleActive(ExerciseLibrary $exerciseLibrary)
    {
        $exerciseLibrary->update(['is_active' => !$exerciseLibrary->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $exerciseLibrary->is_active,
            'message' => $exerciseLibrary->is_active
                ? "เปิดใช้งาน \"{$exerciseLibrary->name}\" แล้ว"
                : "ปิดใช้งาน \"{$exerciseLibrary->name}\" แล้ว",
        ]);
    }

    /**
     * อัปโหลดรูปภาพ - บีบอัด, เปลี่ยนชื่อเป็น Hash, เก็บ Relative Path
     */
    private function uploadImage($file, string $subPath = 'uploads/exercises'): string
    {
        $hashName = $file->hashName();
        $relativePath = $subPath . '/' . date('Y/m');

        // บีบอัดรูปภาพ
        $image = Image::make($file->getRealPath());
        $image->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $fullPath = storage_path('app/public/' . $relativePath);
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        $image->save($fullPath . '/' . $hashName, 80);

        return $relativePath . '/' . $hashName;
    }

    /**
     * อัปโหลดวิดีโอ
     */
    private function uploadVideo($file): string
    {
        $hashName = $file->hashName();
        $relativePath = 'uploads/videos/exercises/' . date('Y/m');

        $path = Storage::disk('public')->putFileAs($relativePath, $file, $hashName);

        return $path;
    }

    /**
     * ลบไฟล์จาก Storage
     */
    private function deleteFile(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
