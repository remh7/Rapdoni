@extends('layouts.app')

@section('title', $song->title . ' - ' . $song->artist_name)

@section('content')
<div class="bg-gray-100 min-h-screen pb-20">
    <div class="container mx-auto px-4 py-8">
        
        <!-- دکمه بازگشت -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 transition mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            بازگشت
        </a>
        
        <!-- کارت اصلی آهنگ -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="md:flex">
                <!-- کاور -->
                <div class="md:w-80 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center p-8">
                    <div class="w-64 h-64 rounded-2xl shadow-xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        @if($song->cover_image)
                            <img src="{{ Storage::url($song->cover_image) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-32 h-32 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                            </svg>
                        @endif
                    </div>
                </div>
                
                <!-- اطلاعات -->
                <div class="flex-1 p-6 md:p-8">
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                            {{ $song->category->name ?? 'بدون دسته' }}
                        </span>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">{{ $song->title }}</h1>
                    <p class="text-xl text-gray-500 mb-4">{{ $song->artist_name }}</p>
                    
                    <div class="flex items-center gap-4 text-gray-400 text-sm mb-6">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ number_format($song->plays_count) }} بازدید
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5zm0 11c-2.76 0-5-2.24-5-5h2c0 1.66 1.34 3 3 3s3-1.34 3-3h2c0 2.76-2.24 5-5 5z"/>
                            </svg>
                            {{ $song->formatted_duration ?? '03:30' }}
                        </span>
                    </div>
                    
                    <!-- پلیر HTML5 شیک‌تر -->
                    <div class="mb-6 bg-purple-50 rounded-xl p-4 border border-purple-100">
                        <audio controls class="w-full" style="height: 40px;">
                            <source src="{{ Storage::url($song->file_path) }}" type="audio/mpeg">
                            مرورگر شما از پلیر صوتی پشتیبانی نمی‌کند.
                        </audio>
                    </div>
                    
                   <!-- لینک دانلود با Route -->
<div>
    <a href="{{ route('song.download', $song->id) }}" 
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition text-sm shadow-md">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
        </svg>
        دانلود آهنگ
    </a>
</div>
                </div>
            </div>
        </div>
        
        <!-- آهنگ‌های مشابه -->
        @if($relatedSongs->count() > 0)
        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">آهنگ‌های مشابه</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($relatedSongs as $related)
                <a href="{{ route('song.show', $related->id) }}" class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    <div class="aspect-square bg-gray-50 flex items-center justify-center relative">
                        @if($related->cover_image)
                            <img src="{{ Storage::url($related->cover_image) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-gray-300 group-hover:text-gray-400 transition" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="text-gray-800 text-sm font-medium truncate">{{ $related->title }}</h3>
                        <p class="text-gray-400 text-xs truncate">{{ $related->artist_name }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    // ثبت بازدید
    fetch(`/song/{{ $song->id }}/play`, { 
        method: 'POST', 
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        } 
    }).catch(err => console.error('خطا:', err));
</script>
@endsection