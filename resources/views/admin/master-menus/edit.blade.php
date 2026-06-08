<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master-menus.index') }}"
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-pen-to-square mr-2 text-amber-600"></i>แก้ไขเมนูอาหาร
                </h2>
                <p class="text-sm text-gray-500 mt-1">{{ $masterMenu->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <form method="POST" action="{{ route('admin.master-menus.update', $masterMenu) }}" enctype="multipart/form-data"
              x-data="menuEditForm()">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i>
                    กรุณาตรวจสอบข้อมูลที่กรอก
                    <ul class="mt-2 ml-4 list-disc text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- ====== Left Column: Main Info ====== -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Basic Info Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-info-circle text-nature-500 mr-2"></i>ข้อมูลพื้นฐาน
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อเมนู <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $masterMenu->name) }}"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300 focus:border-nature-500"
                                       required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">รายละเอียด</label>
                                <textarea name="description" rows="3"
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">{{ old('description', $masterMenu->description) }}</textarea>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">หมวดหมู่ <span class="text-red-500">*</span></label>
                                    <select name="category" required
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300 bg-white">
                                        <option value="">-- เลือกหมวดหมู่ --</option>
                                        @foreach($categories as $key => $label)
                                            <option value="{{ $key }}" {{ old('category', $masterMenu->category) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ระดับความยาก</label>
                                    <select name="difficulty_level"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300 bg-white">
                                        <option value="">-- เลือก --</option>
                                        @foreach($difficulties as $key => $label)
                                            <option value="{{ $key }}" {{ old('difficulty_level', $masterMenu->difficulty_level) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ขนาดเสิร์ฟ</label>
                                    <input type="text" name="serving_size" value="{{ old('serving_size', $masterMenu->serving_size) }}"
                                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">เวลาเตรียม (นาที)</label>
                                    <input type="number" name="preparation_time" value="{{ old('preparation_time', $masterMenu->preparation_time) }}"
                                           min="0" max="999"
                                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nutrition Info Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-chart-pie text-green-500 mr-2"></i>ข้อมูลโภชนาการ
                        </h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">แคลอรี่ (kcal)</label>
                                <input type="number" name="calories" value="{{ old('calories', $masterMenu->calories) }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">โปรตีน (g)</label>
                                <input type="number" name="protein" value="{{ old('protein', $masterMenu->protein) }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">คาร์โบไฮเดรต (g)</label>
                                <input type="number" name="carbs" value="{{ old('carbs', $masterMenu->carbs) }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ไขมัน (g)</label>
                                <input type="number" name="fat" value="{{ old('fat', $masterMenu->fat) }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ใยอาหาร (g)</label>
                                <input type="number" name="fiber" value="{{ old('fiber', $masterMenu->fiber) }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">โซเดียม (mg)</label>
                                <input type="number" name="sodium" value="{{ old('sodium', $masterMenu->sodium) }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">
                            </div>
                        </div>
                    </div>

                    <!-- Ingredients & Instructions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-list-check text-amber-500 mr-2"></i>ส่วนผสมและวิธีทำ
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ส่วนผสม</label>
                                <textarea name="ingredients" rows="4"
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">{{ old('ingredients', $masterMenu->ingredients) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">วิธีทำ</label>
                                <textarea name="instructions" rows="5"
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">{{ old('instructions', $masterMenu->instructions) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ====== Right Column ====== -->
                <div class="space-y-6">

                    <!-- Image Upload Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-camera text-purple-500 mr-2"></i>รูปภาพ
                        </h3>
                        <div x-data="{ preview: {{ $masterMenu->image_path ? "'" . Storage::url($masterMenu->image_path) . "'" : 'null' }}, fileName: '', removeImage: false }" class="space-y-3">
                            <!-- Current Image -->
                            @if($masterMenu->image_path)
                                <div x-show="!removeImage && !preview?.startsWith('data:')">
                                    <img src="{{ Storage::url($masterMenu->image_path) }}"
                                         class="w-full h-40 object-cover rounded-lg border border-gray-200 mb-3">
                                    <button type="button" @click="removeImage = true"
                                            class="text-sm text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash-can mr-1"></i>ลบรูปภาพนี้
                                    </button>
                                </div>
                            @endif

                            <!-- Upload New Image -->
                            <div @click="$refs.fileInput.click()"
                                 class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center cursor-pointer hover:border-nature-400 hover:bg-nature-50/30 transition"
                                 @dragover.prevent="($el.classList.add('border-nature-400','bg-nature-50/30'))"
                                 @dragleave.prevent="($el.classList.remove('border-nature-400','bg-nature-50/30'))"
                                 @drop.prevent="
                                     $el.classList.remove('border-nature-400','bg-nature-50/30');
                                     const file = $event.dataTransfer.files[0];
                                     if (file && file.type.startsWith('image/')) {
                                         $refs.fileInput.files = $event.dataTransfer.files;
                                         const reader = new FileReader();
                                         reader.onload = (e) => { preview = e.target.result; fileName = file.name; removeImage = false; };
                                         reader.readAsDataURL(file);
                                     }
                                 ">
                                <div x-show="!preview || preview?.startsWith('/')">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-300 mb-1"></i>
                                    <p class="text-xs text-gray-500">อัปโหลดรูปใหม่</p>
                                </div>
                                <div x-show="preview && preview?.startsWith('data:')" x-cloak>
                                    <img :src="preview" class="w-full h-32 object-cover rounded-lg">
                                </div>
                                <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                                       x-ref="fileInput" class="hidden"
                                       @change="
                                           const file = $event.target.files[0];
                                           if (file) {
                                               const reader = new FileReader();
                                               reader.onload = (e) => { preview = e.target.result; fileName = file.name; removeImage = false; };
                                               reader.readAsDataURL(file);
                                           }
                                       ">
                            </div>
                            <p x-show="fileName" x-cloak class="text-xs text-gray-500 truncate">
                                <i class="fa-solid fa-paperclip mr-1"></i><span x-text="fileName"></span>
                            </p>

                            <!-- Hidden field for remove_image -->
                            <input type="hidden" name="remove_image" :value="removeImage ? '1' : '0'">
                        </div>
                    </div>

                    <!-- Suitable Conditions Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-heart-pulse text-red-500 mr-2"></i>เหมาะสำหรับโรค
                        </h3>
                        <div class="space-y-2">
                            @foreach($conditions as $key => $label)
                                <label class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                    <input type="checkbox" name="suitable_for[]" value="{{ $key }}"
                                           {{ in_array($key, old('suitable_for', $masterMenu->suitable_for ?? [])) ? 'checked' : '' }}
                                           class="w-4 h-4 text-nature-600 border-gray-300 rounded focus:ring-nature-300">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tags Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-tags text-teal-500 mr-2"></i>แท็ก
                        </h3>
                        <input type="text" name="tags" value="{{ old('tags', $masterMenu->tags ? implode(',', $masterMenu->tags) : '') }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300"
                               placeholder="คั่นด้วยคอมม่า">
                    </div>

                    <!-- Settings Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-gear text-gray-500 mr-2"></i>ตั้งค่า
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">เปิดใช้งาน</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                           {{ old('is_active', $masterMenu->is_active) ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-nature-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-nature-600"></div>
                                </label>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ลำดับการแสดงผล</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', $masterMenu->sort_order) }}"
                                       min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====== Action Buttons ====== -->
            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.master-menus.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                    ยกเลิก
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-nature-600 text-white rounded-lg hover:bg-nature-700 transition text-sm font-medium shadow-sm">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>บันทึกการแก้ไข
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function menuEditForm() {
            return {};
        }
    </script>
    @endpush
</x-app-layout>
