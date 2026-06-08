@auth
@php
    $user = auth()->user();
    $userRole = $user->roles->first()?->name ?? 'patient';
    $roleNames = [
        'system-admin' => 'System Admin',
        'sub-admin'    => 'Sub-Admin',
        'doctor'       => 'แพทย์',
        'nurse'        => 'พยาบาล',
        'laboratory'   => 'ห้องปฏิบัติการ',
        'nutritionist' => 'นักโภชนาการ',
        'physiotherapist' => 'นักกายภาพ',
        'observer'     => 'ผู้สังเกตการณ์',
        'patient'      => 'ผู้ป่วย',
    ];
    $roleIcons = [
        'system-admin' => 'fa-shield-halved',
        'sub-admin'    => 'fa-user-shield',
        'doctor'       => 'fa-user-doctor',
        'nurse'        => 'fa-user-nurse',
        'laboratory'   => 'fa-flask',
        'nutritionist' => 'fa-apple-whole',
        'physiotherapist' => 'fa-dumbbell',
        'observer'     => 'fa-eye',
        'patient'      => 'fa-bed-pulse',
    ];
    $roleColors = [
        'system-admin'  => 'bg-nature-100 ring-nature-200 text-nature-600',
        'sub-admin'     => 'bg-ncdblue-100 ring-ncdblue-200 text-ncdblue-600',
        'doctor'        => 'bg-sky-100 ring-sky-200 text-sky-600',
        'nurse'         => 'bg-purple-100 ring-purple-200 text-purple-600',
        'laboratory'    => 'bg-amber-100 ring-amber-200 text-amber-600',
        'nutritionist'  => 'bg-green-100 ring-green-200 text-green-600',
        'physiotherapist' => 'bg-orange-100 ring-orange-200 text-orange-600',
        'observer'      => 'bg-pink-100 ring-pink-200 text-pink-600',
        'patient'       => 'bg-rose-100 ring-rose-200 text-rose-600',
    ];
@endphp

<aside :class="[
    'sidebar-transition fixed inset-y-0 left-0 z-40 flex flex-col bg-white border-r border-slate-200 shadow-sm sidebar-pattern',
    sidebarOpen ? 'w-64' : 'w-0 lg:w-20 overflow-hidden lg:overflow-visible'
]">
    <!-- Brand / Toggle -->
    <div class="flex items-center gap-3 px-5 h-16 border-b border-slate-100 flex-shrink-0">
        <button @click="sidebarOpen = !sidebarOpen"
                class="sidebar-toggle heart-pulse-anim flex items-center justify-center w-9 h-9 rounded-lg bg-ncdblue-500 shadow-md shadow-ncdblue-500/20 transition-transform"
                :title="sidebarOpen ? 'หดเมนู' : 'ขยายเมนู'">
            <i x-show="sidebarOpen" x-transition class="fa-solid fa-heart-pulse text-white text-base"></i>
            <i x-show="!sidebarOpen" x-transition class="fa-solid fa-chevron-right text-white text-sm"></i>
        </button>
        <span x-show="sidebarOpen" x-transition class="font-bold text-lg text-ncdblue-700 whitespace-nowrap">
            NCD Care <span class="text-nature-600">4U</span>
        </span>
    </div>

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto py-4 px-3">
        <ul class="space-y-1">
            <!-- แดชบอร์ด -->
            <li>
                <a href="{{ route('dashboard') }}" class="menu-active flex items-center gap-3 px-3 py-2.5 rounded-lg bg-nature-50 text-nature-700 font-medium">
                    <i class="fa-solid fa-house-medical text-lg w-6 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">แดชบอร์ด</span>
                </a>
            </li>
            <!-- ผู้ป่วย -->
            @role(['doctor','nurse','system-admin','sub-admin'])
            <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-nature-50/50 hover:text-nature-700 transition-colors">
                    <i class="fa-solid fa-hospital-user text-lg w-6 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">ผู้ป่วย</span>
                </a>
            </li>
            @endrole
            <!-- นัดหมาย -->
            <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-nature-50/50 hover:text-nature-700 transition-colors">
                    <i class="fa-solid fa-calendar-check text-lg w-6 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">นัดหมาย</span>
                </a>
            </li>
            <!-- บันทึกสุขภาพ -->
            <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-nature-50/50 hover:text-nature-700 transition-colors">
                    <i class="fa-solid fa-notes-medical text-lg w-6 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">บันทึกสุขภาพ</span>
                </a>
            </li>
            <!-- อาหารและโภชนาการ -->
            <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-nature-50/50 hover:text-nature-700 transition-colors">
                    <i class="fa-solid fa-bowl-food text-lg w-6 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">อาหารและโภชนาการ</span>
                </a>
            </li>

            <!-- Divider + Admin Section -->
            @role(['system-admin','sub-admin'])
            <li class="pt-3 pb-1">
                <span x-show="sidebarOpen" class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3">จัดการระบบ</span>
                <hr x-show="!sidebarOpen" class="border-slate-200 mx-2">
            </li>
            <!-- จัดการเมนูอาหาร -->
            <li>
                <a href="{{ route('admin.master-menus.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-nature-50/50 hover:text-nature-700 transition-colors">
                    <i class="fa-solid fa-utensils text-lg w-6 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">จัดการเมนูอาหาร</span>
                </a>
            </li>
            <!-- คลังท่าออกกำลังกาย -->
            <li>
                <a href="{{ route('admin.exercise-libraries.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-nature-50/50 hover:text-nature-700 transition-colors">
                    <i class="fa-solid fa-dumbbell text-lg w-6 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">คลังท่าออกกำลังกาย</span>
                </a>
            </li>
            <!-- จัดการผู้ใช้ -->
            <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-nature-50/50 hover:text-nature-700 transition-colors">
                    <i class="fa-solid fa-users-gear text-lg w-6 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">จัดการผู้ใช้</span>
                </a>
            </li>
            @endrole
            <!-- ตั้งค่า -->
            <li>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:bg-nature-50/50 hover:text-nature-700 transition-colors">
                    <i class="fa-solid fa-gear text-lg w-6 text-center"></i>
                    <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">ตั้งค่า</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- User Info -->
    <div class="border-t border-slate-100 p-4 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full {{ $roleColors[$userRole] ?? 'bg-nature-100 ring-nature-200 text-nature-600' }} flex items-center justify-center ring-2">
                <i class="fa-solid {{ $roleIcons[$userRole] ?? 'fa-user' }}"></i>
            </div>
            <div x-show="sidebarOpen" x-transition class="min-w-0">
                <p class="text-sm font-semibold text-slate-700 truncate">{{ $user->name }}</p>
                <p class="text-xs text-slate-400">{{ $roleNames[$userRole] ?? 'ผู้ใช้' }}</p>
            </div>
            <form x-show="sidebarOpen" method="POST" action="{{ route('logout') }}" class="ml-auto">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

@endauth