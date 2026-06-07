<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <!-- Welcome Section -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-8">
            <h1 class="text-3xl font-bold text-gray-900">ยินดีต้อนรับ, {{ auth()->user()->name }}! 👋</h1>
            <p class="mt-2 text-gray-600">นี่คือภาพรวมระบบการดูแลผู้ป่วย NCD ของคุณ</p>
        </div>

        <!-- Stats Grid -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1: ผู้ป่วย -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">ผู้ป่วยที่ดูแล</dt>
                                    <dd class="text-3xl font-bold text-gray-900">12</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm text-blue-600 font-semibold cursor-pointer hover:text-blue-800">ดูรายชื่อทั้งหมด →</div>
                    </div>
                </div>

                <!-- Card 2: แผนอาหาร -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-amber-50 text-amber-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">แผนอาหารที่สั่งจ่าย</dt>
                                    <dd class="text-3xl font-bold text-gray-900">8</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm text-amber-600 font-semibold cursor-pointer hover:text-amber-800">จัดการแผนอาหาร →</div>
                    </div>
                </div>

                <!-- Card 3: ท่าบริหาร -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-50 text-green-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">ท่าบริหารที่สั่งจ่าย</dt>
                                    <dd class="text-3xl font-bold text-gray-900">15</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm text-green-600 font-semibold cursor-pointer hover:text-green-800">จัดการท่าบริหาร →</div>
                    </div>
                </div>

                <!-- Card 4: การแจ้งเตือน -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-rose-50 text-rose-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">การแจ้งเตือนใหม่</dt>
                                    <dd class="text-3xl font-bold text-gray-900">3</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-3">
                        <div class="text-sm text-rose-600 font-semibold cursor-pointer hover:text-rose-800">ดูรายละเอียด →</div>
                    </div>
                </div>

            </div>

            <!-- Recent Activity Section -->
            <div class="mt-8 bg-white shadow-lg rounded-xl border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">กิจกรรมล่าสุดในระบบ</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">ผู้ป่วยใหม่: <span class="font-semibold">คุณสมชาย</span> ได้ลงทะเบียนเข้าสู่ระบบ</p>
                            <p class="text-xs text-gray-500 mt-1">2 นาทีที่แล้ว</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">นักโภชนาการ: <span class="font-semibold">เมนู Low Carb</span> ถูกเพิ่มเข้าคลังวัสดุ</p>
                            <p class="text-xs text-gray-500 mt-1">15 นาทีที่แล้ว</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">แพทย์: <span class="font-semibold">นพ. ประเสริฐ</span> ได้จด Progress Note ให้ผู้ป่วย</p>
                            <p class="text-xs text-gray-500 mt-1">1 ชั่วโมงที่แล้ว</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
