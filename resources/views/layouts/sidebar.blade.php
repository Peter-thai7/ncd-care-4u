@php
    $userRole = auth()->user()->roles->first()->name ?? 'Patient';
    $roleColors = [
        'System Admin'      => 'gray',
        'Sub-Admin'         => 'slate',
        'Doctor'            => 'green',
        'Nutritionist'      => 'amber',
        'Physiotherapist'   => 'sky',
        'Nurse'             => 'purple',
        'Laboratory'        => 'orange',
        'Patient'           => 'blue',
        'Observer'          => 'pink',
    ];
    $sidebarColor = $roleColors[$userRole] ?? 'blue';
    $userInitial = strtoupper(auth()->user()->name[0] ?? 'U');
@endphp

<!-- Mobile Overlay -->
<div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-30 md:hidden" @click="sidebarOpen = false">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>
</div>

<!-- Sidebar Container -->
<div class="fixed inset-y-0 left-0 z-40 w-72 flex flex-col bg-gradient-to-b from-{{ $sidebarColor }}-900 to-{{ $sidebarColor }}-800 transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 shadow-2xl"
     :class="{ 'translate-x-0': sidebarOpen }">
     
    <div class="flex flex-col flex-grow overflow-y-auto">
        
        <!-- Logo & Close Button -->
        <div class="flex items-center justify-between flex-shrink-0 px-6 py-5 border-b border-{{ $sidebarColor }}-700/50">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <!-- Logo Icon -->
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <div class="text-white font-extrabold text-xl tracking-wider">
                    NCD Care 4U
                </div>
            </a>
            <!-- Close Button (Mobile) -->
            <button @click="sidebarOpen = false" class="md:hidden text-white/50 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Dynamic Role Badge -->
        <div class="px-6 py-4">
            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-{{ $sidebarColor }}-700/60 text-white uppercase tracking-widest border border-{{ $sidebarColor }}-600/50">
                {{ $userRole }}
            </span>
        </div>

        <!-- Navigation Menu -->
        <div class="mt-2 flex-1 flex flex-col px-4">
            <nav class="flex-1 space-y-1">
                
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-white bg-{{ $sidebarColor }}-700/40 shadow-sm transition duration-150">
                    <div class="bg-{{ $sidebarColor }}-600/40 p-2 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    แดชบอร์ด
                </a>

                @role('System Admin|Sub-Admin')
                <div class="mt-8 mb-2 px-4 text-xs font-bold text-{{ $sidebarColor }}-400 uppercase tracking-widest">
                    ระบบหลังบ้าน
                </div>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-white/80 hover:bg-{{ $sidebarColor }}-700/30 hover:text-white transition duration-150">
                    <div class="bg-{{ $sidebarColor }}-700/30 p-2 rounded-lg group-hover:bg-{{ $sidebarColor }}-600/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    จัดการคลังวัสดุ
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-white/80 hover:bg-{{ $sidebarColor }}-700/30 hover:text-white transition duration-150">
                    <div class="bg-{{ $sidebarColor }}-700/30 p-2 rounded-lg group-hover:bg-{{ $sidebarColor }}-600/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    จัดการผู้ป่วย
                </a>
                @endrole

                @role('Doctor')
                <div class="mt-8 mb-2 px-4 text-xs font-bold text-{{ $sidebarColor }}-400 uppercase tracking-widest">
                    แพทย์ผู้ตรวจ
                </div>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-white/80 hover:bg-{{ $sidebarColor }}-700/30 hover:text-white transition duration-150">
                    <div class="bg-{{ $sidebarColor }}-700/30 p-2 rounded-lg group-hover:bg-{{ $sidebarColor }}-600/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    รายชื่อคนไข้ของฉัน
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-white/80 hover:bg-{{ $sidebarColor }}-700/30 hover:text-white transition duration-150">
                    <div class="bg-{{ $sidebarColor }}-700/30 p-2 rounded-lg group-hover:bg-{{ $sidebarColor }}-600/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    จด Progress Note
                </a>
                @endrole

                @role('Patient')
                <div class="mt-8 mb-2 px-4 text-xs font-bold text-{{ $sidebarColor }}-400 uppercase tracking-widest">
                    ข้อมูลสุขภาพของฉัน
                </div>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-white/80 hover:bg-{{ $sidebarColor }}-700/30 hover:text-white transition duration-150">
                    <div class="bg-{{ $sidebarColor }}-700/30 p-2 rounded-lg group-hover:bg-{{ $sidebarColor }}-600/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    แผนอาหารที่ได้รับ
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-white/80 hover:bg-{{ $sidebarColor }}-700/30 hover:text-white transition duration-150">
                    <div class="bg-{{ $sidebarColor }}-700/30 p-2 rounded-lg group-hover:bg-{{ $sidebarColor }}-600/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    ท่าบริหารที่ได้รับ
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-white/80 hover:bg-{{ $sidebarColor }}-700/30 hover:text-white transition duration-150">
                    <div class="bg-{{ $sidebarColor }}-700/30 p-2 rounded-lg group-hover:bg-{{ $sidebarColor }}-600/40">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    บันทึกค่าใช้จ่าย
                </a>
                @endrole

            </nav>
        </div>

        <!-- User Profile & Logout -->
        <div class="flex-shrink-0 border-t border-{{ $sidebarColor }}-700/50 p-4 mt-2">
            <div class="flex items-center gap-3">
                <!-- Avatar Circle -->
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white font-bold text-sm border border-white/10">
                    {{ $userInitial }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs font-medium text-{{ $sidebarColor }}-300 truncate">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 rounded-lg text-{{ $sidebarColor }}-300 hover:text-white hover:bg-{{ $sidebarColor }}-700/50 focus:outline-none transition duration-150" title="ออกจากระบบ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
