@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- خوش‌آمدگویی -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gray-800 rounded-full flex items-center justify-center text-white text-xl font-bold shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-800">
                            سلام، {{ auth()->user()->name }} 
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">
                            به داشبورد رپدونی خوش اومدی
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- کارت‌های دسترسی سریع -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            
            <!-- پنل مدیریت - فقط ادمین -->
            @if(auth()->user()->is_admin)
            <a href="{{ route('admin.dashboard') }}" 
               class="group bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center backdrop-blur">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/40 group-hover:text-white group-hover:-translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mt-4">پنل مدیریت</h3>
                <p class="text-sm text-gray-300 mt-1">مدیریت آهنگ‌ها، هنرمندان و دسته‌بندی‌ها</p>
            </a>
            @endif

            <!-- آهنگ‌ها -->
            <a href="{{ route('songs.index') }}" 
               class="group bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-gray-600 group-hover:-translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mt-4">آهنگ‌ها</h3>
                <p class="text-sm text-gray-500 mt-1">مرور و گوش دادن به آهنگ‌های رپ</p>
            </a>

            <!-- هنرمندان -->
            <a href="/artists" 
               class="group bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-gray-600 group-hover:-translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mt-4">هنرمندان</h3>
                <p class="text-sm text-gray-500 mt-1">آشنایی با هنرمندان رپ ایرانی</p>
            </a>

        </div>

    </div>
</div>

@endsection