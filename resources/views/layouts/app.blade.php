<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'NCD Care 4U') }}</title>

    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <!-- Anuphan Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Alpine.js (loaded after Vite) -->
    @vite(['resources/js/app.js'])
</head>

<body class="bg-slate-50 font-anuphan text-slate-800" x-data="{ loading: true, sidebarOpen: window.innerWidth >= 1024 }" x-init="setTimeout(() => { loading = false }, 800)">

    <!-- ============ SKELETON LOADING ============ -->
    <div x-show="loading" x-transition class="min-h-screen flex">
        <div class="w-64 bg-white border-r border-slate-200 p-5 hidden lg:block">
            <div class="skeleton h-8 w-32 mb-8"></div>
            <div class="space-y-4">
                <div class="skeleton h-5 w-full"></div>
                <div class="skeleton h-5 w-3/4"></div>
                <div class="skeleton h-5 w-5/6"></div>
                <div class="skeleton h-5 w-2/3"></div>
                <div class="skeleton h-5 w-full"></div>
                <div class="skeleton h-5 w-4/5"></div>
            </div>
        </div>
        <div class="flex-1 p-6 lg:p-8">
            <div class="skeleton h-8 w-48 mb-6"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="skeleton h-28 rounded-xl"></div>
                <div class="skeleton h-28 rounded-xl"></div>
                <div class="skeleton h-28 rounded-xl"></div>
                <div class="skeleton h-28 rounded-xl"></div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="skeleton h-72 rounded-xl"></div>
                <div class="skeleton h-72 rounded-xl"></div>
                <div class="skeleton h-72 rounded-xl"></div>
            </div>
        </div>
    </div>

    <!-- ============ MAIN APP ============ -->
    <div x-show="!loading" x-transition.duration.500ms class="min-h-screen flex">

        <!-- ===== SIDEBAR ===== -->
        @include('layouts.sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <main :class="[
            'flex-1 transition-all duration-300',
            sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'
        ]">
            <!-- Top Navbar -->
            <header class="glass-bar sticky top-0 z-30 border-b border-slate-200/60 h-16 flex items-center px-5 lg:px-8 gap-4">
                <!-- Thai Date -->
                <div class="flex items-center gap-2 text-slate-500">
                    <i class="fa-regular fa-calendar text-sm"></i>
                    <span id="todayDate" class="text-sm font-medium"></span>
                </div>
                <!-- Right -->
                <div class="ml-auto flex items-center gap-3">
                    <!-- Search -->
                    <div class="hidden md:flex items-center bg-slate-100 rounded-lg px-3 py-2 gap-2 focus-within:ring-2 focus-within:ring-nature-300 transition-all">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
                        <input type="text" placeholder="ค้นหา..." class="bg-transparent outline-none text-sm text-slate-600 placeholder:text-slate-400 w-44">
                    </div>
                    <!-- Notification -->
                    <button class="relative text-slate-500 hover:text-nature-600 transition-colors">
                        <i class="fa-solid fa-bell text-lg"></i>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-nature-500 text-white text-[10px] rounded-full flex items-center justify-center">3</span>
                    </button>
                    <!-- Avatar -->
                    @auth
                    @php
                        $user = auth()->user();
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
                        $userRole = $user->roles->first()?->name ?? 'patient';
                        $avatarClass = $roleColors[$userRole] ?? $roleColors['patient'];
                    @endphp
                    <div class="w-8 h-8 rounded-full {{ $avatarClass }} flex items-center justify-center ring-2">
                        <i class="fa-solid fa-user text-sm"></i>
                    </div>
                    @endauth
                </div>
            </header>

            <!-- Page Header -->
            @isset($header)
                <div class="px-5 lg:px-8 pt-5 lg:pt-6">
                    {{ $header }}
                </div>
            @endisset

            <!-- Page Content -->
            <div class="p-5 lg:p-8 {{ isset($header) ? 'pt-0 lg:pt-0' : '' }}">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/30 z-30 lg:hidden" x-transition.opacity></div>

    <!-- Force Tailwind to generate sidebar offset classes -->
    <div class="hidden lg:ml-64 lg:ml-20"></div>

    <!-- Thai Date Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const days = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
            const months = ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                            'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
            const now = new Date();
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear() + 543;
            const el = document.getElementById('todayDate');
            if (el) el.textContent = 'วัน' + dayName + 'ที่ ' + date + ' ' + monthName + ' ' + year;
        });
    </script>

    <!-- Page-specific Scripts -->
    @stack('scripts')
</body>
</html>