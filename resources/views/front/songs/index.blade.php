@extends('layouts.app')

@section('title', 'همه آهنگ‌ها')

@section('content')
<div class="bg-gray-100 min-h-screen pb-28">
    
    <!-- هدر صفحه -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-12 text-center">
            <div class="inline-block p-3 bg-gray-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-light text-gray-800 mb-2">همه آهنگ‌ها</h1>
            <p class="text-gray-400 text-sm">تمامی آهنگ‌های موجود در رپدونی</p>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        
        <!-- فیلتر دسته‌بندی -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-2 justify-center">
                <a href="{{ route('songs.index') }}" class="px-4 py-2 rounded-full text-sm transition {{ !request()->get('category') ? 'bg-gray-800 text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                    همه
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('songs.index', ['category' => $category->id]) }}" class="px-4 py-2 rounded-full text-sm transition {{ request()->get('category') == $category->id ? 'bg-gray-800 text-white' : 'bg-white text-gray-600 hover:bg-gray-100' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
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
                آهنگی وجود ندارد
            </div>
            @endforelse
        </div>
        
        <!-- صفحه‌بندی -->
        <div class="mt-8">
            {{ $songs->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection