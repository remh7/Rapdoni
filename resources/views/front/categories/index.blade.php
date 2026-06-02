@extends('layouts.app')

@section('title', 'دسته‌بندی‌ها')

@section('content')
<div class="bg-gray-100 min-h-screen pb-20">
    
    <!-- هدر صفحه -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-12 text-center">
            <div class="inline-block p-3 bg-gray-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 6h16v2H4zm2-4h12v2H6zm14 8v12l-6-3z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-light text-gray-800 mb-2">دسته‌بندی‌ها</h1>
            <p class="text-gray-400 text-sm">مرور آهنگ‌ها بر اساس سبک</p>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" class="group">
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition transform hover:-translate-y-1">
                    <div class="h-40 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center relative">
                        <div class="text-6xl">
                            @switch($category->name)
                                @case('رپ') 🎤 @break
                                @case('هیپ‌هاپ') 🎧 @break
                                @case('زیرزمینی') 🔥 @break
                                @case('قدیمی') 📻 @break
                                @case('جدید') 🆕 @break
                                @default 🎵
                            @endswitch
                        </div>
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition"></div>
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="text-gray-800 font-bold text-lg">{{ $category->name }}</h3>
                        <p class="text-gray-400 text-sm mt-1">{{ $category->songs_count }} آهنگ</p>
                        <div class="mt-3 inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full group-hover:bg-gray-800 group-hover:text-white transition">
                            مشاهده آهنگ‌ها
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center text-gray-400 py-16">
                هیچ دسته‌بندی وجود ندارد
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection