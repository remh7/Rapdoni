<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل ادمین - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* انیمیشن‌های سفارشی */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .sidebar-hidden {
            transform: translateX(100%);
        }
        @media (min-width: 768px) {
            .sidebar-hidden {
                transform: translateX(0);
            }
        }
        .overlay {
            transition: opacity 0.3s ease-in-out;
        }
        
        /* رفع باگ اسکرول در موبایل */
        body.menu-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    
    <!-- اوورلی برای موبایل -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden overlay" style="opacity: 0;"></div>
    
    <div class="flex h-screen relative">
        
        <!-- دکمه همبرگری (فقط موبایل) -->
        <button id="menuToggle" class="fixed top-4 right-4 z-30 md:hidden bg-indigo-600 text-white p-2 rounded-lg shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        
        <!-- سایدبار -->
        <aside id="sidebar" class="fixed md:relative z-30 w-72 bg-gradient-to-b from-gray-900 to-gray-800 text-white h-full overflow-y-auto sidebar-transition transform translate-x-full md:translate-x-0 shadow-2xl" style="top: 0; right: 0;">
            
            <!-- هدر سایدبار با لوگو -->
            <div class="p-6 border-b border-gray-700 bg-gradient-to-r from-indigo-600 to-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold">🎵 موزیک</h2>
                        <p class="text-sm text-gray-300 mt-1">پنل مدیریت</p>
                    </div>
                    <button id="closeMenu" class="md:hidden text-white hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- اطلاعات ادمین -->
            <div class="p-4 border-b border-gray-700 bg-gray-800 bg-opacity-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-lg font-bold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold">{{ auth()->user()->name ?? 'ادمین' }}</p>
                        <p class="text-xs text-gray-400">{{ auth()->user()->email ?? 'admin@site.com' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- منوهای اصلی -->
            <nav class="mt-6 px-4 pb-32">
                <div class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>داشبورد</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('admin.songs.*') && !request()->routeIs('admin.songs.create') ? 'bg-indigo-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                        <span>مدیریت دسته بندی</span>
                    </a>
                    <a href="{{ route('admin.songs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('admin.songs.*') && !request()->routeIs('admin.songs.create') ? 'bg-indigo-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                        <span>مدیریت آهنگ‌ها</span>
                    </a>
                    
                    <a href="{{ route('admin.songs.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200 group {{ request()->routeIs('admin.songs.create') ? 'bg-indigo-600' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>افزودن آهنگ جدید</span>
                    </a>
                    <a href="{{ route('admin.artists.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    <span>هنرمندان</span>
</a>
                    
                    
            </nav>
            
            <!-- لینک خروج -->
            <div class="fixed bottom-0 right-0 left-0 md:absolute p-4 border-t border-gray-700 bg-gray-800 bg-opacity-95 md:bg-opacity-50" style="max-width: 288px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full rounded-lg hover:bg-red-600 transition-all duration-200 text-gray-300 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>خروج از سیستم</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- محتوای اصلی -->
        <main class="flex-1 overflow-auto">
            <div class="bg-white shadow-sm border-b">
                <div class="px-6 py-4">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('header')</h1>
                </div>
            </div>
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
    
    <script>
        // توابع کنترل منوی همبرگری
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');
        const closeMenuBtn = document.getElementById('closeMenu');
        
        function openMenu() {
            sidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            // انیمیشن اوورلی
            setTimeout(() => {
                if (overlay) overlay.style.opacity = '1';
            }, 10);
            document.body.classList.add('menu-open');
        }
        
        function closeMenuFunc() {
            sidebar.classList.add('translate-x-full');
            if (overlay) {
                overlay.style.opacity = '0';
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
            document.body.classList.remove('menu-open');
        }
        
        if (menuToggle) {
            menuToggle.addEventListener('click', openMenu);
        }
        
        if (closeMenuBtn) {
            closeMenuBtn.addEventListener('click', closeMenuFunc);
        }
        
        if (overlay) {
            overlay.addEventListener('click', closeMenuFunc);
        }
        
        // بستن منو با کلید ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !sidebar.classList.contains('translate-x-full') && window.innerWidth < 768) {
                closeMenuFunc();
            }
        });
        
        // رفع باگ در هنگام تغییر سایز صفحه
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                if (overlay) overlay.classList.add('hidden');
                document.body.classList.remove('menu-open');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>