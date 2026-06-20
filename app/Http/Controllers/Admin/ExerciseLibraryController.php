<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExerciseLibraryRequest;
use App\Http\Requests\Admin\UpdateExerciseLibraryRequest;
use App\Models\ExerciseLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ExerciseLibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = ExerciseLibrary::with('creator');
        if ($search = $request->input('search')) { $query->search($search); }
        if ($category = $request->input('category')) { $query->where('category', $category); }
        if ($request->filled('is_active')) { $query->where('is_active', $request->boolean('is_active')); }
        if ($suitable = $request->input('suitable_for')) { $query->whereJsonContains('suitable_for', $suitable); }
        if ($difficulty = $request->input('difficulty_level')) { $query->where('difficulty_level', $difficulty); }
        $exercises = $query->ordered()->paginate(15)->withQueryString();
        $categories = ExerciseLibrary::getCategories();
        $conditions = ExerciseLibrary::getSuitableConditions();
        $difficulties = ExerciseLibrary::getDifficultyLevels();
        return view('admin.exercise-libraries.index', compact('exercises', 'categories', 'conditions', 'difficulties'));
    }

    public function create()
    {
        $categories = ExerciseLibrary::getCategories();
        $conditions = ExerciseLibrary::getSuitableConditions();
        $difficulties = ExerciseLibrary::getDifficultyLevels();
        return view('admin.exercise-libraries.create', compact('categories', 'conditions', 'difficulties'));
    }

    public function store(StoreExerciseLibraryRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')) { $data['thumbnail_path'] = $this->uploadImage($request->file('thumbnail'), 'thumbnails/exercises'); }
        if ($request->hasFile('video_file')) { $data['video_path'] = $this->uploadVideo($request->file('video_file')); }
        if (isset($data['tags']) && is_string($data['tags'])) { $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags']))); }
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $exercise = ExerciseLibrary::create($data);
        return redirect()->route('admin.exercise-libraries.index')->with('success', "สร้างท่าบริหาร \"{$exercise->name}\" เรียบร้อยแล้ว");
    }

    public function show(ExerciseLibrary $exerciseLibrary)
    {
        $exerciseLibrary->load('creator', 'updater');
        $categories = ExerciseLibrary::getCategories();
        $conditions = ExerciseLibrary::getSuitableConditions();
        $difficulties = ExerciseLibrary::getDifficultyLevels();
        return view('admin.exercise-libraries.show', compact('exerciseLibrary', 'categories', 'conditions', 'difficulties'));
    }

    public function edit(ExerciseLibrary $exerciseLibrary)
    {
        $categories = ExerciseLibrary::getCategories();
        $conditions = ExerciseLibrary::getSuitableConditions();
        $difficulties = ExerciseLibrary::getDifficultyLevels();
        return view('admin.exercise-libraries.edit', compact('exerciseLibrary', 'categories', 'conditions', 'difficulties'));
    }

    public function update(UpdateExerciseLibraryRequest $request, ExerciseLibrary $exerciseLibrary)
    {
        $data = $request->validated();
        if ($request->hasFile('thumbnail')) {
            if ($exerciseLibrary->thumbnail_path) { $this->deleteFile($exerciseLibrary->thumbnail_path); }
            $data['thumbnail_path'] = $this->uploadImage($request->file('thumbnail'), 'thumbnails/exercises');
        }
        if ($request->boolean('remove_thumbnail') && $exerciseLibrary->thumbnail_path) { $this->deleteFile($exerciseLibrary->thumbnail_path); $data['thumbnail_path'] = null; }
        if ($request->hasFile('video_file')) {
            if ($exerciseLibrary->video_path) { $this->deleteFile($exerciseLibrary->video_path); }
            $data['video_path'] = $this->uploadVideo($request->file('video_file'));
        }
        if ($request->boolean('remove_video') && $exerciseLibrary->video_path) { $this->deleteFile($exerciseLibrary->video_path); $data['video_path'] = null; }
        if (isset($data['tags']) && is_string($data['tags'])) { $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags']))); }
        $data['is_active'] = $request->boolean('is_active');
        $exerciseLibrary->update($data);
        return redirect()->route('admin.exercise-libraries.index')->with('success', "อัปเดตท่าบริหาร \"{$exerciseLibrary->name}\" เรียบร้อยแล้ว");
    }

    public function destroy(ExerciseLibrary $exerciseLibrary)
    {
        $name = $exerciseLibrary->name;
        $exerciseLibrary->delete();
        return redirect()->route('admin.exercise-libraries.index')->with('success', "ลบท่าบริหาร \"{$name}\" เรียบร้อยแล้ว (Soft Delete)");
    }

    public function toggleActive(ExerciseLibrary $exerciseLibrary)
    {
        $exerciseLibrary->update(['is_active' => !$exerciseLibrary->is_active]);
        return response()->json([
            'success' => true,
            'is_active' => $exerciseLibrary->is_active,
            'message' => $exerciseLibrary->is_active ? "เปิดใช้งาน \"{$exerciseLibrary->name}\" แล้ว" : "ปิดใช้งาน \"{$exerciseLibrary->name}\" แล้ว",
        ]);
    }

    public function trashed()
    {
        $trashedExercises = ExerciseLibrary::onlyTrashed()->with('creator')->orderBy('deleted_at', 'desc')->get();
        $categories = ExerciseLibrary::getCategories();
        return response()->json([
            'items' => $trashedExercises->map(fn($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'category' => $categories[$item->category] ?? $item->category,
                'deleted_at' => $item->deleted_at?->format('d/m/Y H:i'),
                'thumbnail' => $item->thumbnail_path ? Storage::url($item->thumbnail_path) : null,
            ])
        ]);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.exercise-libraries.index')->with('error', 'ไม่ได้เลือกรายการ');
        }
        $count = ExerciseLibrary::onlyTrashed()->whereIn('id', $ids)->restore();
        return response()->json(['success' => true, 'message' => "กู้คืนท่าบริหาร {$count} รายการเรียบร้อยแล้ว"]);
    }

    public function forceDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.exercise-libraries.index')->with('error', 'ไม่ได้เลือกรายการ');
        }
        $items = ExerciseLibrary::onlyTrashed()->whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->thumbnail_path) { $this->deleteFile($item->thumbnail_path); }
            if ($item->video_path) { $this->deleteFile($item->video_path); }
            $item->forceDelete();
        }
        return response()->json(['success' => true, 'message' => "ลบท่าบริหารถาวร " . count($items) . " รายการเรียบร้อยแล้ว"]);
    }

    private function uploadImage($file, string $subPath = 'uploads/exercises'): string
    {
        $hashName = $file->hashName();
        $relativePath = $subPath . '/' . date('Y/m');
        $image = Image::decode($file);
        $image = $image->scaleDown(width: 1200);
        $fullPath = storage_path('app/public/' . $relativePath);
        if (!is_dir($fullPath)) { mkdir($fullPath, 0755, true); }
        $image->save($fullPath . '/' . $hashName, quality: 80);
        return $relativePath . '/' . $hashName;
    }

    private function uploadVideo($file): string
    {
        $hashName = $file->hashName();
        $relativePath = 'uploads/videos/exercises/' . date('Y/m');
        $path = Storage::disk('public')->putFileAs($relativePath, $file, $hashName);
        return $path;
    }

    private function deleteFile(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
