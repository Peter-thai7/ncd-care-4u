<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master-menus.index') }}"
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-plus mr-2 text-blue-600"></i>เพิ่มเมนูอาหารใหม่
                </h2>
                <p class="text-sm text-gray-500 mt-1">เพิ่มเมนูเข้าคลังวัสดุเพื่อให้นักโภชนาการสามารถเลือกสั่งจ่ายให้คนไข้</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <form method="POST" action="{{ route('admin.master-menus.store') }}" enctype="multipart/form-data"
              x-data="menuForm()">
            @csrf

            <!-- ====== Flash / Error ====== -->
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
                            <i class="fa-solid fa-info-circle text-blue-500 mr-2"></i>ข้อมูลพื้นฐาน
                        </h3>
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อเมนู <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="เช่น สลัดไก่นึ่งสมุนไพร" required>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">รายละเอียด</label>
                                <textarea name="description" rows="3"
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="รายละเอียดเกี่ยวกับเมนูนี้...">{{ old('description') }}</textarea>
                            </div>

                            <!-- Category + Difficulty -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">หมวดหมู่ <span class="text-red-500">*</span></label>
                                    <select name="category" required
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="">-- เลือกหมวดหมู่ --</option>
                                        @foreach($categories as $key => $label)
                                            <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ระดับความยาก</label>
                                    <select name="difficulty_level"
                                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="">-- เลือก --</option>
                                        @foreach($difficulties as $key => $label)
                                            <option value="{{ $key }}" {{ old('difficulty_level') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Serving + Prep Time -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ขนาดเสิร์ฟ</label>
                                    <input type="text" name="serving_size" value="{{ old('serving_size') }}"
                                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                           placeholder="เช่น 1 จาน, 200 กรัม">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">เวลาเตรียม (นาที)</label>
                                    <input type="number" name="preparation_time" value="{{ old('preparation_time') }}"
                                           min="0" max="999"
                                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                           placeholder="เช่น 15">
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
                                <input type="number" name="calories" value="{{ old('calories') }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                       placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">โปรตีน (g)</label>
                                <input type="number" name="protein" value="{{ old('protein') }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                       placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">คาร์โบไฮเดรต (g)</label>
                                <input type="number" name="carbs" value="{{ old('carbs') }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                       placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ไขมัน (g)</label>
                                <input type="number" name="fat" value="{{ old('fat') }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                       placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ใยอาหาร (g)</label>
                                <input type="number" name="fiber" value="{{ old('fiber') }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                       placeholder="0">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">โซเดียม (mg)</label>
                                <input type="number" name="sodium" value="{{ old('sodium') }}"
                                       step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                       placeholder="0">
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
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                          placeholder="ระบุส่วนผสมแต่ละรายการ ต่อบรรทัด&#10;เช่น:&#10;อกไก่ 200 กรัม&#10;ผักบุ้ง 100 กรัม">{{ old('ingredients') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">วิธีทำ</label>
                                <textarea name="instructions" rows="5"
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                          placeholder="อธิบายขั้นตอนการทำ&#10;1. ...&#10;2. ...">{{ old('instructions') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ====== Right Column: Image + Conditions + Tags ====== -->
                <div class="space-y-6">

                    <!-- Image Upload Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-camera text-purple-500 mr-2"></i>รูปภาพ
                        </h3>
                        <div x-data="{ preview: null, fileName: '' }" class="space-y-3">
                            <div @click="$refs.fileInput.click()"
                                 class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition"
                                 @dragover.prevent="($el.classList.add('border-blue-400','bg-blue-50/30'))"
                                 @dragleave.prevent="($el.classList.remove('border-blue-400','bg-blue-50/30'))"
                                 @drop.prevent="
                                     $el.classList.remove('border-blue-400','bg-blue-50/30');
                                     const file = $event.dataTransfer.files[0];
                                     if (file && file.type.startsWith('image/')) {
                                         $refs.fileInput.files = $event.dataTransfer.files;
                                         const reader = new FileReader();
                                         reader.onload = (e) => { preview = e.target.result; fileName = file.name; };
                                         reader.readAsDataURL(file);
                                     }
                                 ">
                                <div x-show="!preview">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 mb-2"></i>
                                    <p class="text-sm text-gray-500">คลิกหรือลากไฟล์มาวาง</p>
                                    <p class="text-xs text-gray-400 mt-1">JPEG, PNG, WebP (ไม่เกิน 2MB)</p>
                                </div>
                                <div x-show="preview" x-cloak>
                                    <img :src="preview" class="w-full h-40 object-cover rounded-lg">
                                </div>
                                <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                                       x-ref="fileInput" class="hidden"
                                       @change="
                                           const file = $event.target.files[0];
                                           if (file) {
                                               const reader = new FileReader();
                                               reader.onload = (e) => { preview = e.target.result; fileName = file.name; };
                                               reader.readAsDataURL(file);
                                           }
                                       ">
                            </div>
                            <p x-show="fileName" x-cloak class="text-xs text-gray-500 truncate">
                                <i class="fa-solid fa-paperclip mr-1"></i><span x-text="fileName"></span>
                            </p>
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
                                           {{ in_array($key, old('suitable_for', [])) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tags Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-tags text-teal-500 mr-2"></i>แท็ก (สำหรับค้นหา)
                        </h3>
                        <input type="text" name="tags" value="{{ old('tags') ? implode(',', old('tags')) : '' }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                               placeholder="คั่นด้วยคอมม่า เช่น ลดน้ำหนัก, มังสวิรัติ">
                        <p class="text-xs text-gray-400 mt-1">ใส่แท็กคั่นด้วยคอมม่า</p>
                    </div>

                    <!-- Settings Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-gear text-gray-500 mr-2"></i>ตั้งค่า
                        </h3>
                        <div class="space-y-4">
                            <!-- Active Toggle -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">เปิดใช้งาน</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <!-- Sort Order -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ลำดับการแสดงผล</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                                       min="0"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
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
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow-sm">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>บันทึกเมนู
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function menuForm() {
            return {};
        }
    </script>
    @endpush
</x-app-layout>
