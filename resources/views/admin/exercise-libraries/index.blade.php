<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-dumbbell mr-2 text-blue-600"></i>คลังท่าบริหาร
                </h2>
                <p class="text-sm text-gray-500 mt-1">จัดการท่าบริหารสำหรับสั่งจ่ายให้คนไข้ (Library System)</p>
            </div>
            <a href="{{ route('admin.exercise-libraries.create') }}"
               class="inline-flex items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm text-sm font-medium">
                <i class="fa-solid fa-plus mr-2"></i>เพิ่มท่าบริหารใหม่
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <!-- ====== Filter Bar ====== -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form method="GET" action="{{ route('admin.exercise-libraries.index') }}" class="flex flex-col lg:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="ค้นหาชื่อท่าบริหาร, รายละเอียด..."
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
                        <p class="text-xs text-gray-500">ท่าบริหารทั้งหมด</p>
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
                        <p class="text-xl font-bold text-green-600">{{ \App\Models\ExerciseLibrary::where('is_active', true)->count() }}</p>
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
                        <p class="text-xl font-bold text-red-500">{{ \App\Models\ExerciseLibrary::where('is_active', false)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-trash-can text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">ถูกลบ (Soft)</p>
                        <p class="text-xl font-bold text-amber-600">{{ \App\Models\ExerciseLibrary::onlyTrashed()->count() }}</p>
                    </div>
                </div>
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
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">ชื่อท่าบริหาร</th>
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
                                                 class="w-12 h-12 rounded-lg object-cover border border-gray-200">
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
                                                @click="toggleActive('{{ route('admin.exercise-libraries.toggle-active', $exercise) }}', this)"
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 {{ $exercise->is_active ? 'bg-blue-600' : 'bg-gray-300' }}">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform shadow-sm {{ $exercise->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('admin.exercise-libraries.show', $exercise) }}"
                                               class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="ดู">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.exercise-libraries.edit', $exercise) }}"
                                               class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="แก้ไข">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.exercise-libraries.destroy', $exercise) }}"
                                                  class="inline"
                                                  x-data="{ confirmDelete: false }"
                                                  @submit.prevent="if(!confirmDelete) { confirmDelete = true; $el.querySelector('.confirm-msg').classList.remove('hidden') } else { $el.submit() }">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="ลบ">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                                <span class="confirm-msg hidden text-xs text-red-500 ml-1">กดอีกครั้ง</span>
                                            </form>
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
                    <h3 class="text-lg font-medium text-gray-500 mb-1">ยังไม่มีท่าบริหารในคลัง</h3>
                    <p class="text-sm text-gray-400 mb-4">เริ่มต้นเพิ่มท่าบริหารเพื่อให้นักกายภาพฯ สามารถสั่งจ่ายให้คนไข้ได้</p>
                    <a href="{{ route('admin.exercise-libraries.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                        <i class="fa-solid fa-plus mr-2"></i>เพิ่มท่าบริหารแรก
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        async function toggleActive(url, btn) {
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });
                const data = await res.json();
                if (data.success) {
                    const dot = btn.querySelector('span');
                    if (data.is_active) {
                        btn.classList.remove('bg-gray-300');
                        btn.classList.add('bg-blue-600');
                        dot.classList.remove('translate-x-1');
                        dot.classList.add('translate-x-6');
                    } else {
                        btn.classList.remove('bg-blue-600');
                        btn.classList.add('bg-gray-300');
                        dot.classList.remove('translate-x-6');
                        dot.classList.add('translate-x-1');
                    }
                    showToast(data.message, 'success');
                }
            } catch (e) {
                showToast('เกิดข้อผิดพลาด กรุณาลองใหม่', 'error');
            }
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-sm font-medium transition-all transform translate-x-0 ${
                type === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'
            }`;
            toast.innerHTML = `<i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'} mr-2"></i>${message}`;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 3000);
        }
    </script>
    @endpush
</x-app-layout>
