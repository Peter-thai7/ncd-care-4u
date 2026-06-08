<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fa-solid fa-utensils mr-2 text-nature-600"></i>คลังเมนูอาหาร
                </h2>
                <p class="text-sm text-gray-500 mt-1">จัดการเมนูอาหารสำหรับสั่งจ่ายให้คนไข้ (Library System)</p>
            </div>
            <a href="{{ route('admin.master-menus.create') }}"
               class="inline-flex items-center px-4 py-2.5 bg-nature-600 text-white rounded-lg hover:bg-nature-700 transition shadow-sm text-sm font-medium">
                <i class="fa-solid fa-plus mr-2"></i>เพิ่มเมนูใหม่
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <!-- ====== Filter Bar ====== -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form method="GET" action="{{ route('admin.master-menus.index') }}" class="flex flex-col lg:flex-row gap-3">
                <!-- Search -->
                <div class="flex-1 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="ค้นหาชื่อเมนู, รายละเอียด..."
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300 focus:border-nature-500">
                </div>

                <!-- Category Filter -->
                <select name="category" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300 bg-white min-w-[160px]">
                    <option value="">ทุกหมวดหมู่</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <!-- Disease Filter -->
                <select name="suitable_for" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300 bg-white min-w-[160px]">
                    <option value="">ทุกโรค</option>
                    @foreach($conditions as $key => $label)
                        <option value="{{ $key }}" {{ request('suitable_for') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="is_active" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-nature-300 bg-white min-w-[130px]">
                    <option value="">ทุกสถานะ</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>เปิดใช้งาน</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>ปิดใช้งาน</option>
                </select>

                <button type="submit" class="px-4 py-2.5 bg-nature-600 text-white rounded-lg text-sm hover:bg-nature-700 transition">
                    <i class="fa-solid fa-filter mr-1"></i>ค้นหา
                </button>
                <a href="{{ route('admin.master-menus.index') }}" class="px-4 py-2.5 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition text-center">
                    ล้าง
                </a>
            </form>
        </div>

        <!-- ====== Stats Summary ====== -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-nature-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-bowl-food text-nature-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">เมนูทั้งหมด</p>
                        <p class="text-xl font-bold text-gray-800">{{ \App\Models\MasterMenu::count() }}</p>
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
                        <p class="text-xl font-bold text-green-600">{{ \App\Models\MasterMenu::where('is_active', true)->count() }}</p>
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
                        <p class="text-xl font-bold text-red-500">{{ \App\Models\MasterMenu::where('is_active', false)->count() }}</p>
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
                        <p class="text-xl font-bold text-amber-600">{{ \App\Models\MasterMenu::onlyTrashed()->count() }}</p>
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

        @if(session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                 x-transition class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                <span><i class="fa-solid fa-circle-exclamation mr-2"></i>{{ session('error') }}</span>
                <button @click="show = false" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        <!-- ====== Data Table ====== -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if($menus->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="text-left px-4 py-3 font-semibold text-gray-600 w-16">#</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">รูปภาพ</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">ชื่อเมนู</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">หมวดหมู่</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">แคลอรี่</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-600">โรคที่เหมาะสม</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-600">สถานะ</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-600 w-44">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $index => $menu)
                                <tr class="border-b border-gray-50 hover:bg-nature-50/30 transition">
                                    <td class="px-4 py-3 text-gray-500">{{ $menus->firstItem() + $index }}</td>
                                    <td class="px-4 py-3">
                                        @if($menu->image_path)
                                            <img src="{{ Storage::url($menu->image_path) }}"
                                                 alt="{{ $menu->name }}"
                                                 class="w-12 h-12 rounded-lg object-cover border border-gray-200">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <i class="fa-solid fa-image text-gray-300"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-800">{{ $menu->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($menu->description, 50) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $menu->category === 'breakfast' ? 'bg-amber-50 text-amber-700' : '' }}
                                            {{ $menu->category === 'lunch' ? 'bg-orange-50 text-orange-700' : '' }}
                                            {{ $menu->category === 'dinner' ? 'bg-indigo-50 text-indigo-700' : '' }}
                                            {{ $menu->category === 'snack' ? 'bg-pink-50 text-pink-700' : '' }}
                                            {{ $menu->category === 'beverage' ? 'bg-cyan-50 text-cyan-700' : '' }}
                                            {{ $menu->category === 'supplement' ? 'bg-purple-50 text-purple-700' : '' }}
                                        ">
                                            {{ $categories[$menu->category] ?? $menu->category }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($menu->calories)
                                            <span class="font-semibold text-nature-600">{{ number_format($menu->calories, 0) }}</span>
                                            <span class="text-xs text-gray-400">kcal</span>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($menu->suitable_for && count($menu->suitable_for) > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(array_slice($menu->suitable_for, 0, 2) as $condition)
                                                    <span class="inline-block px-2 py-0.5 bg-nature-50 text-nature-600 rounded text-xs">
                                                        {{ $conditions[$condition] ?? $condition }}
                                                    </span>
                                                @endforeach
                                                @if(count($menu->suitable_for) > 2)
                                                    <span class="inline-block px-2 py-0.5 bg-gray-50 text-gray-500 rounded text-xs">
                                                        +{{ count($menu->suitable_for) - 2 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-300 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button"
                                                @click="toggleActive('{{ route('admin.master-menus.toggle-active', $menu) }}', this)"
                                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-nature-300 focus:ring-offset-2 {{ $menu->is_active ? 'bg-nature-600' : 'bg-gray-300' }}">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform shadow-sm {{ $menu->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ route('admin.master-menus.show', $menu) }}"
                                               class="p-2 text-gray-400 hover:text-nature-600 hover:bg-nature-50 rounded-lg transition"
                                               title="ดูรายละเอียด">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.master-menus.edit', $menu) }}"
                                               class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition"
                                               title="แก้ไข">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.master-menus.destroy', $menu) }}"
                                                  class="inline"
                                                  x-data="{ confirmDelete: false }"
                                                  @submit.prevent="if(!confirmDelete) { confirmDelete = true; $el.querySelector('.confirm-msg').classList.remove('hidden') } else { $el.submit() }">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                        title="ลบ">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                                <span class="confirm-msg hidden text-xs text-red-500 ml-1">กดอีกครั้งเพื่อลบ</span>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/50">
                    {{ $menus->withQueryString()->links() }}
                </div>
            @else
                <div class="py-16 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-utensils text-3xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-500 mb-1">ยังไม่มีเมนูอาหารในคลัง</h3>
                    <p class="text-sm text-gray-400 mb-4">เริ่มต้นเพิ่มเมนูอาหารเพื่อให้นักโภชนาการสามารถสั่งจ่ายให้คนไข้ได้</p>
                    <a href="{{ route('admin.master-menus.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-nature-600 text-white rounded-lg hover:bg-nature-700 transition text-sm">
                        <i class="fa-solid fa-plus mr-2"></i>เพิ่มเมนูแรก
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
                    // Toggle switch UI
                    const dot = btn.querySelector('span');
                    if (data.is_active) {
                        btn.classList.remove('bg-gray-300');
                        btn.classList.add('bg-nature-600');
                        dot.classList.remove('translate-x-1');
                        dot.classList.add('translate-x-6');
                    } else {
                        btn.classList.remove('bg-nature-600');
                        btn.classList.add('bg-gray-300');
                        dot.classList.remove('translate-x-6');
                        dot.classList.add('translate-x-1');
                    }
                    // Flash toast
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
