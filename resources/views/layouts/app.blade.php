<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>رپدونی - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Vazirmatn', system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    
    <!-- هدر شیک خاکستری -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <!-- لوگو -->
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center shadow-sm group-hover:bg-gray-700 transition">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-800">رپدونی</span>
                </a>
                
                <!-- منوی اصلی (دسکتاپ) -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="/" class="text-gray-600 hover:text-gray-900 transition {{ request()->routeIs('home') ? 'text-gray-900 font-medium' : '' }}">خانه</a>
                    <a href="{{ route('songs.index') }}" class="text-gray-600 hover:text-gray-900 transition">آهنگ‌ها</a>
                    <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-gray-900 transition">دسته‌بندی‌ها</a>
                    <a href="artists" class="text-gray-600 hover:text-gray-900 transition">هنرمندان</a>
                </div>
                
                <!-- بخش کاربری + دکمه همبرگری -->
                <div class="flex items-center gap-3">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-gray-700 hover:text-gray-900 transition">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:block text-sm">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 hidden md:block text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="p-2">
                                    <div class="px-3 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                                    </div>
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            پنل مدیریت
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-500 hover:bg-red-50 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            خروج
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition text-sm">ورود</a>
                        <a href="{{ route('register') }}" class="px-3 py-1.5 bg-gray-800 text-white rounded-md text-sm hover:bg-gray-700 transition">ثبت‌نام</a>
                    @endauth
                    
                    <!-- دکمه همبرگری موبایل -->
                    <button id="mobile-menu-btn" class="md:hidden text-gray-600 hover:text-gray-900 transition p-1" aria-label="باز کردن منو">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- منوی موبایل -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="container mx-auto px-4 py-4 space-y-1">
                <a href="/" class="block text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition py-2 px-3 {{ request()->routeIs('home') ? 'text-gray-900 font-medium bg-gray-50' : '' }}">خانه</a>
                <a href="{{ route('songs.index') }}" class="block text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition py-2 px-3">آهنگ‌ها</a>
                <a href="{{ route('categories.index') }}" class="block text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition py-2 px-3">دسته‌بندی‌ها</a>
                <a href="artists" class="block text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition py-2 px-3">هنرمندان</a>
            </div>
        </div>
    </nav>
    
    <!-- محتوای اصلی -->
    <main>
        @yield('content')
    </main>
    
    <!-- فوتر شیک خاکستری -->
    <footer class="bg-white border-t border-gray-200 mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- درباره ما -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">رپدونی</h3>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        بزرگترین آرشیو موزیک رپ و هیپ‌هاپ ایرانی. بهترین آهنگ‌های رپ را با بهترین کیفیت گوش کنید.
                    </p>
                </div>
                
                <!-- لینک‌های سریع -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-4">لینک‌های سریع</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-500 text-sm hover:text-gray-800 transition">آهنگ‌های جدید</a></li>
                        <li><a href="#" class="text-gray-500 text-sm hover:text-gray-800 transition">پربازدیدترین‌ها</a></li>
                        <li><a href="#" class="text-gray-500 text-sm hover:text-gray-800 transition">دسته‌بندی‌ها</a></li>
                        <li><a href="#" class="text-gray-500 text-sm hover:text-gray-800 transition">هنرمندان رپ</a></li>
                    </ul>
                </div>
                
                <!-- دسترسی سریع -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-4">دسترسی سریع</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-500 text-sm hover:text-gray-800 transition">تماس با ما</a></li>
                        <li><a href="#" class="text-gray-500 text-sm hover:text-gray-800 transition">قوانین و مقررات</a></li>
                        <li><a href="#" class="text-gray-500 text-sm hover:text-gray-800 transition">حریم خصوصی</a></li>
                        <li><a href="#" class="text-gray-500 text-sm hover:text-gray-800 transition">راهنما</a></li>
                    </ul>
                </div>
                
                <!-- شبکه‌های اجتماعی -->
                <div>
                    <h4 class="font-semibold text-gray-800 mb-4">ما را دنبال کنید</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-9 h-9 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-800 hover:text-white transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879v-6.99h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.99C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-800 hover:text-white transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0021.213-12.41c0-.212-.005-.424-.015-.636A10.022 10.022 0 0024 4.557z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-800 hover:text-white transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-9 h-9 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-800 hover:text-white transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- کپی‌رایت -->
            <div class="border-t border-gray-100 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-xs">
                    © 2026 رپدونی. تمامی حقوق محفوظ است.
                </p>
            </div>
        </div>
    </footer>
    
    <!-- اسکریپت منوی موبایل -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            
            if (btn && menu && icon) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('hidden');
                    
                    if (menu.classList.contains('hidden')) {
                        icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                    } else {
                        icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
                    }
                });
                
                // بستن منو با کلیک بیرون
                document.addEventListener('click', function(e) {
                    if (!menu.classList.contains('hidden') && 
                        !menu.contains(e.target) && 
                        !btn.contains(e.target)) {
                        menu.classList.add('hidden');
                        icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>