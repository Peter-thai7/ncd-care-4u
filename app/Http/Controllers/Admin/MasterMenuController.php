<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMasterMenuRequest;
use App\Http\Requests\Admin\UpdateMasterMenuRequest;
use App\Models\MasterMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MasterMenuController extends Controller
{
    /**
     * แสดงรายการเมนูอาหารทั้งหมด (คลังวัสดุ)
     */
    public function index(Request $request)
    {
        $query = MasterMenu::with('creator');

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

        $menus = $query->ordered()
            ->paginate(15)
            ->withQueryString();

        $categories = MasterMenu::getCategories();
        $conditions = MasterMenu::getSuitableConditions();
        $difficulties = MasterMenu::getDifficultyLevels();

        return view('admin.master-menus.index', compact(
            'menus', 'categories', 'conditions', 'difficulties'
        ));
    }

    /**
     * แสดงฟอร์มสร้างเมนูอาหารใหม่
     */
    public function create()
    {
        $categories = MasterMenu::getCategories();
        $conditions = MasterMenu::getSuitableConditions();
        $difficulties = MasterMenu::getDifficultyLevels();

        return view('admin.master-menus.create', compact(
            'categories', 'conditions', 'difficulties'
        ));
    }

    /**
     * บันทึกเมนูอาหารใหม่ลงฐานข้อมูล
     */
    public function store(StoreMasterMenuRequest $request)
    {
        $data = $request->validated();

        // จัดการอัปโหลดรูปภาพ
        if ($request->hasFile('image')) {
            $data['image_path'] = $this->uploadImage($request->file('image'));
        }

        // จัดการ tags (แปลงจาก string เป็น array)
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        // ตั้งค่า default
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $menu = MasterMenu::create($data);

        return redirect()
            ->route('admin.master-menus.index')
            ->with('success', "สร้างเมนูอาหาร \"{$menu->name}\" เรียบร้อยแล้ว");
    }

    /**
     * แสดงรายละเอียดเมนูอาหาร
     */
    public function show(MasterMenu $masterMenu)
    {
        $masterMenu->load('creator', 'updater');
        $categories = MasterMenu::getCategories();
        $conditions = MasterMenu::getSuitableConditions();
        $difficulties = MasterMenu::getDifficultyLevels();

        return view('admin.master-menus.show', compact(
            'masterMenu', 'categories', 'conditions', 'difficulties'
        ));
    }

    /**
     * แสดงฟอร์มแก้ไขเมนูอาหาร
     */
    public function edit(MasterMenu $masterMenu)
    {
        $categories = MasterMenu::getCategories();
        $conditions = MasterMenu::getSuitableConditions();
        $difficulties = MasterMenu::getDifficultyLevels();

        return view('admin.master-menus.edit', compact(
            'masterMenu', 'categories', 'conditions', 'difficulties'
        ));
    }

    /**
     * อัปเดตเมนูอาหาร
     */
    public function update(UpdateMasterMenuRequest $request, MasterMenu $masterMenu)
    {
        $data = $request->validated();

        // จัดการอัปโหลดรูปภาพใหม่
        if ($request->hasFile('image')) {
            // ลบรูปเก่า
            if ($masterMenu->image_path) {
                $this->deleteImage($masterMenu->image_path);
            }
            $data['image_path'] = $this->uploadImage($request->file('image'));
        }

        // ลบรูปภาพ (ถ้าเลือกลบ)
        if ($request->boolean('remove_image') && $masterMenu->image_path) {
            $this->deleteImage($masterMenu->image_path);
            $data['image_path'] = null;
        }

        // จัดการ tags
        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));
        }

        $data['is_active'] = $request->boolean('is_active');

        $masterMenu->update($data);

        return redirect()
            ->route('admin.master-menus.index')
            ->with('success', "อัปเดตเมนูอาหาร \"{$masterMenu->name}\" เรียบร้อยแล้ว");
    }

    /**
     * ลบเมนูอาหาร (Soft Delete)
     */
    public function destroy(MasterMenu $masterMenu)
    {
        $name = $masterMenu->name;
        $masterMenu->delete();

        return redirect()
            ->route('admin.master-menus.index')
            ->with('success', "ลบเมนูอาหาร \"{$name}\" เรียบร้อยแล้ว (Soft Delete)");
    }

    /**
     * สลับสถานะ Active/Inactive (Ajax)
     */
    public function toggleActive(MasterMenu $masterMenu)
    {
        $masterMenu->update(['is_active' => !$masterMenu->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $masterMenu->is_active,
            'message' => $masterMenu->is_active
                ? "เปิดใช้งาน \"{$masterMenu->name}\" แล้ว"
                : "ปิดใช้งาน \"{$masterMenu->name}\" แล้ว",
        ]);
    }

    /**
     * อัปโหลดรูปภาพ - บีบอัด, เปลี่ยนชื่อเป็น Hash, เก็บ Relative Path
     */
    private function uploadImage($file): string
    {
        $hashName = $file->hashName();
        $relativePath = 'uploads/menus/' . date('Y/m');

        // บีบอัดรูปภาพด้วย Intervention Image
        $image = Image::make($file->getRealPath());
        $image->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // เก็บล่าสุด
        $fullPath = storage_path('app/public/' . $relativePath);
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        $image->save($fullPath . '/' . $hashName, 80);

        return $relativePath . '/' . $hashName;
    }

    /**
     * ลบรูปภาพจาก Storage
     */
    private function deleteImage(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
