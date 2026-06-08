<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.exercise-libraries.index') }}"
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-eye mr-2 text-nature-600"></i>{{ $exerciseLibrary->name }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">รายละเอียดท่าบริหารในคลังวัสดุ</p>
            </div>
            <a href="{{ route('admin.exercise-libraries.edit', $exerciseLibrary) }}"
               class="inline-flex items-center px-4 py-2.5 bg-nature-600 text-white rounded-lg hover:bg-nature-700 transition shadow-sm text-sm font-medium">
                <i class="fa-solid fa-pen-to-square mr-2"></i>แก้ไข
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- ====== Left Column ====== -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Hero Thumbnail + Name -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    @if($exerciseLibrary->video_url)
                        <div class="aspect-video bg-gray-900">
                            <iframe src="{{ $exerciseLibrary->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @elseif($exerciseLibrary->thumbnail_path)
                        <img src="{{ Storage::url($exerciseLibrary->thumbnail_path) }}"
                             alt="{{ $exerciseLibrary->name }}"
                             class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-ncdblue-50 to-nature-100 flex items-center justify-center">
                            <i class="fa-solid fa-dumbbell text-6xl text-nature-200"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <h3 class="text-2xl font-bold text-gray-800">{{ $exerciseLibrary->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $exerciseLibrary->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $exerciseLibrary->is_active ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-nature-50 text-nature-700">
                                <i class="fa-solid fa-folder mr-1"></i>{{ $categories[$exerciseLibrary->category] ?? $exerciseLibrary->category }}
                            </span>
                            @if($exerciseLibrary->difficulty_level)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $exerciseLibrary->difficulty_level === 'easy' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $exerciseLibrary->difficulty_level === 'medium' ? 'bg-amber-50 text-amber-700' : '' }}
                                    {{ $exerciseLibrary->difficulty_level === 'hard' ? 'bg-red-50 text-red-700' : '' }}
                                ">
                                    <i class="fa-solid fa-signal mr-1"></i>{{ $difficulties[$exerciseLibrary->difficulty_level] ?? $exerciseLibrary->difficulty_level }}
                                </span>
                            @endif
                            @if($exerciseLibrary->duration_minutes)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700">
                                    <i class="fa-solid fa-clock mr-1"></i>{{ $exerciseLibrary->duration_minutes }} นาที
                                </span>
                            @endif
                            @if($exerciseLibrary->calories_burned)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700">
                                    <i class="fa-solid fa-fire mr-1"></i>{{ number_format($exerciseLibrary->calories_burned, 0) }} kcal
                                </span>
                            @endif
                        </div>
                        @if($exerciseLibrary->description)
                            <p class="text-gray-600 whitespace-pre-line">{{ $exerciseLibrary->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Instructions & Precautions -->
                <div class="grid grid-cols-1 gap-6">
                    @if($exerciseLibrary->instructions)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fa-solid fa-list-ol text-nature-500 mr-2"></i>วิธีทำท่าบริหาร
                            </h3>
                            <div class="text-sm text-gray-600 whitespace-pre-line">{{ $exerciseLibrary->instructions }}</div>
                        </div>
                    @endif
                    @if($exerciseLibrary->precautions)
                        <div class="bg-amber-50 rounded-xl border border-amber-200 p-6">
                            <h3 class="text-lg font-semibold text-amber-800 mb-3 flex items-center">
                                <i class="fa-solid fa-triangle-exclamation text-amber-500 mr-2"></i>ข้อควรระวัง
                            </h3>
                            <div class="text-sm text-amber-700 whitespace-pre-line">{{ $exerciseLibrary->precautions }}</div>
                        </div>
                    @endif
                </div>

                <!-- Local Video -->
                @if($exerciseLibrary->video_path && !$exerciseLibrary->video_url)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fa-solid fa-file-video text-indigo-500 mr-2"></i>ไฟล์วิดีโอ
                        </h3>
                        <video controls class="w-full rounded-lg">
                            <source src="{{ Storage::url($exerciseLibrary->video_path) }}" type="video/mp4">
                        </video>
                    </div>
                @endif
            </div>

            <!-- ====== Right Column ====== -->
            <div class="space-y-6">

                <!-- Suitable Conditions -->
                @if($exerciseLibrary->suitable_for && count($exerciseLibrary->suitable_for) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fa-solid fa-heart-pulse text-red-500 mr-2"></i>เหมาะสำหรับโรค
                        </h3>
                        <div class="space-y-2">
                            @foreach($exerciseLibrary->suitable_for as $condition)
                                <div class="flex items-center gap-2 p-2 bg-red-50 rounded-lg">
                                    <i class="fa-solid fa-check-circle text-red-400 text-sm"></i>
                                    <span class="text-sm text-gray-700">{{ $conditions[$condition] ?? $condition }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tags -->
                @if($exerciseLibrary->tags && count($exerciseLibrary->tags) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fa-solid fa-tags text-teal-500 mr-2"></i>แท็ก
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($exerciseLibrary->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 bg-teal-50 text-teal-700 rounded-full text-xs font-medium">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Audit Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fa-solid fa-clock-rotate-left text-gray-500 mr-2"></i>ข้อมูลระบบ
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">สร้างโดย</span>
                            <span class="text-gray-800 font-medium">{{ $exerciseLibrary->creator?->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">วันที่สร้าง</span>
                            <span class="text-gray-800">{{ $exerciseLibrary->created_at?->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">แก้ไขล่าสุดโดย</span>
                            <span class="text-gray-800 font-medium">{{ $exerciseLibrary->updater?->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">วันที่แก้ไข</span>
                            <span class="text-gray-800">{{ $exerciseLibrary->updated_at?->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">ลำดับแสดงผล</span>
                            <span class="text-gray-800">{{ $exerciseLibrary->sort_order }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">ID</span>
                            <span class="text-gray-400 text-xs font-mono">{{ $exerciseLibrary->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
