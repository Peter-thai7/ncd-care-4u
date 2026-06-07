<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- ใส่ x-data เพื่อควบคุมการเปิดปิด Sidebar บนมือถือ -->
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
            
            @include('layouts.sidebar')

            <!-- Content Area (ด้านขวา) -->
            <div class="flex-1 md:ml-64 flex flex-col">
                
                <!-- Top Bar (มีปุ่ม Hamburger สำหรับมือถือ) -->
                <header class="bg-white shadow-md">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center">
                        <!-- ปุ่มเปิด Sidebar (แสดงแค่มือถือ) -->
                        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden mr-4 text-gray-500 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>

                        @isset($header)
                            {{ $header }}
                        @endisset
                    </div>
                </header>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
