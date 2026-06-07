<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master-menus.index') }}"
               class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-eye mr-2 text-blue-600"></i>{{ $masterMenu->name }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">รายละเอียดเมนูอาหารในคลังวัสดุ</p>
            </div>
            <a href="{{ route('admin.master-menus.edit', $masterMenu) }}"
               class="inline-flex items-center px-4 py-2.5 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition shadow-sm text-sm font-medium">
                <i class="fa-solid fa-pen-to-square mr-2"></i>แก้ไข
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- ====== Left Column: Details ====== -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Hero Image + Name -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    @if($masterMenu->image_path)
                        <img src="{{ Storage::url($masterMenu->image_path) }}"
                             alt="{{ $masterMenu->name }}"
                             class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                            <i class="fa-solid fa-utensils text-6xl text-blue-200"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <h3 class="text-2xl font-bold text-gray-800">{{ $masterMenu->name }}</h3>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $masterMenu->is_active ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $masterMenu->is_active ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                <i class="fa-solid fa-folder mr-1"></i>{{ $categories[$masterMenu->category] ?? $masterMenu->category }}
                            </span>
                            @if($masterMenu->difficulty_level)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                    <i class="fa-solid fa-signal mr-1"></i>{{ $difficulties[$masterMenu->difficulty_level] ?? $masterMenu->difficulty_level }}
                                </span>
                            @endif
                            @if($masterMenu->preparation_time)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700">
                                    <i class="fa-solid fa-clock mr-1"></i>{{ $masterMenu->preparation_time }} นาที
                                </span>
                            @endif
                            @if($masterMenu->serving_size)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-teal-50 text-teal-700">
                                    <i class="fa-solid fa-bowl-food mr-1"></i>{{ $masterMenu->serving_size }}
                                </span>
                            @endif
                        </div>
                        @if($masterMenu->description)
                            <p class="text-gray-600 whitespace-pre-line">{{ $masterMenu->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Nutrition Detail -->
                @if($masterMenu->calories || $masterMenu->protein || $masterMenu->carbs || $masterMenu->fat)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fa-solid fa-chart-pie text-green-500 mr-2"></i>ข้อมูลโภชนาการ
                        </h3>
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-4">
                            <div class="text-center p-3 bg-blue-50 rounded-xl">
                                <p class="text-2xl font-bold text-blue-600">{{ number_format($masterMenu->calories, 0) }}</p>
                                <p class="text-xs text-gray-500">แคลอรี่</p>
                                <p class="text-xs text-gray-400">kcal</p>
                            </div>
                            <div class="text-center p-3 bg-red-50 rounded-xl">
                                <p class="text-2xl font-bold text-red-600">{{ number_format($masterMenu->protein, 1) }}</p>
                                <p class="text-xs text-gray-500">โปรตีน</p>
                                <p class="text-xs text-gray-400">กรัม</p>
                            </div>
                            <div class="text-center p-3 bg-amber-50 rounded-xl">
                                <p class="text-2xl font-bold text-amber-600">{{ number_format($masterMenu->carbs, 1) }}</p>
                                <p class="text-xs text-gray-500">คาร์โบฯ</p>
                                <p class="text-xs text-gray-400">กรัม</p>
                            </div>
                            <div class="text-center p-3 bg-yellow-50 rounded-xl">
                                <p class="text-2xl font-bold text-yellow-600">{{ number_format($masterMenu->fat, 1) }}</p>
                                <p class="text-xs text-gray-500">ไขมัน</p>
                                <p class="text-xs text-gray-400">กรัม</p>
                            </div>
                            <div class="text-center p-3 bg-green-50 rounded-xl">
                                <p class="text-2xl font-bold text-green-600">{{ number_format($masterMenu->fiber, 1) }}</p>
                                <p class="text-xs text-gray-500">ใยอาหาร</p>
                                <p class="text-xs text-gray-400">กรัม</p>
                            </div>
                            <div class="text-center p-3 bg-purple-50 rounded-xl">
                                <p class="text-2xl font-bold text-purple-600">{{ number_format($masterMenu->sodium, 1) }}</p>
                                <p class="text-xs text-gray-500">โซเดียม</p>
                                <p class="text-xs text-gray-400">มก.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Ingredients & Instructions -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @if($masterMenu->ingredients)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fa-solid fa-carrot text-orange-500 mr-2"></i>ส่วนผสม
                            </h3>
                            <div class="text-sm text-gray-600 whitespace-pre-line">{{ $masterMenu->ingredients }}</div>
                        </div>
                    @endif
                    @if($masterMenu->instructions)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fa-solid fa-list-ol text-blue-500 mr-2"></i>วิธีทำ
                            </h3>
                            <div class="text-sm text-gray-600 whitespace-pre-line">{{ $masterMenu->instructions }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ====== Right Column ====== -->
            <div class="space-y-6">

                <!-- Suitable Conditions -->
                @if($masterMenu->suitable_for && count($masterMenu->suitable_for) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fa-solid fa-heart-pulse text-red-500 mr-2"></i>เหมาะสำหรับโรค
                        </h3>
                        <div class="space-y-2">
                            @foreach($masterMenu->suitable_for as $condition)
                                <div class="flex items-center gap-2 p-2 bg-red-50 rounded-lg">
                                    <i class="fa-solid fa-check-circle text-red-400 text-sm"></i>
                                    <span class="text-sm text-gray-700">{{ $conditions[$condition] ?? $condition }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tags -->
                @if($masterMenu->tags && count($masterMenu->tags) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fa-solid fa-tags text-teal-500 mr-2"></i>แท็ก
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($masterMenu->tags as $tag)
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
                            <span class="text-gray-800 font-medium">{{ $masterMenu->creator?->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">วันที่สร้าง</span>
                            <span class="text-gray-800">{{ $masterMenu->created_at?->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">แก้ไขล่าสุดโดย</span>
                            <span class="text-gray-800 font-medium">{{ $masterMenu->updater?->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">วันที่แก้ไข</span>
                            <span class="text-gray-800">{{ $masterMenu->updated_at?->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">ลำดับแสดงผล</span>
                            <span class="text-gray-800">{{ $masterMenu->sort_order }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">ID</span>
                            <span class="text-gray-400 text-xs font-mono">{{ $masterMenu->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
