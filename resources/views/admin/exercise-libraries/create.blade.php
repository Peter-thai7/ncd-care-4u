<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.exercise-libraries.index') }}"
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-plus mr-2 text-blue-600"></i>เพิ่มท่ากายบริหารใหม่
                </h2>
                <p class="text-sm text-gray-500 mt-1">เพิ่มท่ากายบริหารเข้าคลังวัสดุเพื่อให้นักกายภาพฯ สามารถเลือกสั่งจ่ายให้คนไข้</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <form method="POST" action="{{ route('admin.exercise-libraries.store') }}" enctype="multipart/form-data">
            @csrf

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
                <!-- ====== Left Column ====== -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Basic Info Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-info-circle text-blue-500 mr-2"></i>ข้อมูลพื้นฐาน
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ชื่อท่ากายบริหาร <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                       placeholder="เช่น ท่ายืดกล้ามเนื้อต้นขา" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">รายละเอียด</label>
                                <textarea name="description" rows="3"
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                          placeholder="อธิบายรายละเอียดของท่ากายบริหาร...">{{ old('description') }}</textarea>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ระยะเวลา (นาที)</label>
                                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}"
                                           min="1" max="999"
                                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                           placeholder="เช่น 15">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">แคลอรี่ที่เผาผลาญ (kcal)</label>
                                    <input type="number" name="calories_burned" value="{{ old('calories_burned') }}"
                                           step="0.01" min="0"
                                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                           placeholder="เช่น 120">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions & Precautions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-list-check text-amber-500 mr-2"></i>วิธีทำและข้อควรระวัง
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">วิธีทำท่ากายบริหาร</label>
                                <textarea name="instructions" rows="5"
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                          placeholder="อธิบายขั้นตอนการทำท่ากายบริหาร&#10;1. ...&#10;2. ...">{{ old('instructions') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>ข้อควรระวัง
                                </label>
                                <textarea name="precautions" rows="3"
                                          class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 bg-amber-50/30"
                                          placeholder="ระบุข้อควรระวัง เช่น ห้ามทำหากมีอาการปวดข้อรุนแรง">{{ old('precautions') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ====== Right Column ====== -->
                <div class="space-y-6">

                    <!-- Video Section with Live Preview -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6"
                         x-data="{
                             videoUrl: '',
                             uploadedVideoUrl: '',

                             detectVideoType(url) {
                                 url = (url || '').trim();
                                 if (!url) return '';
                                 if (/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)/i.test(url)) return 'youtube';
                                 if (/youtube\.com\/shorts\//i.test(url)) return 'youtube_shorts';
                                 if (/facebook\.com\/.*\/videos\//i.test(url)) return 'facebook';
                                 if (/\.mp4(\?|$)/i.test(url)) return 'mp4_url';
                                 return 'other';
                             },

                             getEmbedUrl(url) {
                                 url = (url || '').trim();
                                 const type = this.detectVideoType(url);
                                 if (type === 'youtube' || type === 'youtube_shorts') {
                                     let videoId = null, m;
                                     if (m = url.match(/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/i)) videoId = m[1];
                                     else if (m = url.match(/youtu\.be\/([a-zA-Z0-9_-]{11})/i)) videoId = m[1];
                                     else if (m = url.match(/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/i)) videoId = m[1];
                                     else if (m = url.match(/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/i)) videoId = m[1];
                                     if (videoId) return 'https://www.youtube.com/embed/' + videoId + '?rel=0';
                                 }
                                 if (type === 'facebook') {
                                     return 'https://www.facebook.com/plugins/video.php?href=' + encodeURIComponent(url) + '&show_text=false';
                                 }
                                 return url;
                             },

                             get currentType() { return this.detectVideoType(this.videoUrl); },
                             get currentEmbedUrl() { return this.getEmbedUrl(this.videoUrl); },
                             get hasUrlPreview() { return this.videoUrl.trim().length > 5 && this.currentType !== ''; },

                             handleVideoFile(event) {
                                 const file = event.target.files[0];
                                 if (file) {
                                     this.uploadedVideoUrl = URL.createObjectURL(file);
                                     this.videoUrl = '';
                                 }
                             }
                         }">

                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-video text-indigo-500 mr-2"></i>วิดีโอสาธิต
                        </h3>

                        <div class="space-y-4">
                            <!-- YouTube / Shorts Preview -->
                            <div x-show="hasUrlPreview && !uploadedVideoUrl && (currentType === 'youtube' || currentType === 'youtube_shorts')" x-transition
                                 class="aspect-video bg-gray-900 rounded-lg overflow-hidden">
                                <iframe :src="(currentType === 'youtube' || currentType === 'youtube_shorts') ? currentEmbedUrl : ''"
                                        class="w-full h-full" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            </div>

                            <!-- Facebook Preview -->
                            <div x-show="hasUrlPreview && !uploadedVideoUrl && currentType === 'facebook'" x-transition
                                 class="aspect-video bg-gray-900 rounded-lg overflow-hidden">
                                <iframe :src="currentType === 'facebook' ? currentEmbedUrl : ''"
                                        class="w-full h-full" frameborder="0"
                                        allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>

                            <!-- MP4 URL Preview -->
                            <div x-show="hasUrlPreview && !uploadedVideoUrl && currentType === 'mp4_url'" x-transition
                                 class="aspect-video bg-gray-900 rounded-lg overflow-hidden">
                                <video controls class="w-full h-full" preload="metadata">
                                    <source :src="currentType === 'mp4_url' ? videoUrl : ''" type="video/mp4">
                                </video>
                            </div>

                            <!-- Other URL Preview -->
                            <div x-show="hasUrlPreview && !uploadedVideoUrl && currentType === 'other'" x-transition
                                 class="aspect-video bg-gray-800 rounded-lg overflow-hidden flex items-center justify-center">
                                <a :href="videoUrl" target="_blank" class="text-blue-400 hover:underline text-sm">
                                    <i class="fa-solid fa-external-link mr-1"></i>เปิดลิงก์วิดีโอ
                                </a>
                            </div>

                            <!-- Uploaded Video Preview -->
                            <div x-show="uploadedVideoUrl" x-transition
                                 class="aspect-video bg-gray-900 rounded-lg overflow-hidden">
                                <video controls class="w-full h-full" preload="metadata">
                                    <source :src="uploadedVideoUrl" type="video/mp4">
                                </video>
                            </div>

                            <!-- URL Input -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">URL วิดีโอ</label>
                                <input type="url" name="video_url" x-model="videoUrl"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                       placeholder="https://www.youtube.com/watch?v=...">
                                <p class="text-xs text-gray-400 mt-1">
                                    รองรับ YouTube, YouTube Shorts, Facebook Video, ลิงก์ MP4
                                </p>
                            </div>

                            <!-- Or separator -->
                            <div class="relative flex items-center justify-center">
                                <span class="text-xs text-gray-400 bg-white px-2">หรือ</span>
                                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                            </div>

                            <!-- File Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">อัปโหลดไฟล์วิดีโอ</label>
                                <input type="file" name="video_file" accept="video/mp4,video/webm"
                                       @change="handleVideoFile($event)"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="text-xs text-gray-400 mt-1">MP4, WebM (ไม่เกิน 50MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail Upload -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-image text-purple-500 mr-2"></i>ภาพปก
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
                                <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp"
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

                    <!-- Suitable Conditions -->
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

                    <!-- Tags + Settings -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fa-solid fa-tags text-teal-500 mr-1"></i>แท็ก
                                </label>
                                <input type="text" name="tags" value="{{ old('tags') ? implode(',', old('tags')) : '' }}"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500"
                                       placeholder="คั่นด้วยคอมม่า เช่น ลดน้ำหนัก, กายภาพ">
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">เปิดใช้งาน</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ลำดับการแสดงผล</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                                       min="0" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.exercise-libraries.index') }}"
                   class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                    ยกเลิก
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium shadow-sm">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>บันทึกท่ากายบริหาร
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
