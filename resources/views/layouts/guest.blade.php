<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'رپدونی') }} - @yield('title')</title>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Vazirmatn', system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- لوگو -->
        <div class="text-center mb-8">
            <div class="inline-block p-4 bg-white rounded-full shadow-md mb-3">
                <svg class="w-10 h-10 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">رپدونی</h1>
            <p class="text-gray-400 text-sm mt-1">به جمع ما بپیوندید</p>
        </div>
        
        <!-- کارت فرم -->
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
            {{ $slot }}
        </div>
        
        <!-- فوتر -->
        <div class="text-center mt-6 text-gray-400 text-xs">
            <p>© رپدونی - تمامی حقوق محفوظ است</p>
        </div>
    </div>
</body>
</html>