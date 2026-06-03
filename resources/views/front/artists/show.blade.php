@extends('layouts.app')

@section('title', $artist->name)

@section('content')
<div class="bg-gray-100 min-h-screen pb-28">
    
    <!-- هدر هنرمند -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <!-- آواتار -->
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-lg">
                    @if($artist->avatar)
                        <img src="{{ Storage::url($artist->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-5xl text-gray-400">🎤</span>
                    @endif
                </div>
                
                <!-- اطلاعات -->
                <div class="flex-1 text-center md:text-right">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">{{ $artist->name }}</h1>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-4 text-gray-500 text-sm mb-4">
                        @if($artist->genre)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2v4M12 22v-4M4 12H2M6 12H4M20 12h-2M22 12h-2M19.07 4.93l-2.83 2.83M4.93 19.07l2.83-2.83M19.07 19.07l-2.83-2.83M4.93 4.93l2.83 2.83"/>
                                </svg>
                                {{ $artist->genre }}
                            </span>
                        @endif
                        
                        @if($artist->birth_date)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5zm0 11c-2.76 0-5-2.24-5-5h2c0 1.66 1.34 3 3 3s3-1.34 3-3h2c0 2.76-2.24 5-5 5z"/>
                                </svg>
                                متولد: {{ $artist->birth_date->format('Y/m/d') }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex flex-wrap justify-center md:justify-start gap-6 text-center">
                        <div>
                            <p class="text-2xl font-bold text-gray-800">{{ $totalSongs }}</p>
                            <p class="text-xs text-gray-400">آهنگ</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalPlays) }}</p>
                            <p class="text-xs text-gray-400">کل پخش</p>
                        </div>
                    </div>
                    
                    @if($artist->bio)
                        <div class="mt-4">
                            <p class="text-gray-600 text-sm leading-relaxed max-w-2xl">{{ Str::limit($artist->bio, 200) }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        
        <!-- آهنگ‌های محبوب -->
        @if($popularSongs->count() > 0)
        <div class="mb-10">
            <h2 class="text-xl font-bold text-gray-800 mb-4">🎧 محبوب‌ترین آهنگ‌ها</h2>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                @foreach($popularSongs as $index => $song)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 transition cursor-pointer border-b border-gray-100 last:border-0"
                     onclick="window.location.href='{{ route('song.show', $song->id) }}'">
                    <div class="flex items-center gap-3">
                        <span class="text-gray-400 text-sm w-8">{{ $index + 1 }}</span>
                        <div>
                            <h3 class="text-gray-800 text-sm font-medium">{{ $song->title }}</h3>
                            <p class="text-gray-400 text-xs">{{ $song->artist_name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-gray-400 text-xs">{{ number_format($song->plays_count) }} بازدید</span>
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- همه آهنگ‌ها -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">🎵 همه آهنگ‌ها</h2>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @forelse($songs as $song)
                <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition cursor-pointer" 
                     onclick="window.location.href='{{ route('song.show', $song->id) }}'">
                    <div class="aspect-square bg-gray-50 flex items-center justify-center relative">
                        @if($song->cover_image)
                            <img src="{{ Storage::url($song->cover_image) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                            </svg>
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center transition">
                            <div class="bg-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition">
                                <svg class="w-4 h-4 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="text-gray-800 text-sm font-medium truncate">{{ $song->title }}</h3>
                        <p class="text-gray-400 text-xs mt-1 truncate">{{ $song->artist_name }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center text-gray-400 py-12">
                    آهنگی برای این هنرمند وجود ندارد
                </div>
                @endforelse
            </div>
            
            <!-- صفحه‌بندی -->
            <div class="mt-8">
                {{ $songs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection