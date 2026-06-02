@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="bg-gray-100 min-h-screen pb-28">
    
    <!-- هدر دسته‌بندی -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-12 text-center">
            <div class="inline-block p-3 bg-gray-100 rounded-full mb-4">
                <div class="text-3xl">
                    @switch($category->name)
                        @case('رپ') 🎤 @break
                        @case('هیپ‌هاپ') 🎧 @break
                        @case('زیرزمینی') 🔥 @break
                        @case('قدیمی') 📻 @break
                        @case('جدید') 🆕 @break
                        @default 🎵
                    @endswitch
                </div>
            </div>
            <h1 class="text-3xl font-light text-gray-800 mb-2">{{ $category->name }}</h1>
            <p class="text-gray-400 text-sm">{{ $category->songs_count }} آهنگ در این سبک</p>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        
        <!-- تعداد نتایج -->
        <div class="mb-6">
            <p class="text-gray-400 text-sm">تعداد کل: {{ $songs->total() }} آهنگ</p>
        </div>
        
        <!-- لیست آهنگ‌ها -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @forelse($songs as $song)
            <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition cursor-pointer" 
                 onclick="window.location.href='{{ route('song.show', $song->id) }}'">
                <div class="aspect-square bg-gray-50 flex items-center justify-center relative">
                    @if($song->cover_image)
                        <img src="{{ Storage::url($song->cover_image) }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-12 h-12 text-gray-300 group-hover:text-gray-400 transition" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                        </svg>
                    @endif
                    
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center transition">
                        <div class="bg-white rounded-full p-2.5 opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <h3 class="text-gray-800 text-sm font-medium truncate">{{ $song->title }}</h3>
                    <p class="text-gray-400 text-xs mt-1 truncate">{{ $song->artist_name }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xs text-gray-400">{{ $song->formatted_duration ?? '03:30' }}</span>
                        <span class="text-xs text-gray-400 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ number_format($song->plays_count) }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-400 py-16">
                آهنگی در این دسته‌بندی وجود ندارد
            </div>
            @endforelse
        </div>
        
        <!-- صفحه‌بندی -->
        <div class="mt-8">
            {{ $songs->withQueryString()->links() }}
        </div>
        
        <!-- سایر دسته‌بندی‌ها -->
        @if($otherCategories->count() > 0)
        <div class="mt-16">
            <h2 class="text-xl font-bold text-gray-800 mb-4">سایر دسته‌بندی‌ها</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($otherCategories as $other)
                <a href="{{ route('categories.show', $other->slug) }}" class="px-3 py-1.5 bg-white text-gray-600 text-sm rounded-md hover:bg-gray-800 hover:text-white transition shadow-sm">
                    {{ $other->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection