<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-dumbbell mr-2 text-blue-600"></i>คลังท่ากายบริหาร
                </h2>
                <p class="text-sm text-gray-500 mt-1">จัดการท่ากายบริหารสำหรับสั่งจ่ายให้คนไข้ (Library System)</p>
            </div>
            <a href="{{ route('admin.exercise-libraries.create') }}"
               class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm text-sm font-medium">
                <i class="fa-solid fa-plus mr-2"></i>เพิ่มท่ากายบริหารใหม่
            </a>
        </div>
    </x-slot>

    <div x-data="trashManager()" class="py-6">
        <!-- ====== Filter Bar ====== -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form method="GET" action="{{ route('admin.exercise-libraries.index') }}" class="flex flex-col lg:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="ค้นหาชื่อท่ากายบริหาร, รายละเอียด..."
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <select name="category" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 bg-white min-w-[160px]">
                    <option value="">ทุกหมวดหมู่</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="difficulty_level" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 bg-white min-w-[140px]">
                    <option value="">ทุกระดับ</option>
                    @foreach($difficulties as $key => $label)
                        <option value="{{ $key }}" {{ request('difficulty_level') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="suitable_for" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 bg-white min-w-[160px]">
                    <option value="">ทุกโรค</option>
                    @foreach($conditions as $key => $label)
                        <option value="{{ $key }}" {{ request('suitable_for') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="is_active" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 bg-white min-w-[130px]">
                    <option value="">ทุกสถานะ</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>เปิดใช้งาน</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>ปิดใช้งาน</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                    <i class="fa-solid fa-filter mr-1"></i>ค้นหา
                </button>
                <a href="{{ route('admin.exercise-libraries.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition text-center">
                    ล้าง
                </a>
            </form>
        </div>

        <!-- ====== Stats Summary ====== -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-dumbbell text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">ท่ากายบริหารทั้งหมด</p>
                        <p class="text-xl font-bold text-gray-800">{{ \App\Models\ExerciseLibrary::count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">เปิดใช้งาน</p>
                        <p id="active-count" class="text-xl font-bold text-green-600">{{ \App\Models\ExerciseLibrary::where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">ปิดใช้งาน</p>
                        <p id="inactive-count" class="text-xl font-bold text-red-500">{{ \App\Models\ExerciseLibrary::where('is_active', false)->count() }}</p>
                    </div>
                </div>
            </div>
            <div @click="openTrashModal()"
                 class="cursor-pointer bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md hover:border-amber-200 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-trash-can text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">ถูกลบ (Soft)</p>
                        <p class="text-xl font-bold text-amber-600">{{ \App\Models\ExerciseLibrary::onlyTrashed()->count() }}</p>
                    </div>
                </div>
                <p class="text-[10px] text-amber-400 mt-1 text-right">คลิกเพื่อดู / กู้คืน / ลบถาวร</p>
            </div>
        </div>

        <!-- ====== Flash Message ====== -->
        @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                 x-transition class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                <span><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-500 hover:text-green-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <!-- ====== Data Table ====== -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if($exercises->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="text-left px-4 py-3 font-semibold text-gray-600 w-16">#</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">ภาพปก</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">ชื่อท่ากายบริหาร</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">หมวดหมู่</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">ระยะเวลา</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">ระดับ</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">โรคที่เหมาะสม</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-600">สถานะ</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-600 w-44">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exercises as $index => $exercise)
                                <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition">
                                    <td class="px-4 py-3 text-gray-500">{{ $exercises->firstItem() + $index }}</td>
                                    <td class="px-4 py-3">
                                        @if($exercise->thumbnail_path)
                                            <img src="{{ Storage::url($exercise->thumbnail_path) }}"
                                                 alt="{{ $exercise->name }}"
                                                 style="width:3rem;height:3rem;object-fit:contain;border-radius:0.5rem;border:1px solid #e5e7eb;background:#f9fafb;">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center">
                                                <i class="fa-solid fa-dumbbell text-blue-300"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-800">{{ $exercise->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($exercise->description, 50) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                            {{ $categories[$exercise->category] ?? $exercise->category }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($exercise->duration_minutes)
                                            <span class="text-gray-700">{{ $exercise->duration_minutes }}</span>
                                            <span class="text-xs text-gray-400">นาที</span>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($exercise->difficulty_level)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                                {{ $exercise->difficulty_level === 'easy' ? 'bg-green-50 text-green-700' : '' }}
                                                {{ $exercise->difficulty_level === 'medium' ? 'bg-amber-50 text-amber-700' : '' }}
                                                {{ $exercise->difficulty_level === 'hard' ? 'bg-red-50 text-red-700' : '' }}
                                            ">
                                                {{ $difficulties[$exercise->difficulty_level] ?? $exercise->difficulty_level }}
                                            </span>
                                        @else
                                            <span class="text-gray-300 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($exercise->suitable_for && count($exercise->suitable_for) > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(array_slice($exercise->suitable_for, 0, 2) as $condition)
                                                    <span class="inline-block px-2 py-0.5 bg-red-50 text-red-600 rounded text-xs">
                                                        {{ $conditions[$condition] ?? $condition }}
                                                    </span>
                                                @endforeach
                                                @if(count($exercise->suitable_for) > 2)
                                                    <span class="inline-block px-2 py-0.5 bg-gray-50 text-gray-500 rounded text-xs">
                                                        +{{ count($exercise->suitable_for) - 2 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-300 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button"
                                                @click="toggleActive('{{ route('admin.exercise-libraries.toggle-active', $exercise) }}', $event.currentTarget)"
                                                class="relative inline-flex items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                                style="height:1rem;width:1.75rem;background-color:{{ $exercise->is_active ? '#2563eb' : '#d1d5db' }};">
                                            <span class="inline-block rounded-full bg-white transition-transform shadow-sm" style="height:0.75rem;width:0.75rem;transform:translateX({{ $exercise->is_active ? '14px' : '2px' }});"></span>
                                        </button>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('admin.exercise-libraries.show', $exercise) }}"
                                               class="p-2 rounded-lg transition" style="color:#10b981;" onmouseover="this.style.color='#059669';this.style.backgroundColor='#ecfdf5';" onmouseout="this.style.color='#10b981';this.style.backgroundColor='transparent';" title="ดู">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.exercise-libraries.edit', $exercise) }}"
                                               class="p-2 rounded-lg transition" style="color:#f97316;" onmouseover="this.style.color='#ea580c';this.style.backgroundColor='#fff7ed';" onmouseout="this.style.color='#f97316';this.style.backgroundColor='transparent';" title="แก้ไข">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button"
                                                    class="p-2 rounded-lg transition"
                                                    style="color:#ef4444;"
                                                    onmouseover="this.style.backgroundColor='#fef2f2';"
                                                    onmouseout="this.style.backgroundColor='transparent';"
                                                    title="ลบ"
                                                    @click="openDeleteModal({{ $exercise->id }}, {{ json_encode($exercise->name, JSON_UNESCAPED_UNICODE) }})">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/50">
                    {{ $exercises->withQueryString()->links() }}
                </div>
            @else
                <div class="py-16 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-dumbbell text-3xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-500 mb-1">ยังไม่มีท่ากายบริหารในคลัง</h3>
                    <p class="text-sm text-gray-400 mb-4">เริ่มต้นเพิ่มท่ากายบริหารเพื่อให้นักกายภาพฯ สามารถสั่งจ่ายให้คนไข้ได้</p>
                    <a href="{{ route('admin.exercise-libraries.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                        <i class="fa-solid fa-plus mr-2"></i>เพิ่มท่ากายบริหารแรก
                    </a>
                </div>
            @endif
        </div>

        <!-- ==================== TRASH MODAL ==================== -->
        <div x-show="showTrashModal"
             style="display:none; z-index:50;"
             class="fixed inset-0 overflow-y-auto">
            <div class="flex justify-center" style="align-items:flex-start;min-height:100vh;padding:15vh 1rem 5rem 1rem;">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50" @click="closeTrashModal()"></div>

                <div class="relative bg-white rounded-xl shadow-2xl" style="z-index:51;max-width:512px;width:100%;margin-left:auto;margin-right:auto;">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">
                            <i class="fa-solid fa-trash-can mr-2 text-amber-500"></i>รายการที่ถูกลบ (Soft Delete)
                        </h3>
                        <button @click="closeTrashModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <div class="p-4 max-h-96 overflow-y-auto">
                        <div x-show="loadingTrash" class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-spinner fa-spin text-3xl mb-3 block text-amber-400"></i>
                            กำลังโหลด...
                        </div>

                        <div x-show="!loadingTrash && trashedItems.length === 0" class="text-center py-8 text-gray-400">
                            <i class="fa-solid fa-box-open text-3xl mb-3 block"></i>
                            ไม่มีรายการที่ถูกลบ
                        </div>

                        <div x-show="!loadingTrash && trashedItems.length > 0">
                            <div class="flex items-center mb-3 pb-2 border-b">
                                <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                                    <input type="checkbox"
                                           :checked="selectedIds.length === trashedItems.length && trashedItems.length > 0"
                                           @change="toggleSelectAll()"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    เลือกทั้งหมด (<span x-text="trashedItems.length"></span> รายการ)
                                </label>
                            </div>

                            <template x-for="item in trashedItems" :key="item.id">
                                <div class="flex items-center gap-3 py-2.5 px-3 hover:bg-amber-50 rounded-lg transition">
                                    <input type="checkbox"
                                           :value="String(item.id)"
                                           x-model="selectedIds"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate" x-text="item.name"></p>
                                        <p class="text-xs text-gray-500">
                                            <span x-text="item.category"></span>
                                            <span class="mx-1">·</span>
                                            ลบเมื่อ <span x-text="item.deleted_at"></span>
                                        </p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div x-show="!loadingTrash && trashedItems.length > 0"
                         class="flex items-center justify-between p-4 border-t bg-gray-50" style="border-radius:0 0 0.75rem 0.75rem;">
                        <p class="text-sm text-gray-500">
                            เลือกแล้ว <span class="font-semibold text-amber-600" x-text="selectedIds.length"></span> รายการ
                        </p>
                        <div class="flex gap-2">
                            <button type="button" @click="restoreSelected()"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                                <i class="fa-solid fa-rotate-left mr-1"></i>กู้คืน
                            </button>
                            <button type="button" @click="askForceDelete()"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                <i class="fa-solid fa-fire mr-1"></i>ลบถาวร
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ==================== CONFIRM FORCE DELETE MODAL ==================== -->
        <div x-show="showConfirmModal"
             style="display:none; z-index:100;"
             class="fixed inset-0 overflow-y-auto">
            <div class="flex justify-center" style="align-items:flex-start;min-height:100vh;padding:15vh 1rem 1rem 1rem;">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-60" @click="showConfirmModal = false"></div>

                <div class="relative bg-white rounded-xl shadow-2xl" style="z-index:101;max-width:448px;width:100%;margin-left:auto;margin-right:auto;">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-triangle-exclamation text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">ยืนยันการลบถาวร</h3>
                                <p class="text-xs text-red-500 font-medium">การกระทำนี้ไม่สามารถย้อนกลับได้</p>
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 mb-3">
                            คุณต้องการลบถาวรรายการต่อไปนี้ใช่หรือไม่?
                        </p>

                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-5 max-h-40 overflow-y-auto">
                            <template x-for="item in itemsToDelete" :key="item.id">
                                <p class="text-sm text-red-800 py-0.5" x-text="'• ' + item.name"></p>
                            </template>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" @click="showConfirmModal = false"
                                    class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">
                                ไม่
                            </button>
                            <button type="button" @click="doForceDelete()"
                                    class="px-5 py-2.5 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                <i class="fa-solid fa-fire mr-1"></i>ใช่, ลบถาวร
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Delete Confirm Modal (Soft Delete) -->
                <div x-show="deleteModalOpen" x-cloak
                     style="position:fixed;inset:0;z-index:90;background:rgba(0,0,0,0.5);display:none;"
                     @click.self="closeDeleteModal()"
                     @keydown.escape.window="closeDeleteModal()">
                    <div class="bg-white rounded-xl shadow-2xl p-6"
                         style="position:absolute;top:15%;left:50%;transform:translate(-50%,0);width:90%;max-width:400px;display:flex;flex-direction:column;align-items:center;text-align:center;"
                         @click.outside="closeDeleteModal()">
                        <div style="width:3rem;height:3rem;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                            <i class="fa-solid fa-triangle-exclamation" style="color:#dc2626;font-size:1.25rem;"></i>
                        </div>
                        <h3 style="font-size:1.125rem;font-weight:600;color:#111827;margin-bottom:0.5rem;">ยืนยันการลบ</h3>
                        <p style="font-size:0.875rem;color:#4b5563;margin-bottom:0.25rem;">คุณต้องการลบ</p>
                        <p style="font-size:1rem;font-weight:600;color:#111827;margin-bottom:0.25rem;word-break:break-word;max-width:100%;">"<span x-text="deleteTargetName"></span>"</p>
                        <p style="font-size:0.875rem;color:#4b5563;margin-bottom:1.5rem;">ใช่ไหม?</p>
        
                        <div style="display:flex;gap:0.75rem;justify-content:center;margin-bottom:1rem;">
                            <button type="button" @click="closeDeleteModal()"
                                    style="padding:0.5rem 1rem;border-radius:0.5rem;border:1px solid #d1d5db;color:#374151;background:#ffffff;cursor:pointer;font-weight:500;"
                                    onmouseover="this.style.backgroundColor='#f9fafb';"
                                    onmouseout="this.style.backgroundColor='#ffffff';">
                                ยกเลิก
                            </button>
                            <button type="button" @click="confirmDelete()"
                                    style="padding:0.5rem 1rem;border-radius:0.5rem;background:#dc2626;color:#ffffff;cursor:pointer;font-weight:500;border:none;"
                                    onmouseover="this.style.backgroundColor='#b91c1c';"
                                    onmouseout="this.style.backgroundColor='#dc2626';">
                                <i class="fa-solid fa-trash-can" style="margin-right:0.25rem;"></i>ใช่ ยืนยัน
                            </button>
                        </div>
                        <p style="font-size:0.75rem;color:#9ca3af;margin-top:0;">
                            <i class="fa-solid fa-circle-info" style="margin-right:0.25rem;"></i>รายการจะถูกย้ายไป "ถูกลบ (Soft)" สามารถกู้คืนได้
                        </p>
                    </div>
                </div>
        </div>

    @push('scripts')

    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";
        function trashManager() {
            return {
                showTrashModal: false,
                showConfirmModal: false,
                deleteModalOpen: false,
                deleteTargetId: null,
                deleteTargetName: '',
                trashedItems: [],
                selectedIds: [],
                itemsToDelete: [],
                loadingTrash: false,

                openDeleteModal(id, name) {
                    console.log('[DEBUG] openDeleteModal:', id, name);
                    this.deleteTargetId = id;
                    this.deleteTargetName = name;
                    this.deleteModalOpen = true;
                },

                closeDeleteModal() {
                    console.log('[DEBUG] closeDeleteModal');
                    this.deleteModalOpen = false;
                    this.deleteTargetId = null;
                    this.deleteTargetName = '';
                },

                confirmDelete() {
                    console.log('[DEBUG] confirmDelete for id:', this.deleteTargetId);
                    if (!this.deleteTargetId) {
                        showToast('ไม่พบรายการที่จะลบ', 'error');
                        return;
                    }
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("admin.exercise-libraries.destroy", ":id") }}'.replace(':id', this.deleteTargetId);

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = CSRF_TOKEN;
                    form.appendChild(tokenInput);

                    document.body.appendChild(form);
                    this.deleteModalOpen = false;
                    form.submit();
                },

                openTrashModal() {
                    console.log('[DEBUG] openTrashModal called');
                    this.showTrashModal = true;
                    this.selectedIds = [];
                    this.loadTrashed();
                },

                closeTrashModal() {
                    console.log('[DEBUG] closeTrashModal called');
                    this.showTrashModal = false;
                },

                async loadTrashed() {
                    console.log('[DEBUG] loadTrashed start');
                    this.loadingTrash = true;
                    try {
                        const res = await fetch('{{ route("admin.exercise-libraries.trashed") }}');
                        console.log('[DEBUG] loadTrashed response status:', res.status);
                        const data = await res.json();
                        console.log('[DEBUG] loadTrashed data:', data);
                        this.trashedItems = Array.isArray(data) ? data : (data.items || []);
                        console.log('[DEBUG] trashedItems set:', this.trashedItems);
                    } catch (e) {
                        console.error('[DEBUG] loadTrashed error:', e);
                        showToast('ไม่สามารถโหลดรายการที่ถูกลบได้', 'error');
                    }
                    this.loadingTrash = false;
                },

                toggleSelectAll() {
                    if (this.selectedIds.length === this.trashedItems.length) {
                        this.selectedIds = [];
                    } else {
                        this.selectedIds = this.trashedItems.map(i => String(i.id));
                    }
                    console.log('[DEBUG] toggleSelectAll — selectedIds:', this.selectedIds);
                },

                async restoreSelected() {
                    console.log('[DEBUG] restoreSelected called, selectedIds:', this.selectedIds);
                    if (this.selectedIds.length === 0) {
                        showToast('กรุณาเลือกรายการที่ต้องการกู้คืน', 'error');
                        return;
                    }
                    try {
                        const res = await fetch('{{ route("admin.exercise-libraries.restore") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            body: JSON.stringify({ ids: this.selectedIds })
                        });
                        const data = await res.json();
                        console.log('[DEBUG] restore response:', data);
                        if (data.success) {
                            showToast(data.message, 'success');
                            this.selectedIds = [];
                            await this.loadTrashed();
                            setTimeout(() => window.location.reload(), 1000);
                        }
                    } catch (e) {
                        console.error('[DEBUG] restore error:', e);
                        showToast('เกิดข้อผิดพลาดในการกู้คืน', 'error');
                    }
                },

                askForceDelete() {
                    console.log('[DEBUG] askForceDelete called, selectedIds:', this.selectedIds);
                    if (this.selectedIds.length === 0) {
                        showToast('กรุณาเลือกรายการที่ต้องการลบถาวร', 'error');
                        return;
                    }
                    this.itemsToDelete = this.trashedItems.filter(i => this.selectedIds.includes(String(i.id)));
                    console.log('[DEBUG] itemsToDelete:', this.itemsToDelete);
                    this.showConfirmModal = true;
                    console.log('[DEBUG] showConfirmModal set to:', this.showConfirmModal);
                },

                async doForceDelete() {
                    console.log('[DEBUG] doForceDelete called');
                    try {
                        const res = await fetch('{{ route("admin.exercise-libraries.force-delete") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN
                            },
                            body: JSON.stringify({ ids: this.selectedIds })
                        });
                        const data = await res.json();
                        console.log('[DEBUG] forceDelete response:', data);
                        if (data.success) {
                            this.showConfirmModal = false;
                            this.showTrashModal = false;
                            this.selectedIds = [];
                            this.itemsToDelete = [];
                            showToast(data.message, 'success');
                            setTimeout(() => window.location.reload(), 1000);
                        }
                    } catch (e) {
                        console.error('[DEBUG] forceDelete error:', e);
                        showToast('เกิดข้อผิดพลาดในการลบถาวร', 'error');
                    }
                }
            }
        }

        async function toggleActive(url, btn) {
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                    }
                });
                const data = await res.json();
                if (data.success) {
                    const dot = btn.querySelector('span');
                    if (data.is_active) {
                        btn.style.backgroundColor = '#2563eb';
                        dot.style.transform = 'translateX(14px)';
                    } else {
                        btn.style.backgroundColor = '#d1d5db';
                        dot.style.transform = 'translateX(2px)';
                    }
                    // Update counters dynamically
                                    const activeEl = document.getElementById('active-count');
                                    const inactiveEl = document.getElementById('inactive-count');
                                    if (activeEl && inactiveEl) {
                                        let activeCount = parseInt(activeEl.textContent, 10) || 0;
                                        let inactiveCount = parseInt(inactiveEl.textContent, 10) || 0;
                                        if (data.is_active) {
                                            activeCount++;
                                            inactiveCount = Math.max(0, inactiveCount - 1);
                                        } else {
                                            activeCount = Math.max(0, activeCount - 1);
                                            inactiveCount++;
                                        }
                                        activeEl.textContent = activeCount;
                                        inactiveEl.textContent = inactiveCount;
                                    }
                                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'เกิดข้อผิดพลาด กรุณาลองใหม่', 'error');
                }
            } catch (e) {
                showToast('เกิดข้อผิดพลาด กรุณาลองใหม่', 'error');
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.style.cssText = `position:fixed;top:1rem;right:1rem;z-index:200;padding:0.75rem 1rem;border-radius:0.5rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);font-size:0.875rem;font-weight:500;transition:all 0.3s;` +
                (type === 'success' ? 'background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;' : 'background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;');
            toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'} mr-2"></i>${message}`;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
        }

    </script>
    @endpush
</x-app-layout>
